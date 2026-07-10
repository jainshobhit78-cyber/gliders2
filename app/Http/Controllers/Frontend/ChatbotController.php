<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use App\Models\Product;
use App\Models\AboutLeadership;
use App\Models\NewsArticle;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $message = trim($request->message);
        if (empty($message)) {
            return response()->json(['reply' => 'Please type a valid question.']);
        }

        $apiKey = env('GEMINI_API_KEY');

        // LOCAL FALLBACK MODE: Token-matching NLP (No API Key)
        if (empty($apiKey)) {
            return $this->handleLocalFuzzyMatch($message);
        }

        // SMART GENERATIVE AI MODE: Google Gemini with full Database Context
        try {
            // 1. Gather general company profile settings
            $settings = GeneralSetting::first();
            $companyName = $settings->company_name ?? 'Gliders India Limited';
            $generalContext = "Company Name: " . $companyName . "\n";
            if (!empty($settings->footer_address)) {
                $generalContext .= "Address: " . strip_tags($settings->footer_address) . "\n";
            }
            if (!empty($settings->contact_email)) {
                $generalContext .= "Email: " . $settings->contact_email . "\n";
            }

            // 2. Gather CMD & Leadership Journey / Messages
            $leaders = AboutLeadership::orderBy('position', 'asc')->get();
            $leadershipContext = "";
            foreach ($leaders as $leader) {
                $leadershipContext .= "- **" . $leader->name . "** (" . $leader->designation . "): ";
                if (!empty($leader->message)) {
                    $leadershipContext .= strip_tags($leader->message);
                }
                $leadershipContext .= "\n";
            }

            // 3. Gather Products and Specifications
            $products = Product::with('category')->get();
            $productsContext = "";
            foreach ($products as $product) {
                $categoryName = $product->category->name ?? 'Defense Systems';
                $desc = strip_tags($product->description);
                if (strlen($desc) > 200) {
                    $desc = substr($desc, 0, 200) . "...";
                }
                $productsContext .= "- **" . $product->title . "** (Category: " . $categoryName . "): " . $desc . "\n";
            }

            // 4. Gather Latest News Articles
            $news = NewsArticle::where('status', 'Published')->latest()->take(5)->get();
            $newsContext = "";
            foreach ($news as $article) {
                $content = strip_tags($article->content);
                if (strlen($content) > 150) {
                    $content = substr($content, 0, 150) . "...";
                }
                $newsContext .= "- **News: " . $article->title . "** (Published: " . $article->created_at->format('d M Y') . "): " . $content . "\n";
            }

            // 5. Construct System Instructions
            $systemPrompt = "You are the official AI Assistant for Gliders India Limited (GIL), a premier Government of India Enterprise under the Ministry of Defence, based in Kanpur, Uttar Pradesh.\n";
            $systemPrompt .= "Answer the user's questions politely, professionally, and dynamically based ONLY on the following real-time website database contents:\n\n";
            
            $systemPrompt .= "### WEBSITE GENERAL PROFILE:\n" . $generalContext . "\n";
            $systemPrompt .= "### LEADERSHIP, LEADER PROFILE & CMD JOURNEY/MESSAGES:\n" . $leadershipContext . "\n";
            $systemPrompt .= "### REAL-TIME PRODUCT CATALOG & SPECIFICATIONS:\n" . $productsContext . "\n";
            $systemPrompt .= "### LATEST PUBLISHED NEWS ARTICLES:\n" . $newsContext . "\n\n";
            
            $systemPrompt .= "### INSTRUCTIONS:\n";
            $systemPrompt .= "- Frame your answers naturally and dynamically in conversational sentences based on the context above.\n";
            $systemPrompt .= "- Format your output cleanly (use bold tags like **bold** for key words, and bullet points if presenting lists).\n";
            $systemPrompt .= "- Keep the response concise, engaging, and perfect for a website chat window (1-3 sentences average).\n";
            $systemPrompt .= "- If the information is not present in the context, politely state that you don't have that specific record, and offer to direct them to the support form.\n";

            // 6. Request Gemini API
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => "System instructions:\n" . $systemPrompt . "\n\nUser Question: " . $message]
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
                    // Convert markdown bold and lists to HTML
                    $replyHtml = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $replyText);
                    $replyHtml = preg_replace('/^\*\s(.*?)$/m', '<li>$1</li>', $replyHtml);
                    $replyHtml = str_replace("\n", "<br>", $replyHtml);
                    
                    return response()->json([
                        'reply' => $replyHtml,
                        'redirect' => false
                    ]);
                }
            }

            Log::error("Gemini connection error: " . $response->body());
            return $this->handleLocalFuzzyMatch($message);

        } catch (\Exception $e) {
            Log::error("Gemini failed, falling back: " . $e->getMessage());
            return $this->handleLocalFuzzyMatch($message);
        }
    }

    private function handleLocalFuzzyMatch($message)
    {
        $userTokens = $this->tokenize($message);
        if (empty($userTokens)) {
            return response()->json([
                'reply' => 'I didn\'t quite catch that. Could you please rephrase or select one of the questions below?',
                'suggestions' => $this->getGeneralSuggestions()
            ]);
        }

        $faqs = ChatbotFaq::all();
        $bestMatch = null;
        $highestScore = 0;
        $suggestions = [];

        foreach ($faqs as $faq) {
            $questionTokens = $this->tokenize($faq->question);
            
            $intersect = array_intersect($userTokens, $questionTokens);
            $union = array_unique(array_merge($userTokens, $questionTokens));
            
            $score = count($union) > 0 ? (count($intersect) / count($union)) : 0;

            foreach ($userTokens as $token) {
                if (str_contains(strtolower($faq->question), $token)) {
                    $score += 0.25;
                }
            }

            if ($score > 0) {
                $suggestions[] = [
                    'faq' => $faq,
                    'score' => $score
                ];
            }

            if ($score > $highestScore) {
                $highestScore = $score;
                $bestMatch = $faq;
            }
        }

        if ($bestMatch && $highestScore >= 0.25) {
            return response()->json([
                'reply' => $bestMatch->answer,
                'redirect' => false
            ]);
        }

        if (!empty($suggestions)) {
            usort($suggestions, fn($a, $b) => $b['score'] <=> $a['score']);
            $topSuggestions = array_slice($suggestions, 0, 3);
            $questionsList = array_map(fn($item) => $item['faq']->question, $topSuggestions);

            return response()->json([
                'reply' => 'I couldn\'t find an exact match for that locally. Did you mean one of these questions?',
                'suggestions' => $questionsList,
                'redirect' => false
            ]);
        }

        return response()->json([
            'reply' => 'I couldn\'t find any matching answers. To enable dynamic AI conversational support, please configure the <code>GEMINI_API_KEY</code> in the site\'s settings!',
            'suggestions' => $this->getGeneralSuggestions(),
            'redirect' => true
        ]);
    }

    private function tokenize($text)
    {
        $clean = preg_replace('/[^\w\s]/', '', strtolower($text));
        $words = explode(' ', $clean);
        $stopWords = ['is', 'a', 'the', 'what', 'how', 'who', 'where', 'why', 'of', 'in', 'on', 'at', 'to', 'for', 'with', 'about', 'our', 'your', 'you', 'me', 'i', 'please', 'can'];
        return array_values(array_filter($words, fn($word) => strlen($word) > 1 && !in_array($word, $stopWords)));
    }

    private function getGeneralSuggestions()
    {
        return ChatbotFaq::select('question')->latest()->take(3)->pluck('question')->toArray();
    }

    public function questions()
    {
        $questions = ChatbotFaq::select('question')->latest()->get();
        return response()->json($questions);
    }
}