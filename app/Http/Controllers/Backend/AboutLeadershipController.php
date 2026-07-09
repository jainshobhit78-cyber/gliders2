<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LeadershipMilestone;
use Illuminate\Http\Request;
use App\Models\AboutLeadership;

class AboutLeadershipController extends Controller
{

    public function list()
    {
        $data['leaders'] = AboutLeadership::orderBy('position', 'asc')->get();

        return view('backend.about.leadership.list', $data);
    }


    public function add()
    {
        return view('backend.about.leadership.add');
    }


    public function store(Request $request)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $pictureName = null;
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $pictureName = $file->hashName();
            $file->move(public_path('uploads/leadership'), $pictureName);
        }

        $leader = AboutLeadership::create([
            'leader_name' => $request->leader_name,
            'role' => $request->role,
            'sub_title' => $request->sub_title,
            'bio' => $request->bio,
            'position' => $request->position,
            'picture' => $pictureName,
        ]);

        if ($request->has('milestones')) {

            foreach ($request->milestones as $index => $milestone) {

                // Skip empty milestone
                if (
                    empty($milestone['start_date']) &&
                    empty($milestone['end_date']) &&
                    empty($milestone['heading']) &&
                    empty($milestone['description']) &&
                    empty($milestone['image'])
                ) {
                    continue;
                }

                $imageName = null;

                if ($request->hasFile("milestones.$index.image")) {
                    $file = $request->file("milestones.$index.image");

                    $imageName = $file->hashName();
                    $file->move(public_path('uploads/milestones'), $imageName);
                }

                LeadershipMilestone::create([
                    'leadership_id' => $leader->id,
                    'start_date' => $milestone['start_date'] ?? null,
                    'end_date' => $milestone['end_date'] ?? null,
                    'heading' => $milestone['heading'] ?? null,
                    'description' => $milestone['description'] ?? null,
                    'image' => $imageName
                ]);
            }
        }

        return redirect('admin/about')
            ->with('success', 'Leadership Added Successfully');
    }

    public function edit($id)
    {
        $leader = AboutLeadership::with('milestones')->findOrFail($id);

        return view('backend.about.leadership.edit', compact('leader'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg',
        ]);

        $leader = AboutLeadership::findOrFail($id);

        $pictureName = $leader->picture;
        if ($request->hasFile('picture')) {
            if ($leader->picture && file_exists(public_path('uploads/leadership/' . $leader->picture))) {
                unlink(public_path('uploads/leadership/' . $leader->picture));
            }
            $file = $request->file('picture');
            $pictureName = $file->hashName();
            $file->move(public_path('uploads/leadership'), $pictureName);
        }

        // ✅ Update leader data
        $leader->update([
            'leader_name' => $request->leader_name,
            'role' => $request->role,
            'sub_title' => $request->sub_title,
            'bio' => $request->bio,
            'position' => $request->position,
            'picture' => $pictureName,
        ]);

        $existingIds = [];

        if ($request->has('milestones')) {

            foreach ($request->milestones as $index => $milestone) {

                // ✅ Skip empty rows
                if (
                    empty($milestone['start_date']) &&
                    empty($milestone['end_date']) &&
                    empty($milestone['heading']) &&
                    empty($milestone['description'])
                ) {
                    continue;
                }

                // ✅ Keep old image by default
                $imageName = $milestone['old_image'] ?? null;

                // ✅ Upload new image (if exists)
                if ($request->hasFile("milestones.$index.image")) {

                    // 👉 delete old image
                    if (!empty($milestone['old_image']) && file_exists(public_path('uploads/milestones/' . $milestone['old_image']))) {
                        unlink(public_path('uploads/milestones/' . $milestone['old_image']));
                    }

                    $file = $request->file("milestones.$index.image");
                    $imageName = $file->hashName();
                    $file->move(public_path('uploads/milestones'), $imageName);
                }

                // ✅ UPDATE existing milestone
                if (!empty($milestone['id'])) {

                    $existingIds[] = $milestone['id'];

                    LeadershipMilestone::where('id', $milestone['id'])->update([
                        'start_date' => $milestone['start_date'] ?? null,
                        'end_date' => $milestone['end_date'] ?? null,
                        'heading' => $milestone['heading'] ?? null,
                        'description' => $milestone['description'] ?? null,
                        'image' => $imageName
                    ]);

                } else {
                    // ✅ CREATE new milestone

                    $new = LeadershipMilestone::create([
                        'leadership_id' => $leader->id,
                        'start_date' => $milestone['start_date'] ?? null,
                        'end_date' => $milestone['end_date'] ?? null,
                        'heading' => $milestone['heading'] ?? null,
                        'description' => $milestone['description'] ?? null,
                        'image' => $imageName
                    ]);

                    $existingIds[] = $new->id;
                }
            }
        }

        // ✅ DELETE removed milestones
        $oldMilestones = LeadershipMilestone::where('leadership_id', $leader->id)->get();

        foreach ($oldMilestones as $old) {

            if (!in_array($old->id, $existingIds)) {

                // 👉 delete image file
                if ($old->image && file_exists(public_path('uploads/milestones/' . $old->image))) {
                    unlink(public_path('uploads/milestones/' . $old->image));
                }

                $old->delete();
            }
        }

        return redirect('admin/about')
            ->with('success', 'Leadership Updated Successfully');
    }

    public function delete($id)
    {
        $leader = AboutLeadership::findOrFail($id);

        if ($leader->picture && file_exists(public_path('uploads/leadership/' . $leader->picture))) {
            unlink(public_path('uploads/leadership/' . $leader->picture));
        }

        $leader->delete();

        return redirect()->back()
            ->with('success', 'Leadership Deleted Successfully');
    }

}

