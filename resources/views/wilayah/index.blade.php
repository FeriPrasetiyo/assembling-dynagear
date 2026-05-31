<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Wilayah - Dynagear</title>
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
            </span>

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

        <h2>Data Wilayah</h2>

        <a href="/wilayah/create" class="btn btn-success">
            + Tambah Wilayah
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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

                        <p class="text-muted">
                            Kelola data foto dan video wilayah
                        </p>

                    </div>

                    <div class="card-footer bg-white border-0">

                        <div class="d-grid gap-2">

                            <a href="/wilayah/{{ $wilayah->id }}/foto-video"
                               class="btn btn-primary">
                                📷 Lihat Foto & Video
                            </a>

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

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-md-12">

                <div class="alert alert-info text-center">

                    Belum ada data wilayah.

                    <br><br>

                    <a href="/wilayah/create"
                       class="btn btn-success">
                        Tambah Wilayah Pertama
                    </a>

                </div>

            </div>

        @endforelse

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>