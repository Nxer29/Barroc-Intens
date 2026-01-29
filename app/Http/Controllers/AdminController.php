<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // Dashboard met site-statistieken
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $userCount = class_exists(\App\Models\User::class) ? \App\Models\User::count() : 0;
        $roles = Role::all();
        $roleCounts = [];
        foreach ($roles as $role) {
            // sommige setups hebben relation 'users'
            try {
                $count = $role->users()->count();
            } catch (\Throwable $e) {
                $count = 0;
            }
            $roleCounts[$role->name] = $count;
        }

        // Voorbeelden van andere modelstatistieken (veilig checken of model bestaat)
        $productCount = class_exists(\App\Models\Product::class) ? \App\Models\Product::count() : 0;
        $productCategoryCount = class_exists(\App\Models\ProductCategory::class) ? \App\Models\ProductCategory::count() : 0;
        $inventoryCount = class_exists(\App\Models\Inventory::class) ? \App\Models\Inventory::count() : 0;
        $appointmentTypeCount = class_exists(\App\Models\AppointmentType::class) ? \App\Models\AppointmentType::count() : 0;

        return view('admin-dashboard.dashboard', compact(
            'userCount',
            'roles',
            'roleCounts',
            'productCount',
            'productCategoryCount',
            'inventoryCount',
            'appointmentTypeCount'
        ));
    }

    // Pagina met alle gebruikers en rollen
    public function users(): \lluminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('Admin-Dashboard.users', compact('users', 'roles'));
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
