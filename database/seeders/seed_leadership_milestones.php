<?php

use App\Models\AboutLeadership;
use App\Models\LeadershipMilestone;
use Illuminate\Support\Facades\File;

// 1. Ensure uploads/leadership directory exists
$leadershipDir = public_path('uploads/leadership');
if (!File::exists($leadershipDir)) {
    File::makeDirectory($leadershipDir, 0755, true);
}

// 2. Copy profile images from milestones to leadership directory
$cmdImg = '1777812513_cmd.webp';
$dfImg = '1777812631_df.webp';

if (File::exists(public_path('uploads/milestones/' . $cmdImg))) {
    File::copy(public_path('uploads/milestones/' . $cmdImg), $leadershipDir . '/' . $cmdImg);
}
if (File::exists(public_path('uploads/milestones/' . $dfImg))) {
    File::copy(public_path('uploads/milestones/' . $dfImg), $leadershipDir . '/' . $dfImg);
}

// 3. Clear existing milestones
LeadershipMilestone::truncate();

// 4. Update Shri M C Balasubramaniam (ID 11)
$leader11 = AboutLeadership::find(11);
if ($leader11) {
    $leader11->update([
        'picture' => $cmdImg,
        'position' => 1
    ]);

    // Create 3 demo milestones
    LeadershipMilestone::create([
        'leadership_id' => 11,
        'start_date' => '2000-01-03',
        'end_date' => '2010-12-31',
        'heading' => 'Probationary & R&D Officer',
        'description' => '<p>Began career at the National Academy of Defence Production. Led operational research, indigenous design optimization, and initial parachute engineering testing.</p>',
        'image' => null
    ]);

    LeadershipMilestone::create([
        'leadership_id' => 11,
        'start_date' => '2011-01-01',
        'end_date' => '2024-12-31',
        'heading' => 'General Manager',
        'description' => '<p>General Manager at Ordnance Parachute Factory Kanpur. Supervised manufacturing of extreme climate gear, high-altitude parachutes, and troop comforts.</p>',
        'image' => null
    ]);

    LeadershipMilestone::create([
        'leadership_id' => 11,
        'start_date' => '2025-01-23',
        'end_date' => null,
        'heading' => 'Chairman & Managing Director',
        'description' => '<p>Assumed command as CMD of Gliders India Limited. Directing national defense strategies, strategic corporate accounts, and global aerospace business development.</p>',
        'image' => null
    ]);
}

// 5. Update Shri S P Patnaik (ID 13)
$leader13 = AboutLeadership::find(13);
if ($leader13) {
    $leader13->update([
        'picture' => $dfImg,
        'position' => 2
    ]);

    // Create 3 demo milestones
    LeadershipMilestone::create([
        'leadership_id' => 13,
        'start_date' => '1995-01-01',
        'end_date' => '2010-12-31',
        'heading' => 'Financial Controller',
        'description' => '<p>Financial Controller at THDC India Ltd. Spearheaded Asset Management ERP implementation and established cost reduction models for key projects.</p>',
        'image' => null
    ]);

    LeadershipMilestone::create([
        'leadership_id' => 13,
        'start_date' => '2011-01-01',
        'end_date' => '2025-04-01',
        'heading' => 'Chief General Manager (Finance)',
        'description' => '<p>Chief General Manager (Finance) at NLC India Ltd. Managed large debt capital restructurings, project evaluations, and successfully secured RE funding closures.</p>',
        'image' => null
    ]);

    LeadershipMilestone::create([
        'leadership_id' => 13,
        'start_date' => '2025-04-02',
        'end_date' => null,
        'heading' => 'Director (Finance) & CFO',
        'description' => '<p>Appointed Director of Finance at Gliders India Limited. Overseeing treasury, investment strategies, compliance operations, and corporate accounts.</p>',
        'image' => null
    ]);
}

echo "Seeded successfully!\n";
