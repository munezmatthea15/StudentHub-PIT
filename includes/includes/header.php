<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$page = $page ?? 'StudentHub';

$menu = [
    'Dashboard' => 'index.php',
    'Students' => 'students.php',
    'Courses' => 'courses.php',
    'Departments' => 'departments.php',
    'Reports' => 'reports.php',
    'Settings' => 'settings.php'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($page) ?> | StudentHub</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<aside class="sidebar">
    <div class="brand">
        <div class="logo">S</div>
        <h2>StudentHub</h2>
    </div>

    <div class="menu-label">MANAGEMENT</div>

    <nav>
        <?php foreach ($menu as $label => $url): ?>
            <a href="<?= htmlspecialchars($url) ?>"
               class="<?= $page === $label ? 'active' : '' ?>">
                <?= htmlspecialchars($label) ?>
            </a>
        <?php endforeach; ?>

        <a href="logout.php">Logout</a>
    </nav>
</aside>

<div class="main">
    <header class="topbar">
        <span>Student Information Management</span>
        <div class="profile">
            <?= htmlspecialchars($_SESSION['full_name']) ?>
        </div>
    </header>

    <main class="content">
