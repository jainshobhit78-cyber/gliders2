<?php

use App\Http\Controllers\Backend\ChatbotFaqController;
use App\Http\Controllers\Backend\TickerNewsController;
use App\Http\Controllers\Backend\MediaController;
use App\Http\Controllers\Backend\FNewsController;
use App\Http\Controllers\Backend\NewsController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RajshabhaAboutController;
use App\Http\Controllers\Backend\AboutCodesConductController;
use App\Http\Controllers\Backend\AboutDirectoryController;
use App\Http\Controllers\Backend\AboutHistoryController;
use App\Http\Controllers\Backend\AboutHumanResourcesController;
use App\Http\Controllers\Backend\AboutLeadershipController;
use App\Http\Controllers\Backend\AboutMissionController;
use App\Http\Controllers\Backend\AboutProductionUnitController;
use App\Http\Controllers\Backend\AboutSocialResponsibilityController;
use App\Http\Controllers\Backend\AboutVisionController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\CareerNotificationController;
use App\Http\Controllers\Backend\FinanceEoiController;
use App\Http\Controllers\Backend\FinanceReportController;
use App\Http\Controllers\Backend\RajshabhaNiyamController;
use App\Http\Controllers\Backend\RajshabhaRulesController;
use App\Http\Controllers\Backend\RoleAndPermissionController;
use App\Http\Controllers\Backend\RTIInformationController;
use App\Http\Controllers\Backend\RTIOfficerController;
use App\Http\Controllers\Backend\VendorsPortalController;
use App\Http\Controllers\Backend\VigilanceBulletinController;
use App\Http\Controllers\Backend\VigilanceContactController;
use App\Http\Controllers\Backend\VigilanceCvoController;
use App\Http\Controllers\Backend\VigilanceManualController;
use App\Http\Controllers\Backend\VigilanceMonitorController;
use App\Http\Controllers\Backend\VigilanceSetupController;
use App\Http\Controllers\Backend\VigilanceSexualHarassmentController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\keyOfferingsController;
use App\Http\Controllers\Backend\LegacyController;
use App\Http\Controllers\Backend\SystemSettingsController;
use App\Http\Controllers\Backend\ApprovalController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\CareerController;
use App\Http\Controllers\Frontend\ChatbotController;
use App\Http\Controllers\Frontend\FinanceController;
use App\Http\Controllers\Frontend\FMediaController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PolicyController;
use App\Http\Controllers\Frontend\RajbhashaController;
use App\Http\Controllers\Frontend\RtiController;
use App\Http\Controllers\Frontend\VendorController;
use App\Http\Controllers\Frontend\VigilanceController;
use App\Http\Controllers\Frontend\ProductFController;
use Illuminate\Support\Facades\Route;




// Backend ROUTES



Route::redirect('admin', 'admin/dashboard');

Route::get('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/login', [AdminAuthController::class, 'loginPost']);


Route::get('admin/forgot-password', [AdminAuthController::class, 'forgotPassword']);
Route::post('admin/forgot-password', [AdminAuthController::class, 'forgotPasswordPost'])->middleware('throttle:3,5');

Route::get('admin/verify-otp', [AdminAuthController::class, 'verifyOtpForm']);
Route::post('admin/verify-otp', [AdminAuthController::class, 'verifyOtpPost'])->middleware('throttle:3,5');

