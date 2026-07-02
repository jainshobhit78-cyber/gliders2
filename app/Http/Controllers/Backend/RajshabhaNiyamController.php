<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RajshabhaNiyam;

class RajshabhaNiyamController extends Controller
{

    public function list()
    {

        $items = RajshabhaNiyam::latest()->get();

        return view('backend.rajshabha.niyam.list', compact('items'));

    }


    public function add()
    {

        return view('backend.rajshabha.niyam.add');

    }


    public function store(Request $request)
    {

        $pdf = null;

        if ($request->hasFile('pdf')) {

            $pdf = time() . '.' . $request->pdf->extension();

            $request->pdf->move(public_path('uploads/rajshabha'), $pdf);

        }

        RajshabhaNiyam::create([
            'heading' => $request->heading,
            'pdf' => $pdf
        ]);

        return redirect('admin/rajshabha?tab=niyam');

    }


    public function edit($id)
    {

        $item = RajshabhaNiyam::findOrFail($id);

        return view('backend.rajshabha.niyam.edit', compact('item'));

    }


    public function update(Request $request, $id)
    {

        $item = RajshabhaNiyam::findOrFail($id);

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

        return redirect('admin/rajshabha?tab=niyam');

    }


    public function delete($id)
    {

        $item = RajshabhaNiyam::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/rajshabha/' . $item->pdf))) {
            unlink(public_path('uploads/rajshabha/' . $item->pdf));
        }

        $item->delete();

        return redirect()->back();

    }

}
