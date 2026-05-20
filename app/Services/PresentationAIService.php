<?php

namespace App\Services;

class PresentationAIService
{
    private $client;

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

    public function generate(string $topic, array $points): array
    {
        $prompt = $this->buildPrompt($topic, $points);

        $response = $this->client->chat()->create([
//            'model' => 'openai/gpt-oss-20b:free',
            'model' => 'qwen/qwen3-coder',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert presentation creator. Return ONLY valid json.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.7,
            'max_tokens' => 6000,
        ]);

        $content = $response->choices[0]->message->content;

        $clean = preg_replace('/```json|```/i', '', $content);
        $clean = trim($clean);

        $decoded = json_decode($clean, true);

        if ($decoded === null) {
            \Log::error('AI response could not be decoded', ['raw' => $content]);
            return ['slides' => []];
        }

        return $decoded;
    }

    private function buildPrompt(string $topic, array $points): string
    {
        $pointsText = implode(", ", $points);

        return "
Create a presentation structure in STRICT JSON format.

Topic: {$topic}
Key points: {$pointsText}

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
