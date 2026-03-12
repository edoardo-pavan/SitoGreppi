<?php
// Genera CSS dinamico basato sui colori in dati.json
header('Content-Type: text/css');

$dati_file = '../../dati.json';
if (file_exists($dati_file)) {
    $dati = json_decode(file_get_contents($dati_file), true);
    $colori = $dati['colori'] ?? [];
    
    echo ":root {\n";
    echo "  --primary: " . ($colori['primary'] ?? '#2d7a3a') . ";\n";
    echo "  --primary-bright: " . ($colori['primary_bright'] ?? '#4ade80') . ";\n";
    echo "  --accent: " . ($colori['accent'] ?? '#facc15') . ";\n";
    echo "  --dark: " . ($colori['dark'] ?? '#121212') . ";\n";
    echo "  --light: " . ($colori['light'] ?? '#ffffff') . ";\n";
    echo "}\n";
} else {
    // Colori default
    echo ":root {\n";
    echo "  --primary: #2d7a3a;\n";
    echo "  --primary-bright: #4ade80;\n";
    echo "  --accent: #facc15;\n";
    echo "  --dark: #121212;\n";
    echo "  --light: #ffffff;\n";
    echo "}\n";
}
?>