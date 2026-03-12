<?php
// admin/upload.php - Gestione upload immagini
session_start();

// Verifica autenticazione
if (!isset($_SESSION['autenticato']) || $_SESSION['autenticato'] !== true) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autenticato']);
    exit();
}

// Cartella di destinazione
$upload_dir = '../assets/img/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Gestione file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $type = $_POST['type'] ?? 'generic';
    
    // Verifica errori
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'Errore upload: ' . $file['error']]);
        exit();
    }
    
    // Genera nome univoco
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $upload_dir . $filename;
    
    // Sposta il file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $relative_path = 'assets/img/uploads/' . $filename;
        
        // Se è un logo, aggiorna il JSON
        if ($type === 'logo') {
            $dati_file = '../dati.json';
            if (file_exists($dati_file)) {
                $dati = json_decode(file_get_contents($dati_file), true);
                $dati['config']['logo'] = $relative_path;
                file_put_contents($dati_file, json_encode($dati, JSON_PRETTY_PRINT));
            }
        }
        
        echo json_encode(['success' => true, 'path' => $relative_path]);
    } else {
        echo json_encode(['error' => 'Impossibile salvare il file']);
    }
} else {
    echo json_encode(['error' => 'Nessun file ricevuto']);
}
?>