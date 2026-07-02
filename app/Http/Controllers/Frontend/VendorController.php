<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VendorsPortal;

class VendorController extends Controller
{
    public function index($tab = 'portal')
    {
        $portals = VendorsPortal::latest()->get();

        return view('frontend.vendors.index', compact(
            'tab',
            'portals'
        ));
    }
}   