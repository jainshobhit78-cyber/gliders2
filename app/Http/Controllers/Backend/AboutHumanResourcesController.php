<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutHumanResources;

class AboutHumanResourcesController extends Controller
{
    public function list()
    {
        $data['hrs'] = AboutHumanResources::latest()->get();

        return view('backend.about.hr.list', $data);
    }

    public function add()
    {
        return view('backend.about.hr.add');
    }

    public function store(Request $request)
    {
        AboutHumanResources::create([
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->vision,
            'mission' => $request->mission,
            'objectives' => $request->objectives,
            'strategy' => $request->strategy,
        ]);

        return redirect('admin/about?tab=human-resources')
            ->with('success', 'Human Resource Added Successfully');
    }

    public function edit($id)
    {
        $data['hr'] = AboutHumanResources::findOrFail($id);

        return view('backend.about.hr.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $hr = AboutHumanResources::findOrFail($id);

        $hr->update([
            'title' => $request->title,
            'description' => $request->description,
            'vision' => $request->vision,
            'mission' => $request->mission,
            'objectives' => $request->objectives,
            'strategy' => $request->strategy,
        ]);

        return redirect('admin/about?tab=human-resources')
            ->with('success', 'Human Resource Updated Successfully');
    }

    public function delete($id)
    {
        $hr = AboutHumanResources::findOrFail($id);
        $hr->delete();

        return redirect('admin/about?tab=human-resources')
            ->with('success', 'Human Resource Deleted Successfully');
    }
}
