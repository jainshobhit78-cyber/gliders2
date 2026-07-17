<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FinanceReport;
use App\Models\FinanceEoi;

class FinanceController extends Controller
{
    public function index($tab = 'annual-report')
    {
        $reports = FinanceReport::with('files')
            ->orderBy('display_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        $eois = FinanceEoi::orderBy('display_order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.finance.index', compact(
            'tab',
            'reports',
            'eois'
        ));
    }
}