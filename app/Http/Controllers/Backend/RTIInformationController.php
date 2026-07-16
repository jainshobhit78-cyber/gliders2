<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RTIInformation;

class RTIInformationController extends Controller
{

    public function list()
    {
        $data['items'] = RTIInformation::latest()->get();

        return view('backend.rti.information.list', $data);
    }

    public function add()
    {
        return view('backend.rti.information.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = new RTIInformation();

        $item->info_text = $request->info_text;

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $filename = \App\Support\UploadedDocument::store($file, public_path('uploads/rti'));

            $item->pdf = $filename;
        }

        $item->save();

        return redirect('admin/rti?tab=information')
            ->with('success', 'Added Successfully');
    }


    public function edit($id)
    {
        $data['item'] = RTIInformation::findOrFail($id);

        return view('backend.rti.information.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = RTIInformation::findOrFail($id);

        $item->info_text = $request->info_text;

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/rti/' . $item->pdf))) {

                unlink(public_path('uploads/rti/' . $item->pdf));
            }

            $file = $request->file('pdf');

            $filename = \App\Support\UploadedDocument::store($file, public_path('uploads/rti'));

            $item->pdf = $filename;
        }

        $item->save();

        return redirect('admin/rti?tab=information')
            ->with('success', 'Updated Successfully');
    }


    public function delete($id)
    {

        $item = RTIInformation::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/rti/' . $item->pdf))) {

            unlink(public_path('uploads/rti/' . $item->pdf));
        }

        $item->delete();

        return redirect('admin/rti?tab=information')
            ->with('success', 'Deleted Successfully');
    }

}
