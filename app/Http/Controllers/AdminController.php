<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Inventory;
use App\Models\AppointmentType;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        // KPI COUNTS
        $userCount = User::count();
        $roles = Role::all();

        // Users per role
        $roleCounts = [];
        foreach ($roles as $role) {
            try {
                $roleCounts[$role->name] = $role->users()->count();
            } catch (\Throwable $e) {
                $roleCounts[$role->name] = 0;
            }
        }

        // Other stats
        $productCount = class_exists(Product::class) ? Product::count() : 0;
        $productCategoryCount = class_exists(ProductCategory::class) ? ProductCategory::count() : 0;
        $inventoryCount = class_exists(Inventory::class) ? Inventory::count() : 0;
        $appointmentTypeCount = class_exists(AppointmentType::class) ? AppointmentType::count() : 0;

        // Products per category (ECHTE DATA)
        $productPerCategory = ProductCategory::withCount('products')->get();

        return view('admin-dashboard.dashboard', compact(
            'userCount',
            'roles',
            'roleCounts',
            'productCount',
            'productCategoryCount',
            'inventoryCount',
            'appointmentTypeCount',
            'productPerCategory'
        ));
    }

    public function users()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin-dashboard.users', compact('users', 'roles'));
    }
    // Toggle role (assign if missing, remove if present) — AJAX endpoint
    public function toggleRole($id): \Illuminate\Http\JsonResponse
    {
        request()->validate([
            'role' => 'required|string',
        ]);

        $users = User::all();

        $user = $users->findOrFail($id);

        $roleName = request()->input('role');

        $role = Role::where('name', $roleName)->first();
        if (!$role) {
            return response()->json(['message' => 'Rol bestaat niet.'], 422);
        }

        if ($user->hasRole($roleName)) {
            $user->removeRole($roleName);
            $action = 'removed';
        } else {
            $user->assignRole($roleName);
            $action = 'assigned';
        }

        // Retourneer actuele rollenlijst van de user
        $currentRoles = $user->getRoleNames();


        return response()->json([
            'message' => "Role {$action}",
            'action' => $action,
            'roles' => $currentRoles,
            'user_id' => $user->id,
            'role' => $roleName,
        ]);
    }
}
