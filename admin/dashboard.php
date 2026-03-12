<?php
// admin/dashboard.php - Interfaccia principale dashboard
session_start();

// Verifica autenticazione
if (!isset($_SESSION['autenticato']) || $_SESSION['autenticato'] !== true) {
    header('Location: login.php');
    exit();
}

// Carica i dati del sito
$dati_file = '../dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
} else {
    die('Errore: File dati.json non trovato.');
}

// Determina la sezione attiva
$sezione = $_GET['sezione'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo htmlspecialchars($dati['config']['titolo_sito']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        /* Stili specifici per la dashboard */
        body { background: var(--gray-100); }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: var(--dark); color: white; padding: 1rem; }
        .sidebar h3 { color: var(--primary-bright); margin-bottom: 1rem; }
        .sidebar nav a { display: block; color: white; padding: 0.8rem; text-decoration: none; border-radius: 4px; margin-bottom: 0.5rem; }
        .sidebar nav a:hover, .sidebar nav a.active { background: var(--primary); }
        .main-content { flex: 1; padding: 2rem; }
        .section { display: none; }
        .section.active { display: block; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-control { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 0.8rem 1.5rem; background: var(--primary); color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: var(--dark); }
        .color-picker { width: 50px; height: 40px; padding: 0; border: none; cursor: pointer; }
        .event-list { margin-top: 1rem; }
        .event-item { background: white; padding: 1rem; margin-bottom: 0.5rem; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        .editor-toolbar { background: #f5f5f5; padding: 0.5rem; border: 1px solid #ddd; border-bottom: none; }
        .editor-toolbar button { padding: 0.5rem; margin-right: 0.2rem; cursor: pointer; }
        .editor-content { min-height: 200px; border: 1px solid #ddd; padding: 1rem; background: white; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h3>Dashboard Greppi</h3>
            <nav>
                <a href="?sezione=home" class="<?php echo $sezione === 'home' ? 'active' : ''; ?>">Home</a>
                <a href="?sezione=colori" class="<?php echo $sezione === 'colori' ? 'active' : ''; ?>">Colori Sito</a>
                <a href="?sezione=pagine" class="<?php echo $sezione === 'pagine' ? 'active' : ''; ?>">Pagine</a>
                <a href="?sezione=eventi" class="<?php echo $sezione === 'eventi' ? 'active' : ''; ?>">Eventi</a>
                <a href="?sezione=media" class="<?php echo $sezione === 'media' ? 'active' : ''; ?>">Media</a>
                <a href="backup.php" target="_blank">Backup</a>
                <a href="logout.php" style="color: #ff6b6b; margin-top: 2rem;">Esci</a>
            </nav>
        </div>

        <!-- Contenuto Principale -->
        <div class="main-content">
            <!-- Sezione Home -->
            <div id="home" class="section <?php echo $sezione === 'home' ? 'active' : ''; ?>">
                <h2>Impostazioni Home</h2>
                <div class="form-group">
                    <label>Titolo Hero:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($dati['pagine']['home']['titolo_hero']); ?>" id="home-titolo">
                </div>
                <div class="form-group">
                    <label>Descrizione Hero:</label>
                    <textarea class="form-control" rows="3" id="home-descrizione"><?php echo htmlspecialchars($dati['pagine']['home']['descrizione_hero']); ?></textarea>
                </div>
                <div class="form-group">
                    <label>ID Video Corri Greppi:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($dati['config']['video_corri_greppi']); ?>" id="video-corri">
                </div>
                <div class="form-group">
                    <label>ID Video Greppi Bike:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($dati['config']['video_greppi_bike']); ?>" id="video-bike">
                </div>
                <button class="btn" onclick="salvaHome()">Salva Modifiche</button>
            </div>

            <!-- Sezione Colori -->
            <div id="colori" class="section <?php echo $sezione === 'colori' ? 'active' : ''; ?>">
                <h2>Colori del Sito</h2>
                <p>Modifica i colori principali del sito. Le modifiche saranno visibili immediatamente.</p>
                
                <div class="form-group">
                    <label>Verde Primario:</label>
                    <input type="color" class="color-picker" value="<?php echo $dati['colori']['primary']; ?>" id="col-primary">
                </div>
                <div class="form-group">
                    <label>Verde Chiaro:</label>
                    <input type="color" class="color-picker" value="<?php echo $dati['colori']['primary_bright']; ?>" id="col-primary-bright">
                </div>
                <div class="form-group">
                    <label>Giallo Accent:</label>
                    <input type="color" class="color-picker" value="<?php echo $dati['colori']['accent']; ?>" id="col-accent">
                </div>
                <div class="form-group">
                    <label>Colore Scuro:</label>
                    <input type="color" class="color-picker" value="<?php echo $dati['colori']['dark']; ?>" id="col-dark">
                </div>
                <div class="form-group">
                    <label>Colore Chiaro:</label>
                    <input type="color" class="color-picker" value="<?php echo $dati['colori']['light']; ?>" id="col-light">
                </div>
                <button class="btn" onclick="salvaColori()">Salva Colori</button>
            </div>

            <!-- Sezione Pagine -->
            <div id="pagine" class="section <?php echo $sezione === 'pagine' ? 'active' : ''; ?>">
                <h2>Pagine Statiche</h2>
                <div class="form-group">
                    <label>Seleziona pagina:</label>
                    <select class="form-control" id="pagina-selezionata" onchange="caricaPagina()">
                        <option value="chi_siamo">Chi Siamo</option>
                        <option value="sponsor">Sponsor</option>
                        <option value="contatti">Contatti</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Titolo:</label>
                    <input type="text" class="form-control" id="pagina-titolo">
                </div>
                <div class="form-group">
                    <label>Contenuto:</label>
                    <div class="editor-toolbar">
                        <button onclick="execCmd('bold')"><b>B</b></button>
                        <button onclick="execCmd('italic')"><i>I</i></button>
                        <button onclick="execCmd('insertUnorderedList')">• Lista</button>
                        <button onclick="execCmd('insertOrderedList')">1. Lista</button>
                        <button onclick="insertLink()">Link</button>
                    </div>
                    <div class="editor-content" contenteditable="true" id="pagina-contenuto"></div>
                </div>
                <button class="btn" onclick="salvaPagina()">Salva Pagina</button>
            </div>

            <!-- Sezione Eventi -->
            <div id="eventi" class="section <?php echo $sezione === 'eventi' ? 'active' : ''; ?>">
                <h2>Gestione Eventi</h2>
                <div class="event-list">
                    <?php foreach ($dati['eventi'] as $evento): ?>
                    <div class="event-item">
                        <span><?php echo htmlspecialchars($evento['titolo']); ?></span>
                        <div>
                            <button class="btn" style="padding: 0.4rem 0.8rem; margin-right: 0.5rem;" onclick="modificaEvento('<?php echo $evento['id']; ?>')">Modifica</button>
                            <button class="btn" style="background: #ff6b6b; padding: 0.4rem 0.8rem;" onclick="eliminaEvento('<?php echo $evento['id']; ?>')">Elimina</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <button class="btn" onclick="nuovoEvento()" style="margin-top: 1rem;">Nuovo Evento</button>
                
                <!-- Form per modifica/creazione evento (nascosto per default) -->
                <div id="evento-form" style="display: none; margin-top: 2rem; background: white; padding: 1.5rem; border-radius: 8px;">
                    <h3 id="titolo-form-evento">Nuovo Evento</h3>
                    <input type="hidden" id="evento-id">
                    <div class="form-group">
                        <label>Titolo:</label>
                        <input type="text" class="form-control" id="evento-titolo">
                    </div>
                    <div class="form-group">
                        <label>Descrizione Breve:</label>
                        <input type="text" class="form-control" id="evento-descrizione">
                    </div>
                    <div class="form-group">
                        <label>Immagine Copertina:</label>
                        <input type="file" class="form-control" id="evento-immagine">
                    </div>
                    <div class="form-group">
                        <label>Contenuto Pagina:</label>
                        <div class="editor-toolbar">
                            <button onclick="execCmdEvento('bold')"><b>B</b></button>
                            <button onclick="execCmdEvento('italic')"><i>I</i></button>
                            <button onclick="execCmdEvento('insertUnorderedList')">• Lista</button>
                        </div>
                        <div class="editor-content" contenteditable="true" id="evento-contenuto"></div>
                    </div>
                    <div class="form-group">
                        <label>Data Evento:</label>
                        <input type="date" class="form-control" id="evento-data">
                    </div>
                    <button class="btn" onclick="salvaEvento()">Salva Evento</button>
                    <button class="btn" style="background: #6c757d;" onclick="chiudiFormEvento()">Annulla</button>
                </div>
            </div>

            <!-- Sezione Media -->
            <div id="media" class="section <?php echo $sezione === 'media' ? 'active' : ''; ?>">
                <h2>Media</h2>
                <div class="form-group">
                    <label>Carica Logo Sito:</label>
                    <input type="file" class="form-control" id="upload-logo" accept="image/*">
                    <button class="btn" onclick="uploadLogo()" style="margin-top: 0.5rem;">Carica Logo</button>
                </div>
                <div class="form-group">
                    <label>Carica Immagine per Evento/Pagina:</label>
                    <input type="file" class="form-control" id="upload-generico" accept="image/*">
                    <button class="btn" onclick="uploadGenerico()" style="margin-top: 0.5rem;">Carica Immagine</button>
                </div>
                <div id="upload-status"></div>
            </div>
        </div>
    </div>

    <script>
        // Funzioni base per la dashboard
        function execCmd(command) {
            document.execCommand(command, false, null);
        }
        
        function insertLink() {
            var url = prompt('Inserisci l\'URL:');
            if (url) document.execCommand('createLink', false, url);
        }

        // Funzioni di salvataggio
        async function salvaHome() {
            const dati = {
                pagine: {
                    home: {
                        titolo_hero: document.getElementById('home-titolo').value,
                        descrizione_hero: document.getElementById('home-descrizione').value
                    }
                },
                config: {
                    video_corri_greppi: document.getElementById('video-corri').value,
                    video_greppi_bike: document.getElementById('video-bike').value
                }
            };
            await salvaDati(dati);
        }

        async function salvaColori() {
            const dati = {
                colori: {
                    primary: document.getElementById('col-primary').value,
                    primary_bright: document.getElementById('col-primary-bright').value,
                    accent: document.getElementById('col-accent').value,
                    dark: document.getElementById('col-dark').value,
                    light: document.getElementById('col-light').value
                }
            };
            await salvaDati(dati);
        }

        async function salvaDati(nuoviDati) {
            try {
                const response = await fetch('save.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify(nuoviDati)
                });
                const result = await response.json();
                if (result.success) {
                    alert('Modifiche salvate con successo!');
                    location.reload();
                } else {
                    alert('Errore: ' + result.error);
                }
            } catch (error) {
                alert('Errore di connessione');
            }
        }

        // Funzioni per le pagine
        function caricaPagina() {
            const pagina = document.getElementById('pagina-selezionata').value;
            // Qui dovresti caricare i dati della pagina selezionata
            // Per ora mostriamo un messaggio
            document.getElementById('pagina-titolo').value = 'Titolo ' + pagina;
            document.getElementById('pagina-contenuto').innerHTML = '<p>Contenuto di ' + pagina + '</p>';
        }

        // Funzioni per gli eventi
        function nuovoEvento() {
            document.getElementById('evento-form').style.display = 'block';
            document.getElementById('titolo-form-evento').textContent = 'Nuovo Evento';
            // Reset form
            document.getElementById('evento-id').value = '';
            document.getElementById('evento-titolo').value = '';
            document.getElementById('evento-descrizione').value = '';
            document.getElementById('evento-contenuto').innerHTML = '';
            document.getElementById('evento-data').value = '';
        }

        function modificaEvento(id) {
            // Qui dovresti caricare i dati dell'evento
            document.getElementById('evento-form').style.display = 'block';
            document.getElementById('titolo-form-evento').textContent = 'Modifica Evento';
            document.getElementById('evento-id').value = id;
            // Esempio: popolare i campi con i dati dell'evento
        }

        function chiudiFormEvento() {
            document.getElementById('evento-form').style.display = 'none';
        }

        async function uploadLogo() {
            const file = document.getElementById('upload-logo').files[0];
            if (!file) return alert('Seleziona un file');
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', 'logo');
            
            try {
                const response = await fetch('upload.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    alert('Logo caricato: ' + result.path);
                    // Aggiorna il logo nel sito (opzionale)
                } else {
                    alert('Errore: ' + result.error);
                }
            } catch (error) {
                alert('Errore caricamento');
            }
        }

        async function uploadGenerico() {
            const file = document.getElementById('upload-generico').files[0];
            if (!file) return alert('Seleziona un file');
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', 'generic');
            
            try {
                const response = await fetch('upload.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.success) {
                    alert('Immagine caricata: ' + result.path);
                    // Copia il percorso negli appunti
                    navigator.clipboard.writeText(result.path);
                } else {
                    alert('Errore: ' + result.error);
                }
            } catch (error) {
                alert('Errore caricamento');
            }
        }
    </script>
</body>
</html>