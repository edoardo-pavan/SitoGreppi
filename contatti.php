<?php
// Carica i dati del sito
$dati_file = 'dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
} else {
    die('Errore: File dati.json non trovato.');
}

// Estrai dati per Contatti
$titolo_pagina = $dati['pagine']['contatti']['titolo'] ?? 'Contattaci';
$indirizzo = $dati['pagine']['contatti']['indirizzo'] ?? '';
$email = $dati['pagine']['contatti']['email'] ?? '';
$logo = $dati['config']['logo'] ?? 'img/logo1.png';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contattaci per domande sugli eventi o per proposte di collaborazione.">
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
                <li><a href="sponsor.php">Sponsor</a></li>
                <li><a href="contatti.php" class="active">Contatti</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <h1><?php echo htmlspecialchars($titolo_pagina); ?></h1>
        <p>Hai domande sugli eventi o vuoi proporti come volontario nello staff? Scrivici!</p>
    </section>

    <main class="container">
        <div class="contact-grid">
            <div>
                <h2>Come Contattarci</h2>
                <p style="margin-bottom: 2rem;">Per qualsiasi domanda sugli eventi o per proposte di collaborazione, utilizza i recapiti qui sotto. Rispondiamo sempre entro 24 ore.</p>
            </div>

            <div>
                <h2>Contattaci Direttamente</h2>
                <div style="margin-top: 1.5rem;">
                    <h3 style="color: var(--primary); margin-bottom: 0.5rem;">📍 Indirizzo</h3>
                    <p><?php echo nl2br(htmlspecialchars($indirizzo)); ?></p>
                </div>

                <div style="margin-top: 1.5rem;">
                    <h3 style="color: var(--primary); margin-bottom: 0.5rem;">📧 Email</h3>
                    <p><a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email); ?></a></p>
                </div>

                <div style="margin-top: 1.5rem;">
                    <h3 style="color: var(--primary); margin-bottom: 0.5rem;">📱 Social Media</h3>
                    <p><a href="https://instagram.com/greppisport" target="_blank">Instagram: @greppisport</a></p>
                </div>

                <div style="margin-top: 1.5rem;">
                    <h3 style="color: var(--primary); margin-bottom: 0.5rem;">💬 Orari di Disponibilità</h3>
                    <p>Lunedì - Venerdì: 9:00 - 17:00<br>
                    Rispondiamo ai messaggi entro 24 ore</p>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p><strong>Comitato Sportivo Studentesco</strong></p>
        <p>I.I.S.S. Alessandro Greppi - Via Dei Mille 27, Monticello Brianza (LC)</p>
        <p><small>&copy; 2026 Greppi Sport. Tutti i diritti riservati.</small></p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>