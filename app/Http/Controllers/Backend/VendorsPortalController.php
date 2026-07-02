<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorsPortal;

class VendorsPortalController extends Controller
{

    public function list()
    {

        $items = VendorsPortal::latest()->get();

        return view('backend.vendors.portal.list', compact('items'));

    }


    public function add()
    {

        return view('backend.vendors.portal.add');

    }


    public function store(Request $request)
    {

        $pdf = null;

        if ($request->hasFile('pdf')) {

            $pdf = time() . '.' . $request->pdf->extension();

            $request->pdf->move(public_path('uploads/vendors'), $pdf);

        }

        VendorsPortal::create([
            'title' => $request->title,
            'pdf' => $pdf
        ]);

        return redirect('admin/vendors?tab=portal');

    }


    public function edit($id)
    {

        $item = VendorsPortal::findOrFail($id);

        return view('backend.vendors.portal.edit', compact('item'));

    }


    public function update(Request $request, $id)
    {

        $item = VendorsPortal::findOrFail($id);

        $pdf = $item->pdf;

        if ($request->hasFile('pdf')) {

            if ($item->pdf && file_exists(public_path('uploads/vendors/' . $item->pdf))) {
                unlink(public_path('uploads/vendors/' . $item->pdf));
            }

            $pdf = time() . '.' . $request->pdf->extension();

            $request->pdf->move(public_path('uploads/vendors'), $pdf);

        }

        $item->update([
            'title' => $request->title,
            'pdf' => $pdf
        ]);

        return redirect('admin/vendors?tab=portal');

    }


    public function delete($id)
    {

        $item = VendorsPortal::findOrFail($id);

        if ($item->pdf && file_exists(public_path('uploads/vendors/' . $item->pdf))) {
            unlink(public_path('uploads/vendors/' . $item->pdf));
        }

        $item->delete();

        return redirect()->back();

    }

}
