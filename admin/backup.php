<?php
// admin/backup.php - Generazione backup ZIP
session_start();

// Verifica autenticazione
if (!isset($_SESSION['autenticato']) || $_SESSION['autenticato'] !== true) {
    die('Accesso negato. <a href="login.php">Login</a>');
}

// Carica i dati del sito
$dati_file = '../dati.json';
if (!file_exists($dati_file)) {
    die('File dati non trovato.');
}

$dati = json_decode(file_get_contents($dati_file), true);

// Crea ZIP
$zip = new ZipArchive();
$zip_name = 'backup_greppi_' . date('Ymd_His') . '.zip';
$zip_path = sys_get_temp_dir() . '/' . $zip_name;

if ($zip->open($zip_path, ZipArchive::CREATE) !== TRUE) {
    die('Impossibile creare il file ZIP.');
}

// Aggiungi dati.json
$zip->addFile($dati_file, 'dati.json');

// Aggiungi immagini utilizzate
$immagini_usate = [];

// Logo
if (isset($dati['config']['logo'])) {
    $immagini_usate[] = '../' . $dati['config']['logo'];
}

// Immagini eventi
foreach ($dati['eventi'] as $evento) {
    if (isset($evento['immagine'])) {
        $immagini_usate[] = '../' . $evento['immagine'];
    }
}

// Aggiungi immagini uniche al ZIP
$immagini_aggiunte = [];
foreach ($immagini_usate as $img_path) {
    if (file_exists($img_path) && !in_array($img_path, $immagini_aggiunte)) {
        $zip->addFile($img_path, 'immagini/' . basename($img_path));
        $immagini_aggiunte[] = $img_path;
    }
}

$zip->close();

// Invia il file al browser
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zip_name . '"');
header('Content-Length: ' . filesize($zip_path));

readfile($zip_path);

// Elimina file temporaneo
unlink($zip_path);
exit();
?>