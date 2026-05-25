<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pharmacy') — Pharmacy Management System</title>
    <link rel="stylesheet" href="/css/pharmacy.css">
</head>
<body>
<div class="pharma-wrapper">
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>
    <aside class="pharma-sidebar" id="pharma-sidebar">
        <div class="sidebar-brand">
            <a href="#" class="brand-logo">
                <div class="sidebar-logo-mark">
                    <svg width="32" height="32" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="44" height="44" rx="10" fill="#40916c"/>
                        <rect x="18" y="8" width="8" height="28" rx="2" fill="white"/>
                        <rect x="8" y="18" width="28" height="8" rx="2" fill="white"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-name">Pharmacy</div>
                    <div class="brand-sub">Management System</div>
                </div>
            </a>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar-nav')
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Sign Out</button>
            </form>
        </div>
    </aside>

    <div class="pharma-main">
        <header class="pharma-topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="mobile-menu-btn" onclick="openSidebar()">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <div>
                    <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                    <div class="topbar-subtitle">@yield('page-subtitle', 'PharmaCare Management System')</div>
                </div>
            </div>
            <div class="topbar-actions">
                @yield('topbar-actions')
            </div>
        </header>

        <main class="pharma-content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0;padding-left:16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
    @yield('scripts')
<script>
function openSidebar() {
    document.getElementById('pharma-sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('open');
}
function closeSidebar() {
    document.getElementById('pharma-sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('open');
}
</script>
</body>
</html>
