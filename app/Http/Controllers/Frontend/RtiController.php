<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RTIInformation;
use App\Models\RTIOfficer;

class RtiController extends Controller
{
    public function index($tab = 'information')
    {
        $information = RTIInformation::latest()->get();

        $officersGliders = RTIOfficer::where('role', 'GLIDERS')->latest()->get();
        $officersOpf = RTIOfficer::where('role', 'OPF')->latest()->get();

        return view('frontend.rti.index', compact(
            'tab',
            'information',
            'officersGliders',
            'officersOpf'
        ));
    }
}