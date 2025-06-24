<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" type="image/png" href="{{ asset('logoapk.png') }}">
  <title>Agenda Kegiatan Ombudsman</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-color: #0066cc;
      --secondary-color: #FF8C00;
      --accent-color: #00b4d8;
      --light-bg: #f8f9fa;
      --dark-bg: #1a1a2e;
      --text-light: #f8f9fa;
      --text-dark: #212529;
      --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--light-bg);
      color: var(--text-dark);
      margin: 0;
      padding: 0;
      transition: var(--transition);
      line-height: 1.6;
    }

    /* Navbar Styles */
    .custom-navbar {
      background-color: var(--primary-color);
      color: var(--text-light);
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .custom-navbar .left img {
      height: 60px;
      width: auto;
      transition: transform 0.3s ease;
    }

    .custom-navbar .left img:hover {
      transform: scale(1.05);
    }

    .custom-navbar .center {
      font-size: 1.1rem;
      font-weight: 500;
      text-align: center;
      flex: 1;
    }

    .custom-navbar .right {
      display: flex;
      align-items: center;
      gap: 15px;
      flex-wrap: wrap;
    }

    .social-icon {
      font-size: 1.2rem;
      color: var(--text-light);
      transition: var(--transition);
      padding: 5px;
    }

    .social-icon:hover {
      color: #ffdc00;
      transform: translateY(-2px);
    }

    /* Main Content Styles */
    .main-container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 20px;
    }

    /* Hero Section */
    .hero-section {
      background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
      color: white;
      padding: 60px 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('{{ asset("ombudsman-pattern.png") }}') center/cover;
      opacity: 0.1;
      z-index: 0;
    }

    .hero-content {
      position: relative;
      z-index: 1;
    }

    .page-title {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 15px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .page-subtitle {
      font-size: 1.2rem;
      max-width: 800px;
      margin: 0 auto 25px;
      opacity: 0.9;
    }

    /* Agenda Table Styles */
    .agenda-section {
      background-color: white;
      border-radius: 10px;
      box-shadow: var(--card-shadow);
      padding: 30px;
      margin-bottom: 40px;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .section-title {
      font-size: 1.8rem;
      font-weight: 600;
      color: var(--primary-color);
      margin: 0;
    }

    .agenda-table-container {
      overflow-x: auto;
      border-radius: 8px;
    }

    .agenda-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background-color: white;
      border-radius: 8px;
      overflow: hidden;
    }

    .agenda-table th {
      background-color: var(--secondary-color);
      color: white;
      font-weight: 500;
      padding: 15px;
      text-align: center;
      position: sticky;
      top: 0;
    }

    .agenda-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #e9ecef;
      vertical-align: middle;
    }

    .agenda-table tr:last-child td {
      border-bottom: none;
    }

    .agenda-table tr:hover td {
      background-color: rgba(0, 180, 216, 0.05);
    }

    .date-cell {
      font-weight: 500;
      color: var(--primary-color);
    }

    .time-cell {
      font-family: 'Courier New', monospace;
      font-weight: 500;
    }

    .division-badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
      background-color: #e9f5ff;
      color: var(--primary-color);
    }

    /* Footer Styles */
    .footer {
      background-color: var(--primary-color);
      color: var(--text-light);
      padding: 30px 0;
      text-align: center;
      margin-top: 50px;
    }

    .footer-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .footer-links {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    .footer-link {
      color: var(--text-light);
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-link:hover {
      color: #ffdc00;
    }

    .copyright {
      opacity: 0.8;
      font-size: 0.9rem;
    }

    /* Dark Mode Styles */
    .dark-mode {
      background-color: var(--dark-bg);
      color: var(--text-light);
    }

    .dark-mode .agenda-section,
    .dark-mode .agenda-table {
      background-color: #16213e;
    }

    .dark-mode .agenda-table th {
      background-color: #0f3460;
    }

    .dark-mode .agenda-table td {
      border-bottom-color: #2a3a5e;
      color: var(--text-light);
    }

    .dark-mode .agenda-table tr:hover td {
      background-color: rgba(0, 180, 216, 0.1);
    }

    .dark-mode .division-badge {
      background-color: #1e3a8a;
      color: #bfdbfe;
    }

    .dark-mode .date-cell {
      color: #93c5fd;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .custom-navbar {
        padding: 15px;
      }

      .page-title {
        font-size: 2rem;
      }

      .agenda-table th,
      .agenda-table td {
        padding: 10px 12px;
      }
    }

    @media (max-width: 768px) {
      .custom-navbar {
        flex-direction: column;
        gap: 15px;
      }

      .hero-section {
        padding: 40px 15px;
      }

      .page-title {
        font-size: 1.8rem;
      }

      .section-header {
        flex-direction: column;
        align-items: flex-start;
      }
    }

    @media (max-width: 576px) {
      .agenda-table {
        font-size: 0.9rem;
      }

      .agenda-table th,
      .agenda-table td {
        padding: 8px 10px;
      }
    }

    /* Animation Effects */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .animated {
      animation: fadeIn 0.6s ease-out forwards;
    }

    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }
    .delay-3 { animation-delay: 0.6s; }

    /* Button Styles */
    .btn-ombudsman {
      background-color: var(--secondary-color);
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 30px;
      font-weight: 500;
      transition: var(--transition);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-ombudsman:hover {
      background-color: #e67e00;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Utility Classes */
    .text-accent {
      color: var(--accent-color);
    }

    .bg-gradient {
      background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    }
  </style>
</head>

<body onload="updateTime()">
  <!-- Navbar -->
  <nav class="custom-navbar">
    <div class="left">
      <a href="{{route('home')}}">
        <img src="{{ asset('logoapk.png') }}" alt="Ombudsman" class="animated" />
      </a>
    </div>
    <div class="center animated delay-1" id="datetime">Memuat waktu...</div>
    <div class="right">
      <a href="#" class="social-icon" title="Call 137"><i class="fas fa-phone-volume"></i></a>
      <a href="#" class="social-icon" title="Email"><i class="fas fa-envelope"></i></a>
      <a href="#" class="social-icon" title="Facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="social-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
      <a href="#" class="social-icon" title="Instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" class="social-icon" title="YouTube"><i class="fab fa-youtube"></i></a>
      <a target="_blank" href="https://api.whatsapp.com/send?phone=6283826383761" class="social-icon" title="WhatsApp">
        <i class="fab fa-whatsapp"></i>
      </a>
      <button class="social-icon toggle-mode" onclick="toggleDarkMode()" title="Toggle Mode" style="background: none; border: none;">
        <i class="fas fa-adjust"></i>
      </button>
      <a href="{{ route('login') }}" class="btn btn-ombudsman animated delay-2" target="_blank">
        <i class="fas fa-sign-in-alt"></i> Login Admin
      </a>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-container">
    <!-- Hero Section -->
    <section class="hero-section animated">
      <div class="hero-content">
        <h1 class="page-title">Agenda Kegiatan Ombudsman</h1>
        <p class="page-subtitle">Transparansi dan akuntabilitas kegiatan harian Ombudsman Republik Indonesia Perwakilan Sumatera Selatan</p>
        <div id="current-date" class="badge bg-light text-dark p-2 animated delay-1"></div>
      </div>
    </section>

    <!-- Agenda Section -->
    <section class="agenda-section animated delay-1">
      <div class="section-header">
        <h2 class="section-title"><i class="fas fa-calendar-alt text-accent"></i> Agenda Mingguan</h2>
        <div class="btn-group" role="group">
          <button type="button" class="btn btn-outline-primary active">Minggu Ini</button>
        </div>
      </div>

      <div class="agenda-table-container">
        <table class="agenda-table">
          <thead>
            <tr>
              <th style="width: 5%;">No</th>
              <th style="width: 15%;">Hari & Tanggal</th>
              <th style="width: 10%;">Waktu</th>
              <th style="width: 30%;">Kegiatan</th>
              <th style="width: 15%;">Instansi</th>
              <th style="width: 10%;">Divisi</th>
              <th style="width: 15%;">Penanggung Jawab</th>
            </tr>
          </thead>
          <tbody>
            @php
                $previousDate = null;
                $number = 1;
            @endphp
            @foreach ($agendas as $agenda)
              <tr class="animated delay-2">
                @if ($agenda->date != $previousDate)
                  <td class="text-center align-middle date-cell" rowspan="{{ $agendas->where('date', $agenda->date)->count() }}">{{ $number++ }}</td>
                  <td class="align-middle date-cell" rowspan="{{ $agendas->where('date', $agenda->date)->count() }}">
                    <strong>{{ $agenda->day }}</strong><br>
                    {{ \Carbon\Carbon::parse($agenda->date)->translatedFormat('d F Y') }}
                  </td>
                @endif
                <td class="text-center align-middle time-cell">{{ $agenda->time }}</td>
                <td class="align-middle">
                    @php
                        $activities = json_decode($agenda->activity, true) ?? [$agenda->activity];
                    @endphp
                    @foreach($activities as $activity)
                        <div class="mb-1">
                          <i class="fas fa-circle text-accent" style="font-size: 6px; vertical-align: middle; margin-right: 8px;"></i>
                          {{ $activity }}
                        </div>
                    @endforeach
                </td>
                <td class="align-middle">{{ $agenda->institution }}</td>
                <td class="text-center align-middle">
                  @php
                      $divisionLabels = [
                          'pvl' => 'PVL',
                          'pl' => 'PL',
                          'pc' => 'PC',
                          'kaper' => 'Kaper',
                          'sekretariat' => 'Sekretariat'
                      ];
                      $divisionClass = [
                          'pvl' => 'bg-primary',
                          'pl' => 'bg-success',
                          'pc' => 'bg-info',
                          'kaper' => 'bg-warning',
                          'sekretariat' => 'bg-secondary'
                      ];
                  @endphp
                  <span class="badge {{ $divisionClass[$agenda->division] ?? 'bg-dark' }} rounded-pill">
                    {{ $divisionLabels[$agenda->division] ?? '-' }}
                  </span>
                </td>
                <td class="align-middle">
                  <div class="d-flex align-items-center">
                    <div class="avatar-sm me-2">
                      <div class="avatar-title bg-light text-primary rounded-circle">
                        <i class="fas fa-user"></i>
                      </div>
                    </div>
                    <div>{{ $agenda->person_in_charge }}</div>
                  </div>
                </td>
              </tr>
              @php
                  $previousDate = $agenda->date;
              @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

    <!-- Additional Info Section -->
    <section class="agenda-section animated delay-2">
      <div class="section-header">
        <h2 class="section-title"><i class="fas fa-info-circle text-accent"></i> Informasi Tambahan</h2>
      </div>
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-primary"><i class="fas fa-clock me-2"></i>Jam Operasional</h5>
              <p class="card-text">
                Senin - Kamis: 08.00 - 16.00 WIB<br>
                Jumat: 08.00 - 16.30 WIB<br>
                Sabtu - Minggu: Libur
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-primary"><i class="fas fa-map-marker-alt me-2"></i>Lokasi Kantor</h5>
              <p class="card-text">
                Jl. Demang Lebar Daun No.17, Palembang<br>
                Sumatera Selatan 30139<br>
                Telp: (0711) 376400
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-links">
        <a href="#" class="footer-link">Tentang Kami</a>
        <a href="#" class="footer-link">Layanan</a>
        <a href="#" class="footer-link">Kontak</a>
        <a href="#" class="footer-link">FAQ</a>
        <a href="#" class="footer-link">Privasi</a>
      </div>
      <div class="copyright">
        &copy; {{ date('Y') }} Ombudsman Republik Indonesia - Sumatera Selatan | Dibuat oleh Tim IT Ombudsman
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Update date and time
    function updateTime() {
      const now = new Date();
      const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
      const dateStr = now.toLocaleDateString('id-ID', options);
      const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
      document.getElementById('datetime').textContent = `${dateStr}, ${timeStr}`;
      document.getElementById('current-date').textContent = `Update Terakhir: ${dateStr}, ${timeStr}`;
    }

    setInterval(updateTime, 1000);
    updateTime();

    // Dark mode toggle
    function toggleDarkMode() {
      document.body.classList.toggle('dark-mode');
      const icon = document.querySelector('.toggle-mode i');
      if (document.body.classList.contains('dark-mode')) {
        icon.classList.remove('fa-adjust');
        icon.classList.add('fa-sun');
      } else {
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-adjust');
      }

      // Save preference to localStorage
      localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    }

    // Check for saved dark mode preference
    if (localStorage.getItem('darkMode') === 'true') {
      document.body.classList.add('dark-mode');
      const icon = document.querySelector('.toggle-mode i');
      icon.classList.remove('fa-adjust');
      icon.classList.add('fa-sun');
    }

    // Add hover effects to table rows
    document.querySelectorAll('.agenda-table tbody tr').forEach(row => {
      row.addEventListener('mouseenter', () => {
        row.style.transform = 'translateX(5px)';
        row.style.transition = 'transform 0.2s ease';
      });
      row.addEventListener('mouseleave', () => {
        row.style.transform = '';
      });
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>
