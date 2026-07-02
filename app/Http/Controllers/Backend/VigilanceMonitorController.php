<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VigilanceMonitor;

class VigilanceMonitorController extends Controller
{

    public function list()
    {
        $data['items'] = VigilanceMonitor::latest()->get();

        return view('backend.vigilance.monitor.list', $data);
    }

    public function add()
    {
        return view('backend.vigilance.monitor.add');
    }

    public function store(Request $request)
    {

        $item = new VigilanceMonitor();

        $item->title = $request->title;
        $item->address = $request->address;

        $item->save();

        return redirect('admin/vigilance?tab=monitor')
            ->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $data['item'] = VigilanceMonitor::findOrFail($id);

        return view('backend.vigilance.monitor.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $item = VigilanceMonitor::findOrFail($id);

        $item->title = $request->title;
        $item->address = $request->address;

        $item->save();

        return redirect('admin/vigilance?tab=monitor')
            ->with('success', 'Updated Successfully');
    }

    public function delete($id)
    {

        $item = VigilanceMonitor::findOrFail($id);

        $item->delete();

        return redirect('admin/vigilance?tab=monitor')
            ->with('success', 'Deleted Successfully');
    }
}
