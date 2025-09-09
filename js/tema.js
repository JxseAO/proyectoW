document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("modoToggle");
    if (!toggle) return;

    // Inicializar toggle según el estado actual del body
    const isDark = document.body.classList.contains("dark-mode");
    toggle.checked = isDark;

    // Cambiar label automáticamente
    const updateLabel = () => {
        const label = toggle.nextElementSibling;
        if (label) label.textContent = toggle.checked ? "Oscuro" : "Claro";
    };
    updateLabel();

    // Manejar cambio de toggle
    toggle.addEventListener("change", () => {
        document.body.classList.toggle("dark-mode", toggle.checked);
        updateLabel();

        // Guardar tema del usuario vía AJAX
        fetch("includes/guardar_tema.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "tema=" + (toggle.checked ? "dark" : "light")
        });

        // Opcional: actualizar calendario en tiempo real si existe
        if (typeof actualizarCalendario === "function") {
            actualizarCalendario(toggle.checked);
        }
    });
});