Route::get('admin/reset-password/{token}', [AdminAuthController::class, 'showResetForm']);
Route::post('admin/reset-password', [AdminAuthController::class, 'resetPasswordPost']);

Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['adminAuth', 'ipWhitelist', 'validateCmsUploads'])->group(function () {

    Route::get('admin/run-migrations', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }
        \Illuminate\Support\Facades\Artisan::call('migrate');
        return "Database migrations successfully executed!";
    });

    Route::get('admin/fix-permissions', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\AdminRolePermissionSeeder']);
        return "Permissions successfully populated inside the database!";
    });

    Route::get('admin/clear-cache', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        return "Application cache, routes, and views successfully cleared!";
    });

    // System Settings Routes
    Route::get('admin/settings', [SystemSettingsController::class, 'index'])->name('admin.settings.index')->middleware('permission:settings.view,admin');
    Route::post('admin/settings/update', [SystemSettingsController::class, 'update'])->name('admin.settings.update')->middleware('permission:settings.edit,admin');

    // Approvals Dashboard Routes
    Route::get('admin/approvals', [ApprovalController::class, 'index'])->name('admin.approvals.index')->middleware('permission:approvals.view,admin');
    Route::get('admin/approvals/news/approve/{id}', [ApprovalController::class, 'approveNews'])->name('admin.approvals.news.approve')->middleware('permission:approvals.edit,admin');
    Route::get('admin/approvals/media/approve/{id}', [ApprovalController::class, 'approveMedia'])->name('admin.approvals.media.approve')->middleware('permission:approvals.edit,admin');

    Route::get('admin/dashboard', function () {
        return view('backend.dashboard.list');
    })->middleware('permission:dashboard.view,admin');

    Route::get('admin/about', function () {
        return view('backend.about.index');
    })->middleware('permission:about.view,admin');

    Route::get('admin/about/leadership', [AboutLeadershipController::class, 'list'])->middleware('permission:leadership.view,admin');
    Route::get('admin/about/leadership/add', [AboutLeadershipController::class, 'add'])->middleware('permission:leadership.create,admin');
    Route::post('admin/about/leadership/add', [AboutLeadershipController::class, 'store'])->middleware('permission:leadership.create,admin');
    Route::get('admin/about/leadership/edit/{id}', [AboutLeadershipController::class, 'edit'])->middleware('permission:leadership.edit,admin');
    Route::post('admin/about/leadership/update/{id}', [AboutLeadershipController::class, 'update'])->middleware('permission:leadership.edit,admin');
    Route::delete('admin/about/leadership/delete/{id}', [AboutLeadershipController::class, 'delete'])->middleware('permission:leadership.delete,admin');

    Route::get('admin/about/production-unit', [AboutProductionUnitController::class, 'list'])->middleware('permission:production_unit.view,admin');
    Route::get('admin/about/production-unit/add', [AboutProductionUnitController::class, 'add'])->middleware('permission:production_unit.create,admin');
    Route::post('admin/about/production-unit/add', [AboutProductionUnitController::class, 'store'])->middleware('permission:production_unit.create,admin');
    Route::get('admin/about/production-unit/edit/{id}', [AboutProductionUnitController::class, 'edit'])->middleware('permission:production_unit.edit,admin');
    Route::post('admin/about/production-unit/update/{id}', [AboutProductionUnitController::class, 'update'])->middleware('permission:production_unit.edit,admin');
    Route::delete('admin/about/production-unit/delete-image/{id}', [AboutProductionUnitController::class, 'deleteImage'])->middleware('permission:production_unit.delete,admin');
    Route::delete('admin/about/production-unit/delete/{id}', [AboutProductionUnitController::class, 'delete'])->middleware('permission:production_unit.delete,admin');

    Route::get(
        'admin/about/production-unit/view/{id}',
        [AboutProductionUnitController::class, 'viewMilestones']
    )->middleware('permission:production_unit.view,admin');

    Route::get('admin/about/history', [AboutHistoryController::class, 'list'])->middleware('permission:history.view,admin');
    Route::get('admin/about/history/add', [AboutHistoryController::class, 'add'])->middleware('permission:history.create,admin');
    Route::post('admin/about/history/add', [AboutHistoryController::class, 'store'])->middleware('permission:history.create,admin');
    Route::get('admin/about/history/edit/{id}', [AboutHistoryController::class, 'edit'])->middleware('permission:history.edit,admin');
    Route::post('admin/about/history/update/{id}', [AboutHistoryController::class, 'update'])->middleware('permission:history.edit,admin');
    Route::delete('admin/about/history/delete/{id}', [AboutHistoryController::class, 'delete'])->middleware('permission:history.delete,admin');

    Route::get('admin/about/social-responsibility', [AboutSocialResponsibilityController::class, 'list'])->middleware('permission:social_responsibility.view,admin');
    Route::get('admin/about/social-responsibility/add', [AboutSocialResponsibilityController::class, 'add'])->middleware('permission:social_responsibility.create,admin');
    Route::post('admin/about/social-responsibility/add', [AboutSocialResponsibilityController::class, 'store'])->middleware('permission:social_responsibility.create,admin');
    Route::get('admin/about/social-responsibility/edit/{id}', [AboutSocialResponsibilityController::class, 'edit'])->middleware('permission:social_responsibility.edit,admin');
    Route::post('admin/about/social-responsibility/update/{id}', [AboutSocialResponsibilityController::class, 'update'])->middleware('permission:social_responsibility.edit,admin');
    Route::delete('admin/about/social-responsibility/delete/{id}', [AboutSocialResponsibilityController::class, 'delete'])->middleware('permission:social_responsibility.delete,admin');

    Route::get('admin/about/human-resources', [AboutHumanResourcesController::class, 'list'])->middleware('permission:human_resources.view,admin');
    Route::get('admin/about/human-resources/add', [AboutHumanResourcesController::class, 'add'])->middleware('permission:human_resources.create,admin');
    Route::post('admin/about/human-resources/add', [AboutHumanResourcesController::class, 'store'])->middleware('permission:human_resources.create,admin');
    Route::get('admin/about/human-resources/edit/{id}', [AboutHumanResourcesController::class, 'edit'])->middleware('permission:human_resources.edit,admin');
    Route::post('admin/about/human-resources/update/{id}', [AboutHumanResourcesController::class, 'update'])->middleware('permission:human_resources.edit,admin');
    Route::delete('admin/about/human-resources/delete/{id}', [AboutHumanResourcesController::class, 'delete'])->middleware('permission:human_resources.delete,admin');

    Route::get('admin/about/vision', [AboutVisionController::class, 'list'])->middleware('permission:vision.view,admin');
    Route::get('admin/about/vision/add', [AboutVisionController::class, 'add'])->middleware('permission:vision.create,admin');
    Route::post('admin/about/vision/add', [AboutVisionController::class, 'store'])->middleware('permission:vision.create,admin');
    Route::get('admin/about/vision/edit/{id}', [AboutVisionController::class, 'edit'])->middleware('permission:vision.edit,admin');
    Route::post('admin/about/vision/update/{id}', [AboutVisionController::class, 'update'])->middleware('permission:vision.edit,admin');
    Route::delete('admin/about/vision/delete/{id}', [AboutVisionController::class, 'delete'])->middleware('permission:vision.delete,admin');

    Route::get('admin/about/mission', [AboutMissionController::class, 'list'])->middleware('permission:mission.view,admin');
    Route::get('admin/about/mission/add', [AboutMissionController::class, 'add'])->middleware('permission:mission.create,admin');
    Route::post('admin/about/mission/add', [AboutMissionController::class, 'store'])->middleware('permission:mission.create,admin');
    Route::get('admin/about/mission/edit/{id}', [AboutMissionController::class, 'edit'])->middleware('permission:mission.edit,admin');
    Route::post('admin/about/mission/update/{id}', [AboutMissionController::class, 'update'])->middleware('permission:mission.edit,admin');
    Route::delete('admin/about/mission/delete/{id}', [AboutMissionController::class, 'delete'])->middleware('permission:mission.delete,admin');

    Route::get('admin/about/directory', [AboutDirectoryController::class, 'list'])->middleware('permission:directory.view,admin');
    Route::get('admin/about/directory/add', [AboutDirectoryController::class, 'add'])->middleware('permission:directory.create,admin');
    Route::post('admin/about/directory/add', [AboutDirectoryController::class, 'store'])->middleware('permission:directory.create,admin');
    Route::get('admin/about/directory/edit/{id}', [AboutDirectoryController::class, 'edit'])->middleware('permission:directory.edit,admin');
    Route::post('admin/about/directory/update/{id}', [AboutDirectoryController::class, 'update'])->middleware('permission:directory.edit,admin');
    Route::delete('admin/about/directory/delete/{id}', [AboutDirectoryController::class, 'delete'])->middleware('permission:directory.delete,admin');

    Route::get('admin/about/codes', [AboutCodesConductController::class, 'list'])->middleware('permission:codes_of_conduct.view,admin');
    Route::get('admin/about/codes/add', [AboutCodesConductController::class, 'add'])->middleware('permission:codes_of_conduct.create,admin');
    Route::post('admin/about/codes/add', [AboutCodesConductController::class, 'store'])->middleware('permission:codes_of_conduct.create,admin');
    Route::get('admin/about/codes/edit/{id}', [AboutCodesConductController::class, 'edit'])->middleware('permission:codes_of_conduct.edit,admin');
    Route::post('admin/about/codes/update/{id}', [AboutCodesConductController::class, 'update'])->middleware('permission:codes_of_conduct.edit,admin');
    Route::delete('admin/about/codes/delete/{id}', [AboutCodesConductController::class, 'delete'])->middleware('permission:codes_of_conduct.delete,admin');

    Route::get('admin/vigilance', function () {
        return view('backend.vigilance.index');
    })->middleware('permission:vigilance.view,admin');

    Route::get('admin/vigilance/cvo', [VigilanceCvoController::class, 'list'])->middleware('permission:chief_vigilance_officer.view,admin');
    Route::get('admin/vigilance/cvo/add', [VigilanceCvoController::class, 'add'])->middleware('permission:chief_vigilance_officer.create,admin');
    Route::post('admin/vigilance/cvo/add', [VigilanceCvoController::class, 'store'])->middleware('permission:chief_vigilance_officer.create,admin');
    Route::get('admin/vigilance/cvo/edit/{id}', [VigilanceCvoController::class, 'edit'])->middleware('permission:chief_vigilance_officer.edit,admin');
    Route::post('admin/vigilance/cvo/update/{id}', [VigilanceCvoController::class, 'update'])->middleware('permission:chief_vigilance_officer.edit,admin');
    Route::delete('admin/vigilance/cvo/delete/{id}', [VigilanceCvoController::class, 'delete'])->middleware('permission:chief_vigilance_officer.delete,admin');

    Route::get('admin/vigilance/setup', [VigilanceSetupController::class, 'list'])->middleware('permission:vigilance_setup.view,admin');
    Route::get('admin/vigilance/setup/add', [VigilanceSetupController::class, 'add'])->middleware('permission:vigilance_setup.create,admin');
    Route::post('admin/vigilance/setup/add', [VigilanceSetupController::class, 'store'])->middleware('permission:vigilance_setup.create,admin');
    Route::get('admin/vigilance/setup/edit/{id}', [VigilanceSetupController::class, 'edit'])->middleware('permission:vigilance_setup.edit,admin');
    Route::post('admin/vigilance/setup/update/{id}', [VigilanceSetupController::class, 'update'])->middleware('permission:vigilance_setup.edit,admin');
    Route::delete('admin/vigilance/setup/delete/{id}', [VigilanceSetupController::class, 'delete'])->middleware('permission:vigilance_setup.delete,admin');

    Route::get('admin/vigilance/contact', [VigilanceContactController::class, 'list'])->middleware('permission:vigilance_contact_details.view,admin');
    Route::get('admin/vigilance/contact/add', [VigilanceContactController::class, 'add'])->middleware('permission:vigilance_contact_details.create,admin');
    Route::post('admin/vigilance/contact/add', [VigilanceContactController::class, 'store'])->middleware('permission:vigilance_contact_details.create,admin');
    Route::get('admin/vigilance/contact/edit/{id}', [VigilanceContactController::class, 'edit'])->middleware('permission:vigilance_contact_details.edit,admin');
    Route::post('admin/vigilance/contact/update/{id}', [VigilanceContactController::class, 'update'])->middleware('permission:vigilance_contact_details.edit,admin');
    Route::delete('admin/vigilance/contact/delete/{id}', [VigilanceContactController::class, 'delete'])->middleware('permission:vigilance_contact_details.delete,admin');


    Route::get('admin/vigilance/harassment', [VigilanceSexualHarassmentController::class, 'list'])->middleware('permission:sexual_harassment_of_women_at_workplace.view,admin');
    Route::get('admin/vigilance/harassment/add', [VigilanceSexualHarassmentController::class, 'add'])->middleware('permission:sexual_harassment_of_women_at_workplace.create,admin');
    Route::post('admin/vigilance/harassment/add', [VigilanceSexualHarassmentController::class, 'store'])->middleware('permission:sexual_harassment_of_women_at_workplace.create,admin');
    Route::get('admin/vigilance/harassment/edit/{id}', [VigilanceSexualHarassmentController::class, 'edit'])->middleware('permission:sexual_harassment_of_women_at_workplace.edit,admin');
    Route::post('admin/vigilance/harassment/update/{id}', [VigilanceSexualHarassmentController::class, 'update'])->middleware('permission:sexual_harassment_of_women_at_workplace.edit,admin');
    Route::delete('admin/vigilance/harassment/delete/{id}', [VigilanceSexualHarassmentController::class, 'delete'])->middleware('permission:sexual_harassment_of_women_at_workplace.delete,admin');


    Route::get('admin/vigilance/monitor', [VigilanceMonitorController::class, 'list'])->middleware('permission:independent_external_monitor.view,admin');
    Route::get('admin/vigilance/monitor/add', [VigilanceMonitorController::class, 'add'])->middleware('permission:independent_external_monitor.create,admin');
    Route::post('admin/vigilance/monitor/add', [VigilanceMonitorController::class, 'store'])->middleware('permission:independent_external_monitor.create,admin');
    Route::get('admin/vigilance/monitor/edit/{id}', [VigilanceMonitorController::class, 'edit'])->middleware('permission:independent_external_monitor.edit,admin');
    Route::post('admin/vigilance/monitor/update/{id}', [VigilanceMonitorController::class, 'update'])->middleware('permission:independent_external_monitor.edit,admin');
    Route::delete('admin/vigilance/monitor/delete/{id}', [VigilanceMonitorController::class, 'delete'])->middleware('permission:independent_external_monitor.delete,admin');

    Route::get('admin/vigilance/manuals', [VigilanceManualController::class, 'list'])->middleware('permission:manuals_and_policies.view,admin');
    Route::get('admin/vigilance/manuals/add', [VigilanceManualController::class, 'add'])->middleware('permission:manuals_and_policies.create,admin');
    Route::post('admin/vigilance/manuals/add', [VigilanceManualController::class, 'store'])->middleware('permission:manuals_and_policies.create,admin');
    Route::get('admin/vigilance/manuals/edit/{id}', [VigilanceManualController::class, 'edit'])->middleware('permission:manuals_and_policies.edit,admin');
    Route::post('admin/vigilance/manuals/update/{id}', [VigilanceManualController::class, 'update'])->middleware('permission:manuals_and_policies.edit,admin');
    Route::delete('admin/vigilance/manuals/delete/{id}', [VigilanceManualController::class, 'delete'])->middleware('permission:manuals_and_policies.delete,admin');

    Route::get('admin/vigilance/bulletin', [VigilanceBulletinController::class, 'list'])->middleware('permission:vigilance_bulletin.view,admin');
    Route::get('admin/vigilance/bulletin/add', [VigilanceBulletinController::class, 'add'])->middleware('permission:vigilance_bulletin.create,admin');
    Route::post('admin/vigilance/bulletin/add', [VigilanceBulletinController::class, 'store'])->middleware('permission:vigilance_bulletin.create,admin');
    Route::get('admin/vigilance/bulletin/edit/{id}', [VigilanceBulletinController::class, 'edit'])->middleware('permission:vigilance_bulletin.edit,admin');
    Route::post('admin/vigilance/bulletin/update/{id}', [VigilanceBulletinController::class, 'update'])->middleware('permission:vigilance_bulletin.edit,admin');
    Route::delete('admin/vigilance/bulletin/delete/{id}', [VigilanceBulletinController::class, 'delete'])->middleware('permission:vigilance_bulletin.delete,admin');

    Route::get('admin/rti', function () {
        return view('backend.rti.index');
    })->middleware('permission:rti.view,admin');

    Route::get('admin/rti/officers', [RTIOfficerController::class, 'list'])->middleware('permission:rti_officers.view,admin');
    Route::get('admin/rti/officers/add', [RTIOfficerController::class, 'add'])->middleware('permission:rti_officers.create,admin');
    Route::post('admin/rti/officers/add', [RTIOfficerController::class, 'store'])->middleware('permission:rti_officers.create,admin');
    Route::get('admin/rti/officers/edit/{id}', [RTIOfficerController::class, 'edit'])->middleware('permission:rti_officers.edit,admin');
    Route::post('admin/rti/officers/update/{id}', [RTIOfficerController::class, 'update'])->middleware('permission:rti_officers.edit,admin');
    Route::delete('admin/rti/officers/delete/{id}', [RTIOfficerController::class, 'delete'])->middleware('permission:rti_officers.delete,admin');

    Route::get('admin/rti/information', [RTIInformationController::class, 'list'])->middleware('permission:rti_information.view,admin');
    Route::get('admin/rti/information/add', [RTIInformationController::class, 'add'])->middleware('permission:rti_information.create,admin');
    Route::post('admin/rti/information/add', [RTIInformationController::class, 'store'])->middleware('permission:rti_information.create,admin');
    Route::get('admin/rti/information/edit/{id}', [RTIInformationController::class, 'edit'])->middleware('permission:rti_information.edit,admin');
    Route::post('admin/rti/information/update/{id}', [RTIInformationController::class, 'update'])->middleware('permission:rti_information.edit,admin');
    Route::delete('admin/rti/information/delete/{id}', [RTIInformationController::class, 'delete'])->middleware('permission:rti_information.delete,admin');

    Route::get('admin/careers', function () {
        return view('backend.careers.index');
    })->middleware('permission:careers.view,admin');

    Route::get('admin/careers/notifications', [CareerNotificationController::class, 'list'])->middleware('permission:careers.view,admin');
    Route::get('admin/careers/notifications/add', [CareerNotificationController::class, 'add'])->middleware('permission:careers.create,admin');
    Route::post('admin/careers/notifications/add', [CareerNotificationController::class, 'store'])->middleware('permission:careers.create,admin');
    Route::get('admin/careers/notifications/edit/{id}', [CareerNotificationController::class, 'edit'])->middleware('permission:careers.edit,admin');
    Route::post('admin/careers/notifications/update/{id}', [CareerNotificationController::class, 'update'])->middleware('permission:careers.edit,admin');
    Route::delete(
        'admin/careers/notifications/file/delete/{id}',
        [CareerNotificationController::class, 'deleteFile']
    )->middleware('permission:careers.delete,admin');
    Route::delete('admin/careers/notifications/delete/{id}', [CareerNotificationController::class, 'delete'])->middleware('permission:careers.delete,admin');


    Route::get('admin/finance', function () {
        return view('backend.finance.index');
    })->middleware('permission:finance.view,admin');

    Route::get('admin/finance/reports', [FinanceReportController::class, 'list'])->middleware('permission:annual_reports.view,admin');
    Route::get('admin/finance/reports/add', [FinanceReportController::class, 'add'])->middleware('permission:annual_reports.create,admin');
    Route::post('admin/finance/reports/add', [FinanceReportController::class, 'store'])->middleware('permission:annual_reports.create,admin');
    Route::get('admin/finance/reports/edit/{id}', [FinanceReportController::class, 'edit'])->middleware('permission:annual_reports.edit,admin');
    Route::post('admin/finance/reports/update/{id}', [FinanceReportController::class, 'update'])->middleware('permission:annual_reports.edit,admin');
    Route::delete('admin/finance/reports/delete/{id}', [FinanceReportController::class, 'delete'])->middleware('permission:annual_reports.delete,admin');
    Route::delete(
        'admin/finance/reports/file/delete/{id}',
        [FinanceReportController::class, 'deleteFile']
    )->middleware('permission:annual_reports.delete,admin');

    Route::get('admin/finance/eoi', [FinanceEoiController::class, 'list'])->middleware('permission:eoi_for_banks.view,admin');
    Route::get('admin/finance/eoi/add', [FinanceEoiController::class, 'add'])->middleware('permission:eoi_for_banks.create,admin');
    Route::post('admin/finance/eoi/add', [FinanceEoiController::class, 'store'])->middleware('permission:eoi_for_banks.create,admin');
    Route::get('admin/finance/eoi/edit/{id}', [FinanceEoiController::class, 'edit'])->middleware('permission:eoi_for_banks.edit,admin');
    Route::post('admin/finance/eoi/update/{id}', [FinanceEoiController::class, 'update'])->middleware('permission:eoi_for_banks.edit,admin');
    Route::delete('admin/finance/eoi/delete/{id}', [FinanceEoiController::class, 'delete'])->middleware('permission:eoi_for_banks.delete,admin');

    Route::get('admin/rajshabha', function () {
        return view('backend.rajshabha.index');
    })->middleware('permission:rajshabha.view,admin');

    Route::get('admin/rajshabha/about', [RajshabhaAboutController::class, 'list'])->middleware('permission:rajshabha_about_us.view,admin');
    Route::get('admin/rajshabha/about/add', [RajshabhaAboutController::class, 'add'])->middleware('permission:rajshabha_about_us.create,admin');
    Route::post('admin/rajshabha/about/add', [RajshabhaAboutController::class, 'store'])->middleware('permission:rajshabha_about_us.create,admin');
    Route::get('admin/rajshabha/about/edit/{id}', [RajshabhaAboutController::class, 'edit'])->middleware('permission:rajshabha_about_us.edit,admin');
    Route::post('admin/rajshabha/about/update/{id}', [RajshabhaAboutController::class, 'update'])->middleware('permission:rajshabha_about_us.edit,admin');
    Route::delete('admin/rajshabha/about/delete/{id}', [RajshabhaAboutController::class, 'delete'])->middleware('permission:rajshabha_about_us.delete,admin');

    Route::get('admin/rajshabha/niyam', [RajshabhaNiyamController::class, 'list'])->middleware('permission:niyam_pustak.view,admin');
    Route::get('admin/rajshabha/niyam/add', [RajshabhaNiyamController::class, 'add'])->middleware('permission:niyam_pustak.create,admin');
    Route::post('admin/rajshabha/niyam/add', [RajshabhaNiyamController::class, 'store'])->middleware('permission:niyam_pustak.create,admin');
    Route::get('admin/rajshabha/niyam/edit/{id}', [RajshabhaNiyamController::class, 'edit'])->middleware('permission:niyam_pustak.edit,admin');
    Route::post('admin/rajshabha/niyam/update/{id}', [RajshabhaNiyamController::class, 'update'])->middleware('permission:niyam_pustak.edit,admin');
    Route::delete('admin/rajshabha/niyam/delete/{id}', [RajshabhaNiyamController::class, 'delete'])->middleware('permission:niyam_pustak.delete,admin');

    Route::get('admin/rajshabha/rules', [RajshabhaRulesController::class, 'list'])->middleware('permission:rajshabha_rules.view,admin');
    Route::get('admin/rajshabha/rules/add', [RajshabhaRulesController::class, 'add'])->middleware('permission:rajshabha_rules.create,admin');
    Route::post('admin/rajshabha/rules/add', [RajshabhaRulesController::class, 'store'])->middleware('permission:rajshabha_rules.create,admin');
    Route::get('admin/rajshabha/rules/edit/{id}', [RajshabhaRulesController::class, 'edit'])->middleware('permission:rajshabha_rules.edit,admin');
    Route::post('admin/rajshabha/rules/update/{id}', [RajshabhaRulesController::class, 'update'])->middleware('permission:rajshabha_rules.edit,admin');
    Route::delete('admin/rajshabha/rules/delete/{id}', [RajshabhaRulesController::class, 'delete'])->middleware('permission:rajshabha_rules.delete,admin');

    Route::get('admin/vendors', function () {
        return view('backend.vendors.index');
    })->middleware('permission:vendors.view,admin');

    Route::get('admin/vendors/portal', [VendorsPortalController::class, 'list'])->middleware('permission:vendors.view,admin');
    Route::get('admin/vendors/portal/add', [VendorsPortalController::class, 'add'])->middleware('permission:vendors.create,admin');
    Route::post('admin/vendors/portal/add', [VendorsPortalController::class, 'store'])->middleware('permission:vendors.create,admin');
    Route::get('admin/vendors/portal/edit/{id}', [VendorsPortalController::class, 'edit'])->middleware('permission:vendors.edit,admin');
    Route::post('admin/vendors/portal/update/{id}', [VendorsPortalController::class, 'update'])->middleware('permission:vendors.edit,admin');
    Route::delete('admin/vendors/portal/delete/{id}', [VendorsPortalController::class, 'delete'])->middleware('permission:vendors.delete,admin');

    Route::get('admin/news', [NewsController::class, 'index'])->middleware('permission:news.view,admin');

    Route::get('admin/news/list', [NewsController::class, 'list'])->middleware('permission:news.view,admin');
    Route::get('admin/news/add', [NewsController::class, 'add'])->middleware('permission:news.create,admin');
    Route::post('admin/news/add', [NewsController::class, 'store'])->middleware('permission:news.create,admin');
    Route::get('admin/news/edit/{id}', [NewsController::class, 'edit'])->middleware('permission:news.edit,admin');
    Route::post('admin/news/update/{id}', [NewsController::class, 'update'])->middleware('permission:news.edit,admin');
    Route::delete('admin/news/delete/{id}', [NewsController::class, 'delete'])->middleware('permission:news.delete,admin');
    Route::post('admin/news/category/add', [NewsController::class, 'categoryAdd'])->middleware('permission:news_categories.create,admin');
    Route::post('admin/news/category/update/{id}', [NewsController::class, 'categoryUpdate'])->middleware('permission:news_categories.edit,admin');

    // Legacy Management Routes (Gliders Legacy)
    Route::get('admin/legacy', [LegacyController::class, 'index'])->name('admin.legacy.index')->middleware('permission:legacy.view,admin');
    Route::get('admin/legacy/add', [LegacyController::class, 'add'])->name('admin.legacy.add')->middleware('permission:legacy.create,admin');
    Route::post('admin/legacy/store', [LegacyController::class, 'store'])->name('admin.legacy.store')->middleware('permission:legacy.create,admin');
    Route::get('admin/legacy/edit/{id}', [LegacyController::class, 'edit'])->name('admin.legacy.edit')->middleware('permission:legacy.edit,admin');
    Route::post('admin/legacy/update/{id}', [LegacyController::class, 'update'])->name('admin.legacy.update')->middleware('permission:legacy.edit,admin');
    Route::delete('admin/legacy/delete/{id}', [LegacyController::class, 'delete'])->name('admin.legacy.delete')->middleware('permission:legacy.delete,admin');

    // OPF Legacy Management Routes (OPF Legacy)
    Route::get('admin/opf-legacy', [LegacyController::class, 'indexOPF'])->name('admin.opf_legacy.index')->middleware('permission:legacy.view,admin');
    Route::get('admin/opf-legacy/add', [LegacyController::class, 'addOPF'])->name('admin.opf_legacy.add')->middleware('permission:legacy.create,admin');
    Route::post('admin/opf-legacy/store', [LegacyController::class, 'storeOPF'])->name('admin.opf_legacy.store')->middleware('permission:legacy.create,admin');
    Route::get('admin/opf-legacy/edit/{id}', [LegacyController::class, 'editOPF'])->name('admin.opf_legacy.edit')->middleware('permission:legacy.edit,admin');
    Route::post('admin/opf-legacy/update/{id}', [LegacyController::class, 'updateOPF'])->name('admin.opf_legacy.update')->middleware('permission:legacy.edit,admin');
    Route::delete('admin/opf-legacy/delete/{id}', [LegacyController::class, 'deleteOPF'])->name('admin.opf_legacy.delete')->middleware('permission:legacy.delete,admin');

    Route::post('admin/legacy/settings', [LegacyController::class, 'updateSettings'])->name('admin.legacy.settings')->middleware('permission:legacy.edit,admin');
    Route::post('admin/legacy/reorder', [LegacyController::class, 'reorder'])->name('admin.legacy.reorder')->middleware('permission:legacy.edit,admin');

    Route::get('admin/category/list', [ProductCategoryController::class, 'list'])->middleware('permission:product_categories.view,admin');
    Route::get('admin/category/add', [ProductCategoryController::class, 'add'])->middleware('permission:product_categories.create,admin');
    Route::post('admin/category/add', [ProductCategoryController::class, 'store'])->middleware('permission:product_categories.create,admin');
    Route::get('admin/category/edit/{id}', [ProductCategoryController::class, 'edit'])->middleware('permission:product_categories.edit,admin');
    Route::post('admin/category/update/{id}', [ProductCategoryController::class, 'update'])->middleware('permission:product_categories.edit,admin');
    Route::delete('admin/category/delete/{id}', [ProductCategoryController::class, 'delete'])->middleware('permission:product_categories.delete,admin');

    Route::get('admin/product/list', [ProductController::class, 'list'])->middleware('permission:product.view,admin');
    Route::get('admin/product/add', [ProductController::class, 'add'])->middleware('permission:product.create,admin');
    Route::post('admin/product/add', [ProductController::class, 'store'])->middleware('permission:product.create,admin');
    Route::get('admin/product/edit/{id}', [ProductController::class, 'edit'])->middleware('permission:product.edit,admin');
    Route::post('admin/product/update/{id}', [ProductController::class, 'update'])->middleware('permission:product.edit,admin');
    Route::delete('admin/product/delete/{id}', [ProductController::class, 'delete'])->middleware('permission:product.delete,admin');

    Route::get('admin/media', [MediaController::class, 'list'])->middleware('permission:media.view,admin');
    Route::get('admin/media/add', [MediaController::class, 'add'])->middleware('permission:media.create,admin');
    Route::post('admin/media/store', [MediaController::class, 'store'])->middleware('permission:media.create,admin');
    Route::post('admin/media/upload-video', [MediaController::class, 'uploadVideo'])->middleware('permission:media.create,admin');
    Route::get('admin/media/edit/{id}', [MediaController::class, 'edit'])->middleware('permission:media.edit,admin');
    Route::post('admin/media/update/{id}', [MediaController::class, 'update'])->middleware('permission:media.edit,admin');
    Route::delete('admin/media/delete/{id}', [MediaController::class, 'delete'])->middleware('permission:media.delete,admin');

    Route::get('admin/profile', [AdminAuthController::class, 'profile_page'])->middleware('permission:profile.view,admin');
    Route::post('admin/profile/update', [AdminAuthController::class, 'update_profile'])->middleware('permission:profile.edit,admin');


    Route::get('admin/role', [RoleAndPermissionController::class, 'index'])->name('admin.index')->middleware('permission:roles.view,admin');

    Route::get('admin/create_sub', [RoleAndPermissionController::class, 'create_sub_admin_page'])
        ->name('admin.create')->middleware('permission:roles.create,admin');

    Route::post('admin/store', [RoleAndPermissionController::class, 'store_sub_admin'])
        ->name('admin.store')->middleware('permission:roles.create,admin');

    Route::get('admin/{id}/edit', [RoleAndPermissionController::class, 'edit_sub_admin'])
        ->name('admin.edit')->middleware('permission:roles.edit,admin');

    Route::post('admin/{id}', [RoleAndPermissionController::class, 'update_sub_admin'])
        ->name('admin.update')->middleware('permission:roles.edit,admin');

    Route::post('admin/destroy/{id}', [RoleAndPermissionController::class, 'delete_sub_admin'])
        ->name('admin.destroy')->middleware('permission:roles.delete,admin');

    Route::get('admin/home', function () {
        return view('backend.home_page.index');
    })->middleware('permission:home_page.view,admin');

    Route::get('admin/home/key_offerings', [keyOfferingsController::class, 'list'])->middleware('permission:home_page.view,admin');
    Route::get('admin/about/key_offerings/add', [keyOfferingsController::class, 'add'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/about/key_offerings/add', [keyOfferingsController::class, 'store'])->middleware('permission:home_page.edit,admin');
    Route::get('admin/about/key_offerings/edit/{id}', [keyOfferingsController::class, 'edit'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/about/key_offerings/update/{id}', [keyOfferingsController::class, 'update'])->middleware('permission:home_page.edit,admin');
    Route::delete('admin/about/key_offerings/delete/{id}', [keyOfferingsController::class, 'delete'])->middleware('permission:home_page.delete,admin');

    Route::get('admin/home/video_banner/edit', [keyOfferingsController::class, 'edit_video_banner'])->middleware('permission:home_page.view,admin');
    Route::post('admin/video_banner/update', [keyOfferingsController::class, 'update_video_banner'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/video_banner/upload-chunk', [keyOfferingsController::class, 'uploadChunk'])->name('admin.video_banner.upload_chunk')->middleware('permission:home_page.edit,admin');

    Route::get('admin/home/our_units/edit', [keyOfferingsController::class, 'edit_our_units'])->middleware('permission:home_page.view,admin');
    Route::post('admin/our_units/update', [keyOfferingsController::class, 'update_our_units'])->middleware('permission:home_page.edit,admin');

    Route::get('admin/home/state_counter/edit', [keyOfferingsController::class, 'edit_state_counter'])->middleware('permission:home_page.view,admin');
    Route::post('admin/state_counter/update', [keyOfferingsController::class, 'update_state_counter'])->middleware('permission:home_page.edit,admin');
    // Ticker News routes
    Route::get('admin/home/marquee/edit', [TickerNewsController::class, 'index'])->middleware('permission:home_page.view,admin');
    Route::post('admin/home/marquee/speed/update', [TickerNewsController::class, 'updateSpeed'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/home/marquee/add', [TickerNewsController::class, 'store'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/home/marquee/update-item/{id}', [TickerNewsController::class, 'updateItem'])->middleware('permission:home_page.edit,admin');
    Route::delete('admin/home/marquee/delete/{id}', [TickerNewsController::class, 'delete'])->middleware('permission:home_page.delete,admin');

    Route::get('admin/home/image_gallery', [keyOfferingsController::class, 'image_gallery_list'])->middleware('permission:home_page.view,admin');
    Route::get('admin/home/image_gallery/form/{id?}', [keyOfferingsController::class, 'image_gallery_form'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/home/image_gallery/save', [keyOfferingsController::class, 'image_gallery_save'])->middleware('permission:home_page.edit,admin');
    Route::delete('admin/home/image_gallery/delete/{id}', [keyOfferingsController::class, 'image_gallery_delete'])->middleware('permission:home_page.delete,admin');


    Route::get('admin/home/partner_logo', [keyOfferingsController::class, 'partner_logo_list'])->middleware('permission:home_page.view,admin');
    Route::get('admin/home/partner_logo/form/{id?}', [keyOfferingsController::class, 'partner_logo_form'])->middleware('permission:home_page.edit,admin');
    Route::post('admin/home/partner_logo/save', [keyOfferingsController::class, 'partner_logo_save'])->middleware('permission:home_page.edit,admin');
    Route::delete('admin/home/partner_logo/delete/{id}', [keyOfferingsController::class, 'partner_logo_delete'])->middleware('permission:home_page.delete,admin');

    Route::get('admin/inquiry', [HomeController::class, 'adminIndex'])
        ->name('admin.inquiry')->middleware('permission:inquiry.view,admin');
    Route::post('admin/inquiry/reply/{id}', [HomeController::class, 'replyContact'])
        ->name('admin.inquiry.reply')->middleware('permission:inquiry.edit,admin');

    Route::get('/chatbot', [ChatbotFaqController::class, 'index'])->name('chatbot.index')->middleware('permission:chatbot.view,admin');
    Route::get('/chatbot/create', [ChatbotFaqController::class, 'create'])->name('chatbot.create')->middleware('permission:chatbot.create,admin');
    Route::post('/chatbot/store', [ChatbotFaqController::class, 'store'])->name('chatbot.store')->middleware('permission:chatbot.create,admin');
    Route::get('/chatbot/edit/{id}', [ChatbotFaqController::class, 'edit'])->name('chatbot.edit')->middleware('permission:chatbot.edit,admin');
    Route::post('/chatbot/update/{id}', [ChatbotFaqController::class, 'update'])->name('chatbot.update')->middleware('permission:chatbot.edit,admin');
    Route::delete('/chatbot/delete/{id}', [ChatbotFaqController::class, 'destroy'])->name('chatbot.delete')->middleware('permission:chatbot.delete,admin');
    
});


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about/{tab?}', [AboutController::class, 'index'])->name('about');
Route::get('/vigilance/{tab?}', [VigilanceController::class, 'index'])->name('vigilance');
Route::get('/rti/{tab?}', [RtiController::class, 'index'])->name('rti');
Route::get('/careers/{tab?}', [CareerController::class, 'index'])->name('careers');
Route::get('/finance/{tab?}', [FinanceController::class, 'index'])
    ->name('finance');
Route::get('/rajbhasha/{tab?}', [RajbhashaController::class, 'index'])
    ->name('rajbhasha');
Route::get('/vendors/{tab?}', [VendorController::class, 'index'])
    ->name('vendors');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductFController::class, 'index'])->name('products.index');
    Route::get('/category/{id}', [ProductFController::class, 'category'])->name('products.category');
    Route::get('/category/{categoryId}/product/{productId}', [ProductFController::class, 'productDetail'])
        ->name('products.detail');
});

// Route::get('/news/{category?}', [\App\Http\Controllers\Frontend\FNewsController::class, 'index'])
//     ->name('news');

Route::get('/news', [\App\Http\Controllers\Frontend\FNewsController::class, 'categories'])
    ->name('news.categories');

Route::get('/news/category/{id}', [\App\Http\Controllers\Frontend\FNewsController::class, 'category'])
    ->name('news.category');

Route::get('/news/article/{id}', [\App\Http\Controllers\Frontend\FNewsController::class, 'show'])
    ->name('news.show');

Route::get('/media/{playlist?}', [FMediaController::class, 'index'])
    ->name('media');
Route::post('/contact-store', [HomeController::class, 'storeContact'])->name('contact.store');

Route::get('/privacy-policy', [PolicyController::class, 'privacy'])
    ->name('privacy.policy');

Route::get('/terms-and-conditions', [PolicyController::class, 'terms'])
    ->name('terms.conditions');

Route::get('/sitemap', [PolicyController::class, 'sitemap'])
    ->name('sitemap');
    
Route::get('/chatbot/questions', [ChatbotController::class, 'questions']);
Route::post('/chatbot/reply', [ChatbotController::class, 'reply']);
