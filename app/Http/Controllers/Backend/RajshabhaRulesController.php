<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RajshabhaRules;

class RajshabhaRulesController extends Controller
{

    public function list()
    {

        $items = RajshabhaRules::latest()->get();

        return view('backend.rajshabha.rules.list', compact('items'));

    }


    public function add()
    {

        return view('backend.rajshabha.rules.add');

    }


    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $pdf = null;

        if ($request->hasFile('pdf')) {

            $pdf = \App\Support\UploadedDocument::store($request->file('pdf'), public_path('uploads/rajshabha'));

        }

        RajshabhaRules::create([
            'heading' => $request->heading,
            'pdf' => $pdf
        ]);

        return redirect('admin/rajshabha?tab=rules');

    }


    public function edit($id)
    {

        $item = RajshabhaRules::findOrFail($id);

        return view('backend.rajshabha.rules.edit', compact('item'));

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = RajshabhaRules::findOrFail($id);

        $pdf = $item->pdf;

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/rajshabha/' . $item->pdf))) {
                unlink(public_path('uploads/rajshabha/' . $item->pdf));
            }

            $pdf = \App\Support\UploadedDocument::store($request->file('pdf'), public_path('uploads/rajshabha'));

        }

        $item->update([
            'heading' => $request->heading,
            'pdf' => $pdf
        ]);

        return redirect('admin/rajshabha?tab=rules');

    }


    public function delete($id)
    {

        $item = RajshabhaRules::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/rajshabha/' . $item->pdf))) {
            unlink(public_path('uploads/rajshabha/' . $item->pdf));
        }

        $item->delete();

        return redirect()->back();

    }

}
