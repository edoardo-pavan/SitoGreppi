<?php
// Carica i dati del sito
$dati_file = 'dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
} else {
    die('Errore: File dati.json non trovato.');
}

// Estrai dati per la home
$titolo_hero = $dati['pagine']['home']['titolo_hero'] ?? 'Lo sport vive al Greppi';
$descrizione_hero = $dati['pagine']['home']['descrizione_hero'] ?? 'Benvenuti nel portale ufficiale...';
$video_corri = $dati['config']['video_corri_greppi'] ?? '0tg53-FqKUw';
$video_bike = $dati['config']['video_greppi_bike'] ?? 'YhmUD1YrfaY';
$logo = $dati['config']['logo'] ?? 'img/logo1.png';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Comitato Sportivo Studentesco dell'I.I.S.S. Alessandro Greppi. Eventi sportivi: Corri Greppi, Greppi Bike, Festa Primaverile.">
    <title><?php echo htmlspecialchars($dati['config']['titolo_sito'] ?? 'Greppi Sport'); ?> | I.I.S.S. Alessandro Greppi</title>
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

    <section class="hero" style="background-image: url('img/fotovillahome.png'); background-size: cover; background-position: center;">
        <div class="hero-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.6);"></div>
        <div style="position: relative; z-index: 2;">
            <h1><?php echo htmlspecialchars($titolo_hero); ?></h1>
            <p><?php echo nl2br(htmlspecialchars($descrizione_hero)); ?></p>
        </div>
    </section>

    <main class="container">
        <h2 style="text-align: center;">I Nostri Eventi</h2>
        <br>
        <br>
        <div class="events-grid">
            <?php foreach ($dati['eventi'] as $evento): ?>
            <div class="card">
                <div class="card-img" style="background-image: url('<?php echo htmlspecialchars($evento['immagine']); ?>'); background-size: cover; background-position: center; color: transparent;"></div>
                <div class="card-content">
                    <h3><?php echo htmlspecialchars($evento['titolo']); ?></h3>
                    <p><?php echo htmlspecialchars($evento['descrizione_breve']); ?></p>
                    <br>
                    <a href="evento.php?id=<?php echo $evento['slug']; ?>" class="btn">Scopri di più</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <section style="background: var(--dark); color: white; padding: 60px 20px; text-align: center;">
        <h2 style="color: var(--primary-bright); margin-bottom: 2rem;">I Nostri Momenti</h2>
        <p style="margin-bottom: 3rem; font-size: 1.1rem;">Scopri l'energia e la passione del Comitato Sportivo Studentesco attraverso i nostri video</p>
        
        <div class="video-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem; max-width: 1200px; margin: 0 auto;">
            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <iframe src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($video_corri); ?>" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div style="padding: 1rem;">
                    <h4 style="color: var(--dark); margin: 0;">Corri Greppi 2025</h4>
                </div>
            </div>
            
            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                <div style="position: relative; padding-bottom: 56.25%; height: 0;">
                    <iframe src="https://www.youtube-nocookie.com/embed/<?php echo htmlspecialchars($video_bike); ?>" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;" 
                            allowfullscreen>
                    </iframe>
                </div>
                <div style="padding: 1rem;">
                    <h4 style="color: var(--dark); margin: 0;">Greppi Bike 2025</h4>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p><strong>Comitato Sportivo Studentesco</strong></p>
        <p>I.I.S.S. Alessandro Greppi - Via Dei Mille 27, Monticello Brianza (LC)</p>
        <p><a href="https://instagram.com/greppievents" target="_blank">Seguici su Instagram: @greppievents</a></p>
        <p><small>&copy; 2026 Greppi Sport. Tutti i diritti riservati.</small></p>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>