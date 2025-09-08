document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("modoToggle");
    if (!toggle) return;

    // Activar toggle si el body tiene clase dark-mode
    if (document.body.classList.contains("dark-mode")) {
        toggle.checked = true;
    }

    toggle.addEventListener("change", () => {
        const tema = toggle.checked ? "dark" : "light";
        document.body.classList.toggle("dark-mode", tema === "dark");

        // Cambiar label también
        const label = toggle.nextElementSibling;
        if(label) label.textContent = tema === "dark" ? "Oscuro" : "Claro";

        // Guardar tema vía AJAX
        fetch("includes/guardar_tema.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "tema=" + tema
        });
    });
});
