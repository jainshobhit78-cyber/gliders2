<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminRolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'dashboard.view',
            'settings.view',
            'settings.edit',
            'approvals.view',
            'approvals.edit',
            'inquiry.view',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'legacy.view',
            'legacy.create',
            'legacy.edit',
            'legacy.delete',

            'about.view',
            'leadership.view',
            'leadership.create',
            'leadership.edit',
            'leadership.delete',
            'production_unit.view',
            'production_unit.create',
            'production_unit.edit',
            'production_unit.delete',
            'history.view',
            'history.create',
            'history.edit',
            'history.delete',
            'social_responsibility.view',
            'social_responsibility.create',
            'social_responsibility.edit',
            'social_responsibility.delete',
            'human_resources.view',
            'human_resources.create',
            'human_resources.edit',
            'human_resources.delete',
            'vision.view',
            'vision.create',
            'vision.edit',
            'vision.delete',
            'mission.view',
            'mission.create',
            'mission.edit',
            'mission.delete',
            'directory.view',
            'directory.create',
            'directory.edit',
            'directory.delete',
            'codes_of_conduct.view',
            'codes_of_conduct.create',
            'codes_of_conduct.edit',
            'codes_of_conduct.delete',

            'news.view',
            'news.create',
            'news.edit',
            'news.delete',
            'news_categories.create',
            'news_categories.edit',

            'media.view',
            'media.create',
            'media.edit',
            'media.delete',

            'product_categories.view',
            'product_categories.create',
            'product_categories.edit',
            'product_categories.delete',
            'product.view',
            'product.create',
            'product.edit',
            'product.delete',

            'vigilance.view',
            'chief_vigilance_officer.view',
            'chief_vigilance_officer.create',
            'chief_vigilance_officer.edit',
            'chief_vigilance_officer.delete',
            'vigilance_setup.view',
            'vigilance_setup.create',
            'vigilance_setup.edit',
            'vigilance_setup.delete',
            'vigilance_contact_details.view',
            'vigilance_contact_details.create',
            'vigilance_contact_details.edit',
            'vigilance_contact_details.delete',
            'sexual_harassment_of_women_at_workplace.view',
            'sexual_harassment_of_women_at_workplace.create',
            'sexual_harassment_of_women_at_workplace.edit',
            'sexual_harassment_of_women_at_workplace.delete',
            'independent_external_monitor.view',
            'independent_external_monitor.create',
            'independent_external_monitor.edit',
            'independent_external_monitor.delete',
            'manuals_and_policies.view',
            'manuals_and_policies.create',
            'manuals_and_policies.edit',
            'manuals_and_policies.delete',
            'vigilance_bulletin.view',
            'vigilance_bulletin.create',
            'vigilance_bulletin.edit',
            'vigilance_bulletin.delete',

            'rti.view',
            'rti_officers.view',
            'rti_officers.create',
            'rti_officers.edit',
            'rti_officers.delete',
            'rti_information.view',
            'rti_information.create',
            'rti_information.edit',
            'rti_information.delete',
            
            'careers.view',
            'careers.create',
            'careers.edit',
            'careers.delete',
            
            'finance.view',
            'annual_reports.view',
            'annual_reports.create',
            'annual_reports.edit',
            'annual_reports.delete',
            'eoi_for_banks.view',
            'eoi_for_banks.create',
            'eoi_for_banks.edit',
            'eoi_for_banks.delete',

            'rajshabha.view',
            'rajshabha_about_us.view',
            'rajshabha_about_us.create',
            'rajshabha_about_us.edit',
            'rajshabha_about_us.delete',
            'niyam_pustak.view',
            'niyam_pustak.create',
            'niyam_pustak.edit',
            'niyam_pustak.delete',
            'rajshabha_rules.view',
            'rajshabha_rules.create',
            'rajshabha_rules.edit',
            'rajshabha_rules.delete',

            'vendors.view',
            'vendors.create',
            'vendors.edit',
            'vendors.delete',

            'home_page.view',
            'home_page.create',
            'home_page.edit',
            'home_page.delete',

            'profile.view',
            'profile.edit',

            'chatbot.view',
            'chatbot.create',
            'chatbot.edit',
            'chatbot.delete'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin'
            ]);
        }

        // Roles
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin'
        ]);

        $subAdminRole = Role::firstOrCreate([
            'name' => 'sub_admin',
            'guard_name' => 'admin'
        ]);

        // Assign permissions
        $adminRole->syncPermissions(Permission::all());

        $subAdminRole->syncPermissions([
            'dashboard.view'
        ]);
    }
}
