<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VigilanceBulletin;

class VigilanceBulletinController extends Controller
{

    public function list()
    {
        $data['items'] = VigilanceBulletin::latest()->get();

        return view('backend.vigilance.bulletin.list', $data);
    }

    public function add()
    {
        return view('backend.vigilance.bulletin.add');
    }

    public function store(Request $request)
    {

        $item = new VigilanceBulletin();

        $item->info_text = $request->info_text;

        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/vigilance'), $filename);

            $item->pdf = $filename;
        }

        $item->save();

        return redirect('admin/vigilance?tab=bulletin')
            ->with('success', 'Added Successfully');
    }

    public function edit($id)
    {

        $data['item'] = VigilanceBulletin::findOrFail($id);

        return view('backend.vigilance.bulletin.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $item = VigilanceBulletin::findOrFail($id);

        $item->info_text = $request->info_text;

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/vigilance/' . $item->pdf))) {

                unlink(public_path('uploads/vigilance/' . $item->pdf));
            }

            $file = $request->file('pdf');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/vigilance'), $filename);

            $item->pdf = $filename;
        }

        $item->save();

        return redirect('admin/vigilance?tab=bulletin')
            ->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {

        $item = VigilanceBulletin::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/vigilance/' . $item->pdf))) {

            unlink(public_path('uploads/vigilance/' . $item->pdf));
        }

        $item->delete();

        return redirect('admin/vigilance?tab=bulletin')
            ->with('success', 'Deleted Successfully');
    }

}
