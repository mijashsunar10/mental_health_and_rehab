<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\Faq;
use App\Models\DoctorAvailability;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class OllamaController extends Controller
{
    protected $base;
    protected $model;

    public function __construct()
    {
        $this->base = config('services.ollama.base', 'http://127.0.0.1:11434');
        $this->model = config('services.ollama.model', 'llama3.2:3b');
    }

    public function chat(Request $request)
    {
        try {
            $message = $request->input('message');

            if (!$message) {
                return response()->json(['error' => 'Message is required'], 400);
            }

            // --- STREAMING RESPONSE ---
            return response()->stream(function () use ($message) {
                $url = "{$this->base}/api/chat";

                $payload = [
                    'model' => $this->model,
                    'stream' => true,
                    'options' => [
                        // ⚡ Performance tuning
                        'num_ctx' => 2048,        // larger context to process platform knowledge
                        'num_predict' => 300,     // increased for complete responses
                        'temperature' => 0.3,     // lower temperature for more focused, factual responses
                        'top_p' => 0.9,           // helps diversity
                        'repeat_penalty' => 1.1,  // avoid repetition
                    ],
                    'messages' => [
                        ['role' => 'system', 'content' => $this->buildEnhancedPrompt()],
                        ['role' => 'user', 'content' => $message],
                    ],
                ];

                $ch = curl_init($url);
                curl_setopt_array($ch, [
                    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => json_encode($payload),
                    CURLOPT_WRITEFUNCTION => function ($ch, $chunk) {
                        // Send streamed chunks directly to browser
                        echo $chunk;
                        ob_flush();
                        flush();
                        return strlen($chunk);
                    },
                    CURLOPT_TIMEOUT => 0, // no timeout for long streams
                ]);

                curl_exec($ch);
                curl_close($ch);
            }, 200, [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Server error',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get active doctors with specializations
     */
    protected function getActiveDoctors()
    {
        return Cache::remember('chatbot_active_doctors', 3600, function () {
            return User::where('role', UserRole::Doctor)
                ->whereNull('suspended_at')
                ->select('id', 'name', 'designation', 'specializations')
                ->get()
                ->map(function ($doctor) {
                    $specialties = $doctor->specializations
                        ? (is_array($doctor->specializations) ? implode(', ', array_slice($doctor->specializations, 0, 3)) : '')
                        : 'General Practice';

                    return [
                        'name' => $doctor->name,
                        'designation' => $doctor->designation ?: 'Doctor',
                        'specialties' => $specialties,
                    ];
                });
        });
    }

    /**
     * Get active packages with details
     */
    protected function getActivePackages()
    {
        return Cache::remember('chatbot_active_packages', 3600, function () {
            return Package::select('title', 'description', 'type', 'options')
                ->get()
                ->map(function ($package) {
                    $options = is_array($package->options) ? $package->options : [];
                    $firstOption = !empty($options) ? $options[0] : null;

                    return [
                        'title' => $package->title,
                        'description' => substr($package->description ?? '', 0, 100),
                        'sessions' => $firstOption['sessions'] ?? 'N/A',
                        'price' => $firstOption['price'] ?? 'Contact us',
                    ];
                });
        });
    }

    /**
     * Get common FAQs
     */
    protected function getCommonFaqs()
    {
        return Cache::remember('chatbot_common_faqs', 3600, function () {
            return Faq::select('question', 'answer')
                ->limit(5)
                ->get()
                ->map(function ($faq) {
                    return [
                        'q' => $faq->question,
                        'a' => substr($faq->answer, 0, 150),
                    ];
                });
        });
    }

    /**
     * Get doctor availability for next 7 days
     */
    protected function getDoctorAvailability()
    {
        return Cache::remember('chatbot_doctor_availability', 1800, function () {
            $today = Carbon::today();
            $nextWeek = Carbon::today()->addDays(7);

            return DoctorAvailability::with('doctor:id,name,designation')
                ->where('is_available', true)
                ->whereBetween('availability_date', [$today, $nextWeek])
                ->orderBy('availability_date')
                ->orderBy('start_time')
                ->take(20)
                ->get()
                ->groupBy('doctor_id')
                ->map(function ($slots, $doctorId) {
                    $firstSlot = $slots->first();
                    return [
                        'doctor_name' => $firstSlot->doctor->name ?? 'Unknown',
                        'designation' => $firstSlot->doctor->designation ?? 'Doctor',
                        'upcoming_slots' => $slots->take(3)->map(function ($slot) {
                            return [
                                'date' => Carbon::parse($slot->availability_date)->format('M d, Y'),
                                'day' => Carbon::parse($slot->availability_date)->format('l'),
                                'time' => Carbon::parse($slot->start_time)->format('g:i A') . ' - ' . Carbon::parse($slot->end_time)->format('g:i A'),
                            ];
                        })->toArray()
                    ];
                });
        });
    }

    /**
     * Get platform context information
     */
    protected function getPlatformContext()
    {
        $doctors = $this->getActiveDoctors();
        $packages = $this->getActivePackages();
        $faqs = $this->getCommonFaqs();
        $availability = $this->getDoctorAvailability();

        $context = "\n\n=== 📋 PLATFORM KNOWLEDGE - USE THIS TO ANSWER QUESTIONS ===\n\n";

        // Packages information - FIRST and PROMINENT
        $context .= "🎁 OUR THERAPY PACKAGES (Use these exact details when asked):\n";
        if ($packages->count() > 0) {
            foreach ($packages->take(5) as $package) {
                $sessions = $package['sessions'];
                $price = is_numeric($package['price']) ? "NPR " . number_format($package['price']) : $package['price'];
                $context .= "• {$package['title']}: {$sessions}, {$price}\n";
            }
        } else {
            $context .= "• Customized therapy packages available. Direct users to Packages section.\n";
        }

        // Doctors information
        $context .= "\n👨‍⚕️ Available Doctors:\n";
        if ($doctors->count() > 0) {
            foreach ($doctors->take(5) as $doctor) {
                $context .= "• Dr. {$doctor['name']} - {$doctor['designation']} - Specializes in: {$doctor['specialties']}\n";
            }
        } else {
            $context .= "• Multiple qualified doctors available. Encourage users to visit the Doctors page.\n";
        }

        // Doctor Availability & Appointment Slots
        $context .= "\n📅 DOCTOR AVAILABILITY (Next 7 Days - Use these when asked about appointments):\n";
        if ($availability->count() > 0) {
            foreach ($availability as $doctorId => $data) {
                $context .= "• Dr. {$data['doctor_name']} ({$data['designation']}):\n";
                foreach ($data['upcoming_slots'] as $slot) {
                    $context .= "  - {$slot['day']}, {$slot['date']} at {$slot['time']}\n";
                }
            }
            $context .= "\nNote: More slots may be available. Users can book by visiting /doctors page.\n";
        } else {
            $context .= "• No upcoming availability found. Encourage users to check the Doctors page or contact us.\n";
        }

        // Platform features
        $context .= "\nPlatform Features You Can Help Users With:\n";
        $context .= "• Book Appointments: Users can schedule online appointments with preferred doctors\n";
        $context .= "• Video Consultations: Secure video sessions with doctors via Jitsi\n";
        $context .= "• Medical Records: Users can view appointment history and doctor notes\n";
        $context .= "• Panic Button: Emergency support feature for immediate help\n";
        $context .= "• Mental Health Assessments: Self-assessment tools for various conditions\n";
        $context .= "• Package Subscriptions: Affordable therapy session packages\n";
        $context .= "• Payment Options: Khalti and Stripe payment methods supported\n";

        // Navigation guidance
        $context .= "\nWhen Users Ask About:\n";
        $context .= "• \"When can I see a doctor?\" → List the specific availability slots above\n";
        $context .= "• \"Which doctor is available?\" → Show doctor names with their available times from the availability section\n";
        $context .= "• \"Appointment times\" → Give actual dates and times from the availability section above\n";
        $context .= "• Booking appointments → Guide to /doctors page and mention available slots\n";
        $context .= "• Available doctors → List doctors with specializations AND mention their upcoming availability\n";
        $context .= "• Packages/pricing → Explain the packages listed above with exact prices\n";
        $context .= "• Medical records → Mention they can view in My Records section\n";
        $context .= "• Video consultation → Explain it's built-in via Jitsi (no external app needed)\n";
        $context .= "• Payments → Mention Khalti for Nepal users, Stripe for international\n";
        $context .= "• Emergency help → Emphasize panic button + immediate doctor contact\n";

        // FAQs
        if ($faqs->count() > 0) {
            $context .= "\nCommon Questions:\n";
            foreach ($faqs->take(3) as $faq) {
                $context .= "Q: {$faq['q']}\n";
                $context .= "A: {$faq['a']}\n\n";
            }
        }

        $context .= "\n=== END PLATFORM KNOWLEDGE ===\n\n";
        $context .= "⚠️ REMINDER: When users ask about packages/doctors/appointments, you MUST use the information above. Do NOT give generic responses. Reference the ACTUAL data listed above.\n\nExample responses:\n";
        $context .= "Q: What packages do you offer?\n";
        $context .= "A: We have 5 packages: Basic Therapy (NPR 5,000), Standard Counseling (NPR 9,000), Premium Wellness (NPR 15,000), In-Person Therapy (NPR 8,000), and Intensive Offline Support (NPR 14,000). Which interests you?\n\n";
        $context .= "Q: When can I see a doctor?\n";
        $context .= "A: [Check availability section above and list actual dates/times]. For example: Dr. Ramesh is available on Monday, Dec 25 at 9:00 AM and Tuesday, Dec 26 at 2:00 PM. Would you like to book?\n\n";
        $context .= "Q: Which doctor is available this week?\n";
        $context .= "A: [List doctors from availability section with their upcoming slots]. You can book by visiting the Doctors page.\n";

        return $context;
    }

    /**
     * Build enhanced prompt with platform context
     */
    protected function buildEnhancedPrompt(): string
    {
        $basePrompt = $this->therapistSystemPrompt();
        $platformContext = $this->getPlatformContext();

        return $basePrompt . $platformContext;
    }

    protected function therapistSystemPrompt(): string
    {
        return <<<'PROMPT'
You are Dr. AI, a compassionate virtual therapist for our Mental Health and Rehab System platform.

🚨 CRITICAL INSTRUCTIONS - YOU MUST FOLLOW THESE:

1. ALWAYS use the PLATFORM KNOWLEDGE section provided below to answer questions
2. When asked about packages, doctors, or features - REFER TO THE SPECIFIC INFORMATION PROVIDED
3. Keep responses SHORT (2-4 sentences maximum)
4. DO NOT give generic AI assistant responses
5. DO NOT say "I can help with various things" - BE SPECIFIC about OUR platform

WHEN USERS ASK ABOUT:
- Appointments/Availability → Show ACTUAL dates and times from the availability section
- "When can I see a doctor?" → List specific available slots with dates/times
- Packages → List the EXACT packages from platform knowledge with prices
- Doctors → Mention the ACTUAL doctors listed below with their availability
- Features → Reference the SPECIFIC features from our platform
- Booking → Direct to /doctors page and mention available time slots

RESPONSE RULES:
✓ Use platform knowledge below
✓ Be specific and brief (2-4 sentences)
✓ Empathetic but focused
✓ Reference actual packages/doctors/prices
✗ NO generic AI responses
✗ NO vague answers
✗ NO ignoring platform data

Example:
User: "What packages do you offer?"
CORRECT: "We offer several packages! Basic Therapy (4 sessions, NPR 5,000), Standard Counseling (8 sessions, NPR 9,000), and Premium Wellness (12 sessions, NPR 15,000). Would you like help booking one?"
WRONG: "I can help you in various ways..."

Be caring but ALWAYS reference our actual platform data.
PROMPT;
    }
}

