<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VigilanceCvo;
use App\Models\VigilanceSetup;
use App\Models\VigilanceContact;
use App\Models\VigilanceSexualHarassment;
use App\Models\VigilanceMonitor;
use App\Models\VigilanceManual;
use App\Models\VigilanceBulletin;

class VigilanceController extends Controller
{
    public function index($tab = 'chief-officer')
    {
        $chiefOfficers = VigilanceCvo::latest()->get();
        $setup = VigilanceSetup::latest()->get();
        $contact = VigilanceContact::latest()->get();
        $harassment = VigilanceSexualHarassment::latest()->get();
        $monitor = VigilanceMonitor::latest()->first();
        $manuals = VigilanceManual::latest()->get();
        $bulletins = VigilanceBulletin::latest()->get();

        return view('frontend.vigilance.index', compact(
            'chiefOfficers',
            'setup',
            'contact',
            'harassment',
            'monitor',
            'manuals',
            'bulletins',
            'tab'
        ));
    }
}