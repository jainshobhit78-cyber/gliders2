<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutMission;

class AboutMissionController extends Controller
{

    public function list()
    {
        $data['missions'] = AboutMission::latest()->get();

        return view('backend.about.mission.list', $data);
    }

    public function add()
    {
        return view('backend.about.mission.add');
    }

    public function store(Request $request)
    {

        AboutMission::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('admin/about?tab=mission')
            ->with('success', 'Mission Added Successfully');

    }

    public function edit($id)
    {

        $data['mission'] = AboutMission::findOrFail($id);

        return view('backend.about.mission.edit', $data);

    }

    public function update(Request $request, $id)
    {

        $mission = AboutMission::findOrFail($id);

        $mission->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('admin/about?tab=mission')
            ->with('success', 'Mission Updated Successfully');

    }

    public function delete($id)
    {

        $mission = AboutMission::findOrFail($id);

        $mission->delete();

        return redirect('admin/about?tab=mission')
            ->with('success', 'Deleted Successfully');

    }

}
