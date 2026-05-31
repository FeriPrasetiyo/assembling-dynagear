<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Data Foto & Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Tambah Data - {{ $wilayah->nama_wilayah }}</h4>
        </div>

        <div class="card-body">
            <form action="/wilayah/{{ $wilayah->id }}/foto-video"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label>Nomor SO</label>
                    <input type="text" name="nomor_so" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Foto</label>
                    <input type="file"
       name="foto[]"
       class="form-control"
       multiple>
                </div>

                <div class="mb-3">
                    <label>Video</label>
                    <input type="file"
       name="video[]"
       class="form-control"
       multiple>
                </div>

                <button type="submit" class="btn btn-success">
                    Simpan
                </button>

                <a href="/wilayah/{{ $wilayah->id }}/foto-video" class="btn btn-secondary">
                    Kembali
                </a>
            </form>
        </div>
    </div>

</div>

</body>
</html>