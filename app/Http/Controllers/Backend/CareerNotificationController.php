<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CareerNotification;
use App\Models\CareerNotificationFile;

class CareerNotificationController extends Controller
{

    public function list()
    {
        $data['items'] = CareerNotification::with('files')->latest()->get();

        return view('backend.careers.notifications.list', $data);
    }

    public function add()
    {
        return view('backend.careers.notifications.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdfs' => 'nullable|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
        ]);

        $item = CareerNotification::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('pdfs')) {
            foreach ($request->file('pdfs') as $pdf) {
                $name = $pdf->hashName();
                $pdf->move(public_path('uploads/careers'), $name);

                CareerNotificationFile::create([
                    'notification_id' => $item->id,
                    'pdf' => $name
                ]);
            }
        }

        return redirect('admin/careers?tab=notifications')
            ->with('success', 'Added Successfully');
    }

    public function edit($id)
    {
        $data['item'] = CareerNotification::with('files')->findOrFail($id);

        return view('backend.careers.notifications.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pdfs' => 'nullable|array',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
        ]);

        $item = CareerNotification::findOrFail($id);

        $item->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('pdfs')) {
            foreach ($request->file('pdfs') as $pdf) {
                $name = $pdf->hashName();
                $pdf->move(public_path('uploads/careers'), $name);

                CareerNotificationFile::create([
                    'notification_id' => $item->id,
                    'pdf' => $name
                ]);
            }
        }

        return redirect('admin/careers?tab=notifications')
            ->with('success', 'Updated Successfully');
    }

    public function deleteFile($id)
    {

        $file = CareerNotificationFile::findOrFail($id);

        if (file_exists(public_path('uploads/careers/' . $file->pdf))) {

            unlink(public_path('uploads/careers/' . $file->pdf));

        }

        $file->delete();

        return redirect()->back()
            ->with('success', 'PDF Deleted Successfully');

    }
    public function delete($id)
    {

        $item = CareerNotification::findOrFail($id);

        foreach ($item->files as $file) {
            if (file_exists(public_path('uploads/careers/' . $file->pdf))) {
                unlink(public_path('uploads/careers/' . $file->pdf));
            }

            $file->delete();
        }

        $item->delete();

        return redirect('admin/careers?tab=notifications')
            ->with('success', 'Deleted Successfully');
    }
}

