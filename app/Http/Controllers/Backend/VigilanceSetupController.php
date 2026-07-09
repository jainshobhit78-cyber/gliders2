<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VigilanceSetup;

class VigilanceSetupController extends Controller
{

    public function list()
    {
        $data['setups'] = VigilanceSetup::latest()->get();

        return view('backend.vigilance.setup.list', $data);
    }


    public function add()
    {
        return view('backend.vigilance.setup.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $setup = new VigilanceSetup();

        $setup->description = $request->description;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/vigilance'), $filename);

            $setup->image = $filename;

        }

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/vigilance'), $filename);

            $setup->pdf = $filename;

        }

        $setup->save();

        return redirect('admin/vigilance?tab=setup')
            ->with('success', 'Added Successfully');

    }


    public function edit($id)
    {
        $data['setup'] = VigilanceSetup::findOrFail($id);

        return view('backend.vigilance.setup.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $setup = VigilanceSetup::findOrFail($id);

        $setup->description = $request->description;

        if ($request->hasFile('image')) {

            if ($setup->image && file_exists(public_path('uploads/vigilance/' . $setup->image))) {
                unlink(public_path('uploads/vigilance/' . $setup->image));
            }

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/vigilance'), $filename);

            $setup->image = $filename;

        }

        if ($request->hasFile('pdf')) {

            if ($setup->pdf && file_exists(public_path('uploads/vigilance/' . $setup->pdf))) {
                unlink(public_path('uploads/vigilance/' . $setup->pdf));
            }

            $file = $request->file('pdf');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/vigilance'), $filename);

            $setup->pdf = $filename;

        }

        $setup->save();

        return redirect('admin/vigilance?tab=setup')
            ->with('success', 'Updated Successfully');

    }


    public function delete($id)
    {

        $setup = VigilanceSetup::findOrFail($id);

        if ($setup->image && file_exists(public_path('uploads/vigilance/' . $setup->image))) {
            unlink(public_path('uploads/vigilance/' . $setup->image));
        }

        if ($setup->pdf && file_exists(public_path('uploads/vigilance/' . $setup->pdf))) {
            unlink(public_path('uploads/vigilance/' . $setup->pdf));
        }

        $setup->delete();

        return redirect('admin/vigilance?tab=setup')
            ->with('success', 'Deleted Successfully');

    }

}
