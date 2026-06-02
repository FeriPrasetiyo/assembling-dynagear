<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Wilayah - Dynagear</title>
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

        <a href="/wilayah" class="btn btn-light btn-sm">
            Kembali
        </a>

    </div>
</nav>

<div class="container mt-4">

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Wilayah</h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/wilayah" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">User Pemilik Wilayah</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">-- Pilih User --</option>

                        @foreach($users as $user)
                            <option value="{{ $user->id }}">
                                {{ $user->name }} - {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Wilayah</label>
                    <input type="text"
                           name="nama_wilayah"
                           class="form-control"
                           placeholder="Contoh: Jakarta"
                           value="{{ old('nama_wilayah') }}"
                           required>
                </div>

                <button type="submit" class="btn btn-success">
                    Simpan
                </button>

                <a href="/wilayah" class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>