<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — Pharmacy Management System</title>
    <link rel="stylesheet" href="{{ asset('css/pharmacy.css') }}">
    <style>
        .role-radio-group { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; margin-bottom:16px; }
        .role-radio-btn { position:relative; }
        .role-radio-btn input[type=radio] { position:absolute; opacity:0; width:0; height:0; }
        .role-radio-btn label { display:block; padding:12px 8px; border:2px solid var(--border); border-radius:var(--radius); background:#fff; cursor:pointer; text-align:center; font-size:13px; font-weight:600; color:var(--navy); transition:all 0.15s; }
        .role-radio-btn input[type=radio]:checked + label { border-color:var(--green); background:var(--green-pale); color:var(--green-dark); }
        .role-radio-btn label:hover { border-color:var(--green); background:var(--green-pale); }
        input[type="password"]::-ms-reveal, input[type="password"]::-ms-clear { display:none; }
    </style>
</head>
<body>
<div class="login-page">
    <div class="login-card" style="max-width:480px;">
        <div class="login-logo">
            <div class="login-logo-mark">
                <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="44" height="44" rx="10" fill="#2d6a4f"/>
                    <rect x="18" y="8" width="8" height="28" rx="2" fill="white"/>
                    <rect x="8" y="18" width="28" height="8" rx="2" fill="white"/>
                </svg>
            </div>
            <h1>Pharmacy</h1>
            <p>Create your account</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Select Role <span style="color:var(--red)">*</span></label>
                <div class="role-radio-group">
                    <div class="role-radio-btn">
                        <input type="radio" name="role" id="role-customer" value="customer" {{ old('role','customer')==='customer'?'checked':'' }} onchange="updateEmailPreview()">
                        <label for="role-customer">Customer</label>
                    </div>
                    <div class="role-radio-btn">
                        <input type="radio" name="role" id="role-staff" value="staff" {{ old('role')==='staff'?'checked':'' }} onchange="updateEmailPreview()">
                        <label for="role-staff">Staff</label>
                    </div>
                    <div class="role-radio-btn">
                        <input type="radio" name="role" id="role-admin" value="admin" {{ old('role')==='admin'?'checked':'' }} onchange="updateEmailPreview()">
                        <label for="role-admin">Admin</label>
                    </div>
                </div>
                <div id="approval-notice" style="display:none;font-size:12px;color:var(--muted);background:#f4f6f9;border:1px solid var(--border);border-radius:var(--radius);padding:8px 12px;margin-top:-8px;margin-bottom:8px;"></div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">First Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="e.g. Maria" autofocus required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name <span style="color:var(--red)">*</span></label>
                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="e.g. Santos" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Username <span style="color:var(--red)">*</span></label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="e.g. mariasantos" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email Address <span style="color:var(--red)">*</span></label>
                <input type="email" name="base_email" id="base-email" class="form-control @error('base_email') is-invalid @enderror" value="{{ old('base_email') }}" placeholder="e.g. maria@gmail.com" oninput="updateEmailPreview()" required>
                @error('base_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div id="email-preview" style="font-size:12px;color:var(--muted);margin-top:4px;"></div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. 09171234567">
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="e.g. Makati City">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Password <span style="color:var(--red)">*</span></label>
                    <div style="position:relative;">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 6 characters" id="reg-password" autocomplete="new-password" required style="padding-right:40px;">
                        <button type="button" onclick="togglePw('reg-password',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);padding:0;line-height:1;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password <span style="color:var(--red)">*</span></label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" id="reg-password-confirm" autocomplete="new-password" required style="padding-right:40px;">
                        <button type="button" onclick="togglePw('reg-password-confirm',this)" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--muted);padding:0;line-height:1;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="justify-content:center;padding:10px;">
                Create Account
            </button>
        </form>

        <div style="text-align:center;margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
            <span style="font-size:13px;color:var(--muted);">Already have an account?</span>
            <a href="{{ route('login') }}" style="font-size:13px;color:var(--green);font-weight:600;margin-left:4px;text-decoration:none;">Sign In</a>
        </div>
    </div>
</div>
<script>
    function getSelectedRole() {
        const checked = document.querySelector('input[name=role]:checked');
        return checked ? checked.value : 'customer';
    }

    function updateEmailPreview() {
        const email = document.getElementById('base-email').value.trim();
        const role  = getSelectedRole();
        const preview = document.getElementById('email-preview');
        const notice  = document.getElementById('approval-notice');

        if (email && email.includes('@')) {
            const parts = email.split('@');
            preview.textContent = 'Your login email will be: ' + parts[0] + '.' + role + '@' + parts[1];
        } else {
            preview.textContent = '';
        }

        if (role === 'staff') {
            notice.textContent = 'Staff accounts require approval from an Admin before you can log in.';
            notice.style.display = 'block';
        } else if (role === 'admin') {
            notice.textContent = 'Admin accounts require approval from the Super Admin before you can log in.';
            notice.style.display = 'block';
        } else {
            notice.style.display = 'none';
        }
    }

    function togglePw(id, btn) {
        const input = document.getElementById(id);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('svg').style.opacity = isHidden ? '0.4' : '1';
    }

    updateEmailPreview();
</script>
</body>
</html>
