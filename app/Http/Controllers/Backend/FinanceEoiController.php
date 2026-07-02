<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceEoi;

class FinanceEoiController extends Controller
{

    public function list()
    {
        $data['items'] = FinanceEoi::latest()->get();

        return view('backend.finance.eoi.list', $data);
    }


    public function add()
    {
        return view('backend.finance.eoi.add');
    }


    public function store(Request $request)
    {

        $pdfName = null;

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $pdfName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/finance'), $pdfName);

        }

        FinanceEoi::create([
            'title' => $request->title,
            'description' => $request->description,
            'pdf' => $pdfName
        ]);

        return redirect('admin/finance?tab=eoi')
            ->with('success', 'Added Successfully');

    }


    public function edit($id)
    {

        $data['item'] = FinanceEoi::findOrFail($id);

        return view('backend.finance.eoi.edit', $data);

    }



    public function update(Request $request, $id)
    {

        $item = FinanceEoi::findOrFail($id);

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/finance/' . $item->pdf))) {

                unlink(public_path('uploads/finance/' . $item->pdf));

            }

            $file = $request->file('pdf');

            $pdfName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/finance'), $pdfName);

            $item->pdf = $pdfName;

        }

        $item->title = $request->title;
        $item->description = $request->description;

        $item->save();

        return redirect('admin/finance?tab=eoi')
            ->with('success', 'Updated Successfully');

    }



    public function delete($id)
    {

        $item = FinanceEoi::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/finance/' . $item->pdf))) {

            unlink(public_path('uploads/finance/' . $item->pdf));

        }

        $item->delete();

        return redirect('admin/finance?tab=eoi')
            ->with('success', 'Deleted Successfully');

    }

}
