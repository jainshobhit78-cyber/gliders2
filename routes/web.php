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
use App\Http\Controllers\Backend\CareerJobController;
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
        
        $output = "";

        // 1. Social fields migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_11_010000_add_social_fields_to_general_settings.php',
                '--force' => true
            ]);
            $output .= "Social fields migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Social fields migration failed: " . $e->getMessage() . ". ";
        }

        // 2. Launch experience migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_17_010000_add_launch_experience_to_general_settings.php',
                '--force' => true
            ]);
            $output .= "Launch experience migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Launch experience migration failed: " . $e->getMessage() . ". ";
        }

        // 3. Finance display order migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_17_020000_add_display_order_to_finance_tables.php',
                '--force' => true
            ]);
            $output .= "Finance display order migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Finance display order migration failed: " . $e->getMessage() . ". ";
        }

        // 4. Finance EOI status toggle migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_17_030000_add_eoi_enabled_to_general_settings_table.php',
                '--force' => true
            ]);
            $output .= "Finance EOI toggle migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Finance EOI toggle migration failed: " . $e->getMessage() . ". ";
        }

        // 5. Contact Messages Company/Location columns migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_17_040000_add_company_and_location_to_contact_messages_table.php',
                '--force' => true
            ]);
            $output .= "Contact Messages Company/Location migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Contact Messages Company/Location migration failed: " . $e->getMessage() . ". ";
        }

        // 6. Career Jobs table migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_17_050000_create_career_jobs_table.php',
                '--force' => true
            ]);
            $output .= "Career Jobs migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Career Jobs migration failed: " . $e->getMessage() . ". ";
        }

        // 7. More Font Families migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_18_020000_add_more_font_fields_to_general_settings.php',
                '--force' => true
            ]);
            $output .= "More Font Families migration run completed. ";
        } catch (\Exception $e) {
            $output .= "More Font Families migration failed: " . $e->getMessage() . ". ";
        }

        // 8. Products display_order column migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_18_030000_add_display_order_to_products_table.php',
                '--force' => true
            ]);
            $output .= "Products display_order migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Products display_order migration failed: " . $e->getMessage() . ". ";
        }

        // 9. Homepage product selection and auto-slider migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_18_040000_add_homepage_products_to_general_settings.php',
                '--force' => true
            ]);
            $output .= "Homepage products migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Homepage products migration failed: " . $e->getMessage() . ". ";
        }

        // 10. Admin profile photo migration
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', [
                '--path' => 'database/migrations/2026_07_18_050000_add_profile_photo_to_admins_table.php',
                '--force' => true
            ]);
            $output .= "Admin profile photo migration run completed. ";
        } catch (\Exception $e) {
            $output .= "Admin profile photo migration failed: " . $e->getMessage() . ". ";
        }

        // Self-healing fallback: directly alter the tables if migrations table is out of sync
        try {
            \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'social_facebook')) {
                    $table->string('social_facebook')->nullable();
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'social_twitter')) {
                    $table->string('social_twitter')->nullable();
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'social_instagram')) {
                    $table->string('social_instagram')->nullable();
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'social_linkedin')) {
                    $table->string('social_linkedin')->nullable();
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'social_youtube')) {
                    $table->string('social_youtube')->nullable();
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'eoi_enabled')) {
                    $table->boolean('eoi_enabled')->default(true);
                }
            });

            \Illuminate\Support\Facades\Schema::table('finance_reports', function ($table) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('finance_reports', 'display_order')) {
                    $table->integer('display_order')->default(999);
                }
            });

            \Illuminate\Support\Facades\Schema::table('finance_eoi', function ($table) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('finance_eoi', 'display_order')) {
                    $table->integer('display_order')->default(999);
                }
            });

            \Illuminate\Support\Facades\Schema::table('contact_messages', function ($table) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'company_name')) {
                    $table->string('company_name')->nullable()->after('name');
                }
                if (!\Illuminate\Support\Facades\Schema::hasColumn('contact_messages', 'location')) {
                    $table->string('location')->nullable()->after('company_name');
                }
            });

            if (!\Illuminate\Support\Facades\Schema::hasTable('career_jobs')) {
                \Illuminate\Support\Facades\Schema::create('career_jobs', function ($table) {
                    $table->id();
                    $table->string('type')->default('recruitment');
                    $table->string('title');
                    $table->text('job_info')->nullable();
                    $table->text('eligibility')->nullable();
                    $table->date('last_date')->nullable();
                    $table->string('pdf')->nullable();
                    $table->boolean('status')->default(true);
                    $table->timestamps();
                });
            }

            $output .= " | Schema checks and column additions successfully verified!";

            // Self-healing: nav_font_size column
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'nav_font_size')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->string('nav_font_size')->nullable()->default('14');
                });
                $output .= " | nav_font_size column added.";
            }

            // Self-healing: main_menu_font_family, submenu_font_family, body_font_family columns
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'main_menu_font_family')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->string('main_menu_font_family')->nullable()->default('Outfit');
                });
                $output .= " | main_menu_font_family column added.";
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'submenu_font_family')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->string('submenu_font_family')->nullable()->default('Outfit');
                });
                $output .= " | submenu_font_family column added.";
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'body_font_family')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->string('body_font_family')->nullable()->default('Outfit');
                });
                $output .= " | body_font_family column added.";
            }

            // Self-healing: products display_order column
            if (!\Illuminate\Support\Facades\Schema::hasColumn('products', 'display_order')) {
                \Illuminate\Support\Facades\Schema::table('products', function ($table) {
                    $table->integer('display_order')->default(999)->after('category_id');
                });
                $output .= " | products display_order column added.";
            }

            // Self-healing: homepage_product_1, 2, 3, 4, and product_slider_auto columns in general_settings
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'homepage_product_1')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->integer('homepage_product_1')->nullable();
                    $table->foreign('homepage_product_1')->references('id')->on('products')->nullOnDelete();
                });
                $output .= " | homepage_product_1 added.";
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'homepage_product_2')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->integer('homepage_product_2')->nullable();
                    $table->foreign('homepage_product_2')->references('id')->on('products')->nullOnDelete();
                });
                $output .= " | homepage_product_2 added.";
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'homepage_product_3')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->integer('homepage_product_3')->nullable();
                    $table->foreign('homepage_product_3')->references('id')->on('products')->nullOnDelete();
                });
                $output .= " | homepage_product_3 added.";
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'homepage_product_4')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->integer('homepage_product_4')->nullable();
                    $table->foreign('homepage_product_4')->references('id')->on('products')->nullOnDelete();
                });
                $output .= " | homepage_product_4 added.";
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('general_settings', 'product_slider_auto')) {
                \Illuminate\Support\Facades\Schema::table('general_settings', function ($table) {
                    $table->boolean('product_slider_auto')->default(true);
                });
                $output .= " | product_slider_auto added.";
            }

            // Self-healing: profile_photo column in admins table
            if (!\Illuminate\Support\Facades\Schema::hasColumn('admins', 'profile_photo')) {
                \Illuminate\Support\Facades\Schema::table('admins', function ($table) {
                    $table->string('profile_photo')->nullable()->after('password');
                });
                $output .= " | admins profile_photo added.";
            }
        } catch (\Exception $ex) {
            $output .= " | Manual schema update failed: " . $ex->getMessage();
        }

        return $output;
    });

    Route::get('admin/fix-permissions', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\AdminRolePermissionSeeder']);
        return "Permissions successfully populated inside the database!";
    });

    Route::get('admin/seed-brake-parachutes', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }

        $output = "--- RUNNING BRAKE PARACHUTE PRODUCT SEEDER ---\n";
        
        $mirageData = [
            'title' => 'Brake Parachute for Mirage-2000 A/C',
            'category_id' => 5,
            'description' => '<p>The brake parachute is intended to reduce the Aircraft landing run of the aircraft and provides additional safety during emergencies.</p>',
            'wallpaper' => 'mirage_2000_bp.jpg',
            'display_order' => 4,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Unicross Design', 'description' => 'Unicross configuration for maximum drag stability.', 'icon' => ''],
                ['parameter' => 'Measurement of Canopy', 'value' => '5280 X 5280 mm', 'description' => 'Canopy surface dimensions.', 'icon' => ''],
                ['parameter' => 'No. Of Rigging lines', 'value' => '32', 'description' => 'Total load lines supporting the canopy.', 'icon' => ''],
                ['parameter' => 'Effective length of rigging lines', 'value' => '4350 mm', 'description' => 'Length of risers.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Fabric nylon 105 gm undyed Mockleno weave 6/6', 'description' => 'Highly durable, heat-resistant nylon weave.', 'icon' => ''],
                ['parameter' => 'Salient Features', 'value' => 'Streaming speed up to 300 kmph (emergency up to 390 kmph).', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Aerodynamic Deceleration', 'description' => 'Significantly reduces the landing run distance of the Mirage-2000 aircraft, providing additional safety during normal and emergency landing rolls.'],
                ['heading' => 'High-Strength Mockleno Material', 'description' => 'Manufactured using premium mockleno weave 105 gm nylon fabric, providing excellent thermal resistance and deployment stability.'],
                ['heading' => 'Reliable Extraction', 'description' => 'Features 32 rigging lines with a length of 4350 mm, ensuring rapid, symmetrical, and twist-free canopy inflation under extreme aerodynamic loads.']
            ]
        ];

        $migSeriesData = [
            'title' => 'Brake Parachute for MIG-21/23/25 Series A/C',
            'category_id' => 5,
            'description' => '<p>The Brake Parachute is used to reduce the landing run of the aircraft and provides additional safety during emergencies.</p>',
            'wallpaper' => 'mig_series_bp.jpg',
            'display_order' => 7,
            'technical_specs' => [
                ['parameter' => 'MiG-21 Canopy Area', 'value' => 'Unicross, 15.3 sqm', 'description' => 'MiG-21 canopy surface area.', 'icon' => ''],
                ['parameter' => 'MiG-21 Mass / Auxiliary Parachute', 'value' => '14 kg / 0.90 sqm', 'description' => 'MiG-21 system weight.', 'icon' => ''],
                ['parameter' => 'MiG-21 Landing Speed (Normal / Emergency)', 'value' => '180 kmph / 300-320 kmph', 'description' => 'MiG-21 streaming speed thresholds.', 'icon' => ''],
                ['parameter' => 'MiG-23 Canopy Area / Mass', 'value' => 'Unicross, 21 sqm / 18.5 kg', 'description' => 'MiG-23 canopy surface area and weight.', 'icon' => ''],
                ['parameter' => 'MiG-23 Landing Speed (Normal / Emergency)', 'value' => '180 to 300 kmph / 300-320 kmph', 'description' => 'MiG-23 operational speeds.', 'icon' => ''],
                ['parameter' => 'MiG-25 Canopy Area / Mass', 'value' => 'Unicross (Twin), 23.2 sqm / 54 kg', 'description' => 'MiG-25 twin canopy specifications.', 'icon' => ''],
                ['parameter' => 'MiG-25 Landing Speed (Normal / Emergency)', 'value' => '330 kmph / above 330 kmph', 'description' => 'MiG-25 high-speed operational limits.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Fabric Nylon 109 gm U/D', 'description' => 'High-strength nylon fabric for MiG series.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Multi-Aircraft Compatibility', 'description' => 'Tailored configurations designed specifically to support deployment and safe retardation across MiG-21, MiG-23, and MiG-25 fighter jets.'],
                ['heading' => 'Heavy Retardation Force', 'description' => 'Can decelerate aircraft landing masses ranging from 14 kg (system weight) up to 54 kg dual systems, ensuring safety even in adverse runway situations.']
            ]
        ];

        $tejasData = [
            'title' => 'Brake Parachute (Hybrid) for LCA (Tejas)',
            'category_id' => 5,
            'description' => '<p>Light Light Combat Aircraft (LCA) Tejas is a multi-role Combat Aircraft which uses a brake Parachute as retardation device to reduce the landing roll. Brake Parachute system is an effective device used for retarding and shortening the landing run of an Aircraft on its landing roll as well as during aborted take-off.</p>',
            'wallpaper' => 'lca_tejas_bp.jpg',
            'display_order' => 1,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Uni cross', 'description' => 'Unicross layout for stable drag.', 'icon' => ''],
                ['parameter' => 'Surface Area of Main Parachute', 'value' => '17 Sq. Mtr.', 'description' => 'Total main parachute area.', 'icon' => ''],
                ['parameter' => 'Span / Width of Arm', 'value' => '5.76 m / 1.73 m', 'description' => 'Geometric dimensions of the canopy.', 'icon' => ''],
                ['parameter' => 'No. Of Rigging Line', 'value' => '32', 'description' => 'Kevlar rigging lines layout.', 'icon' => ''],
                ['parameter' => 'Deployment Speed (Normal / Emergency)', 'value' => '285 Kmph / 340 Kmph', 'description' => 'Operational deployment speeds.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Fabric Nylon 66, 93 U/D', 'description' => 'Heavy-duty parachute fabric.', 'icon' => ''],
                ['parameter' => 'Rigging Lines Material', 'value' => 'Tape Para-Aramid (Kevlar) 21 mm BS: 800 Kg', 'description' => 'Ultra high strength Kevlar lines.', 'icon' => ''],
                ['parameter' => 'Mass of Parachute', 'value' => '10 Kg', 'description' => 'Packaged system weight.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Hybrid Kevlar Reinforcement', 'description' => 'Features high-strength Kevlar (Para-Aramid) rigging lines designed for exceptional thermal and shock loading limits.'],
                ['heading' => 'Retardation and Roll Shortening', 'description' => 'Highly effective at reducing the landing run on dry, wet, and icy runways, as well as providing safety during aborted take-offs.']
            ]
        ];

        $hawkData = [
            'title' => 'Brake Parachute for Hawk (AJT) Aircraft',
            'category_id' => 5,
            'description' => '<p>Brake Parachute for Hawk (AJT) is an effective device used for retarding and shortening the landing run of an Aircraft on its landing roll as well as during aborted take-off. The Brake Parachute is very useful during unfavourable landing conditions such as wet and icy runways.</p>',
            'wallpaper' => 'hawk_ajt_bp.jpg',
            'display_order' => 6,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Ring Slot', 'description' => 'Ring-slot design ensuring highly stable drag.', 'icon' => ''],
                ['parameter' => 'Nominal Dia. Of Canopy / Surface Area', 'value' => '3.82 M / 11.4 sqm', 'description' => 'Canopy geometric specifications.', 'icon' => ''],
                ['parameter' => 'No. Of rigging lines / Length', 'value' => '30 / 5480 mm', 'description' => 'Rigging lines configuration.', 'icon' => ''],
                ['parameter' => 'Aircraft Landing Mass (Normal / Max)', 'value' => '5900 Kgs / 9100 Kgs', 'description' => 'Supported landing mass range.', 'icon' => ''],
                ['parameter' => 'Max. Deployment Speed', 'value' => '160 Knots', 'description' => 'Maximum streaming velocity threshold.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Fabric Nylon 66, 90 gsm U/D', 'description' => 'Highly strong lightweight nylon fabric.', 'icon' => ''],
                ['parameter' => 'Mass of Parachute System', 'value' => '6.2 kg', 'description' => 'Total system weight.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Ring Slot Drag Design', 'description' => 'Uses an aerodynamically optimized ring-slot geometry to deliver exceptionally stable and symmetric drag force during deployment.'],
                ['heading' => 'Unfavourable Weather Retardation', 'description' => 'Ensures safe stopping distances for the Hawk trainer jet under challenging weather and runway conditions.']
            ]
        ];

        $lakshyaData = [
            'title' => 'Parachute Recovery System for PTA-Lakshya MK-II',
            'category_id' => 5,
            'description' => '<p>This two stage Parachute is used for the safe recovery of Pilot less target Aircraft (PTA) Lakshya at the end of its mission.</p>',
            'wallpaper' => 'lakshya_recovery_bp.jpg',
            'display_order' => 8,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Tri-conical', 'description' => 'Tri-conical layout for stable target recovery.', 'icon' => ''],
                ['parameter' => 'Dia of Canopy / No. of Gores', 'value' => '14.63 m / 48', 'description' => 'Canopy geometric dimensions.', 'icon' => ''],
                ['parameter' => 'No. Of Rigging Lines / Length', 'value' => '48 / 14.6 m', 'description' => 'Rigging lines layout.', 'icon' => ''],
                ['parameter' => 'Recovery Speed (Normal / Max)', 'value' => '270 Kmph / 684 Kmph IAS', 'description' => 'Deployment speed ranges.', 'icon' => ''],
                ['parameter' => 'Recovery Altitude', 'value' => '300 m to 9 Km', 'description' => 'Operating altitude range.', 'icon' => ''],
                ['parameter' => 'Rate of Descent / Max Recovery Mass', 'value' => '6-7 m/s / 500 Kg', 'description' => 'Descent speed and capacity.', 'icon' => ''],
                ['parameter' => 'Basic Material (Fabric 1 / 2)', 'value' => 'Fabric Nylon 37 gm Rip Stop / Fabric Nylon 75 gm', 'description' => 'Specialized lightweight high-tensile ripstop nylon.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Two-Stage Safe Recovery', 'description' => 'Features a two-stage sequential deployment mechanism designed for safe deceleration and recovery of target aircraft.'],
                ['heading' => 'High-Altitude Deployment', 'description' => 'Operates normally across a wide altitude range from 300 meters up to 9 kilometers at speeds up to 684 km/h.']
            ]
        ];

        $jaguarData = [
            'title' => 'Brake Parachute for Jaguar A/C',
            'category_id' => 5,
            'description' => '<p>The Brake Parachute is used to reduce the landing run of the aircraft. The parachute is stowed directly into a metal container with the parachute connecting riser protruding at the aircraft end. The main parachute is held in position in the removable container by a pair of locking strap & the auxiliary parachute is stowed in a small pack which is attached to one of the straps.</p>',
            'wallpaper' => 'jaguar_bp.jpg',
            'display_order' => 5,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Ribbon Type', 'description' => 'Ribbon configuration to minimize shock.', 'icon' => ''],
                ['parameter' => 'Diameter of Canopy', 'value' => '5.64 m', 'description' => 'Canopy diameter.', 'icon' => ''],
                ['parameter' => 'No. Of Rigging lines / Length', 'value' => '24 / 5500 mm', 'description' => 'Rigging lines configuration.', 'icon' => ''],
                ['parameter' => 'Normal / Emergency streaming speed', 'value' => '150 knots / 180 knots', 'description' => 'Operational deployment speeds.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Ribbon Nylon 50 mm / 16 mm', 'description' => 'High strength nylon ribbon grids.', 'icon' => ''],
                ['parameter' => 'Service Life', 'value' => '40 streamings', 'description' => 'Total certified deployment cycles.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Ribbon Type Canopy', 'description' => 'Engineered with high-tensile nylon ribbon gaps to allow controlled airflow and minimize high-speed shock impact.'],
                ['heading' => 'Locking Strap Enclosure', 'description' => 'Designed to fit into a specialized metal tail container featuring auxiliary parachute auto-deployment straps.']
            ]
        ];

        $su30Data = [
            'title' => 'Brake Parachute for SU-30 A/C',
            'category_id' => 5,
            'description' => '<p>The brake parachute is intended to reduce the Aircraft landing run of the aircraft and provides additional safety during emergencies.</p>',
            'wallpaper' => 'su30_bp.jpg',
            'display_order' => 2,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Uni-cross', 'description' => 'Unicross design layout.', 'icon' => ''],
                ['parameter' => 'Surface area of main Parachute', 'value' => 'total 50 sqm (25 Sqm each - 2 nos)', 'description' => 'Dual canopy surface area.', 'icon' => ''],
                ['parameter' => 'Span / Width of Arm', 'value' => '7m / 2.1m', 'description' => 'Canopy arm dimensions.', 'icon' => ''],
                ['parameter' => 'No. Of rigging lines / Length', 'value' => '32 / 6680 mm', 'description' => 'Rigging lines specs.', 'icon' => ''],
                ['parameter' => 'Landing Speed (Normal / Emergency)', 'value' => '260 Kmph / 300 Kmph', 'description' => 'High speed operational thresholds.', 'icon' => ''],
                ['parameter' => 'Max. Operational load / Weight', 'value' => '234000 N / 24 kg', 'description' => 'Load capacity and system weight.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Fabric Nylon 66, 93 gm U/D', 'description' => 'Polyamide Nylon 66 fabric.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Twin-Canopy Unicross Design', 'description' => 'Deploys dual canopy parachutes (25 sqm each) to generate massive deceleration force for the heavy Sukhoi SU-30 fighter jet.'],
                ['heading' => 'Polyamide Nylon Construction', 'description' => 'Built with resin-treated Nylon 66 fabrics to ensure low air permeability and high shock resistance during emergency landings.']
            ]
        ];

        $mig29Data = [
            'title' => 'Brake Parachute for MiG-29 UPG A/C',
            'category_id' => 5,
            'description' => '<p>High-performance braking parachute designed for safe landing and retardation of the MiG-29 UPG fighter jet.</p>',
            'wallpaper' => 'mig_series_bp.jpg',
            'display_order' => 3,
            'technical_specs' => [
                ['parameter' => 'Design of Canopy', 'value' => 'Unicross Design', 'description' => 'Unicross configuration for MiG-29.', 'icon' => ''],
                ['parameter' => 'Canopy Surface Area', 'value' => '14.4 sqm', 'description' => 'MiG-29 canopy surface area.', 'icon' => ''],
                ['parameter' => 'System Mass / Auxiliary Parachute', 'value' => '8.2 kg / 1.0 sqm', 'description' => 'MiG-29 system weight specs.', 'icon' => ''],
                ['parameter' => 'Landing Speed (Normal / Emergency)', 'value' => '180 kmph / 310 kmph', 'description' => 'Deployment operational speeds.', 'icon' => ''],
                ['parameter' => 'Basic Material', 'value' => 'Fabric Nylon 93 gm U/D', 'description' => 'Nylon 93 gm fabric.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'MiG-29 Precision Fit', 'description' => 'Engineered precisely for the MiG-29 rear deploy housing, ensuring zero-fault deployment at streaming speeds up to 180 kmph.'],
                ['heading' => 'High Retardation efficiency', 'description' => 'Generates balanced drag forces instantly upon release, reducing runway load and ensuring flight safety.']
            ]
        ];

        $sync = function ($matchKeyword, $data) use (&$output) {
            $product = \App\Models\Product::where('category_id', 5)
                ->where('title', 'LIKE', '%' . $matchKeyword . '%')
                ->first();

            if ($product) {
                $product->update($data);
                $output .= "Updated existing product ID {$product->id}: {$product->title}\n";
            } else {
                $product = \App\Models\Product::create($data);
                $output .= "Created new product ID {$product->id}: {$product->title}\n";
            }

            if ($product->wallpaper) {
                $exists = \App\Models\ProductImage::where('product_id', $product->id)
                    ->where('image', $product->wallpaper)
                    ->exists();
                if (!$exists) {
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $product->wallpaper
                    ]);
                }
            }
        };

        $sync('SU-30', $su30Data);
        $sync('Mig29', $mig29Data);
        $sync('Tejas', $tejasData);
        $sync('Mirage', $mirageData);
        $sync('MIG-21/23/25', $migSeriesData);
        $sync('Hawk', $hawkData);
        $sync('Lakshya', $lakshyaData);
        $sync('Jaguar', $jaguarData);

        return response($output . "\nSeeding Completed Successfully!", 200)
            ->header('Content-Type', 'text/plain');
    });

    Route::get('admin/seed-rubber-inflatables', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }

        $output = "--- RUNNING RUBBER INFLATABLES PRODUCT SEEDER ---\n";

        // 1. Create Category "Rubber Inflatables" if not exists
        $category = \App\Models\ProductCategory::where('name', 'LIKE', '%Rubber Inflatables%')->first();
        if (!$category) {
            $category = \App\Models\ProductCategory::create([
                'name' => 'Rubber Inflatables',
                'category_title' => 'Rubber Inflatables',
                'category_subtitle' => 'Explore KM floats, inflatable boats and our growing range of rubber-based systems.',
                'image' => 'ibgc.png',
                'wallpaper_image' => 'km_bridge.jpg',
                'status' => 'active',
                'display_order' => 10
            ]);
            $output .= "Created new category: Rubber Inflatables (ID: {$category->id})\n";
        } else {
            $category->update([
                'name' => 'Rubber Inflatables',
                'category_title' => 'Rubber Inflatables',
                'category_subtitle' => 'Explore KM floats, inflatable boats and our growing range of rubber-based systems.',
                'status' => 'active',
            ]);
            $output .= "Updated existing category: Rubber Inflatables (ID: {$category->id})\n";
        }

        $catId = $category->id;

        // 2. Define Products
        $ibgcData = [
            'title' => 'Inflatable Boat Gemini Craft (IBGC)',
            'category_id' => $catId,
            'description' => '<p>High-durability tactical inflatable boat designed for maritime patrol, search and rescue (SAR), and specialized combat operations. Compliant with ISO 6185-3 and military standards, featuring robust Hypalon construction.</p>',
            'wallpaper' => 'ibgc.png',
            'display_order' => 1,
            'technical_specs' => [
                ['parameter' => 'Design of Boat', 'value' => 'Inflatable V-shape keel', 'description' => 'Symmetric V-hull for high speed stability.', 'icon' => ''],
                ['parameter' => 'Material', 'value' => 'Hypalon rubberized fabric', 'description' => 'Extremely durable, UV-resistant fabric.', 'icon' => ''],
                ['parameter' => 'Overall Length / Width', 'value' => '4.7 meters / 1.9 meters', 'description' => 'Standard military dimensions.', 'icon' => ''],
                ['parameter' => 'Capacity', 'value' => '8 to 10 fully equipped personnel', 'description' => 'Load carrying specification.', 'icon' => ''],
                ['parameter' => 'Compatible Motor', 'value' => 'Outboard motor up to 50 HP', 'description' => 'Maximum engine compatibility.', 'icon' => ''],
                ['parameter' => 'Design Standards', 'value' => 'ISO 6185-3 / NCD 4006', 'description' => 'Certified naval design compliance.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Combat Grade Material', 'description' => 'Engineered with military-grade Hypalon rubberized fabric for superior UV, abrasion, and fuel resistance in harsh marine conditions.'],
                ['heading' => 'High Capacity & Stability', 'description' => 'Safely carries up to 10 fully armed commandos or search and rescue personnel with excellent stability under high-speed outboard propulsion.']
            ]
        ];

        $baplwData = [
            'title' => 'Boat Assault Pneumatic Light Weight (BAPLW)',
            'category_id' => $catId,
            'description' => '<p>Specialized lightweight assault inflatable craft designed for tactical river crossings, bridging support, and rapid military insertion tasks. Highly portable and rapidly deployable.</p>',
            'wallpaper' => 'baplw.png',
            'display_order' => 2,
            'technical_specs' => [
                ['parameter' => 'Overall Length', 'value' => '4.95 meters', 'description' => 'Overall craft length.', 'icon' => ''],
                ['parameter' => 'Overall Width', 'value' => '1.90 meters', 'description' => 'Overall craft width.', 'icon' => ''],
                ['parameter' => 'Hull Diameter', 'value' => '500 mm', 'description' => 'Pneumatic tube diameter.', 'icon' => ''],
                ['parameter' => 'Capacity', 'value' => '12 fully armed personnel (including 2 crew)', 'description' => 'Assault squad transport limit.', 'icon' => ''],
                ['parameter' => 'Weight', 'value' => 'Maximum 70 kg (excluding floor and accessories)', 'description' => 'Lightweight boat hull weight.', 'icon' => ''],
                ['parameter' => 'Freeboard (at 1200 kg load)', 'value' => '300 mm', 'description' => 'Safety clearance with 1200 kg load.', 'icon' => ''],
                ['parameter' => 'Freeboard (at 2000 kg load)', 'value' => '200 mm', 'description' => 'Safety clearance with 2000 kg load.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Tactical Assault Capacity', 'description' => 'Specifically built to carry a full squad of 12 fully armed infantrymen for bridging and river crossing operations.'],
                ['heading' => 'Lightweight Portability', 'description' => 'Weighs less than 70 kg without floorboards, allowing rapid manual portage and quick air or vehicular transport.']
            ]
        ];

        $brpData = [
            'title' => 'Boat Reconnaissance Pneumatic (3 Men)',
            'category_id' => $catId,
            'description' => '<p>Compact, highly portable pneumatic reconnaissance boat designed for stealth scouting, marine surveillance, and shallow-water patrol missions. Supplied with folding paddles and foot pump.</p>',
            'wallpaper' => 'brp_3men.png',
            'display_order' => 3,
            'technical_specs' => [
                ['parameter' => 'Design Standard', 'value' => 'Military standard MIL-B-13831E', 'description' => 'Scouting boat military specifications.', 'icon' => ''],
                ['parameter' => 'Capacity', 'value' => '3 fully equipped reconnaissance crew', 'description' => 'Ideal load carrying specification.', 'icon' => ''],
                ['parameter' => 'Floor Construction', 'value' => 'Durable fiber planks / floorboards', 'description' => 'Sturdy removable decking.', 'icon' => ''],
                ['parameter' => 'Propulsion Compatibility', 'value' => 'Outboard motor up to 3.3 HP or manual paddles', 'description' => 'Propulsion options.', 'icon' => ''],
                ['parameter' => 'Supplied Accessories', 'value' => 'Folding paddles, foot pump, repair kit, boat bag, lifeline ropes', 'description' => 'Complete outfitting package.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Stealth Scouting', 'description' => 'Designed for silent, low-profile navigation during reconnaissance and intelligence gathering in shallow rivers and coastal zones.'],
                ['heading' => 'Complete Accessory Kit', 'description' => 'Comes fully equipped with heavy-duty foot pumps, folding paddles, storage bag, and rapid-repair tools for immediate field deployment.']
            ]
        ];

        $floatAssemblyData = [
            'title' => 'Float Assembly for KM Bridge',
            'category_id' => $catId,
            'description' => '<p>High-durability pneumatic float assemblies engineered to support heavy tactical floating bridges and raft systems (such as Krupp-man bridging gear) for heavy vehicle crossings.</p>',
            'wallpaper' => 'float_assembly.png',
            'display_order' => 4,
            'technical_specs' => [
                ['parameter' => 'Application', 'value' => 'Floating bridges / Kruppman (KM) Bridge system', 'description' => 'Military bridging pontoon system compatibility.', 'icon' => ''],
                ['parameter' => 'Material', 'value' => 'Heavy-duty multi-layer rubberized fabric', 'description' => 'Tough abrasion-resistant layered fabric.', 'icon' => ''],
                ['parameter' => 'Certification', 'value' => 'Self-certification level from Directorate General of Quality Assurance (DGQA)', 'description' => 'Official Ministry of Defence quality standard.', 'icon' => ''],
                ['parameter' => 'Core Components', 'value' => 'Float body, valve assemblies, girder coupling interfaces', 'description' => 'Essential hardware components.', 'icon' => '']
            ],
            'main_capabilities' => [
                ['heading' => 'Heavy Load Bridging', 'description' => 'Specifically designed to provide enormous buoyancy to sustain the heavy loads of military trucks and armored vehicles crossing temporary pontoon bridges.'],
                ['heading' => 'DGQA Self-Certified', 'description' => 'Formally certified by the Ministry of Defence for absolute quality, pressure retention, and structural durability under continuous load stress.']
            ]
        ];

        $sync = function ($matchKeyword, $data) use ($catId, &$output) {
            $product = \App\Models\Product::where('category_id', $catId)
                ->where('title', 'LIKE', '%' . $matchKeyword . '%')
                ->first();

            if ($product) {
                $product->update($data);
                $output .= "Updated existing product ID {$product->id}: {$product->title}\n";
            } else {
                $product = \App\Models\Product::create($data);
                $output .= "Created new product ID {$product->id}: {$product->title}\n";
            }

            if ($product->wallpaper) {
                $exists = \App\Models\ProductImage::where('product_id', $product->id)
                    ->where('image', $product->wallpaper)
                    ->exists();
                if (!$exists) {
                    \App\Models\ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $product->wallpaper
                    ]);
                }
            }
        };

        $sync('Gemini Craft', $ibgcData);
        $sync('BAPLW', $baplwData);
        $sync('3 Men', $brpData);
        $sync('Float Assembly', $floatAssemblyData);

        return response($output . "\nRubber Inflatables Seeding Completed Successfully!", 200)
            ->header('Content-Type', 'text/plain');
    });

    Route::get('admin/clear-cache', function () {
        $user = auth()->guard('admin')->user();
        if (!$user || ($user->email !== 'admin@gliders.com' && !$user->hasRole('admin'))) {
            abort(403, 'User does not have the right permissions.');
        }
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        if (function_exists('opcache_reset')) {
            @opcache_reset();
        }
        return "Application cache, config, routes, views, and OPcache successfully cleared!";
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

    Route::get('admin/careers/recruitment', [CareerJobController::class, 'recruitmentList'])->middleware('permission:careers.view,admin');
    Route::get('admin/careers/internship', [CareerJobController::class, 'internshipList'])->middleware('permission:careers.view,admin');
    Route::get('admin/careers/jobs/add', [CareerJobController::class, 'add'])->middleware('permission:careers.create,admin');
    Route::post('admin/careers/jobs/add', [CareerJobController::class, 'store'])->middleware('permission:careers.create,admin');
    Route::get('admin/careers/jobs/edit/{id}', [CareerJobController::class, 'edit'])->middleware('permission:careers.edit,admin');
    Route::post('admin/careers/jobs/update/{id}', [CareerJobController::class, 'update'])->middleware('permission:careers.edit,admin');
    Route::delete('admin/careers/jobs/delete/{id}', [CareerJobController::class, 'delete'])->middleware('permission:careers.delete,admin');


    Route::get('admin/finance', function () {
        $settings = \App\Models\GeneralSetting::firstOrCreate([]);
        $eoiEnabled = $settings ? (bool)$settings->eoi_enabled : true;
        return view('backend.finance.index', compact('eoiEnabled'));
    })->middleware('permission:finance.view,admin');

    Route::post('admin/finance/toggle-eoi', function (\Illuminate\Http\Request $request) {
        $settings = \App\Models\GeneralSetting::firstOrCreate([]);
        $settings->update([
            'eoi_enabled' => (bool)$request->enabled
        ]);
        return response()->json(['status' => 'success']);
    })->middleware('permission:finance.view,admin')->name('admin.finance.toggle-eoi');

    Route::get('admin/finance/reports', [FinanceReportController::class, 'list'])->middleware('permission:annual_reports.view,admin');
    Route::get('admin/finance/reports/add', [FinanceReportController::class, 'add'])->middleware('permission:annual_reports.create,admin');
    Route::post('admin/finance/reports/add', [FinanceReportController::class, 'store'])->middleware('permission:annual_reports.create,admin');
    Route::get('admin/finance/reports/edit/{id}', [FinanceReportController::class, 'edit'])->middleware('permission:annual_reports.edit,admin');
    Route::post('admin/finance/reports/update/{id}', [FinanceReportController::class, 'update'])->middleware('permission:annual_reports.edit,admin');
    Route::delete('admin/finance/reports/delete/{id}', [FinanceReportController::class, 'delete'])->middleware('permission:annual_reports.delete,admin');
    Route::post('admin/finance/reports/reorder', [FinanceReportController::class, 'reorder'])->middleware('permission:annual_reports.edit,admin')->name('admin.finance.reports.reorder');
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
    Route::post('admin/finance/eoi/reorder', [FinanceEoiController::class, 'reorder'])->middleware('permission:eoi_for_banks.edit,admin')->name('admin.finance.eoi.reorder');

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
    Route::get('/offering/{offering}', function (string $offering) {
        return redirect()->route('products.index', ['offering' => $offering]);
    })->name('products.offering');
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
