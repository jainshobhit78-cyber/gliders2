<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutCodesConduct;
use App\Models\AboutDirectory;
use App\Models\AboutLeadership;
use App\Models\AboutProductionUnit;
use App\Models\AboutHistory;
use App\Models\AboutSocialResponsibility;
use App\Models\AboutHumanResources;
use App\Models\AboutVision;
use App\Models\AboutMission;
use App\Models\LegacyLeader;
use App\Models\LegacySetting;

class AboutController extends Controller
{
    public function index($tab = 'leadership')
    {
        $leaders = AboutLeadership::with('milestones')
            ->orderBy('position')
            ->get();

        $production = AboutProductionUnit::with([
            'milestones.images'
        ])->latest()->get();

        $history = AboutHistory::latest()->get();

        $socialResponsibility = AboutSocialResponsibility::latest()->get();

        $humanResources = AboutHumanResources::latest()->first();

        $vision = AboutVision::latest()->first();

        $mission = AboutMission::latest()->first();

        $directoryHQ = AboutDirectory::where('role', 'Headquarters')->get();
        $directoryOPF = AboutDirectory::where('role', 'OPF')->get();

        $codesConduct = AboutCodesConduct::latest()->get();

        $glidersLegacy = LegacyLeader::where('type', 'gliders')->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
        $opfLegacy = LegacyLeader::where('type', 'opf')->orderBy('display_order', 'asc')->orderBy('id', 'asc')->get();
        $legacySetting = LegacySetting::first();

        return view('frontend.about.index', compact(
            'leaders',
            'production',
            'history',
            'socialResponsibility',
            'humanResources',
            'vision',
            'mission',
            'directoryHQ',
            'directoryOPF',
            'codesConduct',
            'glidersLegacy',
            'opfLegacy',
            'legacySetting',
            'tab'
        ));
    }
}