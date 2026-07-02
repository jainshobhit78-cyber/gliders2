<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutHistory;

class AboutHistoryController extends Controller
{

    public function list()
    {
        $data['histories'] = AboutHistory::latest()->get();

        return view('backend.about.history.list', $data);
    }

    public function add()
    {
        return view('backend.about.history.add');
    }

    public function store(Request $request)
    {
        AboutHistory::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('admin/about?tab=history')
            ->with('success', 'History Added Successfully');
    }

    public function edit($id)
    {
        $data['history'] = AboutHistory::findOrFail($id);

        return view('backend.about.history.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $history = AboutHistory::findOrFail($id);

        $history->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect('admin/about?tab=history')
            ->with('success', 'History Updated Successfully');
    }

    public function delete($id)
    {

        $history = AboutHistory::findOrFail($id);

        $history->delete();

        return redirect('admin/about?tab=history')
            ->with('success', 'Deleted Successfully');
    }

}
