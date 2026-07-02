<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutSocialResponsibility;

class AboutSocialResponsibilityController extends Controller
{

    public function list()
    {
        $data['socials'] = AboutSocialResponsibility::latest()->get();

        return view('backend.about.social.list', $data);
    }

    public function add()
    {
        return view('backend.about.social.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg'
        ]);

        $social = new AboutSocialResponsibility();

        $social->name = $request->name;
        $social->title = $request->title;
        $social->sub_title = $request->sub_title;
        $social->phone = $request->phone;

        $social->heading = $request->heading;
        $social->sub_heading = $request->sub_heading;
        $social->description = $request->description;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/social'), $filename);

            $social->photo = $filename;
        }

        $social->save();

        return redirect('admin/about?tab=social-responsibility')
            ->with('success', 'Added Successfully');

    }

    public function edit($id)
    {

        $data['social'] = AboutSocialResponsibility::findOrFail($id);

        return view('backend.about.social.edit', $data);

    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg'
        ]);

        $social = AboutSocialResponsibility::findOrFail($id);

        $social->name = $request->name;
        $social->title = $request->title;
        $social->sub_title = $request->sub_title;
        $social->phone = $request->phone;

        $social->heading = $request->heading;
        $social->sub_heading = $request->sub_heading;
        $social->description = $request->description;

        if ($request->hasFile('photo')) {

            $oldPath = public_path('uploads/social/' . $social->photo);

            if (!empty($social->photo) && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/social'), $filename);

            $social->photo = $filename;
        }

        $social->save();

        return redirect('admin/about?tab=social-responsibility')
            ->with('success', 'Updated Successfully');

    }

    public function delete($id)
    {

        $social = AboutSocialResponsibility::findOrFail($id);

        if ($social->photo && file_exists(public_path('uploads/social/' . $social->photo))) {
            unlink(public_path('uploads/social/' . $social->photo));
        }

        $social->delete();

        return redirect('admin/about?tab=social-responsibility')
            ->with('success', 'Deleted Successfully');

    }

}
