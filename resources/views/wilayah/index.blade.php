<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dokumentasi product - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

        <a class="navbar-brand" href="/wilayah">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="40"
                 height="40"
                 class="rounded-circle me-2">

            Dynagear
        </a>

        <div class="ms-auto d-flex align-items-center">

            <span class="text-white me-3">
                Selamat Datang,
                <strong>{{ Auth::user()->name }}</strong>

                <span class="badge bg-warning text-dark ms-2">
                    {{ strtoupper(Auth::user()->role) }}
                </span>
            </span>

            @if(Auth::user()->role === 'admin')
                <a href="/users"
                   class="btn btn-light btn-sm me-2">
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

<!-- Content -->
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Dokumentasi Product</h2>

        @if(Auth::user()->role === 'admin')
            <a href="/wilayah/create"
               class="btn btn-success">
                + Tambah Wilayah
            </a>
        @endif

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

            <div class="col-md-4 mb-4">

                <div class="card shadow border-0 h-100">

                    <div class="card-body text-center">

                        <h4 class="fw-bold text-primary">
                            {{ $wilayah->nama_wilayah }}
                        </h4>

                        @if(Auth::user()->role === 'admin' && $wilayah->user)
                            <p class="text-muted mb-1">
                                User:
                                <strong>{{ $wilayah->user->name }}</strong>
                            </p>
                        @endif

                    </div>

                    <div class="card-footer bg-white border-0">

                        <div class="d-grid gap-2">

                            <a href="/wilayah/{{ $wilayah->id }}/foto-video"
                               class="btn btn-primary">
                                📷 Lihat Foto & Video
                            </a>

                            @if(Auth::user()->role === 'admin')

                                <form action="/wilayah/{{ $wilayah->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus wilayah ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger w-100">
                                        🗑 Hapus Wilayah
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-md-12">

                <div class="alert alert-info text-center">

                    Belum ada data wilayah.

                    @if(Auth::user()->role === 'admin')

                        <br><br>

                        <a href="/wilayah/create"
                           class="btn btn-success">
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