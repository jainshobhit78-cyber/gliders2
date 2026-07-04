<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ChatbotFaq;
use Illuminate\Http\Request;

class ChatbotFaqController extends Controller
{
    public function index()
    {
        $faqs = ChatbotFaq::latest()->get();
        return view('backend.chatbot.index', compact('faqs'));
    }

    public function create()
    {
        return view('backend.chatbot.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ]);

        ChatbotFaq::create($request->only(['question', 'answer']));

        return redirect()->route('chatbot.index')
            ->with('success', 'FAQ added successfully');
    }

    public function edit($id)
    {
        $faq = ChatbotFaq::findOrFail($id);
        return view('backend.chatbot.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = ChatbotFaq::findOrFail($id);

        $faq->update($request->only(['question', 'answer']));

        return redirect()->route('chatbot.index')
            ->with('success', 'FAQ updated successfully');
    }

    public function destroy($id)
    {
        ChatbotFaq::findOrFail($id)->delete();

        return back()->with('success', 'FAQ deleted successfully');
    }
}
