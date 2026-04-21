<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    public function optimize(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'instruction' => 'nullable|string',
            'language' => 'nullable|string'
        ]);

        $code = $request->input('code');
        $instruction = $request->input('instruction', 'Optimize this code for better performance, readability, and security. Keep the exact same functionality.');
        $language = $request->input('language', 'php');
        $apiKey = env('OPENROUTER_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'OPENROUTER_API_KEY is not configured in .env file.'], 500);
        }

        $prompt = "You are an expert $language developer. $instruction\n\nReturn ONLY the raw code. Do not include markdown code block syntax (like ```$language or ```) in your response, just the raw code itself.\n\nCode to optimize:\n$code";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'CodeVault'
            ])->post("https://openrouter.ai/api/v1/chat/completions", [
                'model' => 'openai/gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.2,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $optimizedCode = $data['choices'][0]['message']['content'] ?? null;

                if ($optimizedCode) {
                    // Strip any remaining markdown code blocks just in case
                    $optimizedCode = preg_replace('/^```[a-zA-Z]*\n/i', '', $optimizedCode);
                    $optimizedCode = preg_replace('/```$/i', '', $optimizedCode);
                    $optimizedCode = trim($optimizedCode);
                    
                    return response()->json(['optimized_code' => $optimizedCode]);
                }
            }

            Log::error('OpenRouter API Error', ['response' => $response->body()]);
            return response()->json(['error' => 'Failed to generate optimized code from AI.'], 500);

        } catch (\Exception $e) {
            Log::error('OpenRouter API Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while connecting to AI service.'], 500);
        }
    }
}
