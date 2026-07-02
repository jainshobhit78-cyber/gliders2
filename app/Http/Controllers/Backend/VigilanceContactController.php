<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VigilanceContact;

class VigilanceContactController extends Controller
{

    public function list()
    {
        $data['contacts'] = VigilanceContact::latest()->get();

        return view('backend.vigilance.contact.list', $data);
    }


    public function add()
    {
        return view('backend.vigilance.contact.add');
    }


    public function store(Request $request)
    {

        $contact = new VigilanceContact();

        $contact->title = $request->title;
        $contact->sub_title = $request->sub_title;
        $contact->name = $request->name;
        $contact->emails = array_filter($request->emails);
        $contact->address = $request->address;

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/vigilance'), $filename);

            $contact->photo = $filename;
        }

        $contact->save();

        return redirect('admin/vigilance?tab=contact')
            ->with('success', 'Added Successfully');

    }


    public function edit($id)
    {
        $data['contact'] = VigilanceContact::findOrFail($id);

        return view('backend.vigilance.contact.edit', $data);
    }


    public function update(Request $request, $id)
    {

        $contact = VigilanceContact::findOrFail($id);

        $contact->title = $request->title;
        $contact->sub_title = $request->sub_title;
        $contact->name = $request->name;
        $contact->emails = array_filter($request->emails);
        $contact->address = $request->address;

        if ($request->hasFile('photo')) {

            if ($contact->photo && file_exists(public_path('uploads/vigilance/' . $contact->photo))) {
                unlink(public_path('uploads/vigilance/' . $contact->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/vigilance'), $filename);

            $contact->photo = $filename;
        }

        $contact->save();

        return redirect('admin/vigilance?tab=contact')
            ->with('success', 'Updated Successfully');

    }


    public function delete($id)
    {

        $contact = VigilanceContact::findOrFail($id);

        if ($contact->photo && file_exists(public_path('uploads/vigilance/' . $contact->photo))) {
            unlink(public_path('uploads/vigilance/' . $contact->photo));
        }

        $contact->delete();

        return redirect('admin/vigilance?tab=contact')
            ->with('success', 'Deleted Successfully');

    }

}
