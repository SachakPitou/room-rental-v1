<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Room Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * { box-sizing:border-box; margin:0; padding:0; }
        body {
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-wrap { width:100%; max-width:400px; }

        .brand { text-align:center; margin-bottom:28px; }
        .brand-icon {
            width:64px; height:64px;
            background:#1e293b;
            border-radius:18px;
            display:flex; align-items:center; justify-content:center;
            font-size:30px;
            margin:0 auto 14px;
            border:1px solid rgba(255,255,255,.1);
        }
        .brand-name  { font-size:21px; font-weight:700; color:#f1f5f9; letter-spacing:-.3px; }
        .brand-sub   { font-size:11px; color:#475569; margin-top:3px; text-transform:uppercase; letter-spacing:.1em; }

        .card {
            background:#1e293b;
            border-radius:18px;
            padding:30px;
            border:1px solid rgba(255,255,255,.07);
        }
        .form-label {
            font-size:11px; font-weight:600;
            color:#64748b;
            text-transform:uppercase; letter-spacing:.07em;
            margin-bottom:6px;
        }
        .form-control {
            background:#0f172a;
            border:1px solid rgba(255,255,255,.09);
            color:#f1f5f9;
            border-radius:10px;
            padding:11px 14px;
            font-size:14px;
            transition:border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            background:#0f172a;
            border-color:#3b82f6;
            color:#f1f5f9;
            box-shadow:0 0 0 3px rgba(59,130,246,.15);
        }
        .form-control::placeholder { color:#1e3a5f; }
        .form-control.is-invalid   { border-color:#ef4444; }

        .input-group .form-control  { border-radius:10px 0 0 10px !important; }
        .input-group-text {
            background:#0f172a;
            border:1px solid rgba(255,255,255,.09);
            border-left:none;
            color:#475569;
            border-radius:0 10px 10px 0;
            cursor:pointer;
            transition:color .15s;
            padding:0 14px;
        }
        .input-group-text:hover { color:#94a3b8; }

        .form-check-input {
            background-color:#0f172a;
            border-color:rgba(255,255,255,.2);
        }
        .form-check-label { color:#475569; font-size:13px; }

        .btn-login {
            width:100%; padding:13px;
            background:#3b82f6; border:none;
            border-radius:11px;
            font-size:14px; font-weight:600; color:white;
            transition:background .2s, transform .1s;
            margin-top:6px;
        }
        .btn-login:hover  { background:#2563eb; color:white; }
        .btn-login:active { transform:scale(.98); }

        .error-box {
            background:rgba(239,68,68,.1);
            border:1px solid rgba(239,68,68,.25);
            color:#fca5a5;
            border-radius:10px;
            padding:10px 14px;
            font-size:13px;
            margin-bottom:18px;
        }
        .footer-note {
            text-align:center;
            margin-top:20px;
            font-size:11px;
            color:#1e3a5f;
        }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="brand">
        <div class="brand-icon">🏠</div>
        <div class="brand-name">Room Rental</div>
        <div class="brand-sub">Management System</div>
    </div>

    <div class="card">

        @if($errors->any())
        <div class="error-box">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
        @endif

        @if(session('status'))
        <div class="error-box" style="background:rgba(22,163,74,.1);border-color:rgba(22,163,74,.25);color:#86efac">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="admin@roomrental.com"
                   required autofocus autocomplete="email">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password"
                       id="passwordInput"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="••••••••"
                       required autocomplete="current-password">
                <span class="input-group-text" onclick="togglePwd()">
                    <i class="bi bi-eye" id="eyeIcon"></i>
                </span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox"
                       name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
        </button>

        </form>
    </div>

    <div class="footer-note">
        <i class="bi bi-shield-lock me-1"></i>Authorized access only
    </div>

</div>

<script>
function togglePwd() {
    const el   = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (el.type === 'password') {
        el.type       = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        el.type       = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>