<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('logoapk.png') }}">
    <title>Admin - Agenda Kegiatan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            background-image: url('{{ asset('ombudsman.jpg') }}');  /* Ganti URL_GAMBAR dengan URL gambar yang diinginkan */
            background-size: cover;  /* Agar gambar mengisi seluruh halaman */
            background-position: center center;  /* Agar gambar terposisi di tengah */
            background-attachment: fixed;  /* Gambar tidak bergerak saat scroll */
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            min-height: 100vh;
            background-color: #0093d0;
            padding: 20px;
        }
        .sidebar h4 {
            color: white;
            margin-bottom: 10px;
        }
        .sidebar hr {
            border-color: white;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            transition: all 0.2s ease-in-out;
        }
        .sidebar a:hover {
            background-color: #495057;
            padding-left: 5px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .table th {
            background:  #FF8C00;
            color: white;
            text-align: center;
        }
        .section-title {
            color: white;
            margin-top: 25px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            opacity: 0.9;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>Agenda Kegiatan</h4>
        <hr>
        <a href="{{ url('/admin') }}"><i class="fas fa-home me-2"></i>Dashboard</a>
        <a href="{{ route('admin.agenda.index') }}"><i class="fas fa-calendar-alt me-2"></i>Agenda</a>
        <a href="{{ route('admin.agenda.archived') }}"><i class="fas fa-archive me-2"></i>Arsip Agenda</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid" style="background-color: #0093d0;">
                <span class="navbar-brand text-white">Admin Panel</span>
                <div class="d-flex align-items-center">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: #000;"></i>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="container mt-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
