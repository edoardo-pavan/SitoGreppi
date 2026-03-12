/* Editor WYSIWYG Personalizzato */
document.addEventListener('DOMContentLoaded', function() {
    // Seleziona tutti gli editor contenteditable
    const editors = document.querySelectorAll('.editor-content');
    
    editors.forEach(editor => {
        // Aggiungi listener per la selezione del testo
        editor.addEventListener('mouseup', updateToolbarPosition);
        editor.addEventListener('keyup', updateToolbarPosition);
        
        // Aggiungi listener per il blur (nascondi toolbar)
        editor.addEventListener('blur', function() {
            setTimeout(() => {
                if (!document.querySelector('.editor-toolbar:focus')) {
                    hideToolbar();
                }
            }, 200);
        });
    });

    // Crea la toolbar flottante (se non esiste già)
    if (!document.getElementById('floating-toolbar')) {
        const toolbar = document.createElement('div');
        toolbar.id = 'floating-toolbar';
        toolbar.className = 'editor-toolbar-floating';
        toolbar.style.display = 'none';
        toolbar.innerHTML = `
            <button onclick="execCmd('bold')" title="Grassetto"><b>B</b></button>
            <button onclick="execCmd('italic')" title="Corsivo"><i>I</i></button>
            <button onclick="execCmd('underline')" title="Sottolineato"><u>U</u></button>
            <button onclick="execCmd('strikeThrough')" title="Barrato"><s>S</s></button>
            <span style="border-left: 1px solid #ccc; margin: 0 5px;"></span>
            <button onclick="execCmd('insertUnorderedList')" title="Lista puntata">• Lista</button>
            <button onclick="execCmd('insertOrderedList')" title="Lista numerata">1. Lista</button>
            <span style="border-left: 1px solid #ccc; margin: 0 5px;"></span>
            <button onclick="insertLink()" title="Inserisci Link">Link</button>
            <button onclick="insertImage()" title="Inserisci Immagine">IMG</button>
        `;
        document.body.appendChild(toolbar);
        
        // Applica stili CSS inline per la toolbar flottante
        toolbar.style.cssText = `
            position: fixed;
            background: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 10000;
            display: none;
        `;
        
        // Stile per i bottoni
        const buttons = toolbar.querySelectorAll('button');
        buttons.forEach(btn => {
            btn.style.cssText = `
                background: none;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                font-size: 14px;
            `;
            btn.onmouseover = function() { this.style.background = '#f0f0f0'; };
            btn.onmouseout = function() { this.style.background = 'none'; };
        });
    }
});

// Funzioni globali per l'editor
function execCmd(command) {
    document.execCommand(command, false, null);
    // Riporta il focus all'editor attivo
    const selection = window.getSelection();
    if (selection.rangeCount > 0) {
        selection.getRangeAt(0).collapse(false);
    }
}

function insertLink() {
    const url = prompt('Inserisci l\'URL del link:');
    if (url) {
        document.execCommand('createLink', false, url);
    }
}

function insertImage() {
    // Trova l'editor attivo (il contenitore della selezione attuale)
    const selection = window.getSelection();
    if (!selection.rangeCount) return;
    
    const range = selection.getRangeAt(0);
    let editor = range.commonAncestorContainer;
    while (editor && !editor.classList?.contains('editor-content')) {
        editor = editor.parentNode;
    }
    
    if (!editor) {
        alert('Per favore, seleziona il testo prima di inserire un\'immagine.');
        return;
    }
    
    // Crea un input file nascosto
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            uploadAndInsertImage(file, editor);
        }
    };
    input.click();
}

function uploadAndInsertImage(file, editor) {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('type', 'editor'); // Tipo specifico per immagini nell'editor
    
    // Mostra indicatore di caricamento
    const originalText = editor.innerHTML;
    editor.innerHTML += '<div style="color: blue;">Caricamento immagine...</div>';
    
    fetch('admin/upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Rimuovi indicatore di caricamento
        const loading = editor.querySelector('div:last-child');
        if (loading) loading.remove();
        
        if (data.success) {
            // Inserisci l'immagine nel punto del cursore
            const img = document.createElement('img');
            img.src = data.path;
            img.alt = file.name;
            img.style.maxWidth = '100%';
            
            // Inserisci l'immagine nel punto del cursore
            const selection = window.getSelection();
            if (selection.rangeCount > 0) {
                const range = selection.getRangeAt(0);
                range.insertNode(img);
                // Sposta il cursore dopo l'immagine
                range.setStartAfter(img);
                range.setEndAfter(img);
                selection.removeAllRanges();
                selection.addRange(range);
            } else {
                editor.appendChild(img);
            }
        } else {
            alert('Errore upload: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Errore di connessione durante l\'upload');
        // Ripristina contenuto originale
        editor.innerHTML = originalText;
    });
}

function updateToolbarPosition() {
    const selection = window.getSelection();
    const toolbar = document.getElementById('floating-toolbar');
    
    if (!selection.rangeCount || selection.isCollapsed) {
        toolbar.style.display = 'none';
        return;
    }
    
    // Controlla se la selezione è dentro un editor contenteditable
    let container = selection.anchorNode;
    while (container && container.nodeType === 3) {
        container = container.parentNode;
    }
    
    const inEditor = container && (container.classList?.contains('editor-content') || 
                                   container.closest?.('.editor-content'));
    
    if (!inEditor) {
        toolbar.style.display = 'none';
        return;
    }
    
    const range = selection.getRangeAt(0);
    const rect = range.getBoundingClientRect();
    
    if (rect.width === 0 && rect.height === 0) {
        toolbar.style.display = 'none';
        return;
    }
    
    toolbar.style.display = 'block';
    toolbar.style.left = (rect.left + rect.width / 2 - toolbar.offsetWidth / 2) + 'px';
    toolbar.style.top = (rect.top - toolbar.offsetHeight - 5 + window.scrollY) + 'px';
}

function hideToolbar() {
    const toolbar = document.getElementById('floating-toolbar');
    if (toolbar) toolbar.style.display = 'none';
}