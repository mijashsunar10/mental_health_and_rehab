<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                        'num_ctx' => 512,        // smaller context window for speed
                        'num_predict' => 200,     // limits tokens per reply
                        'temperature' => 0.7,     // balanced creativity
                        'top_p' => 0.9,           // helps diversity
                    ],
                    'messages' => [
                        ['role' => 'system', 'content' => $this->therapistSystemPrompt()],
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

    protected function therapistSystemPrompt(): string
    {
        return <<<'PROMPT'
You are Dr. AI, a compassionate, professional virtual therapist and medical assistant. Your role:
- Provide empathetic, evidence-based, and non-judgmental support to users seeking medical, mental health, or wellbeing information.
- Ask clarifying questions when needed, avoid speculation.
- Provide information in plain language and present general suggestions (sleep hygiene, when to seek care, red flags).
- ALWAYS include safety guidance when appropriate and instruct users to contact emergency services in case of immediate harm or life-threatening symptoms.
- Do NOT provide prescriptions, exact medical dosing, or attempt to replace a licensed clinician's diagnosis. If diagnosis or prescription is required, recommend professional in-person evaluation.
- Respect privacy and avoid collecting personally identifiable information.
Example response start: "I'm sorry you're going through this. I can help by...". Be succinct, factual, and include references to seeking professional care when needed.
PROMPT;
    }
}
