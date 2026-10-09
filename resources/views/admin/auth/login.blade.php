<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Akses Terenkripsi | {{ $siteSettings['site_name'] ?? 'Manunggaland' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 50% 30%, #152E5E 0%, #0B1B3D 60%, #061124 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: #FFFFFF;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            padding: 2.75rem 2.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2.25rem;
        }
        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(212, 175, 55, 0.15);
            border: 1px solid rgba(212, 175, 55, 0.35);
            color: #F8E7A2;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 1.25rem;
        }
        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.02em;
        }
        .login-header h1 span {
            color: #D4AF37;
        }
        .login-header p {
            color: #94A3B8;
            font-size: 0.825rem;
            margin-top: 0.35rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #CBD5E1;
            margin-bottom: 0.4rem;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748B;
        }
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.75rem;
            background: rgba(11, 27, 61, 0.7);
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #FFFFFF;
            font-family: inherit;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
            background: rgba(11, 27, 61, 0.9);
        }
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #F8E7A2 0%, #D4AF37 50%, #A67C1E 100%);
            color: #061124;
            font-weight: 800;
            font-size: 0.95rem;
            padding: 0.85rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.3);
            transition: all 0.2s;
            margin-top: 1rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.45);
        }
        .error-alert {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.5);
            color: #FECACA;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-size: 0.8125rem;
            margin-bottom: 1.25rem;
        }
        .security-notice {
            margin-top: 1.75rem;
            text-align: center;
            font-size: 0.75rem;
            color: #64748B;
            line-height: 1.4;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="security-badge">
                <i class="fa-solid fa-lock text-gold"></i>
                <span>ENCRYPTED PORTAL ACCESS</span>
            </div>
            <h1>MANUNGGA<span>LAND</span></h1>
            <p>Sistem Manajemen Agregator & Ekspor Nusantara</p>
        </div>

        @if($errors->any())
            <div class="error-alert">
                <i class="fa-solid fa-circle-exclamation" style="margin-right: 0.35rem;"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Administrator</label>
                <div class="input-wrap">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" name="email" id="email" required autofocus class="form-input" value="{{ old('email', '') }}" placeholder="admin@domain.com">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <div class="input-wrap">
                    <i class="fa-solid fa-key"></i>
                    <input type="password" name="password" id="password" required class="form-input" placeholder="••••••••••••">
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem; font-size: 0.8125rem; color: #CBD5E1;">
                <label style="display: flex; align-items: center; gap: 0.4rem; cursor: pointer;">
                    <input type="checkbox" name="remember" value="1">
                    <span>Ingat Saya</span>
                </label>
                <span style="color: #94A3B8;">Protected by RateLimiter</span>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-shield-check" style="margin-right: 0.4rem;"></i>
                <span>Masuk ke Dashboard</span>
            </button>
        </form>

        <div class="security-notice">
            Akses ke halaman ini dipantau secara ketat. Percobaan login dibatasi maksimal 5 kali per menit untuk mencegah serangan brute-force.
        </div>
    </div>

</body>
</html>
