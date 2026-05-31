<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data Foto & Video</title>
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
            <a href="/wilayah" class="btn btn-light btn-sm">
                Kembali ke Wilayah
            </a>
        </div>

    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2>Data Foto & Video</h2>
            <p class="text-muted mb-0">
                Wilayah :
                <strong>{{ $wilayah->nama_wilayah }}</strong>
            </p>
        </div>

        <a href="/wilayah/{{ $wilayah->id }}/foto-video/create"
           class="btn btn-success">
            + Tambah Data
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">

        <div class="card-body">

            <div class="table-responsive">
                <div class="row mb-3">

    <div class="col-md-6">

        <form method="GET">

            <div class="input-group">

                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Cari Nomor SO / Nama Barang..."
                       value="{{ request('search') }}">

                <button class="btn btn-primary">
                    Cari
                </button>

                <a href="/wilayah/{{ $wilayah->id }}/foto-video"
                   class="btn btn-secondary">
                    Reset
                </a>

            </div>

        </form>

    </div>

</div>

                <table class="table table-bordered table-striped">

                    <thead class="table-primary">

                        <tr>
                            <th>No</th>
                            <th>Nomor SO</th>
                            <th>Nama Barang</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Video</th>
                            <th width="250">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($posts as $post)

                            <tr>

                                <td>
    {{ ($posts->currentPage() - 1) * $posts->perPage() + $loop->iteration }}
</td>

                                <td>
                                    {{ $post->nomor_so }}
                                </td>

                                <td>
                                    {{ $post->nama_barang }}
                                </td>

                                <td>
                                    {{ $post->tanggal }}
                                </td>

                                <td>
                                    {{ $post->description }}
                                </td>

                                <td>
                                    {{ $post->files->where('type','foto')->count() }}
                                    Foto
                                </td>

                                <td>
                                    {{ $post->files->where('type','video')->count() }}
                                    Video
                                </td>

                                <td>

                                    <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
                                       class="btn btn-info btn-sm">
                                        Detail
                                    </a>

                                    <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}/edit"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin hapus data ini?')">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center">

                                    Belum ada data.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>
                <div class="mt-3">
    {{ $posts->withQueryString()->links() }}
</div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>