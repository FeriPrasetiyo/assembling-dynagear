<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Foto & Video</title>
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

        .page-box {
            background: #ffffff;
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
        }

        .data-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
        }

        .btn-mobile {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .search-input {
            padding: 12px;
            border-radius: 12px;
        }

        .badge-media {
            font-size: 14px;
            padding: 8px 12px;
        }

        @media (max-width: 576px) {
            .header-row {
                display: block !important;
            }

            .header-action {
                width: 100%;
                margin-top: 14px;
            }

            .search-actions {
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .search-actions .btn {
                width: 100%;
                padding: 11px;
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

        <a href="/wilayah" class="btn btn-light btn-sm">
            Kembali
        </a>

    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="page-box mb-4">

        <div class="d-flex justify-content-between align-items-center header-row">

            <div>
                <h2 class="fw-bold mb-1">
                    Data Foto & Video
                </h2>

                <p class="text-muted mb-0">
                    Wilayah:
                    <strong>{{ $wilayah->nama_wilayah }}</strong>
                </p>
            </div>

            @if(auth()->user()->role === 'admin')
                <a href="/wilayah/{{ $wilayah->id }}/foto-video/create"
                   class="btn btn-success btn-mobile header-action">
                    + Tambah Data
                </a>
            @endif

        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="page-box mb-4">

        <form method="GET">

            <label class="form-label fw-semibold">
                Cari Data
            </label>

            <input type="text"
                   name="search"
                   class="form-control search-input mb-3"
                   placeholder="Cari Nomor SO / Nama Barang / Deskripsi..."
                   value="{{ request('search') }}">

            <div class="d-flex gap-2 search-actions">
                <button class="btn btn-primary btn-mobile">
                    Cari
                </button>

                <a href="/wilayah/{{ $wilayah->id }}/foto-video"
                   class="btn btn-secondary btn-mobile">
                    Reset
                </a>
            </div>

        </form>

    </div>

    <div class="row">

        @forelse($posts as $post)

            <div class="col-12 col-md-6 col-lg-4 mb-4">

                <div class="card data-card shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div>
                                <h5 class="fw-bold text-primary mb-1">
                                    {{ $post->nama_barang }}
                                </h5>

                                <div class="text-muted small">
                                    SO: <strong>{{ $post->nomor_so }}</strong>
                                </div>
                            </div>

                            <span class="badge bg-primary">
                                #{{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
                            </span>

                        </div>

                        <div class="mb-2">
                            <span class="text-muted small">
                                Tanggal
                            </span>
                            <div class="fw-semibold">
                                {{ $post->tanggal }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="text-muted small">
                                Deskripsi
                            </span>
                            <div>
                                {{ $post->description ?: '-' }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <span class="badge bg-success badge-media me-2">
                                📷 {{ $post->files->where('type','foto')->count() }} Foto
                            </span>

                            <span class="badge bg-dark badge-media">
                                🎥 {{ $post->files->where('type','video')->count() }} Video
                            </span>
                        </div>

                        <div class="d-grid gap-2">

                            <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
                               class="btn btn-primary btn-mobile">
                                Detail
                            </a>

                            @if(auth()->user()->role === 'admin')

                                <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/edit"
                                   class="btn btn-warning btn-mobile">
                                    Edit
                                </a>

                                <form action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus data ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-mobile w-100">
                                        Hapus
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
                        Belum ada data.
                    </h5>

                    <p class="mb-0">
                        Data foto dan video belum tersedia.
                    </p>
                </div>

            </div>

        @endforelse

    </div>

    <div class="mt-3">
        {{ $posts->withQueryString()->links() }}
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>