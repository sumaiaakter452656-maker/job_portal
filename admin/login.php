<?php
require_once __DIR__ . '/../dashboard_config.php';

$dashboards = [
    'admin'    => 'admin_dashboard.php',
    'employer' => 'employer_dashboard.php',
    'seeker'   => 'seeker_dashboard.php',
];

$current = (!empty($_SESSION['user_id']) && isset($dashboards[$_SESSION['role'] ?? '']))
    ? ['name' => $_SESSION['name'] ?? 'User', 'role' => $_SESSION['role']]
    : null;
$need = $_GET['need'] ?? '';
$need = isset($dashboards[$need]) ? $need : '';

$error = '';
$email = '';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        try {
            $st = db()->prepare("SELECT id, name, password, role, status FROM users WHERE email = ? LIMIT 1");
            $st->execute([$email]);
            $user = $st->fetch();

            if (!$user || !password_verify($password, $user['password'])) {
                $error = 'Invalid email or password.';
            } elseif ($user['status'] === 'blocked') {
                $error = 'Your account has been blocked. Please contact the admin.';
            } elseif (!isset($dashboards[$user['role']])) {
                $error = 'Unknown account role.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int) $user['id'];
                $_SESSION['role']    = $user['role'];
                $_SESSION['name']    = $user['name'];
                header('Location: ' . $dashboards[$user['role']]);
                exit;
            }
        } catch (PDOException $e) {
            $error = 'Database connection failed. Check settings in dashboard_config.php.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login · Jobs Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet">
</head>
<body class="theme-admin auth-page">

<div class="auth-wrap">
    <div class="auth-side d-none d-lg-flex">
        <div>
            <div class="d-flex align-items-center gap-2 mb-5">
                <div class="brand-icon"><i class="bi bi-briefcase-fill"></i></div>
                <div class="brand-text">Jobs<span style="color:#c7d2fe">Portal</span></div>
            </div>
            <h1>Find the right job.<br>Hire the right people.</h1>
            <p>One place for job seekers, employers and admins to manage everything.</p>
            <ul class="auth-points">
                <li><i class="bi bi-check-circle-fill"></i> Apply and track your applications</li>
                <li><i class="bi bi-check-circle-fill"></i> Post jobs and review applicants</li>
                <li><i class="bi bi-check-circle-fill"></i> Manage the whole portal from one panel</li>
            </ul>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-card">
            <h2>Welcome back 👋</h2>
            <p class="text-muted mb-4">Login to continue to your dashboard</p>

            <?php if ($need && $current): ?>
                <div class="alert alert-warning rounded-3 py-2 small">
                    <i class="bi bi-info-circle"></i>
                    You are logged in as <b><?= e(ucfirst($current['role'])) ?></b>.
                    This page needs a <b><?= e(ucfirst($need)) ?></b> account — please login with one below.
                </div>
            <?php elseif ($current): ?>
                <div class="alert alert-info rounded-3 py-2 small d-flex flex-wrap align-items-center gap-2">
                    <span><i class="bi bi-person-check"></i> Logged in as <b><?= e($current['name']) ?></b> (<?= e(ucfirst($current['role'])) ?>)</span>
                    <a href="<?= e($dashboards[$current['role']]) ?>" class="fw-semibold">Go to dashboard</a>
                    <span class="text-muted">·</span>
                    <a href="logout.php" class="fw-semibold text-danger">Logout</a>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 py-2 small">
                    <i class="bi bi-exclamation-circle"></i> <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" novalidate>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-icon"><i class="bi bi-envelope"></i>
                        <input type="email" class="form-control" id="email" name="email" value="<?= e($email) ?>" placeholder="you@example.com" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-icon"><i class="bi bi-lock"></i>
                        <input type="password" class="form-control" id="password" name="password" placeholder="••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-accent w-100 py-2"><i class="bi bi-box-arrow-in-right me-1"></i> Login</button>
            </form>

            <div class="demo-box mt-4">
                <div class="small fw-semibold mb-2">Demo accounts <span class="text-muted fw-normal">(password: 123456)</span></div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-white btn-sm" data-fill-email="admin@jobportal.com"><i class="bi bi-shield-lock"></i> Admin</button>
                    <button type="button" class="btn btn-white btn-sm" data-fill-email="employer@jobportal.com"><i class="bi bi-buildings"></i> Employer</button>
                    <button type="button" class="btn btn-white btn-sm" data-fill-email="seeker@jobportal.com"><i class="bi bi-person"></i> Job Seeker</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/script.js"></script>
</body>
</html>
