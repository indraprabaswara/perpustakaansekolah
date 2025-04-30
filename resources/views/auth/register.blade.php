<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Peminjaman Kendaraan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #3498db, #2ecc71);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .register-box {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 380px;
        }

        .title {
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 1.2rem;
            color: #2c3e50;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
            color: #4a5568;
        }

        .form-control {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 0.8rem;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52,152,219,0.2);
        }

        .btn-register {
            background: #3498db;
            color: white;
            padding: 0.6rem;
            border: none;
            border-radius: 4px;
            width: 100%;
            font-size: 0.95rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .btn-register:hover {
            background: #2980b9;
        }

        .help-text {
            font-size: 0.8rem;
            color: #666;
            margin-top: -0.6rem;
            margin-bottom: 0.8rem;
        }

        .login-link {
            text-align: center;
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        .login-link a {
            color: #3498db;
            text-decoration: none;
        }

        select.form-select {
            padding: 0.5rem 0.75rem;
            font-size: 0.9rem;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-bottom: 0.8rem;
            background-color: white;
            cursor: pointer;
        }

        select.form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52,152,219,0.2);
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2 class="title">Daftar Akun Baru</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Jurusan</label>
                <select name="jurusan" class="form-select" required>
                    <option value="" selected disabled>Pilih Jurusan</option>
                    <option value="RPL">RPL</option>
                    <option value="TKJ">TKJ</option>
                    <option value="TJA">TJA</option>
                    <option value="TR">TR</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                <div class="help-text">Minimal 6 karakter</div>
            </div>

            <button type="submit" class="btn-register">Daftar</button>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>