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

        $pdf = null;

        if ($request->hasFile('pdf')) {

            $pdf = time() . '.' . $request->pdf->extension();

            $request->pdf->move(public_path('uploads/rajshabha'), $pdf);

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

        $item = RajshabhaRules::findOrFail($id);

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
