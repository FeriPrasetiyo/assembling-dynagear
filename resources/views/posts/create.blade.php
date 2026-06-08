<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Data Foto & Video</title>
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

        .form-control {
            padding: 12px;
            border-radius: 12px;
            font-size: 16px;
        }

        .btn-mobile {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
        }

        .upload-card {
            border: 1px dashed #ced4da;
            border-radius: 16px;
            padding: 16px;
            background: #fbfcff;
        }

        .upload-button {
            width: 100%;
            padding: 14px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 16px;
        }

        .selected-list {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 10px 12px;
        }

        @media (max-width: 576px) {
            .action-row {
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 10px;
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

    <div class="page-box mb-4">
        <h2 class="fw-bold mb-1">
            Tambah Data
        </h2>

        <p class="text-muted mb-0">
            Wilayah:
            <strong>{{ $wilayah->nama_wilayah }}</strong>
        </p>
    </div>

    <div class="page-box">

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form id="uploadForm"
              action="/wilayah/{{ $wilayah->id }}/foto-video"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor SO</label>
                <input type="text"
                       name="nomor_so"
                       class="form-control"
                       value="{{ old('nomor_so') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="{{ old('nama_barang') }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       class="form-control"
                       value="{{ old('tanggal', date('Y-m-d')) }}"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="description"
                          class="form-control"
                          rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="upload-card mb-3">
                <h5 class="fw-bold mb-3">
                    Foto
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Ambil Foto dari Kamera
                    </label>

                    <input type="file"
                           name="foto[]"
                           id="fotoCameraInput"
                           accept="image/*"
                           capture="environment"
                           hidden>

                    <button type="button"
                            class="btn btn-primary upload-button"
                            onclick="document.getElementById('fotoCameraInput').click()">
                        📷 Buka Kamera
                    </button>

                    <small class="text-muted d-block mt-2">
                        Ambil 1 foto langsung dari kamera HP.
                    </small>

                    <div id="fotoCameraList"
                         class="mt-2 small text-muted">
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold">
                        Pilih Banyak Foto dari Galeri
                    </label>

                    <input type="file"
                           name="foto[]"
                           id="fotoGalleryInput"
                           accept="image/*"
                           multiple
                           hidden>

                    <button type="button"
                            class="btn btn-success upload-button"
                            onclick="document.getElementById('fotoGalleryInput').click()">
                        🖼 Pilih Foto dari Galeri
                    </button>

                    <small class="text-muted d-block mt-2">
                        Pilih banyak foto sekaligus dari galeri HP.
                    </small>

                    <div id="fotoGalleryList"
                         class="mt-2 small text-muted">
                    </div>
                </div>
            </div>

            <div class="upload-card mb-4">
                <h5 class="fw-bold mb-3">
                    Video
                </h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Rekam Video dari Kamera
                    </label>

                    <input type="file"
                           name="video[]"
                           id="videoCameraInput"
                           accept="video/*"
                           capture="environment"
                           hidden>

                    <button type="button"
                            class="btn btn-danger upload-button"
                            onclick="document.getElementById('videoCameraInput').click()">
                        🎥 Rekam Video
                    </button>

                    <small class="text-muted d-block mt-2">
                        Rekam 1 video langsung dari kamera HP.
                    </small>

                    <div id="videoCameraList"
                         class="mt-2 small text-muted">
                    </div>
                </div>

                <div class="mb-0">
                    <label class="form-label fw-semibold">
                        Pilih Video dari Galeri
                    </label>

                    <input type="file"
                           name="video[]"
                           id="videoGalleryInput"
                           accept="video/*"
                           multiple
                           hidden>

                    <button type="button"
                            class="btn btn-dark upload-button"
                            onclick="document.getElementById('videoGalleryInput').click()">
                        📁 Pilih Video dari Galeri
                    </button>

                    <small class="text-muted d-block mt-2">
                        Pilih video dari galeri HP.
                    </small>

                    <div id="videoGalleryList"
                         class="mt-2 small text-muted">
                    </div>
                </div>
            </div>

            <div id="uploadBox" class="d-none mt-4">
                <div class="alert alert-info mb-2">
                    Sedang upload data, mohon tunggu. Jangan tutup halaman ini.
                </div>

                <div class="progress">
                    <div id="uploadProgress"
                         class="progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar"
                         style="width: 0%">
                        0%
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 action-row mt-4">
                <button type="submit"
                        id="submitBtn"
                        class="btn btn-success btn-mobile">
                    Simpan
                </button>

                <a href="/wilayah/{{ $wilayah->id }}/foto-video"
                   class="btn btn-secondary btn-mobile">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<script>
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const uploadBox = document.getElementById('uploadBox');
    const uploadProgress = document.getElementById('uploadProgress');

    const inputs = [
        ['fotoCameraInput', 'fotoCameraList', 'Foto kamera'],
        ['fotoGalleryInput', 'fotoGalleryList', 'Foto galeri'],
        ['videoCameraInput', 'videoCameraList', 'Video kamera'],
        ['videoGalleryInput', 'videoGalleryList', 'Video galeri'],
    ];

    function formatSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function showSelectedFiles(input, target, label) {
        target.innerHTML = '';

        if (!input.files || input.files.length === 0) {
            return;
        }

        let html = '<div class="selected-list">';
        html += '<strong>' + label + ' dipilih:</strong>';
        html += '<ul class="mb-0 mt-1">';

        Array.from(input.files).forEach(function (file) {
            html += '<li>' + file.name + ' (' + formatSize(file.size) + ')</li>';
        });

        html += '</ul>';
        html += '</div>';

        target.innerHTML = html;
    }

    inputs.forEach(function (item) {
        const input = document.getElementById(item[0]);
        const target = document.getElementById(item[1]);
        const label = item[2];

        input.addEventListener('change', function () {
            showSelectedFiles(input, target, label);
        });
    });

    form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerText = 'Mengupload...';

        uploadBox.classList.remove('d-none');

        let progress = 0;

        const interval = setInterval(function () {
            if (progress < 95) {
                progress += 5;
                uploadProgress.style.width = progress + '%';
                uploadProgress.innerText = progress + '%';
            } else {
                clearInterval(interval);
            }
        }, 400);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>