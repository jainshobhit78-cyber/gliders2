<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutProductionUnitImage;
use App\Models\ProductionUnitMilestone;
use App\Models\ProductionUnitMilestoneImage;
use Illuminate\Http\Request;
use App\Models\AboutProductionUnit;

class AboutProductionUnitController extends Controller
{

    public function list()
    {
        $data['units'] = AboutProductionUnit::latest()->get();

        return view('backend.about.production.list', $data);
    }

    public function add()
    {
        return view('backend.about.production.add');
    }


    public function store(Request $request)
    {

        $unit = AboutProductionUnit::create([
            'profile' => $request->profile,
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'bio' => $request->bio
        ]);

        if ($request->has('milestones')) {

            foreach ($request->milestones as $index => $milestone) {

                if (
                    empty($milestone['milestone_date']) &&
                    empty($milestone['milestone_name']) &&
                    empty($milestone['bio'])
                ) {
                    continue;
                }

                /*
                ----------------------------
                VIDEO SAVE
                ----------------------------
                */

                $videoName = null;

                if ($request->hasFile("milestones.$index.video")) {

                    $video = $request->file("milestones.$index.video");

                    $videoName = $video->hashName();
                    $videoPath = public_path('uploads/production/videos');

                    if (!file_exists($videoPath)) {
                        mkdir($videoPath, 0755, true);
                    }

                    $video->move($videoPath, $videoName);
                }

                /*
                ----------------------------
                SAVE MILESTONE
                ----------------------------
                */

                $savedMilestone = ProductionUnitMilestone::create([
                    'production_id' => $unit->id,
                    'milestone_date' => $milestone['milestone_date'] ?? null,
                    'milestone_name' => $milestone['milestone_name'] ?? null,
                    'bio' => $milestone['bio'] ?? null,
                    'video' => $videoName
                ]);

                /*
                ----------------------------
                SAVE MULTIPLE IMAGES
                ----------------------------
                */

                $images = $request->file("milestones.$index.images");

                if (!empty($images)) {

                    $imagePath = public_path('uploads/production/images');

                    if (!file_exists($imagePath)) {
                        mkdir($imagePath, 0755, true);
                    }

                    foreach ($images as $imgIndex => $image) {

                        if (!$image) {
                            continue;
                        }

                        $imageName = time() . '_' . $index . '_' . $imgIndex . '.' .
                            $image->getClientOriginalExtension();

                        $image->move($imagePath, $imageName);

                        ProductionUnitMilestoneImage::create([
                            'milestone_id' => $savedMilestone->id,
                            'image' => $imageName,
                            'sort_order' => $imgIndex
                        ]);
                    }
                }
            }
        }

        return redirect('admin/about?tab=production-unit')
            ->with('success', 'Production Unit Added Successfully');
    }

    public function viewMilestones($id)
    {
        $unit = AboutProductionUnit::with('milestones.images')
            ->findOrFail($id);

        return view(
            'backend.about.production.view_milestones',
            compact('unit')
        );
    }


