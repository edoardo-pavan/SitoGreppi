<?php
// Carica i dati del sito
$dati_file = 'dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
} else {
    die('Errore: File dati.json non trovato.');
}

// Recupera l'ID dell'evento dall'URL
$id_evento = $_GET['id'] ?? '';

// Cerca l'evento nella lista
$evento = null;
foreach ($dati['eventi'] as $e) {
    if ($e['slug'] === $id_evento) {
        $evento = $e;
        break;
    }
}

if (!$evento) {
    // Se l'evento non esiste, reindirizza alla home
    header('Location: index.php');
    exit();
}

$logo = $dati['config']['logo'] ?? 'img/logo1.png';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo htmlspecialchars($evento['descrizione_breve']); ?>">
    <title><?php echo htmlspecialchars($evento['titolo']); ?> | Greppi Sport</title>
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
                <li><a href="sponsor.php">Sponsor</a></li>
                <li><a href="contatti.php">Contatti</a></li>
            </ul>
        </nav>
    </header>

    <nav class="event-nav">
        <ul>
            <li><a href="#hero">Inizio</a></li>
            <li><a href="#info">Info</a></li>
            <li><a href="#iscrizioni">Iscrizioni</a></li>
        </ul>
    </nav>

    <section id="hero" class="hero" style="background-image: url('<?php echo htmlspecialchars($evento['immagine']); ?>'); background-size: cover; background-position: center;">
        <div class="hero-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6);"></div>
        <div style="position: relative; z-index: 2;">
            <h1><?php echo htmlspecialchars($evento['titolo']); ?></h1>
            <p><strong><?php echo date('d/m/Y', strtotime($evento['data'])); ?></strong></p>
        </div>
    </section>

    <main class="container">
        <section id="info" class="event-section">
            <h2>Info Evento</h2>
            <?php echo $evento['contenuto']; ?>
        </section>

        <section id="iscrizioni" class="event-section">
            <h2>Come Iscriversi</h2>
            <div class="signup-section">
                <h3>Scegli la modalità di iscrizione:</h3>
                <div class="btn-container">
                    <a href="#" class="btn">Singolo</a>
                    <a href="#" class="btn">Gruppi</a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p><strong>Comitato Sportivo Studentesco - I.I.S.S. A. Greppi</strong></p>
        <p><a href="index.php">Home</a> | <a href="sponsor.php">Sponsor</a> | <a href="contatti.php">Contatti</a></p>
        <p><small>&copy; 2026 Greppi Sport. Monticello Brianza (LC)</small></p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>