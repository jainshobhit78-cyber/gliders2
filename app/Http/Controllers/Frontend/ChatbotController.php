<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $message = trim($request->message);
        if (empty($message)) {
            return response()->json(['reply' => 'Please type a valid message.']);
        }

        $apiKey = env('GEMINI_API_KEY');

        // FALLBACK: Offline Mode if GEMINI_API_KEY is not configured
        if (empty($apiKey)) {
            $faq = ChatbotFaq::whereRaw('LOWER(question) = ?', [strtolower($message)])
                ->orWhereRaw('LOWER(question) LIKE ?', ["%".strtolower($message)."%"])
                ->first();

            if ($faq) {
                return response()->json([
                    'reply' => $faq->answer,
                    'redirect' => false
                ]);
            }

            return response()->json([
                'reply' => "I am currently running in <strong>Standard Mode</strong>. To enable my live, interactive AI Assistant mode, please configure the <code>GEMINI_API_KEY</code> inside the website's <code>.env</code> file!",
                'redirect' => true
            ]);
        }

        // SMART AI MODE: Query Google Gemini API with Context
        try {
            // 1. Gather all products for dynamic context
            $products = Product::select('title', 'description')->get();
            $productsContext = "";
            foreach ($products as $product) {
                $desc = strip_tags($product->description);
                if (strlen($desc) > 150) {
                    $desc = substr($desc, 0, 150) . "...";
                }
                $productsContext .= "- **" . $product->title . "**: " . $desc . "\n";
            }

            // 2. Gather manually entered FAQs
            $faqs = ChatbotFaq::select('question', 'answer')->get();
            $faqContext = "";
            foreach ($faqs as $faq) {
                $faqContext .= "Q: " . $faq->question . " | A: " . $faq->answer . "\n";
            }

            // 3. Construct System Prompt
            $systemPrompt = "You are a professional, helpful, and friendly AI Assistant for Gliders India Limited (GIL).\n";
            $systemPrompt .= "GIL is a Government of India Enterprise under the Ministry of Defence, based in Kanpur, Uttar Pradesh. We specialize in manufacturing high-quality military, sports, and emergency parachutes and inflatable systems.\n\n";
            
            $systemPrompt .= "Here is the live data from our database to help you answer questions accurately:\n";
            $systemPrompt .= "### OUR PRODUCTS:\n" . $productsContext . "\n";
            $systemPrompt .= "### OFFICIAL FAQ DIRECTIVES:\n" . $faqContext . "\n";
            
            $systemPrompt .= "### RULES:\n";
            $systemPrompt .= "- Provide direct, helpful, and concise answers suitable for a small chat box.\n";
            $systemPrompt .= "- Use formatting (like bold text or bullet points) to make answers easily readable.\n";
            $systemPrompt .= "- If asked about pricing or bulk orders, guide the user to fill out the contact form or email us at contact@glidersindia.in.\n";
            $systemPrompt .= "- Be extremely polite. If a question is completely unrelated to our company or defense/aviation/parachutes, politely request the user to ask questions related to Gliders India Limited.\n";

            // 4. Send API request to Google Gemini
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => "System instructions:\n" . $systemPrompt . "\n\nUser query: " . $message]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'maxOutputTokens' => 350
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $replyText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                if (!empty($replyText)) {
                    // Convert markdown-style bold and bullet points to HTML
                    $replyHtml = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $replyText);
                    $replyHtml = preg_replace('/^\*\s(.*?)$/m', '<li>$1</li>', $replyHtml);
                    $replyHtml = str_replace("\n", "<br>", $replyHtml);
                    
                    return response()->json([
                        'reply' => $replyHtml,
                        'redirect' => false
                    ]);
                }
            }

            Log::error("Gemini API Error details: " . $response->body());
            return response()->json(['reply' => 'I am experiencing a slight connectivity issue. Please try again in a moment.']);

        } catch (\Exception $e) {
            Log::error("Chatbot Gemini integration failed: " . $e->getMessage());
            return response()->json(['reply' => 'Sorry, I encountered an internal error. Please try again.']);
        }
    }

    public function questions()
    {
        $questions = ChatbotFaq::select('question')->latest()->get();
        return response()->json($questions);
    }
}