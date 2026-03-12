<?php
// admin/login.php - Pagina di autenticazione
session_start();

// Carica i dati del sito
$dati_file = '../dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
    $password_hash = $dati['config']['password_admin'] ?? '';
} else {
    die('Errore: File dati.json non trovato.');
}

// Gestione login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_input = $_POST['password'] ?? '';
    
    if (password_verify($password_input, $password_hash)) {
        $_SESSION['autenticato'] = true;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Password errata.';
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dashboard Greppi Sport</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background: var(--gray-100); display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: var(--shadow); width: 100%; max-width: 400px; }
        .login-box h2 { color: var(--primary); margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1rem; }
        .form-control { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; }
        .btn { width: 100%; padding: 0.8rem; background: var(--primary); color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: var(--dark); }
        .error { color: red; text-align: center; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Accesso Dashboard</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" value="admin" disabled class="form-control" style="background: #f5f5f5;">
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required class="form-control" autofocus>
            </div>
            <button type="submit" class="btn">Entra</button>
        </form>
    </div>
</body>
</html>