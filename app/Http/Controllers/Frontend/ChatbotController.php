<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $message = strtolower(trim($request->message));

        $faq = ChatbotFaq::whereRaw('LOWER(question) = ?', [$message])
            ->orWhereRaw('LOWER(question) LIKE ?', ["%{$message}%"])
            ->first();

        if ($faq) {
            return response()->json([
                'reply' => $faq->answer,
                'redirect' => false
            ]);
        }

        return response()->json([
            'reply' => 'Sorry, I could not find the exact answer. Redirecting you to our contact form...',
            'redirect' => true
        ]);
    }

    public function questions()
    {
        $questions = ChatbotFaq::select('question')->latest()->get();

        return response()->json($questions);
    }
}