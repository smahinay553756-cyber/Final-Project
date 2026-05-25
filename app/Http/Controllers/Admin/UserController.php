<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserRemovalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $pendingStaff    = User::where('role', 'staff')->where('approved', false)->latest()->get();
        $pendingRemovals = UserRemovalRequest::with(['targetUser', 'requester'])->where('status', 'pending')->where('requested_by', Auth::id())->latest()->get();
        $query           = User::whereIn('role', ['admin', 'staff'])->latest();
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%");
            });
        }
        if ($request->role) {
            $query->where('role', $request->role);
        }
        $users = $query->paginate(10)->withQueryString();
        return view('admin.users.index', compact('pendingStaff', 'pendingRemovals', 'users'));
    }

    public function customers(Request $request)
    {
        $query = User::where('role', 'customer')->with(['orders'])->latest();
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('username', 'like', "%{$request->search}%");
            });
        }
        $customers = $query->paginate(15)->withQueryString();
        return view('admin.customers.index', compact('customers'));
    }

    public function approveStaff(User $user)
    {
        $user->update(['approved' => true]);
        return back()->with('success', $user->name . ' has been approved.');
    }

    public function rejectStaff(User $user)
    {
        $user->delete();
        return back()->with('success', 'Account rejected and removed.');
    }

    public function requestRemoval(Request $request, User $user)
    {
        if (!in_array($user->role, ['staff'])) {
            return back()->with('error', 'You can only request removal of staff accounts.');
        }

        if (UserRemovalRequest::where('target_user_id', $user->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'A removal request for this user is already pending.');
        }

        UserRemovalRequest::create([
            'target_user_id' => $user->id,
            'requested_by'   => Auth::id(),
            'reason'         => $request->reason,
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Removal request submitted. Waiting for Super Admin approval.');
    }
}
