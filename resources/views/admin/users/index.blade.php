@extends('layouts.app')
@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'Manage system users')

@section('sidebar-nav')
<div class="nav-section-title">Main</div>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
<div class="nav-section-title">Inventory</div>
<a href="{{ route('admin.medicines.index') }}">Medicines</a>
<div class="nav-section-title">Sales</div>
<a href="{{ route('admin.orders.index') }}">Orders</a>
<div class="nav-section-title">Management</div>
<a href="{{ route('admin.users.index') }}" class="active">Users</a>
@endsection

@section('content')

@if($pendingStaff->isNotEmpty())
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">Pending Staff Approvals</span>
        <span class="badge badge-warning">{{ $pendingStaff->count() }} pending</span>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>Name</th><th>Username</th><th>Email</th><th>Registered</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($pendingStaff as $user)
            <tr>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
                <td>
                    <div style="display:flex;gap:4px;">
                        <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.reject', $user) }}" onsubmit="return confirm('Reject and delete this account?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@if($pendingRemovals->isNotEmpty())
<div class="pharma-card" style="margin-bottom:20px;">
    <div class="pharma-card-header">
        <span class="pharma-card-title">My Pending Removal Requests</span>
        <span class="badge badge-warning">{{ $pendingRemovals->count() }} pending</span>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>User</th><th>Role</th><th>Reason</th><th>Submitted</th><th>Status</th></tr>
            </thead>
            <tbody>
            @foreach($pendingRemovals as $req)
            <tr>
                <td><strong>{{ $req->targetUser->name }}</strong></td>
                <td><span class="badge badge-info">{{ ucfirst($req->targetUser->role) }}</span></td>
                <td><small>{{ $req->reason ?? '—' }}</small></td>
                <td><small>{{ $req->created_at->format('M d, Y') }}</small></td>
                <td><span class="badge badge-warning">Awaiting Super Admin</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="pharma-card">
    <div class="pharma-card-header">
        <span class="pharma-card-title">All Users</span>
    </div>
    <div style="padding:12px 16px;border-bottom:1px solid var(--border);">
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:8px;">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email or username..." value="{{ request('search') }}" style="max-width:300px;">
            <select name="role" class="form-control" style="max-width:150px;">
                <option value="">All Roles</option>
                <option value="staff" {{ request('role')=='staff'?'selected':'' }}>Staff</option>
                <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Clear</a>
            @endif
        </form>
    </div>
    <div style="padding:0;">
        <table class="pharma-table">
            <thead>
                <tr><th>Name</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th>Phone</th><th>Joined</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:var(--green);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:12px;flex-shrink:0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        {{ $user->name }}
                    </div>
                </td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @php $rc = ['admin'=>'danger','staff'=>'info','customer'=>'success'][$user->role] ?? 'dark' @endphp
                    <span class="badge badge-{{ $rc }}">{{ ucfirst($user->role) }}</span>
                </td>
                <td>
                    @if($user->approved)
                        <span class="badge badge-success">Approved</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </td>
                <td>{{ $user->phone ?? '—' }}</td>
                <td><small>{{ $user->created_at->format('M d, Y') }}</small></td>
                <td>
                    @if($user->role === 'staff')
                        <button type="button" class="btn btn-danger btn-sm" onclick="openRemovalModal({{ $user->id }}, '{{ $user->name }}')">Remove</button>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div style="padding:14px 16px;">{{ $users->links() }}</div>
    </div>
</div>

{{-- Removal Request Modal --}}
<div id="removal-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:var(--radius);max-width:420px;width:90%;padding:24px;box-shadow:0 10px 40px rgba(0,0,0,0.2);">
        <div style="font-size:18px;font-weight:700;color:var(--navy);margin-bottom:4px;">Request User Removal</div>
        <div style="font-size:13px;color:var(--muted);margin-bottom:20px;" id="removal-subtitle"></div>
        <form method="POST" id="removal-form">
            @csrf
            <div class="form-group">
                <label class="form-label">Reason <span style="color:var(--red)">*</span></label>
                <textarea name="reason" class="form-control" rows="3" placeholder="Explain why this staff should be removed..." required></textarea>
            </div>
            <div style="display:flex;gap:10px;margin-top:6px;">
                <button type="button" class="btn btn-secondary" style="flex:1;justify-content:center;" onclick="document.getElementById('removal-modal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-danger" style="flex:1;justify-content:center;">Submit Request</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openRemovalModal(userId, name) {
        document.getElementById('removal-subtitle').textContent = 'You are requesting removal of: ' + name + '. This requires Super Admin approval.';
        document.getElementById('removal-form').action = '/admin/users/' + userId + '/request-removal';
        document.getElementById('removal-modal').style.display = 'flex';
    }
</script>
@endsection
