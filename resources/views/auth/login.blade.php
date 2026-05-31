<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Dynagear</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">

            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/logo/dynagearlogo.jpg') }}"
                     alt="Logo"
                     width="40"
                     height="40"
                     class="rounded-circle me-2">

                Dynagear
            </a>

            <!-- <div class="ms-auto">
                <a href="/register" class="btn btn-light btn-sm">
                    Register
                </a>
            </div> -->

        </div>
    </nav>

    <!-- Form Login -->
    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card shadow-lg border-0">

                    <div class="card-header bg-primary text-white text-center">
                        <h3>Login</h3>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
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

                        <form method="POST" action="/login">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Masukkan Email"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Masukkan Password"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>

                    </div>

                    <div class="card-footer text-center">
                        Belum punya akun?
                        <a href="/register">
                            Register
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>