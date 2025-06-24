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
        :root {
            --primary-color: #0093d0;
            --secondary-color: #FF8C00;
            --sidebar-width: 250px;
            --navbar-height: 60px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: var(--primary-color);
            padding: 20px 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            padding: 0 20px 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 15px;
        }

        .sidebar h4 {
            color: white;
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 0 15px;
        }

        .sidebar a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .sidebar i {
            width: 22px;
            text-align: center;
            margin-right: 12px;
            font-size: 1rem;
        }

        /* Main content styles */
        .main-content {
            margin-left: 0;
            padding: 20px;
            transition: all 0.3s ease;
            min-height: calc(100vh - var(--navbar-height));
            margin-top: var(--navbar-height);
        }

        .main-content.shifted {
            margin-left: var(--sidebar-width);
        }

        /* Navbar styles */
        .top-navbar {
            background-color: var(--primary-color) !important;
            height: var(--navbar-height);
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 900;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 0;
        }

        .menu-toggle {
            color: white;
            font-size: 1.3rem;
            margin-right: 20px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
        }

        .logout-btn {
            color: white !important;
            font-size: 1.2rem;
            padding: 5px;
            margin-left: auto;
        }

        /* Table container with horizontal scroll */
        .table-responsive-container {
            width: 100%;
            overflow-x: auto;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            background: white;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table th {
            background: var(--secondary-color);
            color: white;
            text-align: center;
            padding: 12px 15px;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table tr:hover td {
            background-color: #f9f9f9;
        }

        /* Card styling for content */
        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Responsive adjustments */
        @media (min-width: 992px) {
            .sidebar {
                left: 0;
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }

            .menu-toggle {
                display: none;
            }
        }

        @media (max-width: 991px) {
            .main-content.shifted {
                margin-left: 0;
            }

            .main-content {
                padding: 15px;
            }

            .table th,
            .table td {
                padding: 10px 12px;
                font-size: 0.9rem;
            }
        }

        /* Custom scrollbar for table */
        .table-responsive-container::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 0 0 8px 8px;
        }

        .table-responsive-container::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .table-responsive-container::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
    </style>
</head>
<body>

    <!-- Sidebar Overlay (for mobile) -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4>Agenda Kegiatan</h4>
        </div>
        <div class="sidebar-menu">
            <a href="{{ url('/admin') }}"><i class="fas fa-home"></i>Dashboard</a>
            <a href="{{ route('admin.agenda.index') }}"><i class="fas fa-calendar-alt"></i>Agenda</a>
            <a href="{{ route('admin.agenda.archived') }}"><i class="fas fa-archive"></i>Arsip Agenda</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar top-navbar">
            <button class="menu-toggle d-lg-none"><i class="fas fa-bars"></i></button>
            <span class="navbar-brand">Admin Panel</span>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </nav>

        <!-- Content Area -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
            document.querySelector('.main-content').classList.toggle('shifted');
        });

        // Close sidebar when clicking on overlay
        document.querySelector('.sidebar-overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.sidebar-overlay').classList.remove('active');
            document.querySelector('.main-content').classList.remove('shifted');
        });

        // Highlight active menu item
        const currentUrl = window.location.href;
        const menuItems = document.querySelectorAll('.sidebar a');

        menuItems.forEach(item => {
            if (item.href === currentUrl) {
                item.classList.add('active');
            }
        });

        // Auto-close sidebar on mobile when clicking a menu item
        if (window.innerWidth < 992) {
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.remove('active');
                    document.querySelector('.sidebar-overlay').classList.remove('active');
                    document.querySelector('.main-content').classList.remove('shifted');
                });
            });
        }

        // Add responsive class to tables
        document.addEventListener('DOMContentLoaded', function() {
            const tables = document.querySelectorAll('table');
            tables.forEach(table => {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive-container';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            });
        });
    </script>
</body>
</html>
