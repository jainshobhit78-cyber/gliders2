<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerJob;

class CareerJobController extends Controller
{
    public function recruitmentList()
    {
        $data['items'] = CareerJob::where('type', 'recruitment')->latest()->get();
        $data['type'] = 'recruitment';
        return view('backend.careers.jobs.list', $data);
    }

    public function internshipList()
    {
        $data['items'] = CareerJob::where('type', 'internship')->latest()->get();
        $data['type'] = 'internship';
        return view('backend.careers.jobs.list', $data);
    }

    public function add(Request $request)
    {
        $data['type'] = $request->get('type', 'recruitment');
        return view('backend.careers.jobs.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:recruitment,internship',
            'title' => 'required|string|max:255',
            'job_info' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'last_date' => 'nullable|date',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = new CareerJob();
        $item->type = $request->type;
        $item->title = $request->title;
        $item->job_info = $request->job_info;
        $item->eligibility = $request->eligibility;
        $item->last_date = $request->last_date;

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $filename = \App\Support\UploadedDocument::store($file, public_path('uploads/careers'));
            $item->pdf = $filename;
        }

        $item->save();

        return redirect('admin/careers?tab=' . $request->type)
            ->with('success', 'Career entry added successfully.');
    }

    public function edit($id)
    {
        $data['item'] = CareerJob::findOrFail($id);
        return view('backend.careers.jobs.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'job_info' => 'nullable|string',
            'eligibility' => 'nullable|string',
            'last_date' => 'nullable|date',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $item = CareerJob::findOrFail($id);
        $item->title = $request->title;
        $item->job_info = $request->job_info;
        $item->eligibility = $request->eligibility;
        $item->last_date = $request->last_date;

        if ($request->hasFile('pdf')) {
            if ($item->pdf && file_exists(public_path('uploads/careers/' . $item->pdf))) {
                unlink(public_path('uploads/careers/' . $item->pdf));
            }
            $file = $request->file('pdf');
            $filename = \App\Support\UploadedDocument::store($file, public_path('uploads/careers'));
            $item->pdf = $filename;
        }

        $item->save();

        return redirect('admin/careers?tab=' . $item->type)
            ->with('success', 'Career entry updated successfully.');
    }

    public function delete($id)
    {
        $item = CareerJob::findOrFail($id);
        if ($item->pdf && file_exists(public_path('uploads/careers/' . $item->pdf))) {
            unlink(public_path('uploads/careers/' . $item->pdf));
        }
        $item->delete();

        return redirect('admin/careers?tab=' . $item->type)
            ->with('success', 'Career entry deleted successfully.');
    }
}
