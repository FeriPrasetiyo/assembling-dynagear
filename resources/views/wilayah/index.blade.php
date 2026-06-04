<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dokumentasi Product - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .page-title {
            font-weight: 700;
        }

        .welcome-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        }

        .wilayah-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            transition: 0.2s;
        }

        .wilayah-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.12);
        }

        .wilayah-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: #e8f1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 12px;
        }

        .btn-mobile {
            padding: 12px;
            font-weight: 600;
            border-radius: 12px;
        }

        .role-badge {
            font-size: 12px;
        }

        @media (max-width: 576px) {
            .navbar .container {
                align-items: flex-start;
            }

            .navbar-actions {
                width: 100%;
                margin-top: 12px;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .navbar-actions .welcome-text {
                grid-column: 1 / -1;
                margin: 0 !important;
                font-size: 14px;
            }

            .navbar-actions a,
            .navbar-actions button {
                width: 100%;
            }

            .header-action {
                width: 100%;
                margin-top: 12px;
            }

            .header-row {
                display: block !important;
            }

            .wilayah-card {
                border-radius: 16px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="/wilayah">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="42"
                 height="42"
                 class="rounded-circle me-2">

            Dynagear
        </a>

        <div class="ms-auto d-flex align-items-center navbar-actions">

            <span class="text-white me-3 welcome-text">
                Selamat Datang,
                <strong>{{ Auth::user()->name }}</strong>

                <span class="badge bg-warning text-dark ms-1 role-badge">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
            </span>

            @if(Auth::user()->role === 'admin')
                <a href="/users"
                   class="btn btn-light btn-sm">
                    User
                </a>
            @endif

            <form action="/logout" method="POST">
                @csrf

                <button type="submit"
                        class="btn btn-danger btn-sm">
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="welcome-box mb-4">
        <div class="d-flex justify-content-between align-items-center header-row">

            <div>
                <h2 class="page-title mb-1">
                    Dokumentasi Product
                </h2>

                <p class="text-muted mb-0">
                    Kelola dokumentasi foto dan video berdasarkan wilayah.
                </p>
            </div>

            @if(Auth::user()->role === 'admin')
                <a href="/wilayah/create"
                   class="btn btn-success btn-mobile header-action">
                    + Tambah Wilayah
                </a>
            @endif

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

        @forelse($wilayahs as $wilayah)

            <div class="col-12 col-md-6 col-lg-4 mb-4">

                <div class="card wilayah-card shadow-sm h-100">

                    <div class="card-body text-center p-4">

                        <div class="wilayah-icon">
                            📍
                        </div>

                        <h4 class="fw-bold text-primary mb-2">
                            {{ $wilayah->nama_wilayah }}
                        </h4>

                        @if(Auth::user()->role === 'admin' && $wilayah->user)
                            <p class="text-muted mb-0">
                                User:
                                <strong>{{ $wilayah->user->name }}</strong>
                            </p>
                        @endif

                    </div>

                    <div class="card-footer bg-white border-0 p-3">

    <div class="d-grid gap-2">

        <a href="/wilayah/{{ $wilayah->id }}/foto-video"
           class="btn btn-primary btn-mobile">
            🖼️ Lihat Dokumentasi
        </a>

        @if(Auth::user()->role === 'admin')

            <a href="/wilayah/{{ $wilayah->id }}/foto-video/create"
               class="btn btn-success btn-mobile">
                📷 Tambah Data
            </a>

            <form action="/wilayah/{{ $wilayah->id }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus wilayah ini?')">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn btn-danger btn-mobile w-100">
                    🗑 Hapus Wilayah
                </button>

            </form>

        @endif

    </div>

</div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-info text-center p-4">

                    <h5 class="fw-bold">
                        Belum ada data wilayah.
                    </h5>

                    <p class="mb-0">
                        Silakan tambahkan wilayah terlebih dahulu.
                    </p>

                    @if(Auth::user()->role === 'admin')

                        <br>

                        <a href="/wilayah/create"
                           class="btn btn-success btn-mobile">
                            Tambah Wilayah Pertama
                        </a>

                    @endif

                </div>

            </div>

        @endforelse

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>