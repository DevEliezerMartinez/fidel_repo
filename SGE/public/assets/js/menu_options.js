document.addEventListener("DOMContentLoaded", function () {
    // Obtener el elemento con el id 'ajustes' y 'config'
    const ajustesButton = document.getElementById("ajustes");
    const configButton = document.getElementById("config");

    if (!ajustesButton) {
        console.error("El botón de ajustes no se encontró en el DOM.");
    }

    if (!configButton) {
        console.error("El botón de configuración no se encontró en el DOM.");
    } else {
        console.log("Importación de menú de opciones.");

        // Añadir el event listener para detectar clics en el botón de ajustes
        ajustesButton.addEventListener("click", function () {
            const minimodaloptions =
                document.getElementsByClassName("options_ajustes")[0];

            // Asegúrate de que el elemento con la clase 'options_ajustes' existe
            if (!minimodaloptions) {
                console.error("No se encontraron opciones de ajustes.");
                return;
            }

            // Alternar la clase 'flex' para mostrar u ocultar
            if (minimodaloptions.classList.contains("flex")) {
                // Si la clase 'flex' está presente, la eliminamos y volvemos a display: none
                minimodaloptions.classList.remove("flex");
                minimodaloptions.style.display = "none";
            } else {
                // Si no tiene la clase 'flex', la añadimos y cambiamos a display: flex
                minimodaloptions.classList.add("flex");
                minimodaloptions.style.display = "flex";
            }

            console.log("Estado de opciones de ajustes actualizado.");
        });

        // Selecciona el menú de configuración
        const menu_config =
            document.getElementsByClassName("options_config")[0];

        if (!menu_config) {
            console.error("No se encontraron opciones de configuración.");
        } else {
            // Añadir el event listener para detectar clics en el botón de configuración
            configButton.addEventListener("click", function () {
                console.log("Presionaste el botón de configuración.");

                // Alternar la clase 'flex' para mostrar u ocultar
                if (menu_config.classList.contains("flex")) {
                    // Si la clase 'flex' está presente, la eliminamos y volvemos a display: none
                    menu_config.classList.remove("flex");
                    menu_config.style.display = "none";
                } else {
                    // Si no tiene la clase 'flex', la añadimos y cambiamos a display: flex
                    menu_config.classList.add("flex");
                    menu_config.style.display = "flex";
                }
            });
        }

        const opciones = document.querySelectorAll(".botton_option");
        const inputUbicacion = document.getElementById("ubicacion"); // El input donde se va a escribir el valor
        //const menu_config = document.getElementById("menu_config"); // Asegúrate de tener el elemento del menú en tu HTML

        // Añadimos un evento click a cada opción para obtener el valor de data-ubicacion
        opciones.forEach((opcion) => {
            opcion.addEventListener("click", function (event) {
                // Obtiene el valor de data-ubicacion
                const ubicacion = opcion.getAttribute("data-ubicacion");
                inputUbicacion.value = ubicacion; // Asigna el valor al input

                // Quita la clase 'options_config_active' de todos los elementos
                opciones.forEach((opcion) => {
                    opcion.classList.remove("options_config_active");
                });

                // Agrega la clase 'options_config_active' al elemento clickeado
                opcion.classList.add("options_config_active");

                // Cierra el menú de configuración al hacer clic en una opción
                menu_config.classList.remove("flex");
                menu_config.style.display = "none";
            });
        });
    }
});
