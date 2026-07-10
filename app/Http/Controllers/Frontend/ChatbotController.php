<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use App\Models\Product;
use App\Models\AboutLeadership;
use App\Models\NewsArticle;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $message = trim($request->message);
        if (empty($message)) {
            return response()->json(['reply' => 'Please type a valid question.']);
        }

        $cleanMsg = strtolower($message);

        // 1. TOPIC: CMD / LEADERSHIP / JOURNEY
        if ($this->hasKeywords($cleanMsg, ['cmd', 'chairman', 'managing director', 'leadership', 'journey', 'message', 'leader', 'leaders'])) {
            $leaders = AboutLeadership::orderBy('position', 'asc')->get();
            if ($leaders->isNotEmpty()) {
                $cmd = $leaders->first(); // The CMD is typically first in position
                $reply = "Our Chairman & Managing Director (CMD) is <strong>{$cmd->name}</strong>.<br>";
                if (!empty($cmd->message)) {
                    $cleanMsgText = strip_tags($cmd->message);
                    if (strlen($cleanMsgText) > 250) {
                        $cleanMsgText = substr($cleanMsgText, 0, 250) . "...";
                    }
                    $reply .= "<strong>His Message & Journey:</strong> \"<i>{$cleanMsgText}</i>\"";
                }
                return response()->json(['reply' => $reply, 'redirect' => false]);
            }
        }

        // 2. TOPIC: SPECIFIC PRODUCT DETECT & DYNAMIC INFO
        $products = Product::with('category')->get();
        foreach ($products as $product) {
            $productTitle = strtolower($product->title);
            // If the query mentions a specific product name
            if (str_contains($cleanMsg, $productTitle) || $this->hasCommonKeywords($cleanMsg, $productTitle)) {
                $categoryName = $product->category->name ?? 'Defense Systems';
                $desc = strip_tags($product->description);
                if (strlen($desc) > 200) {
                    $desc = substr($desc, 0, 200) . "...";
                }
                $reply = "Here is the dynamic info for <strong>{$product->title}</strong>:<br>";
                $reply .= "Category: <strong>{$categoryName}</strong><br>";
                $reply .= "Specifications: {$desc}<br>";
                $reply .= "You can view its details under our Products page!";
                return response()->json(['reply' => $reply, 'redirect' => false]);
            }
        }

        // 3. TOPIC: GENERAL PRODUCTS / CATALOG
        if ($this->hasKeywords($cleanMsg, ['product', 'products', 'parachute', 'parachutes', 'catalog', 'make', 'manufacture', 'specs', 'specifications'])) {
            $productsList = Product::take(4)->get();
            if ($productsList->isNotEmpty()) {
                $reply = "Gliders India Limited manufactures premium parachute systems. Our featured products include:<br><ul>";
                foreach ($productsList as $p) {
                    $reply .= "<li><strong>{$p->title}</strong></li>";
                }
                $reply .= "</ul>You can check the full specifications on our Products page!";
                return response()->json(['reply' => $reply, 'redirect' => false]);
            }
        }

        // 4. TOPIC: LATEST NEWS / UPDATES
        if ($this->hasKeywords($cleanMsg, ['news', 'update', 'updates', 'article', 'articles', 'latest', 'event', 'events'])) {
            $news = NewsArticle::where('status', 'Published')->latest()->take(3)->get();
            if ($news->isNotEmpty()) {
                $reply = "Here are the latest updates from Gliders India:<br><ul style='padding-left: 15px;'>";
                foreach ($news as $article) {
                    $reply .= "<li style='margin-bottom: 8px;'><strong>{$article->title}</strong> (Published: {$article->created_at->format('d M Y')})</li>";
                }
                $reply .= "</ul>";
                return response()->json(['reply' => $reply, 'redirect' => false]);
            }
        }

        // 5. TOPIC: CONTACT / ADDRESS / EMAIL / HEADQUARTERS
        if ($this->hasKeywords($cleanMsg, ['contact', 'address', 'email', 'phone', 'location', 'headquarters', 'hq', 'office', 'where'])) {
            $settings = GeneralSetting::first();
            $reply = "You can contact Gliders India Limited through the following channels:<br>";
            if ($settings) {
                if (!empty($settings->contact_email)) {
                    $reply .= "Email: <strong>{$settings->contact_email}</strong><br>";
                }
                if (!empty($settings->footer_address)) {
                    $reply .= "Headquarters: " . strip_tags($settings->footer_address) . "<br>";
                }
            } else {
                $reply .= "Email: <strong>contact@glidersindia.in</strong><br>";
                $reply .= "Headquarters: Kanpur, Uttar Pradesh, India.<br>";
            }
            return response()->json(['reply' => $reply, 'redirect' => false]);
        }

        // 6. GENERAL STATIC FAQ FUZZY MATCH
        return $this->handleLocalFuzzyMatch($message);
    }

    private function hasKeywords($text, $keywords)
    {
        foreach ($keywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return true;
            }
        }
        return false;
    }

    private function hasCommonKeywords($text1, $text2)
    {
        $words1 = explode(' ', preg_replace('/[^\w\s]/', '', $text1));
        $words2 = explode(' ', preg_replace('/[^\w\s]/', '', $text2));
        $intersect = array_intersect($words1, $words2);
        
        // Remove common short noise words
        $intersect = array_filter($intersect, fn($w) => strlen($w) > 3);
        
        return count($intersect) > 0;
    }

    private function handleLocalFuzzyMatch($message)
    {
        $userTokens = $this->tokenize($message);
        if (empty($userTokens)) {
            return response()->json([
                'reply' => 'I didn\'t quite catch that. Could you please select one of the common questions below?',
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
                'reply' => 'I couldn\'t find an exact match for that. Did you mean one of these questions?',
                'suggestions' => $questionsList,
                'redirect' => false
            ]);
        }

        return response()->json([
            'reply' => 'I couldn\'t find any matching answers in our database. Let me scroll you down to our support inquiry form below so you can write to us directly!',
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