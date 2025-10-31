<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\Faq;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Cache;

class OllamaController extends Controller
{
    protected $base;
    protected $model;

    public function __construct()
    {
        $this->base = config('services.ollama.base', 'http://127.0.0.1:11434');
        $this->model = config('services.ollama.model', 'llama3.2:1b');
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
                        'num_ctx' => 512,        // smaller context window for speed
                        'num_predict' => 200,     // limits tokens per reply
                        'temperature' => 0.7,     // balanced creativity
                        'top_p' => 0.9,           // helps diversity
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
     * Get platform context information
     */
    protected function getPlatformContext()
    {
        $doctors = $this->getActiveDoctors();
        $packages = $this->getActivePackages();
        $faqs = $this->getCommonFaqs();

        $context = "\n\n=== PLATFORM KNOWLEDGE ===\n\n";

        // Doctors information
        $context .= "Available Doctors:\n";
        if ($doctors->count() > 0) {
            foreach ($doctors->take(5) as $doctor) {
                $context .= "• Dr. {$doctor['name']} - {$doctor['designation']} - Specializes in: {$doctor['specialties']}\n";
            }
        } else {
            $context .= "• Multiple qualified doctors available. Encourage users to visit the Doctors page.\n";
        }

        // Packages information
        $context .= "\nTherapy Packages:\n";
        if ($packages->count() > 0) {
            foreach ($packages->take(3) as $package) {
                $sessions = $package['sessions'];
                $price = is_numeric($package['price']) ? "NPR " . number_format($package['price']) : $package['price'];
                $context .= "• {$package['title']}: {$sessions} sessions, {$price}\n  {$package['description']}\n";
            }
        } else {
            $context .= "• Customized therapy packages available. Direct users to Packages section.\n";
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
        $context .= "• Booking appointments → Guide to /doctors or /appointments page\n";
        $context .= "• Available doctors → List the doctors above with their specializations\n";
        $context .= "• Packages/pricing → Explain the packages listed above\n";
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
        $context .= "IMPORTANT: Maintain your empathetic therapeutic tone while providing platform information. When users ask about features, doctors, or packages, provide helpful guidance AND emotional support.";

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
You are Dr. AI, a compassionate, professional virtual therapist and medical assistant for our Mental Health and Rehab System platform. Your dual role:

THERAPEUTIC SUPPORT:
- Provide empathetic, evidence-based, and non-judgmental support to users seeking medical, mental health, or wellbeing information.
- Ask clarifying questions when needed, avoid speculation.
- Provide information in plain language and present general suggestions (sleep hygiene, when to seek care, red flags).
- ALWAYS include safety guidance when appropriate and instruct users to contact emergency services in case of immediate harm or life-threatening symptoms.
- Do NOT provide prescriptions, exact medical dosing, or attempt to replace a licensed clinician's diagnosis. If diagnosis or prescription is required, recommend professional in-person evaluation.
- Respect privacy and avoid collecting personally identifiable information.

PLATFORM NAVIGATION:
- Help users understand and navigate our platform features.
- Guide them to book appointments, explore packages, or contact doctors.
- Provide information about our services, doctors, and resources.
- Be concise but informative about platform capabilities.

Example therapeutic response: "I'm sorry you're going through this. I can help by..."
Example platform response: "I can see you're interested in booking an appointment. We have several qualified doctors available..."

Be succinct, factual, empathetic, and always include references to seeking professional care when needed.
PROMPT;
    }
}

