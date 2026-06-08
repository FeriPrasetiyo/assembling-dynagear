<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow">
        <div class="container">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                     alt="Logo"
                     width="40"
                     height="40"
                     class="rounded-circle me-2">

                Dynagear
            </a>

            <div class="ms-auto">
                <a href="/login" class="btn btn-light btn-sm">
                    Login
                </a>
            </div>

        </div>
    </nav>

    <!-- Form Register -->
    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow-lg border-0">

                    <div class="card-header bg-success text-white text-center">
                        <h3>Register</h3>
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

                        <form method="POST" action="/register">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    placeholder="Masukkan Nama"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Masukkan Email"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Masukkan Password"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                Register
                            </button>
                        </form>

                    </div>

                    <div class="card-footer text-center">
                        Sudah punya akun?
                        <a href="/login">
                            Login
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>