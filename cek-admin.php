<?php
session_start();

// --- 1. SECURITY CHECK ---
// Kalau belum login (session kosong), tendang ke login.php
if (!isset($_SESSION['user_login'])) {
    header("Location: login.php");
    exit;
}

// Logic Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: cek-login.php");
    exit;
}

$username = $_SESSION['user_login'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kemuning Putih</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <style>
        /* --- VARIABLES --- */
        :root {
            --kp-dark: #0f1c13;
            --kp-sidebar: #142319;
            --kp-card: #1a2e22;
            --kp-olive: #606c38;
            --kp-soft: #dce7c7;
            --kp-white: #ffffff;
            --kp-grey: #aebbb0;
            --kp-border: rgba(255, 255, 255, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--kp-dark);
            color: var(--kp-white);
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 260px;
            background-color: var(--kp-sidebar);
            border-right: 1px solid var(--kp-border);
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            position: fixed;
            height: 100vh;
            transition: transform 0.3s ease;
            z-index: 100;
        }

        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--kp-white);
            margin-bottom: 40px;
            padding-left: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .brand span { color: var(--kp-olive); }

        .menu-list { list-style: none; }
        
        .menu-item { margin-bottom: 10px; }
        
        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--kp-grey);
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
            font-size: 0.95rem;
        }

        .menu-link:hover, .menu-link.active {
            background-color: rgba(255,255,255,0.05);
            color: var(--kp-soft);
        }

        .menu-link.active {
            background-color: var(--kp-olive);
            color: white;
        }

        .logout-btn {
            margin-top: auto;
            color: #fca5a5;
        }
        .logout-btn:hover { background-color: rgba(239, 68, 68, 0.1); color: #f87171; }

        /* --- MAIN CONTENT --- */
        .main-content {
            flex: 1;
            margin-left: 260px; /* Lebar sidebar */
            padding: 40px;
        }

        /* Header */
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .page-title h2 { font-size: 1.8rem; font-weight: 600; margin-bottom: 5px; }
        .page-title p { color: var(--kp-grey); font-size: 0.9rem; }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--kp-card);
            padding: 8px 15px;
            border-radius: 50px;
            border: 1px solid var(--kp-border);
        }
        .user-avatar { width: 30px; height: 30px; background: var(--kp-olive); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--kp-card);
            border: 1px solid var(--kp-border);
            padding: 25px;
            border-radius: 16px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            transition: transform 0.3s;
        }

        .stat-card:hover { transform: translateY(-5px); border-color: var(--kp-olive); }

        .stat-info h3 { font-size: 2rem; margin-bottom: 5px; color: var(--kp-white); }
        .stat-info p { color: var(--kp-grey); font-size: 0.9rem; }
        
        .stat-icon {
            padding: 10px;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
            color: var(--kp-soft);
        }

        /* Table Section */
        .table-container {
            background: var(--kp-card);
            border: 1px solid var(--kp-border);
            border-radius: 16px;
            padding: 25px;
            overflow-x: auto;
        }

        .table-header { margin-bottom: 20px; font-size: 1.2rem; font-weight: 600; }

        table { width: 100%; border-collapse: collapse; }
        
        th { text-align: left; padding: 15px; color: var(--kp-grey); font-weight: 500; font-size: 0.9rem; border-bottom: 1px solid var(--kp-border); }
        td { padding: 15px; border-bottom: 1px solid var(--kp-border); font-size: 0.95rem; }
        
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: rgba(255,255,255,0.02); }

        .status-badge {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-new { background: rgba(96, 165, 250, 0.15); color: #60a5fa; }
        .status-done { background: rgba(74, 222, 128, 0.15); color: #4ade80; }
        .status-pending { background: rgba(251, 191, 36, 0.15); color: #fbbf24; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 20px; }
            /* Tambahin toggle button kalo mau full mobile support */
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <i data-lucide="leaf"></i> Kemuning<span>.</span>
        </div>
        
        <ul class="menu-list">
            <li class="menu-item">
                <a href="#" class="menu-link active"><i data-lucide="layout-dashboard"></i> Dashboard</a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link"><i data-lucide="shopping-bag"></i> Produk</a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link"><i data-lucide="message-square"></i> Pesan Masuk <span style="margin-left:auto; background:var(--kp-olive); font-size:10px; padding:2px 6px; border-radius:4px;">3</span></a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link"><i data-lucide="users"></i> Klien</a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link"><i data-lucide="settings"></i> Pengaturan</a>
            </li>
            <li class="menu-item" style="margin-top: auto;">
                <a href="?logout=true" class="menu-link logout-btn"><i data-lucide="log-out"></i> Keluar</a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Header -->
        <div class="header-bar">
            <div class="page-title">
                <h2>Selamat Pagi, <?php echo ucfirst($username); ?>!</h2>
                <p>Berikut ringkasan aktivitas website Anda hari ini.</p>
            </div>
            <div class="user-profile">
                <div class="user-avatar"><?php echo substr(strtoupper($username), 0, 1); ?></div>
                <span>Admin</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>1,204</h3>
                    <p>Total Pengunjung</p>
                </div>
                <div class="stat-icon"><i data-lucide="eye"></i></div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>28</h3>
                    <p>Pesan Masuk (WA)</p>
                </div>
                <div class="stat-icon"><i data-lucide="message-circle"></i></div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Proyek Aktif</p>
                </div>
                <div class="stat-icon"><i data-lucide="briefcase"></i></div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Rp 45jt</h3>
                    <p>Estimasi Omzet</p>
                </div>
                <div class="stat-icon"><i data-lucide="trending-up"></i></div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="table-container">
            <div class="table-header">Pesan Konsultasi Terbaru</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Klien</th>
                        <th>Layanan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dummy Data -->
                    <tr>
                        <td>Budi Santoso</td>
                        <td>Pembuatan Taman</td>
                        <td>28 Jan 2024</td>
                        <td><span class="status-badge status-new">Baru</span></td>
                        <td><a href="#" style="color:var(--kp-soft);">Lihat</a></td>
                    </tr>
                    <tr>
                        <td>Sarah Wijaya</td>
                        <td>Renovasi Kolam</td>
                        <td>27 Jan 2024</td>
                        <td><span class="status-badge status-pending">Proses</span></td>
                        <td><a href="#" style="color:var(--kp-soft);">Lihat</a></td>
                    </tr>
                    <tr>
                        <td>PT. Indah Karya</td>
                        <td>Maintenance Kantor</td>
                        <td>25 Jan 2024</td>
                        <td><span class="status-badge status-done">Selesai</span></td>
                        <td><a href="#" style="color:var(--kp-soft);">Lihat</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
