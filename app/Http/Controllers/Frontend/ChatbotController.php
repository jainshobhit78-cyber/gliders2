<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $message = trim($request->message);
        if (empty($message)) {
            return response()->json(['reply' => 'Please type a valid question.']);
        }

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
            
            // Calculate Jaccard similarity score (token overlap)
            $intersect = array_intersect($userTokens, $questionTokens);
            $union = array_unique(array_merge($userTokens, $questionTokens));
            
            $score = count($union) > 0 ? (count($intersect) / count($union)) : 0;

            // Extra weight for exact keyword matches
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

        // threshold for direct reply
        if ($bestMatch && $highestScore >= 0.25) {
            return response()->json([
                'reply' => $bestMatch->answer,
                'redirect' => false
            ]);
        }

        // If score is low but we have partial matches, suggest them
        if (!empty($suggestions)) {
            // Sort by score descending
            usort($suggestions, fn($a, $b) => $b['score'] <=> $a['score']);
            
            $topSuggestions = array_slice($suggestions, 0, 3);
            $questionsList = array_map(fn($item) => $item['faq']->question, $topSuggestions);

            return response()->json([
                'reply' => 'I couldn\'t find an exact match for that. Did you mean one of these questions?',
                'suggestions' => $questionsList,
                'redirect' => false
            ]);
        }

        // Absolute fallback
        return response()->json([
            'reply' => 'I couldn\'t find any matching questions in our database. Let me scroll you down to our support inquiry form below so you can write to us directly!',
            'suggestions' => $this->getGeneralSuggestions(),
            'redirect' => true
        ]);
    }

    private function tokenize($text)
    {
        // Lowercase and strip punctuation
        $clean = preg_replace('/[^\w\s]/', '', strtolower($text));
        $words = explode(' ', $clean);

        // Stop words to ignore
        $stopWords = ['is', 'a', 'the', 'what', 'how', 'who', 'where', 'why', 'of', 'in', 'on', 'at', 'to', 'for', 'with', 'about', 'our', 'your', 'you', 'me', 'i', 'please', 'can'];

        return array_filter($words, fn($word) => strlen($word) > 1 && !in_array($word, $stopWords));
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