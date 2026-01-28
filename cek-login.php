<?php
session_start();

// --- KONFIGURASI DUMMY (Ganti logic ini kalau udah pake Database) ---
$valid_username = 'admin';
$valid_password = 'admin123';

$error_msg = '';

// Logic saat tombol Login ditekan
if (isset($_POST['submit_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi Sederhana
    if (empty($username) || empty($password)) {
        $error_msg = "Harap isi username dan password.";
    } elseif ($username === $valid_username && $password === $valid_password) {
        // Login Sukses
        $_SESSION['user_login'] = $username;
        // Redirect ke dashboard/home (Ganti 'index.php' sesuai halaman tujuan)
        header("Location: cek-admin.php"); 
        exit;
    } else {
        // Login Gagal
        $error_msg = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kemuning Putih Admin</title>
    <!-- Fonts & Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- CSS VARIABLES (Sesuai Brand) --- */
        :root {
            --kp-dark: #0f1c13;
            --kp-olive: #606c38;
            --kp-soft: #dce7c7;
            --kp-white: #ffffff;
            --kp-glass: rgba(20, 35, 25, 0.85);
            --kp-border: rgba(255, 255, 255, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--kp-dark);
            position: relative;
        }

        /* Background Image dengan Overlay */
        .bg-layer {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2670&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            filter: blur(8px); /* Blur biar fokus ke login */
            opacity: 0.6;
            z-index: 0;
            transform: scale(1.1); /* Zoom dikit biar ga ada border putih pas blur */
        }

        .bg-overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(15, 28, 19, 0.9) 0%, rgba(15, 28, 19, 0.7) 100%);
            z-index: 1;
        }

        /* --- LOGIN CARD --- */
        .login-card {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            background: var(--kp-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--kp-border);
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Logo / Header */
        .login-header h1 {
            font-family: 'Playfair Display', serif;
            color: var(--kp-white);
            font-size: 2rem;
            margin-bottom: 5px;
        }

        .login-header p {
            color: rgba(255,255,255,0.6);
            font-size: 0.9rem;
            margin-bottom: 40px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 25px;
            text-align: left;
            position: relative;
        }

        .form-label {
            color: var(--kp-soft);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            display: block;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 14px 15px 14px 45px; /* Padding kiri buat icon */
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--kp-border);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        .form-input:focus {
            border-color: var(--kp-olive);
            background: rgba(255,255,255,0.1);
            box-shadow: 0 0 0 4px rgba(96, 108, 56, 0.2);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.4);
            width: 18px;
            height: 18px;
            transition: 0.3s;
        }

        .form-input:focus + .input-icon {
            color: var(--kp-olive);
        }

        /* Button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background-color: var(--kp-olive);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            background-color: #728045;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(96, 108, 56, 0.3);
        }

        /* Alert Error */
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-size: 0.9rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        /* Footer Copyright */
        .login-footer {
            margin-top: 30px;
            color: rgba(255,255,255,0.3);
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

    <div class="bg-layer"></div>
    <div class="bg-overlay"></div>

    <div class="login-card">
        <div class="login-header">
            <h1>Kemuning Putih</h1>
            <p>Welcome back, please login to your account.</p>
        </div>

        <!-- Tampilkan Error jika ada -->
        <?php if($error_msg): ?>
            <div class="alert-error">
                <i data-lucide="alert-circle" size="16"></i>
                <?php echo $error_msg; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrapper">
                    <input type="text" name="username" class="form-input" placeholder="Masukkan username" required autocomplete="off">
                    <i data-lucide="user" class="input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" class="form-input" placeholder="Masukkan password" required>
                    <i data-lucide="lock" class="input-icon"></i>
                </div>
            </div>

            <button type="submit" name="submit_login" class="btn-login">
                Masuk Dashboard <i data-lucide="arrow-right" size="18"></i>
            </button>
        </form>

        <div class="login-footer">
            &copy; <?php echo date('Y'); ?> Kemuning Putih Landscape.
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
