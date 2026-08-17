<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FinanceReport;
use App\Models\FinanceEoi;
use App\Models\FinanceReturn;

class FinanceController extends Controller
{
    public function index($tab = 'annual-report')
    {
        $settings = \App\Models\GeneralSetting::first();
        $eoiEnabled = $settings ? (bool)$settings->eoi_enabled : true;

        if (!$eoiEnabled && $tab === 'eoi') {
            return redirect()->route('finance', 'annual-report');
        }

        // Degrade gracefully to an empty state if a table is unavailable, so the
        // public page never returns a 500.
        $reports = \Illuminate\Support\Facades\Schema::hasTable('finance_reports')
            ? FinanceReport::with('files')
                ->orderBy('display_order', 'asc')
                ->orderBy('id', 'desc')
                ->get()
            : collect();
        $returns = \Illuminate\Support\Facades\Schema::hasTable('finance_returns')
            ? FinanceReturn::orderBy('display_order', 'asc')
                ->orderBy('fiscal_year', 'desc')
                ->get()
            : collect();
        $eois = \Illuminate\Support\Facades\Schema::hasTable('finance_eoi')
            ? FinanceEoi::orderBy('display_order', 'asc')
                ->orderBy('id', 'desc')
                ->get()
            : collect();

        return view('frontend.finance.index', compact(
            'tab',
            'reports',
            'returns',
            'eois',
            'eoiEnabled'
        ));
    }
}