    public function edit($id)
    {
        $data['unit'] = AboutProductionUnit::findOrFail($id);

        return view('backend.about.production.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $unit = AboutProductionUnit::findOrFail($id);

        /*
        |--------------------------------
        | UPDATE MAIN UNIT DATA
        |--------------------------------
        */
        $unit->update([
            'profile' => $request->profile,
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
            'bio' => $request->bio
        ]);

        /*
        |--------------------------------
        | UPDATE / ADD MILESTONES
        |--------------------------------
        */
        if ($request->has('milestones')) {

            foreach ($request->milestones as $index => $milestone) {

                // skip empty milestone block
                if (
                    empty($milestone['milestone_date']) &&
                    empty($milestone['milestone_name']) &&
                    empty($milestone['bio']) &&
                    !$request->hasFile("milestones.$index.images") &&
                    !$request->hasFile("milestones.$index.video")
                ) {
                    continue;
                }

                /*
                |--------------------------------
                | UPDATE EXISTING OR CREATE NEW
                |--------------------------------
                */
                $savedMilestone = ProductionUnitMilestone::updateOrCreate(
                    [
                        'id' => $milestone['id'] ?? null
                    ],
                    [
                        'production_id' => $unit->id,
                        'milestone_date' => $milestone['milestone_date'] ?? null,
                        'milestone_name' => $milestone['milestone_name'] ?? null,
                        'bio' => $milestone['bio'] ?? null
                    ]
                );

                /*
                |--------------------------------
                | REMOVE OLD IMAGES
                |--------------------------------
                */
                if (!empty($milestone['removed_images'])) {

                    $removeIds = explode(',', $milestone['removed_images']);

                    foreach ($removeIds as $imgId) {

                        $oldImage = ProductionUnitMilestoneImage::find($imgId);

                        if ($oldImage) {

                            $path = public_path('uploads/production/images/' . $oldImage->image);

                            if (file_exists($path)) {
                                unlink($path);
                            }

                            $oldImage->delete();
                        }
                    }
                }

                /*
                |--------------------------------
                | ADD NEW IMAGES
                |--------------------------------
                */
                if ($request->hasFile("milestones.$index.images")) {

                    $images = $request->file("milestones.$index.images");

                    $imagePath = public_path('uploads/production/images');

                    if (!file_exists($imagePath)) {
                        mkdir($imagePath, 0755, true);
                    }

                    $lastOrder = ProductionUnitMilestoneImage::where(
                        'milestone_id',
                        $savedMilestone->id
                    )->max('sort_order') ?? 0;

                    foreach ($images as $imgIndex => $image) {

                        if (!$image) {
                            continue;
                        }

                        $imageName = $image->hashName();
                        $image->move($imagePath, $imageName);

                        ProductionUnitMilestoneImage::create([
                            'milestone_id' => $savedMilestone->id,
                            'image' => $imageName,
                            'sort_order' => $lastOrder + $imgIndex + 1
                        ]);
                    }
                }

                /*
                |--------------------------------
                | UPDATE VIDEO
                |--------------------------------
                */
                if ($request->hasFile("milestones.$index.video")) {

                    // delete old video
                    if ($savedMilestone->video) {

                        $oldVideoPath = public_path(
                            'uploads/production/videos/' . $savedMilestone->video
                        );

                        if (file_exists($oldVideoPath)) {
                            unlink($oldVideoPath);
                        }
                    }

                    $video = $request->file("milestones.$index.video");

                    $videoName = $video->hashName();
                    $videoPath = public_path('uploads/production/videos');

                    if (!file_exists($videoPath)) {
                        mkdir($videoPath, 0755, true);
                    }

                    $video->move($videoPath, $videoName);

                    $savedMilestone->update([
                        'video' => $videoName
                    ]);
                }
            }
        }

        return redirect('admin/about?tab=production-unit')
            ->with('success', 'Production Unit Updated Successfully');
    }

    public function deleteImage($id)
    {
        $img = AboutProductionUnitImage::findOrFail($id);

        if (file_exists(public_path('uploads/production/' . $img->image))) {
            unlink(public_path('uploads/production/' . $img->image));
        }

        $img->delete();

        return back()->with('success', 'Image deleted');
    }

    public function delete($id)
    {


        $unit = AboutProductionUnit::findOrFail($id);

        // if ($unit->image && file_exists(public_path('uploads/production/' . $unit->image))) {
        //     unlink(public_path('uploads/production/' . $unit->image));
        // }

        foreach ($unit->images as $img) {

            if (file_exists(public_path('uploads/production/' . $img->image))) {

                unlink(public_path('uploads/production/' . $img->image));

            }

            $img->delete();

        }

        if ($unit->video && file_exists(public_path('uploads/production/' . $unit->video))) {
            unlink(public_path('uploads/production/' . $unit->video));
        }

        $unit->delete();

        return redirect('admin/about?tab=production-unit')->with('success', 'Deleted Successfully');

    }

}

