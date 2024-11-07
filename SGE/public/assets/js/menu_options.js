// Obtener el elemento con el id 'ajustes'
const ajustesButton = document.getElementById("ajustes");
const configButton = document.getElementById("config");
const cerrarSesionButton = document.getElementsByClassName("footer_sidebar")[0];

// Añadir el event listener para detectar clics
ajustesButton.addEventListener("click", function () {
  const minimodaloptions =
    document.getElementsByClassName("options_ajustes")[0];

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

  console.log("Estado de opciones de ajustes actualizado");
});

cerrarSesionButton.addEventListener("click", function () {
  localStorage.clear();
  window.location.href = "rutalogout";
});

const menu_config = document.getElementsByClassName("options_config")[0];
configButton.addEventListener("click", function () {

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

// Selecciona todos los enlaces que tienen la clase 'botton_option'
const opciones = document.querySelectorAll(".botton_option");
const inputUbicacion = document.getElementById('ubicacion'); // El input donde se va a escribir el valor


// Añadimos un evento click a cada opción para obtener el valor de data-ubicacion
opciones.forEach((opcion) => {
  opcion.addEventListener("click", function (event) {
   // event.preventDefault(); // Previene la acción por defecto del enlace
    const ubicacion = opcion.getAttribute("data-ubicacion"); // Obtiene el valor de data-ubicacion
    inputUbicacion.value = ubicacion; // Asigna el valor al input

      // Cierra el menú al hacer clic en una opción
      menu_config.classList.remove("flex");
      menu_config.style.display = "none";
  });
});
