<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    public function privacy()
    {
        return view('frontend.policy.privacy');
    }

    public function terms()
    {
        return view('frontend.policy.terms');
    }
    public function sitemap()
    {
        return view('frontend.policy.sitemap');
    }
}