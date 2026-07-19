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

        // Degrade gracefully to an empty state if a table is unavailable, so the
        // public page never returns a 500.
        $notifications = \Illuminate\Support\Facades\Schema::hasTable('career_notifications')
            ? CareerNotification::with('files')->latest()->get()
            : collect();

        $jobs = \Illuminate\Support\Facades\Schema::hasTable('career_jobs')
            ? CareerJob::where('status', true)
                ->where('type', $tab === 'notifications' ? 'recruitment' : $tab)
                ->latest()
                ->get()
            : collect();

        return view('frontend.careers.index', compact(
            'tab',
            'notifications',
            'jobs'
        ));
    }
}