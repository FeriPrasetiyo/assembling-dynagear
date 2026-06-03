<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tambah Data Foto & Video</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Data - {{ $wilayah->nama_wilayah }}</h4>
        </div>

        <div class="card-body">

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
                    <label class="form-label">Nomor SO</label>
                    <input type="text"
                           name="nomor_so"
                           class="form-control"
                           value="{{ old('nomor_so') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3">{{ old('description') }}</textarea>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label fw-bold">Ambil Foto dari Kamera</label>

                    <input type="file"
                           name="foto[]"
                           id="fotoCameraInput"
                           class="form-control"
                           accept="image/*"
                           capture="environment">

                    <small class="text-muted">
                        Untuk mengambil 1 foto langsung dari kamera HP.
                    </small>

                    <div id="fotoCameraList" class="mt-2 small text-muted"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Banyak Foto dari Galeri</label>

                    <input type="file"
                           name="foto[]"
                           id="fotoGalleryInput"
                           class="form-control"
                           accept="image/*"
                           multiple>

                    <small class="text-muted">
                        Untuk memilih banyak foto sekaligus dari galeri HP.
                    </small>

                    <div id="fotoGalleryList" class="mt-2 small text-muted"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Rekam Video dari Kamera</label>

                    <input type="file"
                           name="video[]"
                           id="videoCameraInput"
                           class="form-control"
                           accept="video/*"
                           capture="environment">

                    <small class="text-muted">
                        Untuk merekam 1 video langsung dari kamera HP.
                    </small>

                    <div id="videoCameraList" class="mt-2 small text-muted"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Video dari Galeri</label>

                    <input type="file"
                           name="video[]"
                           id="videoGalleryInput"
                           class="form-control"
                           accept="video/*"
                           multiple>

                    <small class="text-muted">
                        Untuk memilih video dari galeri HP.
                    </small>

                    <div id="videoGalleryList" class="mt-2 small text-muted"></div>
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

                <div class="mt-4">
                    <button type="submit"
                            id="submitBtn"
                            class="btn btn-success">
                        Simpan
                    </button>

                    <a href="/wilayah/{{ $wilayah->id }}/foto-video"
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

<script>
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const uploadBox = document.getElementById('uploadBox');
    const uploadProgress = document.getElementById('uploadProgress');

    const fotoCameraInput = document.getElementById('fotoCameraInput');
    const fotoGalleryInput = document.getElementById('fotoGalleryInput');

    const videoCameraInput = document.getElementById('videoCameraInput');
    const videoGalleryInput = document.getElementById('videoGalleryInput');

    const fotoCameraList = document.getElementById('fotoCameraList');
    const fotoGalleryList = document.getElementById('fotoGalleryList');

    const videoCameraList = document.getElementById('videoCameraList');
    const videoGalleryList = document.getElementById('videoGalleryList');

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

        let html = '<strong>' + label + ' dipilih:</strong><ul class="mb-0">';

        Array.from(input.files).forEach(function (file) {
            html += '<li>' + file.name + ' (' + formatSize(file.size) + ')</li>';
        });

        html += '</ul>';
        target.innerHTML = html;
    }

    fotoCameraInput.addEventListener('change', function () {
        showSelectedFiles(fotoCameraInput, fotoCameraList, 'Foto kamera');
    });

    fotoGalleryInput.addEventListener('change', function () {
        showSelectedFiles(fotoGalleryInput, fotoGalleryList, 'Foto galeri');
    });

    videoCameraInput.addEventListener('change', function () {
        showSelectedFiles(videoCameraInput, videoCameraList, 'Video kamera');
    });

    videoGalleryInput.addEventListener('change', function () {
        showSelectedFiles(videoGalleryInput, videoGalleryList, 'Video galeri');
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