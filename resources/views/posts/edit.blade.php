<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Data Foto & Video</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6f9; }
        .navbar-brand { font-weight: 700; }
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
        .media-card {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
        }
        .media-img {
            height: 200px;
            object-fit: cover;
        }
        @media (max-width: 576px) {
            .action-row {
                display: grid !important;
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .media-img {
                height: 230px;
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

        <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
           class="btn btn-light btn-sm">
            Kembali
        </a>
    </div>
</nav>

<div class="container mt-4 mb-5">

    <div class="page-box mb-4">
        <h2 class="fw-bold mb-1">
            Edit Data
        </h2>

        <p class="text-muted mb-0">
            {{ $post->nama_barang }}
        </p>
    </div>

    <div class="page-box">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="uploadForm"
              action="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor SO</label>
                <input type="text"
                       name="nomor_so"
                       class="form-control"
                       value="{{ old('nomor_so', $post->nomor_so) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       class="form-control"
                       value="{{ old('nama_barang', $post->nama_barang) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date"
                       name="tanggal"
                       class="form-control"
                       value="{{ old('tanggal', $post->tanggal) }}"
                       required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="description"
                          class="form-control"
                          rows="4">{{ old('description', $post->description) }}</textarea>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Foto Saat Ini</h5>

            <div class="row mb-3">

                @forelse($post->files->where('type','foto') as $file)

                    <div class="col-12 col-md-4 mb-3">
                        <div class="card media-card shadow-sm h-100">

                            <img src="{{ asset('storage/'.$file->file) }}"
                                 class="card-img-top media-img">

                            <div class="card-body">

                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="hapus_file[]"
                                           value="{{ $file->id }}"
                                           id="foto{{ $file->id }}">

                                    <label class="form-check-label"
                                           for="foto{{ $file->id }}">
                                        Hapus Foto Ini
                                    </label>
                                </div>

                            </div>

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

            <div class="upload-card mb-4">
                <h5 class="fw-bold mb-3">Tambah Foto Baru</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Ambil Foto dari Kamera</label>
                    <input type="file"
                           name="foto[]"
                           id="fotoCameraInput"
                           class="form-control"
                           accept="image/*"
                           capture="environment">

                    <small class="text-muted">
                        Ambil 1 foto langsung dari kamera HP.
                    </small>

                    <div id="fotoCameraList" class="mt-2 small text-muted"></div>
                </div>

                <div>
                    <label class="form-label fw-semibold">Pilih Banyak Foto dari Galeri</label>
                    <input type="file"
                           name="foto[]"
                           id="fotoGalleryInput"
                           class="form-control"
                           accept="image/*"
                           multiple>

                    <small class="text-muted">
                        Pilih banyak foto sekaligus dari galeri HP.
                    </small>

                    <div id="fotoGalleryList" class="mt-2 small text-muted"></div>
                </div>
            </div>

            <hr>

            <h5 class="fw-bold mb-3">Video Saat Ini</h5>

            <div class="row mb-3">

                @forelse($post->files->where('type','video') as $file)

                    <div class="col-12 col-md-6 mb-3">
                        <div class="card media-card shadow-sm h-100">
                            <div class="card-body">

                                <video width="100%" controls style="border-radius: 14px;">
                                    <source src="{{ asset('storage/'.$file->file) }}">
                                    Browser tidak mendukung video.
                                </video>

                                <div class="form-check mt-3">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="hapus_file[]"
                                           value="{{ $file->id }}"
                                           id="video{{ $file->id }}">

                                    <label class="form-check-label"
                                           for="video{{ $file->id }}">
                                        Hapus Video Ini
                                    </label>
                                </div>

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

            <div class="upload-card mb-4">
                <h5 class="fw-bold mb-3">Tambah Video Baru</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Rekam Video dari Kamera</label>
                    <input type="file"
                           name="video[]"
                           id="videoCameraInput"
                           class="form-control"
                           accept="video/*"
                           capture="environment">

                    <small class="text-muted">
                        Rekam 1 video langsung dari kamera HP.
                    </small>

                    <div id="videoCameraList" class="mt-2 small text-muted"></div>
                </div>

                <div>
                    <label class="form-label fw-semibold">Pilih Video dari Galeri</label>
                    <input type="file"
                           name="video[]"
                           id="videoGalleryInput"
                           class="form-control"
                           accept="video/*"
                           multiple>

                    <small class="text-muted">
                        Pilih video dari galeri HP.
                    </small>

                    <div id="videoGalleryList" class="mt-2 small text-muted"></div>
                </div>
            </div>

            <div class="alert alert-warning">
                Centang foto/video yang ingin dihapus, lalu klik <strong>Update Data</strong>.
            </div>

            <div id="uploadBox" class="d-none mt-4">
                <div class="alert alert-info mb-2">
                    Sedang mengupdate data, mohon tunggu. Jangan tutup halaman ini.
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
                    Update Data
                </button>

                <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
                   class="btn btn-secondary btn-mobile">
                    Batal
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

        if (!input.files || input.files.length === 0) return;

        let html = '<strong>' + label + ' dipilih:</strong><ul class="mb-0">';

        Array.from(input.files).forEach(function (file) {
            html += '<li>' + file.name + ' (' + formatSize(file.size) + ')</li>';
        });

        html += '</ul>';
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
        submitBtn.innerText = 'Mengupdate...';

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