<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TickerNews;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;

class TickerNewsController extends Controller
{
    public function index()
    {
        $tickerItems = TickerNews::orderBy('position', 'asc')->get();
        $settings = GeneralSetting::first();
        return view('backend.home_page.marquee.update', compact('tickerItems', 'settings'));
    }

    public function updateSpeed(Request $request)
    {
        $request->validate([
            'ticker_speed' => 'required|integer|min:5|max:100',
        ]);

        $settings = GeneralSetting::first();
        if ($settings) {
            $settings->update([
                'ticker_speed' => $request->ticker_speed,
            ]);
        }

        return redirect()->back()->with('success', 'Ticker Speed Updated Successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'link' => 'nullable|url',
            'position' => 'required|integer',
        ]);

        TickerNews::create([
            'text' => $request->text,
            'link' => $request->link,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return redirect()->back()->with('success', 'Ticker Notification Added Successfully');
    }

    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string',
            'link' => 'nullable|url',
            'position' => 'required|integer',
        ]);

        $item = TickerNews::findOrFail($id);
        $item->update([
            'text' => $request->text,
            'link' => $request->link,
            'position' => $request->position,
            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return redirect('admin/home/marquee/edit')->with('success', 'Ticker Notification Updated Successfully');
    }

    public function delete($id)
    {
        $item = TickerNews::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Ticker Notification Deleted Successfully');
    }
}
