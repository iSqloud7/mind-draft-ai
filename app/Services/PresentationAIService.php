<?php

namespace App\Services;

class PresentationAIService
{
    private $client;

    // Initialize client with OpenRouter config and SSL certificate.
    public function __construct()
    {
        $this->client = \OpenAI::factory()
            ->withApiKey(env('OPENAI_API_KEY'))
            ->withBaseUri('https://openrouter.ai/api/v1')
            ->withHttpClient(new \GuzzleHttp\Client([
                'verify' => 'D:\\DevTools\\php\\cacert.pem',
                'headers' => [
                    'HTTP-Referer' => 'http://localhost',
                    'X-Title' => 'MindDraftAI'
                ]
            ]))
            ->make();
    }

    // Request AI slide generation and handle JSON response.
    public function generate(string $topic, array $points): array
    {
        $prompt = $this->buildPrompt($topic, $points);

        $response = $this->client->chat()->create([
            # 'model' => 'openai/gpt-oss-20b:free',
            'model' => 'qwen/qwen3-coder',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert presentation creator. Return ONLY valid json.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 6000,
        ]);

        $content = $response->choices[0]->message->content;

        // Clean Markdown tags and decode JSON.
        $clean = preg_replace('/```json|```/i', '', $content);
        $clean = trim($clean);

        $decoded = json_decode($clean, true);

        if ($decoded === null) {
            \Log::error('AI response could not be decoded', ['raw' => $content]);
            return ['slides' => []];
        }

        return $decoded;
    }

    // Format the prompt with topic, points, and JSON rules.
    private function buildPrompt(string $topic, array $points): string
    {
        $pointsCount = count($points);
        $pointsText = implode("\n- ", $points);

        return "
Create a presentation structure in STRICT JSON format.

Topic: {$topic}
Key points to cover:
- {$pointsText}

INSTRUCTIONS:
1. Create exactly {$pointsCount} slides, one for each key point provided.
2. Add a Title slide at the beginning and a Summary slide at the end.
3. Total slides should be {$pointsCount} + 2.

Return format EXACTLY:
{
  \"slides\": [
    {
      \"title\": \"\",
      \"bullets\": [\"\", \"\"],
      \"notes\": \"\"
    }
  ]
}

Rules:
- ONLY JSON
- NO explanations
- NO markdown
";
    }
}
