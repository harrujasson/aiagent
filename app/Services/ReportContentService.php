<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ReportContentService
{
    protected string $apiKey;
    protected string $model;
    protected $rulereport;


    public function __construct()
    {
        $this->apiKey = config('services.openai.key', env('OPENAI_API_KEY'));
        $this->model  = config('services.openai.model', env('OPENAI_MODEL', 'gpt-4o-mini'));

        if(getSettingInfo('company_prompt')){
            $this->rulereport =getSettingInfo('company_prompt');
        }
    }

    protected function splitContentAndHashtags(string $text): array{
        $parts = preg_split('/HASHTAGS:/i', $text);

        $content = $parts[0] ?? '';
        $hashtags = $parts[1] ?? '';

        return [trim($content), trim($hashtags)];
    }

    protected function extractHashtags(string $text): array{
        if (!$text) return [];
        // extract hashtags with regex
        preg_match_all('/#\w+/u', $text, $matches);

        return $matches[0] ?? [];
    }
    protected function removeHashtagsFromContent(string $text): string{
        // Remove words starting with #
        $content =  preg_replace('/#\w+/u', '', $text);
        $contentText = preg_replace('/^CONTENT:\s*/i', '', $content);
        return $contentText;
    }


    public function generate(string $topic, ?string $tone = 'professional', ?int $variants = 1): array
    {
        $prompt = $this->buildPrompt($platform, $topic, $tone, $variants);
        //echo $prompt; die();

        $response = Http::withToken($this->apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model'    => $this->model,
                'messages' => [
                    [
                        'role'    => 'system',
                        'content' => 'You are an expert social media and email copywriter. You always respond with clean text, no markdown, no explanations — only the requested content.'
                    ],
                    [
                        'role'    => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.8,
            ]);

        if ($response->failed()) {
            throw new \RuntimeException('OpenAI API error: ' . $response->body());
        }

        $data = $response->json();

        $contentRaw = $data['choices'][0]['message']['content'] ?? '';
        //echo "<pre>"; print_r($data['choices'][0]); die();
        list($contentText, $hashtagsText) = $this->splitContentAndHashtags($contentRaw);

        $contentText = $this->removeHashtagsFromContent($contentText);
        // You can structure variants by splitting lines or markers if needed.
        return [
            'platform' => $platform,
            'topic'    => $topic,
            'tone'     => $tone,
            'other' => '',
            'content'  => trim($contentText),
            'hashtags' => $this->extractHashtags($hashtagsText),
        ];
    }

    protected function buildPrompt(string $platform, string $topic, string $tone, int $variants): string{

        $base = "Generate {$variants} high-quality {$platform} content piece(s) about: \"{$topic}\".\n";
        $base .= "Tone: {$tone}.\n";

        /**Generate tags */
        if($platform!="email"){
            $base .= "Respond ONLY in this structure:\n";
            $base .= "CONTENT:\n<main content text>\n\n";
            $base .= "HASHTAGS:\n#tag1 #tag2 #tag3 ... (model should generate these)\n\n";
        }
        $base.='Platform rules:';
        return $base . $this->rulereport;

    }
}

