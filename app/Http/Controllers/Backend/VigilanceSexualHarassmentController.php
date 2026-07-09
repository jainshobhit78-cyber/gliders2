<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VigilanceSexualHarassment;

class VigilanceSexualHarassmentController extends Controller
{

    public function list()
    {
        $data['items'] = VigilanceSexualHarassment::latest()->get();

        return view('backend.vigilance.harassment.list', $data);
    }


    public function add()
    {
        return view('backend.vigilance.harassment.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = new VigilanceSexualHarassment();

        $item->info_text = $request->info_text;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = $file->hashName();
            $file->move(public_path('uploads/vigilance'), $filename);

            $item->image = $filename;

        }

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $filename = $file->hashName();
            $file->move(public_path('uploads/vigilance'), $filename);

            $item->pdf = $filename;

        }

        $item->save();

        return redirect('admin/vigilance?tab=harassment')
            ->with('success', 'Added Successfully');

    }


    public function edit($id)
    {

        $data['item'] = VigilanceSexualHarassment::findOrFail($id);

        return view('backend.vigilance.harassment.edit', $data);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = VigilanceSexualHarassment::findOrFail($id);

        $item->info_text = $request->info_text;

        if ($request->hasFile('image')) {

            if ($item->image && file_exists(public_path('uploads/vigilance/' . $item->image))) {

                unlink(public_path('uploads/vigilance/' . $item->image));

            }

            $file = $request->file('image');

            $filename = $file->hashName();
            $file->move(public_path('uploads/vigilance'), $filename);

            $item->image = $filename;

        }


        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/vigilance/' . $item->pdf))) {

                unlink(public_path('uploads/vigilance/' . $item->pdf));

            }

            $file = $request->file('pdf');

            $filename = $file->hashName();
            $file->move(public_path('uploads/vigilance'), $filename);

            $item->pdf = $filename;

        }

        $item->save();

        return redirect('admin/vigilance?tab=harassment')
            ->with('success', 'Updated Successfully');

    }


    public function delete($id)
    {

        $item = VigilanceSexualHarassment::findOrFail($id);

        if ($item->image && file_exists(public_path('uploads/vigilance/' . $item->image))) {

            unlink(public_path('uploads/vigilance/' . $item->image));

        }

        if ($item->pdf && file_exists(public_path('uploads/vigilance/' . $item->pdf))) {

            unlink(public_path('uploads/vigilance/' . $item->pdf));

        }

        $item->delete();

        return redirect('admin/vigilance?tab=harassment')
            ->with('success', 'Deleted Successfully');

    }

}

