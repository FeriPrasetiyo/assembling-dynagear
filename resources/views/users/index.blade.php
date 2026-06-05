<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data User - Dynagear</title>
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
            background:#fff;
            border-radius:16px;
            padding:18px;
            box-shadow:0 4px 14px rgba(0,0,0,.06);
        }

        .user-card{
            border:none;
            border-radius:18px;
            overflow:hidden;
            transition:.2s;
        }

        .user-card:hover{
            transform:translateY(-3px);
            box-shadow:0 8px 20px rgba(0,0,0,.12);
        }

        .user-icon{
            width:70px;
            height:70px;
            border-radius:50%;
            background:#e8f1ff;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:32px;
            margin:auto;
        }

        .btn-mobile{
            padding:12px;
            border-radius:12px;
            font-weight:600;
        }

        @media(max-width:576px){

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

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

        <a href="/wilayah"
           class="navbar-brand d-flex align-items-center">

            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="42"
                 height="42"
                 class="rounded-circle me-2">

            Dynagear
        </a>

        <a href="/wilayah"
           class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>

    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="page-box mb-4">

        <div class="d-flex justify-content-between align-items-center header-row">

            <div>

                <h2 class="fw-bold mb-1">
                    Data User
                </h2>

                <p class="text-muted mb-0">
                    Kelola pengguna sistem Dokumentasi Product Dynagear
                </p>

            </div>

            <a href="/users/create"
               class="btn btn-success btn-mobile header-action">

                <i class="bi bi-person-plus-fill"></i>
                Tambah User

            </a>

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">

        @forelse($users as $user)

            <div class="col-12 col-md-6 col-lg-4 mb-4">

                <div class="card user-card shadow-sm h-100">

                    <div class="card-body text-center p-4">

                        <div class="user-icon mb-3">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <h5 class="fw-bold">
                            {{ $user->name }}
                        </h5>

                        <p class="text-muted mb-2">
                            {{ $user->email }}
                        </p>

                        @if($user->role == 'admin')

                            <span class="badge bg-danger">
                                ADMIN
                            </span>

                        @else

                            <span class="badge bg-primary">
                                USER
                            </span>

                        @endif

                    </div>

                    <div class="card-footer bg-white border-0 p-3">

                        <div class="d-grid gap-2">

                            <a href="/users/{{ $user->id }}/edit"
                               class="btn btn-warning btn-mobile">

                                <i class="bi bi-pencil-square"></i>
                                Edit User

                            </a>

                            <form action="/users/{{ $user->id }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus user ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-mobile w-100">

                                    <i class="bi bi-trash3-fill"></i>
                                    Hapus User

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info text-center p-4">

                    <h5 class="fw-bold">
                        Belum ada user.
                    </h5>

                    <p class="mb-3">
                        Silakan tambahkan user terlebih dahulu.
                    </p>

                    <a href="/users/create"
                       class="btn btn-success">

                        <i class="bi bi-person-plus-fill"></i>
                        Tambah User Pertama

                    </a>

                </div>

            </div>

        @endforelse

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>