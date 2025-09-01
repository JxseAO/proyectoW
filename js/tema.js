const toggle = document.getElementById('modoToggle');

toggle.addEventListener('change', () => {
    const modo = toggle.checked ? 'dark' : 'light';
    document.body.classList.toggle('dark-mode', toggle.checked);

    // Guardar preferencia por usuario en BD
    fetch('../includes/guardar_tema.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `tema=${modo}`
    });
});

// Aplicar tema al cargar la página según la variable PHP
if('<?= $tema ?>' === 'dark'){
    document.body.classList.add('dark-mode');
    toggle.checked = true;
}
