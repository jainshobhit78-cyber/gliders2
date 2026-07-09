<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RTIOfficer;

class RTIOfficerController extends Controller
{

    public function list()
    {

        $data['items'] = RTIOfficer::latest()->get();

        return view('backend.rti.officers.list', $data);

    }


    public function add()
    {

        return view('backend.rti.officers.add');

    }


    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $item = new RTIOfficer();

        $item->title = $request->title;
        $item->name = $request->name;
        $item->post = $request->post;
        $item->email = $request->email;
        $item->phone = $request->phone;
        $item->role = $request->role;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/rti'), $filename);

            $item->image = $filename;

        }

        $item->save();

        return redirect('admin/rti?tab=officers')
            ->with('success', 'Added Successfully');

    }


    public function edit($id)
    {

        $data['item'] = RTIOfficer::findOrFail($id);

        return view('backend.rti.officers.edit', $data);

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $item = RTIOfficer::findOrFail($id);

        $item->title = $request->title;
        $item->name = $request->name;
        $item->post = $request->post;
        $item->email = $request->email;
        $item->phone = $request->phone;
        $item->role = $request->role;

        if ($request->hasFile('image')) {

            if ($item->image && file_exists(public_path('uploads/rti/' . $item->image))) {

                unlink(public_path('uploads/rti/' . $item->image));

            }

            $file = $request->file('image');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/rti'), $filename);

            $item->image = $filename;

        }

        $item->save();

        return redirect('admin/rti?tab=officers')
            ->with('success', 'Updated Successfully');

    }


    public function delete($id)
    {

        $item = RTIOfficer::findOrFail($id);

        if ($item->image && file_exists(public_path('uploads/rti/' . $item->image))) {

            unlink(public_path('uploads/rti/' . $item->image));

        }

        $item->delete();

        return redirect('admin/rti?tab=officers')
            ->with('success', 'Deleted Successfully');

    }

}
