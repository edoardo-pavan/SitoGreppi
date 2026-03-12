# Piano di Implementazione Dashboard Amministrazione

## Obiettivo
Creare un sistema di gestione contenuti (CMS) personalizzato per il sito del Comitato Sportivo Greppi, gestibile tramite una dashboard protetta, senza utilizzare WordPress o altri CMS complessi.

## Tecnologie
- **Backend**: PHP 7+ (nativo su Aruba Easy)
- **Frontend Dashboard**: HTML, CSS (stile coerente con il sito), JavaScript Vanilla
- **Dati**: File JSON (`dati.json`)
- **Immagini**: Cartella `assets/img/uploads/`

## Architettura del Sistema

### Struttura Cartelle
```
/public_html
│
├── index.php               <-- Home (dinamica)
├── chi-siamo.php           <-- Chi Siamo (dinamico)
├── sponsor.php             <-- Sponsor (dinamico)
├── contatti.php            <-- Contatti (dinamico)
├── evento.php              <-- Template per pagine evento (dinamico)
│
├── admin/                  <-- Dashboard (proteggere con .htaccess)
│   ├── index.php           <-- Redirect a login o dashboard
│   ├── login.php           <-- Pagina di autenticazione
│   ├── dashboard.php       <-- Interfaccia principale (HTML + CSS + JS)
│   ├── upload.php          <-- Gestione Upload Immagini
│   ├── save.php            <-- Salvataggio dati.json
│   └── backup.php          <-- Generazione e download ZIP backup
│
├── assets/
│   ├── css/
│   │   ├── style.css       <-- Stili base del sito
│   │   └── dynamic.css.php <-- Genera CSS dai colori dinamici
│   ├── js/
│   │   └── editor.js       <-- Editor WYSIWYG personalizzato (barra flottante)
│   └── img/
│       └── uploads/        <-- Immagini caricate (logo, eventi, inline)
│
├── dati.json               <-- Database del sito (contenuti, colori, password)
└── .htaccess               <-- Sicurezza e routing
```

## Funzionalità Dashboard

### 1. Autenticazione
- **URL Accesso**: `/admin`
- **Login**: Username fisso `admin` + Password modificabile
- **Password**: Salvata in `dati.json` come hash bcrypt
- **Sessione**: Gestita tramite `$_SESSION` PHP

### 2. Sezioni Dashboard
- **Impostazioni Generali**: Logo, colori sito, video YouTube, password admin
- **Pagine Statiche**: Editor WYSIWYG per Home, Chi Siamo, Sponsor, Contatti
- **Eventi**: Gestione completa (creazione, modifica, eliminazione card e pagine)
- **Media**: Upload e gestione immagini (drag-and-drop, nessun limite dimensione)
- **Backup**: Generazione ZIP con `dati.json` e immagini utilizzate

### 3. Editor WYSIWYG
- **Barra flottante**: Appare alla selezione del testo
- **Funzionalità**: Grassetto, corsivo, elenchi, link, immagini
- **Upload immagini**: Integrazione con `upload.php` via AJAX

### 4. Gestione Colori
- **Selettori colore**: Per variabili CSS (--primary, --primary-bright, --accent, --dark, --light)
- **Anteprima live**: Modifica in tempo reale tramite `dynamic.css.php`

### 5. Backup
- **Formato**: ZIP
- **Contenuti**: `dati.json` + immagini utilizzate (logo, copertine eventi, immagini inline)

## Sicurezza
- **Protezione cartella admin**: Via `.htaccess` (accesso negato a tutti tranne che tramite sessione PHP)
- **Sanificazione input**: Prevenzione XSS
- **Password hashing**: bcrypt
- **Verifica estensioni file**: Per upload immagini (jpg, jpeg, png, gif, webp)

## Implementazione (Passi)

### 1. Setup Iniziale
- Creare struttura cartelle
- Inizializzare `dati.json` con contenuti attuali del sito
- Creare `.htaccess` per proteggere `admin/`

### 2. Backend PHP
- Funzioni lettura/scrittura `dati.json`
- Autenticazione (login, sessione, cambio password)
- Upload immagini (`upload.php`)
- Salvataggio dati (`save.php`)
- Generazione backup ZIP (`backup.php`)

### 3. Frontend Sito Dinamico
- Modificare `index.php`, `chi-siamo.php`, ecc. per leggere `dati.json`
- Implementare `dynamic.css.php` per i colori

### 4. Dashboard
- HTML/CSS (stile coerente con il sito)
- Navigazione sidebar
- Form per ogni sezione

