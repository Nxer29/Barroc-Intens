<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the audit logs with search and filter functionality
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')
            ->latest('timestamp');

        // Search: user_id, action, entity, entity_id
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('entity', 'like', "%{$search}%")
                    ->orWhere('entity_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        // Filter by entity
        if ($request->filled('entity')) {
            $query->where('entity', $request->input('entity'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('timestamp', '>=', $request->input('date_from') . ' 00:00:00');
        }

        if ($request->filled('date_to')) {
            $query->where('timestamp', '<=', $request->input('date_to') . ' 23:59:59');
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Get unique actions and entities for filter dropdowns
        $actions = AuditLog::distinct('action')->pluck('action')->sort();
        $entities = AuditLog::distinct('entity')->pluck('entity')->sort();
        $users = User::orderBy('name')->get();

        // Paginate results
        $auditLogs = $query->paginate(50);

        return view('auditlogs.index', compact(
            'auditLogs',
            'actions',
            'entities',
            'users'
        ));
    }
}
