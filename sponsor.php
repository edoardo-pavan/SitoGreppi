<?php
// Carica i dati del sito
$dati_file = 'dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
} else {
    die('Errore: File dati.json non trovato.');
}

// Estrai dati per Sponsor
$titolo_pagina = $dati['pagine']['sponsor']['titolo'] ?? 'I Nostri Partner';
$contenuto = $dati['pagine']['sponsor']['contenuto'] ?? '';
$logo = $dati['config']['logo'] ?? 'img/logo1.png';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Partner e sponsor dell'I.I.S.S. Alessandro Greppi.">
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
                <li><a href="chi-siamo.php">Chi Siamo</a></li>
                <li><a href="sponsor.php" class="active">Sponsor</a></li>
                <li><a href="contatti.php">Contatti</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1><?php echo htmlspecialchars($titolo_pagina); ?></h1>
        <p>Grazie al sostegno delle aziende del territorio, possiamo offrire eventi gratuiti e premi di qualità per tutti gli studenti dell'Istituto Greppi.</p>
    </section>

    <main class="container">
        <?php echo $contenuto; ?>
    </main>

    <footer>
        <p><strong>Comitato Sportivo Studentesco</strong></p>
        <p>I.I.S.S. Alessandro Greppi - Monticello Brianza (LC)</p>
        <p><small>&copy; 2026 Greppi Sport. Tutti i diritti riservati.</small></p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>