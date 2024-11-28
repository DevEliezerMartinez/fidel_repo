document.addEventListener("DOMContentLoaded", function () {
    // Obtener los elementos de los botones
    const ajustesButton = document.getElementById("ajustes");
    const configButton = document.getElementById("config");
    const inputUbicacion = document.getElementById("ubicacion");
    const opciones = document.querySelectorAll(".botton_option");

    // Manejo de errores para los botones principales
    function checkButtons() {
        if (!ajustesButton) {
            console.error("El botón de ajustes no se encontró en el DOM.");
        }

        if (!configButton) {
            console.error(
                "El botón de configuración no se encontró en el DOM."
            );
        }
    }

    // Función para mostrar u ocultar las opciones de ajustes
    function toggleAjustes() {
        const minimodaloptions =
            document.getElementsByClassName("options_ajustes")[0];

        if (!minimodaloptions) {
            console.error("No se encontraron opciones de ajustes.");
            return;
        }

        // Alternar la clase 'flex' y el estilo display
        if (minimodaloptions.classList.contains("flex")) {
            minimodaloptions.classList.remove("flex");
            minimodaloptions.style.display = "none";
        } else {
            minimodaloptions.classList.add("flex");
            minimodaloptions.style.display = "flex";
        }
        console.log("Estado de opciones de ajustes actualizado.");
    }

    // Función para mostrar u ocultar el menú de configuración
    function toggleConfig() {
        const menu_config =
            document.getElementsByClassName("options_config")[0];

        // Elimina la clase si ya existe
        configButton.classList.remove("animation_gear");

        // Usa un pequeño retraso para asegurar que la animación se reinicie
        setTimeout(() => {
            configButton.classList.add("animation_gear");
        }, 10); // 10ms son suficientes para reiniciar la animación

        if (!menu_config) {
            console.error("No se encontraron opciones de configuración.");
            return;
        }

        // Alternar la clase 'flex' y el estilo display
        if (menu_config.classList.contains("flex")) {
            menu_config.classList.remove("flex");
            menu_config.style.display = "none";
        } else {
            menu_config.classList.add("flex");
            menu_config.style.display = "flex";
        }
    }

    // Asignar evento de clic al botón de ajustes
    if (ajustesButton) {
        ajustesButton.addEventListener("click", toggleAjustes);
    }

    // Asignar evento de clic al botón de configuración
    if (configButton) {
        configButton.addEventListener("click", toggleConfig);
    }

    // Función para manejar la selección de opciones en el menú de configuración
    function handleOptionSelection() {
        opciones.forEach((opcion) => {
            opcion.addEventListener("click", function () {
                const ubicacion = opcion.getAttribute("data-ubicacion");
                inputUbicacion.value = ubicacion; // Asigna el valor al input

                // Quitar clase 'options_config_active' de todas las opciones
                opciones.forEach((opt) =>
                    opt.classList.remove("options_config_active")
                );
                opcion.classList.add("options_config_active");

                // Cerrar el menú de configuración
                toggleConfig();
            });
        });
    }

    // Ejecutar las comprobaciones de error y asignar eventos
    checkButtons();
    handleOptionSelection();
});
