<!DOCTYPE html>
<html lang="en">
<head>
    <title>Detail Foto & Video</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="/dashboard">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="40"
                 height="40"
                 class="rounded-circle me-2">
            Dynagear
        </a>

        <a href="/wilayah/{{ $wilayah->id }}/foto-video" class="btn btn-light btn-sm">
            Kembali
        </a>

    </div>
</nav>

<div class="container mt-4">

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Detail Data</h4>
        </div>
        <div class="card-body">
    <p><strong>Nomor SO:</strong> {{ $post->nomor_so }}</p>
    <p><strong>Nama Barang:</strong> {{ $post->nama_barang }}</p>
    <p><strong>Tanggal:</strong> {{ $post->tanggal }}</p>
    <p><strong>Wilayah:</strong> {{ $wilayah->nama_wilayah }}</p>
    <p><strong>Deskripsi:</strong> {{ $post->description }}</p>

    <hr>

    <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/edit"
       class="btn btn-warning">
        Edit Data
    </a>

    <form action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
          method="POST"
          class="d-inline">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-danger"
                onclick="return confirm('Yakin hapus data ini?')">
            Hapus Data
        </button>

    </form>
</div>
    </div>

    <h4>Foto</h4>

    <div class="row mb-4">
        @forelse($post->files->where('type', 'foto') as $file)
            <div class="col-md-4 mb-3">
                <div class="card shadow">
                    <img src="{{ asset('storage/'.$file->file) }}"
                         class="card-img-top"
                         style="height:250px; object-fit:cover;">

                    <div class="card-body text-center">
                        <a href="{{ asset('storage/'.$file->file) }}"
                           target="_blank"
                           class="btn btn-info btn-sm">
                            Lihat Foto
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info">
                    Tidak ada foto.
                </div>
            </div>
        @endforelse
    </div>

    <h4>Video</h4>

    <div class="row">
        @forelse($post->files->where('type', 'video') as $file)
            <div class="col-md-6 mb-3">
                <div class="card shadow">

                    <div class="card-body">
                        <video width="100%" controls>
                            <source src="{{ asset('storage/'.$file->file) }}">
                            Browser tidak mendukung video.
                        </video>
                    </div>

                    <div class="card-footer text-center">
                        <a href="{{ asset('storage/'.$file->file) }}"
                           target="_blank"
                           class="btn btn-info btn-sm">
                            Buka Video
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="alert alert-info">
                    Tidak ada video.
                </div>
            </div>
        @endforelse
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>