<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Data Foto & Video</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4 mb-5">

    <div class="card shadow">

        <div class="card-header bg-warning">
            <h4 class="mb-0">
                Edit Data - {{ $post->nama_barang }}
            </h4>
        </div>

        <div class="card-body">

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
                    <label class="form-label">Nomor SO</label>
                    <input type="text"
                           name="nomor_so"
                           class="form-control"
                           value="{{ old('nomor_so', $post->nomor_so) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text"
                           name="nama_barang"
                           class="form-control"
                           value="{{ old('nama_barang', $post->nama_barang) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ old('tanggal', $post->tanggal) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $post->description) }}</textarea>
                </div>

                <hr>

                <h5>Foto Saat Ini</h5>

                <div class="row mb-3">

                    @forelse($post->files->where('type','foto') as $file)

                        <div class="col-md-3 mb-3">
                            <div class="card h-100">

                                <img src="{{ asset('storage/'.$file->file) }}"
                                     class="card-img-top"
                                     style="height:200px; object-fit:cover;">

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

                <div class="mb-3">
                    <label class="form-label">Tambah Foto Baru</label>

                    <input type="file"
                           name="foto[]"
                           id="fotoInput"
                           class="form-control"
                           accept="image/*"
                           capture="environment"
                           multiple>

                    <small class="text-muted">
                        Di HP akan membuka kamera belakang. Foto baru akan otomatis diberi watermark.
                    </small>

                    <div id="fotoList" class="mt-2 small text-muted"></div>
                </div>

                <hr>

                <h5>Video Saat Ini</h5>

                <div class="row mb-3">

                    @forelse($post->files->where('type','video') as $file)

                        <div class="col-md-6 mb-3">
                            <div class="card h-100">

                                <div class="card-body">

                                    <video width="100%" controls>
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

                <div class="mb-3">
                    <label class="form-label">Tambah Video Baru</label>

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

                <div class="mt-4">
                    <button type="submit"
                            id="submitBtn"
                            class="btn btn-success">
                        Update Data
                    </button>

                    <a href="/wilayah/{{ $wilayah->id }}/foto-video/{{ $post->id }}"
                       class="btn btn-secondary">
                        Batal
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

        let html = '<strong>' + label + ' baru dipilih:</strong><ul class="mb-0">';

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