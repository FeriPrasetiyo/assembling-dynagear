<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Wilayah - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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
            padding: 20px;
            box-shadow: 0 4px 14px rgba(0,0,0,.06);
        }

        .wilayah-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #e8f1ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: auto;
            font-size: 42px;
            color: #0d6efd;
        }

        .form-control,
        .form-select {
            padding: 12px;
            border-radius: 12px;
            font-size: 16px;
        }

        .btn-mobile {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        @media(max-width:576px) {

            .action-row {
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 10px;
            }

        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

        <a class="navbar-brand d-flex align-items-center"
           href="/wilayah">

            <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                 width="42"
                 height="42"
                 class="rounded-circle me-2">

            Dynagear

        </a>

        <a href="/wilayah"
           class="btn btn-light btn-sm">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="page-box mb-4">

        <div class="text-center">

            <div class="wilayah-icon mb-3">
                <i class="bi bi-geo-alt-fill"></i>
            </div>

            <h2 class="fw-bold mb-1">
                Tambah Wilayah
            </h2>

            <p class="text-muted mb-0">
                Tambahkan wilayah baru untuk dokumentasi product
            </p>

        </div>

    </div>

    <div class="page-box">

        @if ($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terjadi Kesalahan:
                </strong>

                <hr>

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

                <label class="form-label fw-semibold">
                    User Pemilik Wilayah
                </label>

                <select name="user_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih User --
                    </option>

                    @foreach($users as $user)

                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>

                            {{ $user->name }} - {{ $user->email }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="mb-4">

                <label class="form-label fw-semibold">
                    Nama Wilayah
                </label>

                <input type="text"
                       name="nama_wilayah"
                       class="form-control"
                       placeholder="Contoh: Jakarta"
                       value="{{ old('nama_wilayah') }}"
                       required>

            </div>

            <div class="d-flex gap-2 action-row">

                <button type="submit"
                        class="btn btn-success btn-mobile">

                    <i class="bi bi-save-fill"></i>
                    Simpan Wilayah

                </button>

                <a href="/wilayah"
                   class="btn btn-secondary btn-mobile">

                    <i class="bi bi-x-circle"></i>
                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>