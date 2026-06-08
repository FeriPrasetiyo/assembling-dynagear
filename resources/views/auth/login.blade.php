<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd, #0b3d91);
        }

        .login-wrapper {
            min-height: calc(100vh - 72px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 12px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 18px;
            overflow: hidden;
        }

        .logo-login {
            width: 76px;
            height: 76px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .form-control {
            padding: 12px;
            font-size: 16px;
            border-radius: 10px;
        }

        .btn-login {
            padding: 12px;
            font-size: 17px;
            border-radius: 10px;
            font-weight: 600;
        }

        .navbar-brand {
            font-weight: 700;
        }

        @media (max-width: 576px) {
            .login-wrapper {
                align-items: flex-start;
                padding-top: 30px;
            }

            .card-body {
                padding: 24px 18px;
            }

            .login-card {
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-warning shadow">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 alt="Logo"
                 width="42"
                 height="42"
                 class="rounded-circle me-2">

            Dynagear
        </a>
    </div>
</nav>

<div class="login-wrapper">

    <div class="card login-card shadow-lg border-0">

        <div class="card-body text-center">

            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 alt="Logo Dynagear"
                 class="logo-login mb-3">

            <h3 class="fw-bold mb-1">
                Selamat Datang
            </h3>

            <p class="text-muted mb-4">
                Silakan login untuk masuk ke sistem
            </p>

            @if(session('success'))
                <div class="alert alert-success text-start">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger text-start">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/login" class="text-start">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Email
                    </label>

                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Masukkan email"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Password
                    </label>

                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Masukkan password"
                           required>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login">
                    Login
                </button>
            </form>

        </div>

        {{-- Jika register publik ingin disembunyikan, biarkan bagian ini dikomentari --}}
        {{--
        <div class="card-footer text-center bg-white">
            Belum punya akun?
            <a href="/register" class="fw-semibold">
                Register
            </a>
        </div>
        --}}

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>