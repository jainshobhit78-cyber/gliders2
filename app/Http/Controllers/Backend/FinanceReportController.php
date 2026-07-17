<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinanceReport;
use App\Models\FinanceReportFile;

class FinanceReportController extends Controller
{

    public function list()
    {
        $data['items'] = FinanceReport::with('files')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.finance.reports.list', $data);
    }


    public function add()
    {
        return view('backend.finance.reports.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'pdfs' => 'nullable|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
        ]);

        $maxOrder = FinanceReport::max('display_order');
        $displayOrder = $maxOrder ? $maxOrder + 1 : 1;

        $item = FinanceReport::create([
            'heading' => $request->heading,
            'description' => $request->description,
            'display_order' => $displayOrder
        ]);

        if ($request->hasFile('pdfs')) {

            foreach ($request->file('pdfs') as $pdf) {

                // IMPORTANT CHECK
                if ($pdf && $pdf->isValid()) {

                    $name = \App\Support\UploadedDocument::store($pdf, public_path('uploads/finance'));

                    FinanceReportFile::create([
                        'report_id' => $item->id,
                        'pdf' => $name
                    ]);
                }

            }

        }

        return redirect('admin/finance?tab=reports')
            ->with('success', 'Added Successfully');
    }


    public function edit($id)
    {
        $data['item'] = FinanceReport::with('files')->findOrFail($id);

        return view('backend.finance.reports.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pdfs' => 'nullable|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
        ]);

        $item = FinanceReport::findOrFail($id);

        $item->update([
            'heading' => $request->heading,
            'description' => $request->description
        ]);


        if ($request->hasFile('pdfs')) {

            foreach ($request->file('pdfs') as $pdf) {

                if ($pdf && $pdf->isValid()) {

                    $name = \App\Support\UploadedDocument::store($pdf, public_path('uploads/finance'));

                    FinanceReportFile::create([
                        'report_id' => $item->id,
                        'pdf' => $name
                    ]);

                }

            }

        }

        return redirect('admin/finance?tab=reports')
            ->with('success', 'Updated Successfully');

    }


    public function delete($id)
    {

        $item = FinanceReport::findOrFail($id);

        foreach ($item->files as $file) {

            if (file_exists(public_path('uploads/finance/' . $file->pdf))) {
                unlink(public_path('uploads/finance/' . $file->pdf));
            }

            $file->delete();

        }

        $item->delete();

        return redirect('admin/finance?tab=reports')
            ->with('success', 'Deleted Successfully');

    }



    public function deleteFile($id)
    {

        $file = FinanceReportFile::findOrFail($id);

        if (file_exists(public_path('uploads/finance/' . $file->pdf))) {
            unlink(public_path('uploads/finance/' . $file->pdf));
        }

        $file->delete();

        return redirect()->back()
            ->with('success', 'PDF Deleted');

    }

    public function reorder(Request $request)
    {
        if ($request->has('order') && is_array($request->order)) {
            foreach ($request->order as $position => $id) {
                FinanceReport::where('id', $id)->update(['display_order' => $position + 1]);
            }
            return response()->json(['status' => 'success']);
        }

        if ($request->has('id') && $request->has('display_order')) {
            FinanceReport::where('id', $request->id)->update(['display_order' => $request->display_order]);
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error'], 400);
    }

}
