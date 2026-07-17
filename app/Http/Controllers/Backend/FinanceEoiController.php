<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceEoi;

class FinanceEoiController extends Controller
{

    public function list()
    {
        $data['items'] = FinanceEoi::orderBy('display_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.finance.eoi.list', $data);
    }


    public function add()
    {
        return view('backend.finance.eoi.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $pdfName = null;

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $pdfName = \App\Support\UploadedDocument::store($file, public_path('uploads/finance'));

        }

        $maxOrder = FinanceEoi::max('display_order');
        $displayOrder = $maxOrder ? $maxOrder + 1 : 1;

        FinanceEoi::create([
            'title' => $request->title,
            'description' => $request->description,
            'pdf' => $pdfName,
            'display_order' => $displayOrder
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
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = FinanceEoi::findOrFail($id);

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/finance/' . $item->pdf))) {

                unlink(public_path('uploads/finance/' . $item->pdf));

            }

            $file = $request->file('pdf');

            $pdfName = \App\Support\UploadedDocument::store($file, public_path('uploads/finance'));

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

    public function reorder(Request $request)
    {
        if ($request->has('order') && is_array($request->order)) {
            foreach ($request->order as $position => $id) {
                FinanceEoi::where('id', $id)->update(['display_order' => $position + 1]);
            }
            return response()->json(['status' => 'success']);
        }

        if ($request->has('id') && $request->has('display_order')) {
            FinanceEoi::where('id', $request->id)->update(['display_order' => $request->display_order]);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 400);
    }

}
