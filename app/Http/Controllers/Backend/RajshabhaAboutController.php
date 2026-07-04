<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RajshabhaAbout;

class RajshabhaAboutController extends Controller
{

    public function list()
    {

        $items = RajshabhaAbout::latest()->get();

        return view('backend.rajshabha.about.list', compact('items'));

    }


    public function add()
    {

        return view('backend.rajshabha.about.add');

    }


    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $pdf = null;

        if ($request->hasFile('pdf')) {
            $pdf = time() . '.' . $request->pdf->extension();
            $request->pdf->move(public_path('uploads/rajshabha'), $pdf);
        }

        RajshabhaAbout::create([
            'heading' => $request->heading,
            'description' => $request->description,
            'pdf' => $pdf
        ]);

        return redirect('admin/rajshabha?tab=about');

    }


    public function edit($id)
    {

        $item = RajshabhaAbout::findOrFail($id);

        return view('backend.rajshabha.about.edit', compact('item'));

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = RajshabhaAbout::findOrFail($id);

        $pdf = $item->pdf;

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/rajshabha/' . $item->pdf))) {
                unlink(public_path('uploads/rajshabha/' . $item->pdf));
            }

            $pdf = time() . '.' . $request->pdf->extension();

            $request->pdf->move(public_path('uploads/rajshabha'), $pdf);

        }

        $item->update([
            'heading' => $request->heading,
            'description' => $request->description,
            'pdf' => $pdf
        ]);

        return redirect('admin/rajshabha?tab=about');

    }


    public function delete($id)
    {

        $item = RajshabhaAbout::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/rajshabha/' . $item->pdf))) {
            unlink(public_path('uploads/rajshabha/' . $item->pdf));
        }

        $item->delete();

        return redirect()->back();

    }

}
