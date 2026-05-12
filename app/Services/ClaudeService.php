<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClaudeService
{
    protected ?string $apiKey;
    protected string $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function analyze(string $symptoms, array $profile = [], array $history = []): array
    {
        if (!$this->apiKey) {
            Log::error('Gemini API key not set.');
            return $this->fallbackResponse();
        }

        $prompt = $this->buildPrompt($symptoms, $profile, $history);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'     => 0.3,
                    'maxOutputTokens' => 8192,
                ],
            ]);

            if ($response->successful()) {
                $parts = $response->json('candidates.0.content.parts') ?? [];
                $text  = collect($parts)->last(fn($p) => isset($p['text']))['text'] ?? null;
                return $this->parseResponse($text);
            }

            Log::error('Gemini API error: ' . $response->body());
            return $this->fallbackResponse();

        } catch (\Exception $e) {
            Log::error('Gemini API exception: ' . $e->getMessage());
            return $this->fallbackResponse();
        }
    }

    public function analyzeLabReport(string $filePath, string $mimeType, string $reportType): array
    {
        if (!$this->apiKey) {
            Log::error('Gemini API key not set.');
            return $this->fallbackLabAnalysis();
        }

        $fullPath = storage_path('app/public/' . $filePath);

        if (!file_exists($fullPath)) {
            Log::error('Lab report file not found: ' . $fullPath);
            return $this->fallbackLabAnalysis();
        }

        if ($mimeType === 'application/octet-stream') {
            $ext      = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimeType = $ext === 'pdf' ? 'application/pdf' : 'image/jpeg';
        }

        $fileData = base64_encode(file_get_contents($fullPath));

        $prompt = <<<PROMPT
You are ClinIQ, an AI medical assistant. Analyze this lab report (type: {$reportType}) and extract all lab values.

IMPORTANT: Respond ONLY with valid JSON. No text before or after. No markdown backticks. Use exactly this structure:
{
  "report_type": "Detected report type name",
  "summary": "2-3 sentence plain-language summary of overall results",
  "lab_values": [
    {
      "name": "Test name",
      "value": "Patient result with unit",
      "range": "Normal reference range",
      "status": "normal",
      "explanation": "Plain language explanation for a non-medical person"
    }
  ],
  "recommendations": [
    "Specific recommendation 1",
    "Specific recommendation 2",
    "Specific recommendation 3"
  ],
  "disclaimer": "This AI analysis is for informational purposes only and is not a substitute for professional medical advice."
}

Rules:
- status must be exactly one of: "normal", "high", "low"
- Extract ALL visible lab values from the report
- Keep explanations simple and in plain English
- Be aware of Pakistan regional health context
- If a value cannot be read clearly, skip it
PROMPT;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->timeout(90)->post($this->apiUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data'      => $fileData,
                                ]
                            ],
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature'     => 0.2,
                    'maxOutputTokens' => 2000,
                ],
            ]);

            if ($response->successful()) {
                $parts = $response->json('candidates.0.content.parts') ?? [];
                $text  = collect($parts)->last(fn($p) => isset($p['text']))['text'] ?? null;
                return $this->parseLabResponse($text);
            }

            Log::error('Gemini Lab API error: ' . $response->body());
            return $this->fallbackLabAnalysis();

        } catch (\Exception $e) {
            Log::error('Gemini Lab exception: ' . $e->getMessage());
            return $this->fallbackLabAnalysis();
        }
    }

    protected function parseResponse(?string $content): array
    {
        if (!$content) {
            Log::error('Gemini returned null content');
            return $this->fallbackResponse();
        }

        $content = preg_replace('/```json/i', '', $content);
        $content = preg_replace('/```/i', '', $content);

        preg_match('/\{.*\}/s', $content, $matches);
        if (empty($matches[0])) {
            Log::error('No JSON found in Gemini response: ' . substr($content, 0, 300));
            return $this->fallbackResponse();
        }

        $parsed = json_decode(trim($matches[0]), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Gemini JSON parse error: ' . json_last_error_msg());
            return $this->fallbackResponse();
        }

        if (empty($parsed['summary']) || empty($parsed['risk_level'])) {
            Log::error('Gemini response missing required fields');
            return $this->fallbackResponse();
        }

        return $parsed;
    }

    protected function parseLabResponse(?string $content): array
    {
        if (!$content) {
            Log::error('Gemini Lab returned null content');
            return $this->fallbackLabAnalysis();
        }

        $content = preg_replace('/```json/i', '', $content);
        $content = preg_replace('/```/i', '', $content);

        preg_match('/\{.*\}/s', $content, $matches);
        if (empty($matches[0])) {
            Log::error('No JSON found in Gemini Lab response: ' . substr($content, 0, 300));
            return $this->fallbackLabAnalysis();
        }

        $parsed = json_decode(trim($matches[0]), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Lab JSON parse error: ' . json_last_error_msg());
            return $this->fallbackLabAnalysis();
        }

        return $parsed;
    }

    protected function fallbackResponse(): array
    {
        return [
            'summary'          => 'Unable to analyze symptoms at this time. Please try again.',
            'conditions'       => [
                ['name' => 'Unable to analyze', 'probability' => 0, 'description' => 'Please try again.'],
            ],
            'risk_level'       => 'medium',
            'risk_explanation' => 'Please consult a doctor for proper evaluation.',
            'recommendations'  => [
                'Please consult a licensed medical professional.',
                'If symptoms are severe, seek emergency care immediately.',
            ],
            'otc_medications'  => [],
            'when_to_seek_help'=> 'Seek medical attention if symptoms worsen.',
            'is_emergency'     => false,
            'follow_up'        => 'Please try again or consult a doctor directly.',
            'disclaimer'       => 'This information is for guidance only and is not a substitute for a licensed medical professional.',
        ];
    }

    protected function fallbackLabAnalysis(): array
    {
        return [
            'report_type'     => 'Unknown',
            'summary'         => 'Unable to analyze the report at this time. Please try again or consult your doctor directly.',
            'lab_values'      => [],
            'recommendations' => [
                'Please consult a licensed medical professional.',
                'If symptoms are severe, seek emergency care immediately.',
            ],
            'disclaimer' => 'This AI analysis is for informational purposes only and is not a substitute for professional medical advice.',
        ];
    }

    protected function buildPrompt(string $symptoms, array $profile = [], array $history = []): string
    {
        $profileInfo = '';

        if (!empty($profile)) {
            $profileInfo = "\n\nPATIENT PROFILE:";
            if (!empty($profile['name']))        $profileInfo .= "\n- Name: {$profile['name']}";
            if (!empty($profile['age']))         $profileInfo .= "\n- Age: {$profile['age']} years";
            if (!empty($profile['gender']))      $profileInfo .= "\n- Gender: {$profile['gender']}";
            if (!empty($profile['blood_group'])) $profileInfo .= "\n- Blood Group: {$profile['blood_group']}";
            if (!empty($profile['allergies']))   $profileInfo .= "\n- Known Allergies: {$profile['allergies']}";
            if (!empty($profile['conditions']))  $profileInfo .= "\n- Medical Conditions: {$profile['conditions']}";
            if (!empty($profile['medications'])) $profileInfo .= "\n- Current Medications: {$profile['medications']}";
        }

        $historyText = '';
        if (!empty($history)) {
            $historyText = "\n\nCONVERSATION HISTORY:";
            foreach ($history as $msg) {
                $role         = strtoupper($msg['role']);
                $historyText .= "\n{$role}: {$msg['content']}";
            }
        }

        return <<<PROMPT
You are ClinIQ, an AI-powered clinical assistant providing safe, structured, and medically responsible health guidance.

CRITICAL RULES:
- You are NOT a licensed doctor
- NEVER provide definitive diagnoses
- NEVER prescribe controlled or prescription-only medications
- ALWAYS prioritize patient safety
- Be aware of regional diseases in Pakistan: Dengue, Malaria, Typhoid, seasonal infections

EMERGENCY DETECTION: If symptoms include chest pain, stroke signs, severe bleeding, difficulty breathing, loss of consciousness, or seizures — set is_emergency to true.

{$profileInfo}
{$historyText}

PATIENT SYMPTOMS: {$symptoms}

IMPORTANT: Respond ONLY with valid JSON. No text before or after. No markdown backticks. Use exactly this structure:
{
  "summary": "Brief summary of reported symptoms",
  "conditions": [
    {"name": "Condition Name", "probability": 75, "description": "Brief explanation"},
    {"name": "Condition Name", "probability": 45, "description": "Brief explanation"},
    {"name": "Condition Name", "probability": 20, "description": "Brief explanation"}
  ],
  "risk_level": "low",
  "risk_explanation": "Why this risk level was assigned",
  "recommendations": [
    "Specific recommendation 1",
    "Specific recommendation 2",
    "Specific recommendation 3",
    "Specific recommendation 4"
  ],
  "otc_medications": [
    {"name": "Medication name", "dosage": "Dosage info", "frequency": "How often"}
  ],
  "when_to_seek_help": "When to see a doctor",
  "is_emergency": false,
  "follow_up": "Follow up advice",
  "disclaimer": "This information is for guidance only and is not a substitute for a licensed medical professional."
}

risk_level must be exactly one of: "low", "medium", "high"
PROMPT;
    }
}   