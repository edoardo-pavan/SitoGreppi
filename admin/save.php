<?php
// admin/save.php - Salva dati nel file JSON
session_start();

// Verifica autenticazione
if (!isset($_SESSION['autenticato']) || $_SESSION['autenticato'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autenticato']);
    exit();
}

// Leggi i dati attuali
$dati_file = '../dati.json';
if (!file_exists($dati_file)) {
    http_response_code(500);
    echo json_encode(['error' => 'File dati non trovato']);
    exit();
}

$dati = json_decode(file_get_contents($dati_file), true);

// Ricevi i nuovi dati dal POST
$nuovi_dati = json_decode(file_get_contents('php://input'), true);

if (!$nuovi_dati) {
    http_response_code(400);
    echo json_encode(['error' => 'Dati non validi']);
    exit();
}

// Aggiorna i dati (qui puoi aggiungere validazioni)
$dati = array_merge($dati, $nuovi_dati);

// Salva il file
if (file_put_contents($dati_file, json_encode($dati, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Dati salvati correttamente']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Impossibile salvare i dati']);
}
?>