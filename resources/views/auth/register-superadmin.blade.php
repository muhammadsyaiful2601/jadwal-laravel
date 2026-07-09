<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Super Admin - Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
            width: 100%;
        }

        .register-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .register-header h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .register-body {
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #f093fb;
            box-shadow: 0 0 0 0.2rem rgba(240, 147, 251, 0.25);
        }

        .input-group-text {
            background: #f093fb;
            border: none;
            color: white;
            border-radius: 10px 0 0 10px;
            padding: 12px 20px;
        }

        .btn-register {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(240, 147, 251, 0.3);
            color: white;
        }

        .btn-register:active {
            transform: translateY(-1px);
        }

        .alert-warning-custom {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            border: none;
            color: #856404;
            border-radius: 10px;
        }

        .back-link {
            color: #f5576c;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-link:hover {
            color: #f093fb;
            text-decoration: none;
        }

        @media (max-width: 576px) {
            .register-header {
                padding: 20px;
            }

            .register-body {
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-card">
            <!-- Register Header -->
            <div class="register-header">
                <h2><i class="fas fa-user-shield me-2"></i> Pendaftaran Super Admin</h2>
                <p class="mb-0">Hanya sekali akses!</p>
            </div>

            <!-- Register Body -->
            <div class="register-body">
                <!-- Error Messages -->
                @if (!empty($error))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $error }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Success Message -->
                @if (!empty($success))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ $success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="text-center">
                        <a href="{{ url('/login') }}" class="btn btn-register w-100">
                            <i class="fas fa-sign-in-alt me-2"></i> Login Sekarang
                        </a>
                    </div>
                @else
                    <!-- Warning Alert -->
                    <div class="alert alert-warning-custom alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian!</strong> Halaman ini hanya bisa diakses sekali untuk mendaftarkan Super Admin
                        pertama.
                    </div>

                    <!-- Register Form -->
                    <form method="POST" action="{{ url('/register-superadmin') }}" id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-1"></i> Username
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="Masukkan email (opsional)">
                            </div>
                            <small class="text-muted">Email hanya digunakan untuk recovery account</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i> Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password" name="password" required
                                    placeholder="Minimal 6 karakter">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i> Konfirmasi Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required placeholder="Ulangi password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i> Daftarkan Super Admin
                        </button>

                        <div class="text-center">
                            <a href="{{ url('/login') }}" class="back-link">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Prevent form resubmission on refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Password match validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password tidak cocok!');
                return false;
            }

            if (password.length < 6) {
                e.preventDefault();
                alert('Password minimal 6 karakter!');
                return false;
            }
        });
    </script>
</body>

</html>
