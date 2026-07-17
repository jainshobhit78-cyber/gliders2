<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CareerNotification;
use App\Models\CareerJob;

class CareerController extends Controller
{
    public function index($tab = 'recruitment')
    {
        if (!in_array($tab, ['recruitment', 'internship', 'notifications'])) {
            $tab = 'recruitment';
        }

        $notifications = CareerNotification::with('files')
            ->latest()
            ->get();

        $jobs = CareerJob::where('status', true)
            ->where('type', $tab === 'notifications' ? 'recruitment' : $tab)
            ->latest()
            ->get();

        return view('frontend.careers.index', compact(
            'tab',
            'notifications',
            'jobs'
        ));
    }
}