<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Pharmacy Management System</title>
    <link rel="stylesheet" href="{{ asset('css/pharmacy.css') }}">
    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear { display:none; }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { display:none; }
    </style>
</head>
<body>
<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-mark">
                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="44" height="44" rx="10" fill="#2d6a4f"/>
                    <rect x="18" y="8" width="8" height="28" rx="2" fill="white"/>
                    <rect x="8" y="18" width="28" height="8" rx="2" fill="white"/>
                </svg>
            </div>
            <h1>Pharmacy</h1>
            <p>Where every dose is managed with care.</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}"
                       placeholder="Enter your email"
                       autocomplete="off"
                       autofocus required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div style="position:relative;">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter your password"
                           id="login-password"
                           autocomplete="new-password"
                           required style="padding-right:40px;">
                    <button type="button" onclick="togglePw('login-password',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);padding:0;line-height:1;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary w-100" style="justify-content:center;padding:10px;">
                Sign In
            </button>
        </form>

        <div style="text-align:center;margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
            <span style="font-size:13px;color:var(--muted);">Don't have an account?</span>
            <a href="{{ route('register') }}" style="font-size:13px;color:var(--green);font-weight:600;margin-left:4px;text-decoration:none;">Create Account</a>
        </div>
    </div>
</div>
<script>
    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('svg').style.opacity = isHidden ? '0.4' : '1';
    }
</script>
</body>
</html>
