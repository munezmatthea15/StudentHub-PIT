<?php
session_start();
require __DIR__ . '/includes/connection.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare(
        "SELECT * FROM users WHERE username = ?"
    );
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];

        header('Location: index.php');
        exit;
    }

    $error = 'Invalid username or password.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>StudentHub | Login</title>

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg,
        #4f46e5, #9333ea, #38bdf8);
    padding: 25px;
}

.login-container {
    display: flex;
    width: 850px;
    max-width: 100%;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 25px 60px #0003;
}

.brand {
    width: 45%;
    padding: 55px 35px;
    background: linear-gradient(145deg,
        #312e81, #7c3aed);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.logo {
    width: 65px;
    height: 65px;
    background: #ffffff25;
    border-radius: 18px;
    display: grid;
    place-items: center;
    font-size: 30px;
    font-weight: bold;
}

.brand h1 {
    font-size: 34px;
    margin-bottom: 10px;
}

.brand p {
    line-height: 1.7;
    color: #ddd6fe;
}

.login-form {
    flex: 1;
    padding: 55px 40px;
}

.login-form h2 {
    color: #25234a;
    font-size: 28px;
    margin-bottom: 8px;
}

.subtitle {
    color: #64748b;
    margin-bottom: 30px;
}

label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    color: #374151;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 14px;
    border: 1px solid #dce1eb;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 15px;
    outline: none;
}

input:focus {
    border-color: #7c3aed;
}

button {
    width: 100%;
    border: none;
    border-radius: 10px;
    padding: 15px;
    background: linear-gradient(90deg,
        #4f46e5, #9333ea);
    color: white;
    font-size: 15px;
    font-weight: bold;
    cursor: pointer;
}

button:hover {
    opacity: 0.9;
}

.error {
    padding: 12px;
    background: #fee2e2;
    color: #b91c1c;
    border-radius: 8px;
    margin-bottom: 18px;
}

.footer {
    margin-top: 28px;
    text-align: center;
    font-size: 12px;
    color: #94a3b8;
}

@media(max-width: 650px) {
    .login-container {
        flex-direction: column;
    }

    .brand {
        width: 100%;
        padding: 25px;
    }

    .login-form {
        padding: 30px 25px;
    }
}
</style>
</head>

<body>
<div class="login-container">

    <section class="brand">
        <div class="logo">S</div>
        <h1>StudentHub</h1>
        <p>Student Information Management System</p>
        <p>Organize. Manage. Connect.</p>
    </section>

    <section class="login-form">

        <h2>Welcome back!</h2>
        <p class="subtitle">Sign in to your account.</p>

        <?php if ($error): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Username</label>
            <input type="text"
                   name="username"
                   placeholder="Enter username"
                   required>

            <label>Password</label>
            <input type="password"
                   name="password"
                   placeholder="Enter password"
                   required>

            <button type="submit">Sign In</button>
        </form>

        <div class="footer">
            StudentHub &copy; 2026
        </div>

    </section>

</div>
</body>
</html>
