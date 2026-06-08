<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
            background:#f4f6f9;
        }

        .navbar-brand{
            font-weight:700;
        }

        .page-box{
            background:#ffffff;
            border-radius:16px;
            padding:20px;
            box-shadow:0 4px 14px rgba(0,0,0,.06);
        }

        .user-avatar{
            width:90px;
            height:90px;
            border-radius:50%;
            background:#e8f1ff;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            font-size:42px;
            color:#0d6efd;
        }

        .form-control,
        .form-select{
            padding:12px;
            border-radius:12px;
        }

        .btn-mobile{
            padding:12px;
            border-radius:12px;
            font-weight:600;
        }

        @media(max-width:576px){

            .action-row{
                display:grid !important;
                grid-template-columns:1fr;
                gap:10px;
            }

            .header-row{
                display:block !important;
            }

            .header-action{
                width:100%;
                margin-top:12px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow">
    <div class="container">

        <a href="/wilayah"
           class="navbar-brand d-flex align-items-center">

            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="42"
                 height="42"
                 class="rounded-circle me-2">

            Dynagear
        </a>

        <a href="/users"
           class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>

    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="page-box mb-4">

        <div class="text-center">

            <div class="user-avatar mb-3">
                <i class="bi bi-person-fill"></i>
            </div>

            <h2 class="fw-bold mb-1">
                Edit User
            </h2>

            <p class="text-muted mb-0">
                Perbarui informasi pengguna sistem
            </p>

        </div>

    </div>

    <div class="page-box">

        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terjadi Kesalahan:
                </strong>

                <hr>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach

            </div>

        @endif

        <form action="/users/{{ $user->id }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Nama Lengkap
                </label>

                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $user->name) }}"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Email
                </label>

                <input type="email"
                       name="email"
                       class="form-control"
                       value="{{ old('email', $user->email) }}"
                       required>

            </div>

            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Password Baru
                </label>

                <input type="password"
                       name="password"
                       class="form-control">

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti password.
                </small>

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Role
                </label>

                <select name="role"
                        class="form-select"
                        required>

                    <option value="user"
                        {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>

                    <option value="admin"
                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                </select>

            </div>

            <div class="d-flex gap-2 action-row">

                <button type="submit"
                        class="btn btn-warning btn-mobile">

                    <i class="bi bi-pencil-square"></i>
                    Update User

                </button>

                <a href="/users"
                   class="btn btn-secondary btn-mobile">

                    <i class="bi bi-x-circle"></i>
                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>