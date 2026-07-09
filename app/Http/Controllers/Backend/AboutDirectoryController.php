<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutDirectory;
use Illuminate\Support\Facades\File;
class AboutDirectoryController extends Controller
{

    public function list()
    {
        $data['directories'] = AboutDirectory::latest()->get();

        return view('backend.about.directory.list', $data);
    }


    public function add()
    {
        return view('backend.about.directory.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
        ]);


        if ($request->hasFile('profile_photo')) {

            $file = $request->file('profile_photo');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/directory'), $name);

        } else {
            return back()->with('error', 'Profile photo is required');
        }
        $mobiles = array_filter($request->mobiles);
        $emails = array_filter($request->emails);

        AboutDirectory::create([
            'role' => $request->role,
            'sr_no' => $request->sr_no,
            'org' => $request->org,
            'name' => $request->name,
            'designation' => $request->designation,
            'sub_designation' => $request->sub_designation,
            'mobile_no' => $mobiles, // ✅ NO json_encode
            'telephone_number' => $request->telephone_number,
            'fax' => $request->fax,
            'email' => $emails, // ✅ NO json_encode
            'deals_in' => $request->deals_in,
            'profile_photo' => $name,
        ]);

        return redirect('admin/about?tab=directory')
            ->with('success', 'Directory Added Successfully');
    }


    public function edit($id)
    {

        $data['directory'] = AboutDirectory::findOrFail($id);

        return view('backend.about.directory.edit', $data);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $directory = AboutDirectory::findOrFail($id);

        if ($request->hasFile('profile_photo')) {

            $oldPath = public_path('uploads/directory/' . $directory->profile_photo);

            if ($directory->profile_photo && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('profile_photo');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/directory'), $name);

        } else {
            $name = $directory->profile_photo;
        }

        $mobiles = array_filter($request->mobiles);
        $emails = array_filter($request->emails);

        $directory->update([
            'role' => $request->role,
            'sr_no' => $request->sr_no,
            'org' => $request->org,
            'name' => $request->name,
            'designation' => $request->designation,
            'sub_designation' => $request->sub_designation,
            'mobile_no' => $mobiles,
            'telephone_number' => $request->telephone_number,
            'fax' => $request->fax,
            'email' => $emails,
            'deals_in' => $request->deals_in,
            'profile_photo' => $name,
        ]);

        return redirect('admin/about?tab=directory')
            ->with('success', 'Directory Updated Successfully');
    }


    public function delete($id)
    {
        $directory = AboutDirectory::findOrFail($id);

        if ($directory->profile_photo) {
            $path = public_path('uploads/directory/' . $directory->profile_photo);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $directory->delete();

        return redirect('admin/about?tab=directory')
            ->with('success', 'Deleted Successfully');
    }

}
