<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { height: 100vh; background: #343a40; color: white; }
        .sidebar .nav-link { color: white; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #007bff; color: white; border-radius: 5px; }
        .content-header { background: white; padding: 15px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .card { border: none; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block sidebar pt-3">
                <h5 class="text-center">Admin Perpustakaan</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link active" href="/admin/dashboard"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/books"><i class="fas fa-book me-2"></i> Kelola Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/transactions"><i class="fas fa-exchange-alt me-2"></i> Transaksi</a></li>
                    <li class="nav-item"><a class="nav-link" href="/admin/users"><i class="fas fa-users me-2"></i> Kelola Anggota</a></li>
                </ul>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="content-header d-flex justify-content-between align-items-center">
                    <h1 class="h4">Hi, {{ auth()->user()->name }}</h1>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf <button class="btn btn-danger">Logout</button></form>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body text-center">
                                <h5>Buku Tersedia</h5>
                                <p class="fs-3">{{ $availableVehicles }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body text-center">
                                <h5>Total Transaksi</h5>
                                <p class="fs-3">{{ $totalTransactions }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body text-center">
                                <h5>Anggota Terdaftar</h5>
                                <p class="fs-3">{{ $registeredUsers }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-body text-center">
                        <h5>Selamat Datang</h5>
                        <p>Gunakan menu di sebelah kiri untuk mengelola sistem.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
