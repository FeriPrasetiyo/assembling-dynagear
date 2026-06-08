<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detail Foto & Video</title>
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

        .media-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
        }

        .media-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
        }

        .btn-mobile {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .info-label {
            font-size: 13px;
            color: #6c757d;
        }

        .info-value {
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .header-row {
                display: block !important;
            }

            .header-action {
                width: 100%;
                margin-top: 12px;
            }

            .media-img {
                height: 230px;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center" href="/wilayah">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="42"
                 height="42"
                 class="rounded-circle me-2">

            Dynagear
        </a>

        <a href="/wilayah/{{ $wilayah->id }}/foto-video"
           class="btn btn-light btn-sm">
            Kembali
        </a>

    </div>
</nav>

<div class="container mt-4 mb-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="page-box mb-4">

        <div class="d-flex justify-content-between align-items-center header-row">

            <div>
                <h2 class="fw-bold mb-1">
                    Detail Data
                </h2>

                <p class="text-muted mb-0">
                    Wilayah:
                    <strong>{{ $wilayah->nama_wilayah }}</strong>
                </p>
            </div>

            @if(auth()->user()->role === 'admin')
                <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/edit"
                   class="btn btn-warning btn-mobile header-action">
                    Edit Data
                </a>
            @endif

        </div>

    </div>

    <div class="page-box mb-4">

        <div class="row">

            <div class="col-12 col-md-6 mb-3">
                <div class="info-label">Nomor SO</div>
                <div class="info-value">{{ $post->nomor_so }}</div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <div class="info-label">Nama Barang</div>
                <div class="info-value">{{ $post->nama_barang }}</div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ $post->tanggal }}</div>
            </div>

            <div class="col-12 mb-3">
                <div class="info-label">Deskripsi</div>
                <div class="info-value">{{ $post->description ?? '-' }}</div>
            </div>

        </div>

        <div class="d-flex gap-2 flex-wrap mt-2">
            <span class="badge bg-success p-2">
                📷 {{ $post->files->where('type','foto')->count() }} Foto
            </span>

            <span class="badge bg-dark p-2">
                🎥 {{ $post->files->where('type','video')->count() }} Video
            </span>
        </div>

    </div>

    <div class="page-box mb-4">

        <h5 class="fw-bold mb-3">
            Foto
        </h5>

        <div class="row">

            @forelse($post->files->where('type','foto') as $file)

                <div class="col-12 col-md-6 col-lg-4 mb-4">

                    <div class="card media-card shadow-sm h-100">

                        <a href="{{ asset('storage/'.$file->file) }}" target="_blank">
                            <img src="{{ asset('storage/'.$file->file) }}"
                                 class="media-img"
                                 alt="Foto dokumentasi">
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <div class="card-body">

                                <form action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/file/{{ $file->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-mobile w-100">
                                        Hapus Foto
                                    </button>
                                </form>

                            </div>
                        @endif

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada foto.
                    </div>
                </div>

            @endforelse

        </div>

    </div>

    <div class="page-box mb-4">

        <h5 class="fw-bold mb-3">
            Video
        </h5>

        <div class="row">

            @forelse($post->files->where('type','video') as $file)

                <div class="col-12 col-md-6 mb-4">

                    <div class="card media-card shadow-sm h-100">

                        <div class="card-body">

                            <video width="100%" controls style="border-radius: 14px;">
                                <source src="{{ asset('storage/'.$file->file) }}">
                                Browser tidak mendukung video.
                            </video>

                            @if(auth()->user()->role === 'admin')
                                <form action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/file/{{ $file->id }}"
                                      method="POST"
                                      class="mt-3"
                                      onsubmit="return confirm('Yakin hapus video ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-mobile w-100">
                                        Hapus Video
                                    </button>
                                </form>
                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada video.
                    </div>
                </div>

            @endforelse

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>