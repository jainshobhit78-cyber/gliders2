<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutVision;

class AboutVisionController extends Controller
{

    public function list()
    {
        $data['visions'] = AboutVision::latest()->get();

        return view('backend.about.vision.list', $data);
    }


    public function add()
    {
        return view('backend.about.vision.add');
    }


    public function store(Request $request)
    {

        AboutVision::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('admin/about?tab=vision')
            ->with('success', 'Vision Added Successfully');

    }


    public function edit($id)
    {
        $data['vision'] = AboutVision::findOrFail($id);

        return view('backend.about.vision.edit', $data);
    }


    public function update(Request $request, $id)
    {

        $vision = AboutVision::findOrFail($id);

        $vision->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('admin/about?tab=vision')
            ->with('success', 'Vision Updated Successfully');

    }


    public function delete($id)
    {

        $vision = AboutVision::findOrFail($id);

        $vision->delete();

        return redirect('admin/about?tab=vision')
            ->with('success', 'Deleted Successfully');

    }

}
