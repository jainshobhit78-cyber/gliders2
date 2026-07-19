<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ImageGallery;
use App\Models\KeyOffering;
use App\Models\ProductCategory;
use App\Models\Marquee;
use App\Models\OurUnit;
use App\Models\PartnerLogo;
use App\Models\StateCounter;
use App\Models\VideoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class keyOfferingsController extends Controller
{
    public function list()
    {
        $key_Offer = KeyOffering::latest()->get();
        return view('backend.home_page.key.list', compact('key_Offer'));
    }

    public function add()
    {
        $categories = ProductCategory::orderBy('name', 'asc')->get();
        return view('backend.home_page.key.create', compact('categories'));
    }



    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'category_id' => 'nullable|exists:product_categories,id',
            'is_home' => 'required|in:0,1',
        ]);

        // ✅ Image Upload
        $imageName = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            // Create unique name
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

            // Move to folder
            $file->move(public_path('uploads/key_offerings'), $imageName);
        }

        // ✅ Save Data
        KeyOffering::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'category_id' => $request->category_id,
            'is_home' => $request->is_home,
        ]);

        // ✅ Redirect
        return redirect('admin/home')
            ->with('success', 'Key Offering added successfully');
    }

    public function edit($id)
    {
        $data['offer'] = KeyOffering::findOrFail($id);
        $data['categories'] = ProductCategory::orderBy('name', 'asc')->get();
        return view('backend.home_page.key.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $offer = KeyOffering::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'category_id' => 'nullable|exists:product_categories,id',
            'is_home' => 'required|in:0,1',
        ]);

        $imageName = $offer->image;

        // ✅ If new image uploaded
        if ($request->hasFile('image')) {

            // 🔥 Delete old image
            if ($offer->image && file_exists(public_path('uploads/key_offerings/' . $offer->image))) {
                unlink(public_path('uploads/key_offerings/' . $offer->image));
            }

            // Upload new image
            $file = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/key_offerings'), $imageName);
        }

        // ✅ Update Data
        $offer->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'category_id' => $request->category_id,
            'is_home' => $request->is_home,
        ]);

        return redirect('admin/home')
            ->with('success', 'Key Offering Updated Successfully');
    }

    public function delete($id)
    {
        $leader = KeyOffering::findOrFail($id);

        if ($leader->image && file_exists(public_path('uploads/key_offerings/' . $leader->image))) {
            unlink(public_path('uploads/key_offerings/' . $leader->image));
        }

        $leader->delete();

        return redirect('admin/home')
            ->with('success', 'Key Offerings Deleted Successfully');
    }


    public function edit_video_banner()
    {
        $offer = VideoBanner::first();

        return view('backend.home_page.video_banner.update', compact('offer'));
    }

    public function uploadChunk(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'chunkIndex' => 'required|integer',
            'totalChunks' => 'required|integer',
            'upload_id' => 'required|string|alpha_num',
            'file_ext' => 'required|string|alpha_num',
        ]);

        $file = $request->file('file');
        $chunkIndex = $request->chunkIndex;
        $totalChunks = $request->totalChunks;
        $upload_id = $request->upload_id;
        $file_ext = $request->file_ext;

        $tempPath = storage_path('app/chunks/' . $upload_id);
        if (!file_exists($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        $file->move($tempPath, $chunkIndex);

        // If it's the last chunk, merge all of them
        if ($chunkIndex == $totalChunks - 1) {
            $finalPath = public_path('uploads/video_banner');
            if (!file_exists($finalPath)) {
                mkdir($finalPath, 0755, true);
            }

            $finalFileName = time() . '_' . $upload_id . '.' . $file_ext;
            $finalFile = fopen($finalPath . '/' . $finalFileName, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = $tempPath . '/' . $i;
                if (!file_exists($chunkFile)) {
                    return response()->json(['error' => 'Chunk ' . $i . ' is missing.'], 400);
                }

                $chunkContent = fopen($chunkFile, 'rb');
                stream_copy_to_stream($chunkContent, $finalFile);
                fclose($chunkContent);
                unlink($chunkFile);
            }

            fclose($finalFile);
            rmdir($tempPath);

            return response()->json(['finalName' => $finalFileName]);
        }

        return response()->json(['success' => true]);
    }

    public function update_video_banner(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'uploaded_banner_video' => 'nullable|string',
            'uploaded_mid_video' => 'nullable|string',
            'banner_video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg,video/quicktime|max:2048000',
            'mid_video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg,video/quicktime|max:2048000',
        ]);

        $banner = VideoBanner::first();

        $bannerVideoName = $banner->banner_video ?? null;
        $midVideoName = $banner->mid_video ?? null;

        // Use chunk uploaded file if exists
        if ($request->filled('uploaded_banner_video')) {
            if ($banner && $banner->banner_video && file_exists(public_path('uploads/video_banner/' . $banner->banner_video))) {
                unlink(public_path('uploads/video_banner/' . $banner->banner_video));
            }
            $bannerVideoName = $request->uploaded_banner_video;
        } elseif ($request->hasFile('banner_video')) {
            if ($banner && $banner->banner_video && file_exists(public_path('uploads/video_banner/' . $banner->banner_video))) {
                unlink(public_path('uploads/video_banner/' . $banner->banner_video));
            }
            $file = $request->file('banner_video');
            $bannerVideoName = time() . '_banner.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/video_banner'), $bannerVideoName);
        }

        // Use chunk uploaded mid file if exists
        if ($request->filled('uploaded_mid_video')) {
            if ($banner && $banner->mid_video && file_exists(public_path('uploads/video_banner/' . $banner->mid_video))) {
                unlink(public_path('uploads/video_banner/' . $banner->mid_video));
            }
            $midVideoName = $request->uploaded_mid_video;
        } elseif ($request->hasFile('mid_video')) {
            if ($banner && $banner->mid_video && file_exists(public_path('uploads/video_banner/' . $banner->mid_video))) {
                unlink(public_path('uploads/video_banner/' . $banner->mid_video));
            }
            $file = $request->file('mid_video');
            $midVideoName = time() . '_mid.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/video_banner'), $midVideoName);
        }

        if ($banner) {
            $banner->update([
                'banner_video' => $bannerVideoName,
                'mid_video' => $midVideoName,
            ]);
        } else {
            VideoBanner::create([
                'title' => $request->title,
                'banner_video' => $bannerVideoName,
                'mid_video' => $midVideoName,
            ]);
        }

        return back()->with('success', $banner ? 'Updated successfully' : 'Created successfully');
    }

    public function edit_our_units()
    {
        $offer = OurUnit::first();
        return view('backend.home_page.units.update', compact('offer'));
    }



    public function update_our_units(Request $request)
    {
        $request->validate([
            'heading' => 'nullable|string|max:255',
            'sub_heading' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'video' => 'nullable|mimes:mp4,webm,ogg',
        ]);

        $banner = OurUnit::first();

        $bannerVideoName = $banner->video ?? null;

        // Banner Video Upload
        if ($request->hasFile('video')) {

            if ($banner && $banner->video && file_exists(public_path('uploads/our_units/' . $banner->video))) {
                unlink(public_path('uploads/our_units/' . $banner->video));
            }

            $file = $request->file('video');
            $bannerVideoName = time() . '_banner.' . $file->getClientOriginalExtension();

            $file->move(public_path('uploads/our_units'), $bannerVideoName);
        }



        if ($banner) {
            $banner->update([
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading,
                'description' => $request->description,
                'video' => $bannerVideoName,
            ]);
        } else {
            OurUnit::create([
                'heading' => $request->heading,
                'sub_heading' => $request->sub_heading,
                'description' => $request->description,
                'video' => $bannerVideoName,
            ]);
        }

        return back()->with('success', $banner ? 'Updated successfully' : 'Created successfully');
    }

    public function edit_state_counter()
    {
        $offer = StateCounter::first();
        return view('backend.home_page.state_counter.update', compact('offer'));
    }
    public function update_state_counter(Request $request)
    {
        $request->validate([
            'years_of_legacy' => 'nullable|integer',
            'parachutes_manufactured' => 'nullable|integer',
            'indigenous_manufacturing' => 'nullable|string|max:255',
            'annual_production_value' => 'nullable|numeric',
        ]);

        $data = [
            'years_of_legacy' => $request->years_of_legacy,
            'parachutes_manufactured' => $request->parachutes_manufactured,
            'indigenous_manufacturing' => $request->indigenous_manufacturing,
            'annual_production_value' => $request->annual_production_value,
        ];

        $stateCounter = StateCounter::first();

        if ($stateCounter) {
            $stateCounter->update($data);
            $message = 'State Counter Updated successfully';
        } else {
            StateCounter::create($data);
            $message = 'State Counter Created successfully';
        }

        return back()->with('success', $message);
    }

    public function edit_marquee()
    {
        $offer = Marquee::first();
        return view('backend.home_page.marquee.update', compact('offer'));
    }

    public function update_marquee(Request $request)
    {
        $request->validate([
            'text1' => 'nullable|string|max:255',
            'text2' => 'nullable|string|max:255',
        ]);

        $data = [
            'text1' => $request->text1,
            'text2' => $request->text2,

        ];

        $stateCounter = Marquee::first();

        if ($stateCounter) {
            $stateCounter->update($data);
            $message = 'Marquee Updated successfully';
        } else {
            Marquee::create($data);
            $message = 'Marquee Created successfully';
        }

        return back()->with('success', $message);
    }

    public function image_gallery_list()
    {
        $image_gallery = ImageGallery::latest()->get();
        return view('backend.home_page.image_gallery.list', compact('image_gallery'));
    }
    public function image_gallery_form($id = null)
    {
        $edit = null;

        if ($id) {
            $edit = ImageGallery::find($id);
        }

        $image_gallery = ImageGallery::latest()->get();

        return view('backend.home_page.image_gallery.form', compact('edit', 'image_gallery'));
    }
    public function image_gallery_save(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $gallery = ImageGallery::find($request->id);

        if ($gallery) {
            if ($request->hasFile('image')) {

                if ($gallery->image && file_exists(public_path($gallery->image))) {
                    unlink(public_path($gallery->image));
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/gallery'), $filename);

                $gallery->image = 'uploads/gallery/' . $filename;
            }

            $gallery->save();

            return back()->with('success', 'Image Updated Successfully');
        } else {
            // STORE
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/gallery'), $filename);

                ImageGallery::create([
                    'image' => 'uploads/gallery/' . $filename,
                ]);
            }

            return back()->with('success', 'Image Added Successfully');
        }
    }


    public function image_gallery_delete($id)
    {
        $image = ImageGallery::findOrFail($id);

        if ($image->image && file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }

    public function partner_logo_list()
    {
        $logo = PartnerLogo::latest()->get();
        return view('backend.home_page.partner_logo.list', compact('logo'));
    }

    public function partner_logo_form($id = null)
    {
        $edit = null;

        if ($id) {
            $edit = PartnerLogo::find($id);
        }

        $logo = PartnerLogo::latest()->get();

        return view('backend.home_page.partner_logo.form', compact('edit', 'logo'));
    }

    public function partner_logo_save(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'name' => 'nullable|string|max:255',
        ]);

        $gallery = PartnerLogo::find($request->id);

        if ($gallery) {
            $gallery->name = $request->name;

            if ($request->hasFile('image')) {

                if ($gallery->image && file_exists(public_path($gallery->image))) {
                    unlink(public_path($gallery->image));
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/partner_logo'), $filename);

                $gallery->image = 'uploads/partner_logo/' . $filename;
            }

            $gallery->save();

            return back()->with('success', 'Partner Logo Updated Successfully');
        } else {
            // STORE
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/partner_logo'), $filename);

                PartnerLogo::create([
                    'image' => 'uploads/partner_logo/' . $filename,
                    'name' => $request->name,
                ]);
            }

            return back()->with('success', 'Partner Logo Added Successfully');
        }
    }

    public function partner_logo_delete($id)
    {
        $image = PartnerLogo::findOrFail($id);

        if ($image->image && file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return back()->with('success', 'Logo deleted successfully');
    }
}
