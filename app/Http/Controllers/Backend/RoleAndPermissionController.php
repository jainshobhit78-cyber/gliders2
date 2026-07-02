<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Hash;
use Spatie\Permission\Models\Permission;
class RoleAndPermissionController extends Controller
{
    public function index()
    {
        $user = auth()->guard('admin')->user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $subAdmins = Admin::role('sub_admin')->get();

        return view('backend.role.index', compact('subAdmins'));
    }

    public function create_sub_admin_page()
    {
        $user = auth()->guard('admin')->user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });

        return view('backend.role.create_sub_admin', compact('permissions'));
    }


    public function store_sub_admin(Request $request)
    {
        $user = auth()->guard('admin')->user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }


        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'permissions' => 'required|array|min:1',
        ], [
            'permissions.required' => 'Please select at least one permission.',
            'permissions.min' => 'At least one permission is required.',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $admin->assignRole('sub_admin');

        $admin->syncPermissions($request->permissions);

        return redirect()->route('admin.index')
            ->with('success', 'Sub Admin Created Successfully');
    }

    public function edit_sub_admin($id)
    {
        $user = auth()->guard('admin')->user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $admin = Admin::findOrFail($id);
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->name)[0];
        });
        $adminPermissions = $admin->getPermissionNames()->toArray();

        return view('backend.role.edit_sub_admin', compact('admin', 'permissions', 'adminPermissions'));
    }

    public function update_sub_admin(Request $request, $id)
    {
        $user = auth()->guard('admin')->user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|min:6',
            'permissions' => 'required|array|min:1',
        ]);

        $admin = Admin::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        $admin->syncPermissions($request->permissions);

        return redirect()->route('admin.index')
            ->with('success', 'Sub Admin Updated Successfully');
    }

    public function delete_sub_admin($id)
    {
        $user = auth()->guard('admin')->user();

        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $admin = Admin::findOrFail($id);

        if ($admin->hasRole('admin')) {
            return back()->with('error', 'Main Admin cannot be deleted');
        }

        $admin->roles()->detach();
        $admin->permissions()->detach();

        $admin->delete();

        return back()->with('success', 'Sub Admin Deleted Successfully');
    }
}
