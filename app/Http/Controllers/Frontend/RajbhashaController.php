<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RajshabhaAbout;
use App\Models\RajshabhaNiyam;
use App\Models\RajshabhaRules;

class RajbhashaController extends Controller
{
    public function index($tab = 'about')
    {
        $abouts = RajshabhaAbout::latest()->get();
        $niyams = RajshabhaNiyam::latest()->get();
        $rules = RajshabhaRules::latest()->get();

        return view('frontend.rajbhasha.index', compact(
            'tab',
            'abouts',
            'niyams',
            'rules'
        ));
    }
}