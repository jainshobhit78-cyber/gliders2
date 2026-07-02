<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VigilanceCvo;

class VigilanceCvoController extends Controller
{

    public function list()
    {
        $data['cvos'] = VigilanceCvo::latest()->get();

        return view('backend.vigilance.cvo.list', $data);
    }

    public function add()
    {
        return view('backend.vigilance.cvo.add');
    }

    public function store(Request $request)
    {

        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg'
        ]);
        $cvo = new VigilanceCvo();

        $cvo->name = $request->name;
        $cvo->title = $request->title;
        $cvo->sub_title = $request->sub_title;
        $cvo->description = $request->description;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cvo'), $filename);

            $cvo->image = $filename;
        }

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cvo'), $filename);

            $cvo->pdf = $filename;
        }

        $cvo->save();

        return redirect('admin/vigilance?tab=cvo')
            ->with('success', 'Added Successfully');
    }

    public function edit($id)
    {

        $data['cvo'] = VigilanceCvo::findOrFail($id);

        return view('backend.vigilance.cvo.edit', $data);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg'
        ]);

        $cvo = VigilanceCvo::findOrFail($id);

        $cvo->name = $request->name;
        $cvo->title = $request->title;
        $cvo->sub_title = $request->sub_title;
        $cvo->description = $request->description;

        if ($request->hasFile('image')) {

            if ($cvo->image && file_exists(public_path('uploads/cvo/' . $cvo->image))) {
                unlink(public_path('uploads/cvo/' . $cvo->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cvo'), $filename);

            $cvo->image = $filename;
        }

        if ($request->hasFile('pdf')) {

            if ($cvo->pdf && file_exists(public_path('uploads/cvo/' . $cvo->pdf))) {
                unlink(public_path('uploads/cvo/' . $cvo->pdf));
            }

            $file = $request->file('pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cvo'), $filename);

            $cvo->pdf = $filename;
        }

        $cvo->save();

        return redirect('admin/vigilance?tab=cvo')
            ->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {

        $cvo = VigilanceCvo::findOrFail($id);

        if ($cvo->pdf && file_exists(public_path('uploads/cvo/' . $cvo->pdf))) {
            unlink(public_path('uploads/cvo/' . $cvo->pdf));
        }

        $cvo->delete();

        return redirect('admin/vigilance?tab=cvo')
            ->with('success', 'Deleted Successfully');

    }

}
