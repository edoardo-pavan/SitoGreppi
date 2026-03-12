# Sito Web Comitato Sportivo Greppi - Gestione Dinamica

Questo repository contiene il codice sorgente del sito web del Comitato Sportivo Studentesco dell'I.I.S.S. Alessandro Greppi, con un sistema di gestione contenuti (CMS) personalizzato.

## Caratteristiche

- **Sito Dinamico**: Tutte le pagine sono generate dinamicamente da un file JSON (`dati.json`).
- **Dashboard di Amministrazione**: Interfaccia protetta per modificare contenuti, colori, eventi e immagini.
- **Gestione Eventi**: Creazione, modifica ed eliminazione di eventi con pagine dedicate.
- **Editor WYSIWYG**: Barra flottante per formattare testo e inserire immagini.
- **Backup Automatico**: Generazione di ZIP con dati e immagini utilizzate.

## Struttura delle Cartelle

```
/
├── index.php               # Home dinamica
├── chi-siamo.php           # Chi Siamo dinamico
├── sponsor.php             # Sponsor dinamico
├── contatti.php            # Contatti dinamico
├── evento.php              # Template pagine evento
├── dati.json               # Database del sito (contenuti, colori, password)
├── .htaccess               # Configurazione server e sicurezza
├── PIANO.MD                # Piano di implementazione
├── README.md               # Questo file
│
├── admin/                  # Dashboard amministrazione
│   ├── index.php           # Redirect login/dashboard
│   ├── login.php           # Pagina autenticazione
│   ├── dashboard.php       # Interfaccia principale
│   ├── upload.php          # Gestione upload immagini
│   ├── save.php            # Salvataggio dati
│   ├── backup.php          # Generazione backup ZIP
│   └── logout.php          # Logout
│
├── assets/
│   ├── css/
│   │   ├── style.css       # Stili base del sito
│   │   └── dynamic.css.php # CSS generato dai colori dinamici
│   ├── js/
│   │   ├── main.js         # Funzionalità sito (menu mobile, etc.)
│   │   └── editor.js       # Editor WYSIWYG
│   └── img/
│       └── uploads/        # Immagini caricate (logo, eventi)
```

## Installazione e Configurazione

### 1. Requisiti
- Server web con PHP 7.0 o superiore
- Supporto per `.htaccess` (Apache)
- Permesso di scrittura sulla cartella `assets/img/uploads/`

### 2. Configurazione Iniziale
1. Caricare tutti i file sul server (es. via FTP).
2. Assicurarsi che la cartella `assets/img/uploads/` abbia permessi di scrittura (755 o 775).
3. Configurare il file `dati.json` con i contenuti iniziali (se non presente, crearlo con la struttura in `PIANO.MD`).

### 3. Primo Accesso alla Dashboard
1. Accedere all'URL: `www.dominio.com/admin`
2. Username fisso: `admin`
3. Password iniziale: impostare nel file `dati.json` sotto `config.password_admin` come hash bcrypt.
   - Per generare un hash bcrypt, usare un tool online o un semplice script PHP:
     ```php
     echo password_hash('tuapassword', PASSWORD_BCRYPT);
     ```
4. Copiare l'hash nel campo `password_admin` di `dati.json`.

## Utilizzo della Dashboard

### Autenticazione
- URL: `/admin`
- Username: `admin` (fisso)
- Password: modificabile dalla dashboard

### Sezioni Disponibili
1. **Home**: Modifica titolo, descrizione e link video YouTube.
2. **Colori Sito**: Selettori colore per personalizzare il tema.
3. **Pagine**: Editor WYSIWYG per Chi Siamo, Sponsor, Contatti.
4. **Eventi**: Gestione completa degli eventi (creazione, modifica, eliminazione).
5. **Media**: Upload immagini (logo, copertine eventi).
6. **Backup**: Download ZIP con dati e immagini utilizzate.

### Editor WYSIWYG
- **Barra flottante**: Appare quando si seleziona testo.
- **Funzionalità**: Grassetto, corsivo, sottolineato, elenchi, link, immagini.
- **Upload immagini**: Cliccare sull'icona "IMG" per caricare un'immagine (viene inserita nel punto del cursore).

## Sicurezza

### Protezione Cartella Admin
Il file `.htaccess` blocca l'accesso diretto ai file sensibili nella cartella `admin/`. L'accesso è consentito solo tramite autenticazione PHP.

### Password
La password è memorizzata come hash bcrypt nel file `dati.json`. Non è visibile in chiaro.

### Upload Immagini
- Solo immagini sono permesse (jpg, jpeg, png, gif, webp).
- Nessun limite di dimensione (configurato in `.htaccess`).
- I file sono salvati in `assets/img/uploads/` con nomi univoci.

## Backup

La funzione "Backup" nella dashboard genera un file ZIP contenente:
- Il file `dati.json` (tutti i dati del sito).
- Le immagini utilizzate (logo, copertine eventi, immagini inline).

## Deploy su Aruba Easy

1. **Caricamento File**:
   - Usa il client FTP di Aruba o il file manager.
   - Carica tutti i file e cartelle, mantenendo la struttura.

2. **Permessi**:
   - Cartelle: 755
   - File: 644
   - `assets/img/uploads/`: 755 o 775 (per permettere scrittura)

3. **Configurazione PHP**:
   - Se necessario, modifica `php.ini` per aumentare `upload_max_filesize` e `post_max_size`.

4. **Test**:
   - Accedi al sito e verifica che tutte le pagine funzionino.
   - Accedi alla dashboard `/admin` e testa login, modifica contenuti, upload immagini, backup.

## Risoluzione Problemi

### Errore "File dati.json non trovato"
- Assicurati che il file `dati.json` esista nella root del sito.

### Errore permessi upload
- Verifica che la cartella `assets/img/uploads/` abbia permessi di scrittura.

### Dashboard non accessibile
- Verifica che `.htaccess` sia presente e configurato correttamente.
- Controlla che la sessione PHP funzioni (cookies abilitati nel browser).

## Aggiornamenti Futuri
- Aggiungere più utenti admin.
- Implementare ricerca eventi.
- Aggiungere gestione categorie eventi.

## Supporto
Per problemi o domande, contattare l'amministratore del sito.