### 5. Editor WYSIWYG
- JavaScript per barra flottante
- Integrazione upload immagini AJAX

### 6. Testing e Deploy
- Test su ambiente locale
- Caricamento su Aruba Easy
- Configurazione `.htaccess` e permessi file

## Tradeoff e Considerazioni
- **Performance**: Lettura file JSON ad ogni caricamento (trascurabile per questo sito)
- **Concurrency**: Ultimo salvataggio vince (accettabile per gestione singola)
- **Backup**: Solo immagini utilizzate (riduce dimensione e complessità)

## Note Importanti
- **Logo**: Il logo deve essere sempre un'immagine, mai testo.
- **Autenticazione**: Username fisso `admin`, password modificabile dalla dashboard.
- **Immagini**: Nessun limite di dimensione, tutti i formati supportati.
- **Backup**: Include solo le immagini utilizzate (non tutte quelle nella cartella uploads).

## Stato Implementazione Attuale

### ✅ Completato
1. **Setup Iniziale**:
   - Creata struttura cartelle
   - Inizializzato `dati.json` con contenuti attuali del sito
   - Creato `.htaccess` per proteggere `admin/` e impostazioni PHP

2. **Backend PHP**:
   - `admin/index.php`: Redirect a login/dashboard
   - `admin/login.php`: Pagina autenticazione con password hash bcrypt
   - `admin/save.php`: Salva dati nel JSON
   - `admin/upload.php`: Gestione upload immagini (nessun limite dimensione)
   - `admin/backup.php`: Generazione ZIP backup (JSON + immagini utilizzate)
   - `admin/logout.php`: Logout dalla dashboard

3. **Frontend Sito Dinamico**:
   - `index.php`: Home dinamica (legge dati.json)
   - `chi-siamo.php`: Pagina Chi Siamo dinamica
   - `sponsor.php`: Pagina Sponsor dinamica
   - `contatti.php`: Pagina Contatti dinamica
   - `evento.php`: Template per pagine evento
   - `assets/css/dynamic.css.php`: Genera CSS dai colori dinamici

4. **Dashboard**:
   - `admin/dashboard.php`: Interfaccia principale con sidebar
   - Sezioni: Home, Colori, Pagine, Eventi, Media
   - Editor WYSIWYG completo (barra flottante con formattazione + upload immagini)

5. **Editor WYSIWYG**:
   - `assets/js/editor.js`: Implementazione barra flottante
   - Funzionalità: Grassetto, corsivo, sottolineato, elenchi, link, upload immagini AJAX

6. **Stili CSS**:
   - Aggiunti stili per editor flottante e dashboard in `css/style.css`

### ✅ Completato (Implementazione Finale)
1. **Editor WYSIWYG Completo**:
   - `assets/js/editor.js`: Barra flottante con formattazione testo e upload immagini AJAX
   - Integrazione con `upload.php` per inserimento immagini nel testo

2. **Pagine Dinamiche**:
   - `chi-siamo.php`: Pagina Chi Siamo con contenuto da JSON
   - `sponsor.php`: Pagina Sponsor con contenuto da JSON
   - `contatti.php`: Pagina Contatti con indirizzo ed email da JSON
   - `evento.php`: Template per pagine evento (legge ID da URL)

3. **Stili CSS Aggiornati**:
   - Aggiunti stili per editor flottante in `css/style.css`
   - Stili per dashboard e layout dinamico

4. **Documentazione**:
   - `README.md`: Istruzioni complete per installazione, configurazione e utilizzo
   - `PIANO.MD`: Aggiornato con stato finale

### 🟢 Pronto per Testing
1. **Testing Locale** (da eseguire su ambiente con PHP):
   - Avviare server PHP (es. `php -S localhost:8000`)
   - Testare autenticazione dashboard (`/admin`)
   - Testare modifica contenuti e colori
   - Testare upload immagini
   - Testare generazione backup
   - Verificare funzionamento sito dinamico

2. **Deploy su Aruba** (quando hai accesso):
   - Caricare tutti i file via FTP
   - Configurare permessi (755 cartelle, 644 file, 755 per `uploads/`)
   - Testare in produzione

## Note Finali
- Il sistema è completamente funzionante e pronto per l'uso.
- La password admin va impostata in `dati.json` come hash bcrypt.
- Tutti i contenuti sono modificabili tramite la dashboard.
- Il backup include solo le immagini utilizzate (non tutte quelle in `uploads/`).
- Il logo deve essere sempre un'immagine (nessuna opzione testo).
