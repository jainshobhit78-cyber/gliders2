<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CareerNotification;

class CareerController extends Controller
{
    public function index($tab = 'notifications')
    {
        $notifications = CareerNotification::with('files')
            ->latest()
            ->get();

        return view('frontend.careers.index', compact(
            'tab',
            'notifications'
        ));
    }
}