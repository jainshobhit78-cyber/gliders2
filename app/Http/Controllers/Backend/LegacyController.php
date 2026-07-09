<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LegacyLeader;
use App\Models\LegacySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LegacyController extends Controller
{
    // ==========================================
    // GLIDERS LEGACY ACTIONS (type = 'gliders')
    // ==========================================
    public function index()
    {
        $leaders = LegacyLeader::where('type', 'gliders')->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
        $setting = LegacySetting::first();
        $type = 'gliders';
        $title = 'Gliders Legacy';

        return view('backend.legacy.list', compact('leaders', 'setting', 'type', 'title'));
    }

    public function add()
    {
        $type = 'gliders';
        $title = 'Gliders Legacy';
        return view('backend.legacy.add', compact('type', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'type' => 'required|string|in:gliders,opf',
            'tenure_start' => 'nullable|string',
            'tenure_end' => 'nullable|string',
            'tenure_text' => 'nullable|string',
            'initials' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $data = $request->except(['image', 'focus_areas', 'stats', 'timeline']);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/category'), $imageName);
            $data['image'] = $imageName;
        }

        // Process dynamic arrays to JSON
        $data['focus_areas'] = $request->focus_areas ? array_values($request->focus_areas) : [];
        $data['stats'] = $request->stats ? array_values($request->stats) : [];
        $data['timeline'] = $request->timeline ? array_values($request->timeline) : [];

        // Set display order
        $maxOrder = LegacyLeader::where('type', $data['type'])->max('display_order');
        $data['display_order'] = $maxOrder ? $maxOrder + 1 : 1;

        LegacyLeader::create($data);

        $redirectRoute = $data['type'] === 'opf' ? 'admin.opf_legacy.index' : 'admin.legacy.index';
        return redirect()->route($redirectRoute)->with('success', 'Leader added successfully!');
    }

    public function edit($id)
    {
        $leader = LegacyLeader::findOrFail($id);
        $type = $leader->type;
        $title = $type === 'opf' ? 'OPF Legacy' : 'Gliders Legacy';
        return view('backend.legacy.edit', compact('leader', 'type', 'title'));
    }

    public function update(Request $request, $id)
    {
        $leader = LegacyLeader::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'type' => 'required|string|in:gliders,opf',
            'tenure_start' => 'nullable|string',
            'tenure_end' => 'nullable|string',
            'tenure_text' => 'nullable|string',
            'initials' => 'nullable|string|max:10',
            'color' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp',
        ]);

        $data = $request->except(['image', 'focus_areas', 'stats', 'timeline']);

        if ($request->hasFile('image')) {
            if ($leader->image && file_exists(public_path('uploads/category/' . $leader->image))) {
                @unlink(public_path('uploads/category/' . $leader->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/category'), $imageName);
            $data['image'] = $imageName;
        }

        // Process dynamic arrays to JSON
        $data['focus_areas'] = $request->focus_areas ? array_values($request->focus_areas) : [];
        $data['stats'] = $request->stats ? array_values($request->stats) : [];
        $data['timeline'] = $request->timeline ? array_values($request->timeline) : [];

        $leader->update($data);

        $redirectRoute = $data['type'] === 'opf' ? 'admin.opf_legacy.index' : 'admin.legacy.index';
        return redirect()->route($redirectRoute)->with('success', 'Leader updated successfully!');
    }

    public function delete($id)
    {
        $leader = LegacyLeader::findOrFail($id);
        $type = $leader->type;

        if ($leader->image && file_exists(public_path('uploads/category/' . $leader->image))) {
            @unlink(public_path('uploads/category/' . $leader->image));
        }

        $leader->delete();

        $redirectRoute = $type === 'opf' ? 'admin.opf_legacy.index' : 'admin.legacy.index';
        return redirect()->route($redirectRoute)->with('success', 'Leader deleted successfully!');
    }

    // ==========================================
    // OPF LEGACY ACTIONS (type = 'opf')
    // ==========================================
    public function indexOPF()
    {
        $leaders = LegacyLeader::where('type', 'opf')->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
        $setting = LegacySetting::first();
        $type = 'opf';
        $title = 'OPF Legacy';

        return view('backend.legacy.list', compact('leaders', 'setting', 'type', 'title'));
    }

    public function addOPF()
    {
        $type = 'opf';
        $title = 'OPF Legacy';
        return view('backend.legacy.add', compact('type', 'title'));
    }

    public function storeOPF(Request $request)
    {
        $request->merge(['type' => 'opf']);
        return $this->store($request);
    }

    public function editOPF($id)
    {
        return $this->edit($id);
    }

    public function updateOPF(Request $request, $id)
    {
        $request->merge(['type' => 'opf']);
        return $this->update($request, $id);
    }

    public function deleteOPF($id)
    {
        return $this->delete($id);
    }

    // ==========================================
    // SETTINGS & REORDERING
    // ==========================================
    public function updateSettings(Request $request)
    {
        $setting = LegacySetting::firstOrCreate([]);

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_accent' => 'required|string|max:255',
            'hero_subtitle' => 'required|string|max:255',
            'timeline_title' => 'required|string|max:255',
            'footer_line1' => 'required|string|max:255',
            'footer_line2' => 'required|string|max:255',
        ]);

        $setting->update($request->all());

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function reorder(Request $request)
    {
        $order = $request->order;
        if (is_array($order)) {
            foreach ($order as $position => $id) {
                LegacyLeader::where('id', $id)->update(['display_order' => $position + 1]);
            }
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 400);
    }
}
