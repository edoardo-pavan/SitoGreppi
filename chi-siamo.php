<?php
// Carica i dati del sito
$dati_file = 'dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
} else {
    die('Errore: File dati.json non trovato.');
}

// Estrai dati per Chi Siamo
$titolo_pagina = $dati['pagine']['chi_siamo']['titolo'] ?? 'Chi Siamo';
$contenuto = $dati['pagine']['chi_siamo']['contenuto'] ?? '';
$logo = $dati['config']['logo'] ?? 'img/logo1.png';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Chi siamo: il Comitato Sportivo Studentesco dell'I.I.S.S. Alessandro Greppi.">
    <title><?php echo htmlspecialchars($titolo_pagina); ?> | Greppi Sport</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dynamic.css.php">
</head>
<body>

    <header class="main-header">
        <nav class="navbar">
            <div class="logo"><a href="index.php"><img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo Greppi Sport"></a></div>
            <button class="menu-toggle" id="menuToggle">☰</button>
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php">Home</a></li>
                <li><a href="chi-siamo.php" class="active">Chi Siamo</a></li>
                <li><a href="sponsor.php">Sponsor</a></li>
                <li><a href="contatti.php">Contatti</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero" style="background-image: url('img/grupporagazzicomitato.jpg'); background-size: cover; background-position: center;">
        <div class="hero-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6);"></div>
        <div style="position: relative; z-index: 2;">
            <h1><?php echo htmlspecialchars($titolo_pagina); ?></h1>
            <p>Il Comitato Sportivo Scolastico dell’Istituto di Istruzione Superiore “Alessandro Greppi”</p>
        </div>
    </section>

    <main class="container">
        <?php echo $contenuto; ?>
    </main>

    <footer>
        <p><strong>Comitato Sportivo Studentesco</strong></p>
        <p>I.I.S.S. Alessandro Greppi - Via Dei Mille 27, Monticello Brianza (LC)</p>
        <p><a href="https://instagram.com/greppievents" target="_blank">Seguici su Instagram: @greppievents</a></p>
        <p><small>&copy; 2026 Greppi Sport. Tutti i diritti riservati.</small></p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>