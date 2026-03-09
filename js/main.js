/* js/main.js */
document.addEventListener('DOMContentLoaded', () => {
    
    // --- Mobile Menu Toggle ---
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');

    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            // Cambia l'icona da hamburger a X
            menuToggle.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
        });
    }

    // --- ScrollSpy per le pagine evento ---
    // Evidenzia il link della sezione visibile nella navbar secondaria
    const sections = document.querySelectorAll('.event-section, .hero');
    const navItems = document.querySelectorAll('.event-nav a');

    window.addEventListener('scroll', () => {
        let current = "";
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            // Se lo scroll è oltre l'inizio della sezione (meno un offset di 150px)
            if (pageYOffset >= (sectionTop - 150)) {
                current = section.getAttribute('id');
            }
        });

        navItems.forEach(item => {
            item.style.textDecoration = "none";
            item.style.fontWeight = "500";
            if (item.getAttribute('href').includes(current)) {
                item.style.textDecoration = "underline";
                item.style.fontWeight = "bold";
            }
        });
    });

    // --- Chiusura menu mobile al click sui link ---
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('active');
            if(menuToggle) menuToggle.textContent = '☰';
        });
    });
});