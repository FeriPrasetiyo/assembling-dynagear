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

        <a class="navbar-brand" href="/wilayah">
            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="40"
                 height="40"
                 class="rounded-circle me-2">
            Dynagear
        </a>

        <div>
            <a href="/wilayah/{{ $wilayah->id }}/foto-video"
               class="btn btn-light btn-sm">
                Kembali
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4 mb-5">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Detail Data</h4>

            @if(auth()->user()->role === 'admin')
                <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/edit"
                   class="btn btn-warning btn-sm">
                    Edit Data
                </a>
            @endif
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th width="200">Wilayah</th>
                    <td>{{ $wilayah->nama_wilayah }}</td>
                </tr>

                <tr>
                    <th>Nomor SO</th>
                    <td>{{ $post->nomor_so }}</td>
                </tr>

                <tr>
                    <th>Nama Barang</th>
                    <td>{{ $post->nama_barang }}</td>
                </tr>

                <tr>
                    <th>Tanggal</th>
                    <td>{{ $post->tanggal }}</td>
                </tr>

                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $post->description ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Foto</h5>
        </div>

        <div class="card-body">

            <div class="row">

                @forelse($post->files->where('type','foto') as $file)

                    <div class="col-md-4 mb-4">
                        <div class="card h-100">

                            <a href="{{ asset('storage/'.$file->file) }}" target="_blank">
                                <img src="{{ asset('storage/'.$file->file) }}"
                                     class="card-img-top"
                                     style="height:260px; object-fit:cover;">
                            </a>

                            @if(auth()->user()->role === 'admin')
                                <div class="card-body">
                                    <form action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/file/{{ $file->id }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus foto ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm w-100">
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
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Video</h5>
        </div>

        <div class="card-body">

            <div class="row">

                @forelse($post->files->where('type','video') as $file)

                    <div class="col-md-6 mb-4">
                        <div class="card h-100">

                            <div class="card-body">

                                <video width="100%" controls>
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
                                                class="btn btn-danger btn-sm w-100">
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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>