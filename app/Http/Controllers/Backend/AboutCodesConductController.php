<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutCodesConduct;

class AboutCodesConductController extends Controller
{

    public function list()
    {
        $data['codes'] = AboutCodesConduct::latest()->get();

        return view('backend.about.codes.list', $data);
    }


    public function add()
    {
        return view('backend.about.codes.add');
    }


    public function store(Request $request)
    {

        $code = new AboutCodesConduct();

        $code->title = $request->title;
        $code->description = $request->description;

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/codes'), $filename);

            $code->pdf = $filename;

        }

        $code->save();

        return redirect('admin/about?tab=codes')
            ->with('success', 'Added Successfully');

    }


    public function edit($id)
    {

        $data['code'] = AboutCodesConduct::findOrFail($id);

        return view('backend.about.codes.edit', $data);

    }


    public function update(Request $request, $id)
    {
        $code = AboutCodesConduct::findOrFail($id);

        $code->title = $request->title;
        $code->description = $request->description;

        if ($request->remove_pdf == 1) {
            if ($code->pdf && file_exists(public_path('uploads/codes/' . $code->pdf))) {
                unlink(public_path('uploads/codes/' . $code->pdf));
            }
            $code->pdf = null;
        }
        if ($request->hasFile('pdf')) {

            // delete old pdf first
            if ($code->pdf && file_exists(public_path('uploads/codes/' . $code->pdf))) {
                unlink(public_path('uploads/codes/' . $code->pdf));
            }

            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/codes'), $filename);

            $code->pdf = $filename;
        }

        $code->save();

        return redirect('admin/about?tab=codes')
            ->with('success', 'Updated Successfully');
    }


    public function delete($id)
    {

        $code = AboutCodesConduct::findOrFail($id);

        if ($code->pdf && file_exists(public_path('uploads/codes/' . $code->pdf))) {
            unlink(public_path('uploads/codes/' . $code->pdf));
        }

        $code->delete();

        return redirect('admin/about?tab=codes')
            ->with('success', 'Deleted Successfully');

    }

}
