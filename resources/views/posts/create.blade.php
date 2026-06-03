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
                    <label class="form-label">Foto</label>

                    <input type="file"
                           name="foto[]"
                           id="fotoInput"
                           class="form-control"
                           accept="image/*"
                           capture="environment"
                           multiple>

                    <small class="text-muted">
                        Di HP akan membuka kamera belakang. Bisa pilih lebih dari satu foto.
                    </small>

                    <div id="fotoList" class="mt-2 small text-muted"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Video</label>

                    <input type="file"
                           name="video[]"
                           id="videoInput"
                           class="form-control"
                           accept="video/*"
                           capture="environment"
                           multiple>

                    <small class="text-muted">
                        Di HP akan membuka kamera video belakang.
                    </small>

                    <div id="videoList" class="mt-2 small text-muted"></div>
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

    const fotoInput = document.getElementById('fotoInput');
    const videoInput = document.getElementById('videoInput');

    const fotoList = document.getElementById('fotoList');
    const videoList = document.getElementById('videoList');

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

    fotoInput.addEventListener('change', function () {
        showSelectedFiles(fotoInput, fotoList, 'Foto');
    });

    videoInput.addEventListener('change', function () {
        showSelectedFiles(videoInput, videoList, 'Video');
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