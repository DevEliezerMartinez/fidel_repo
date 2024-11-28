function filtrarEventos() {
  // Obtener los valores de las fechas y ubicación
  const fechaInicio = document.getElementById("date_start").value;
  const fechaFin = document.getElementById("date_end").value;
  const ubicacion = document.getElementById("ubicacion").value;

  // Construir la URL con los parámetros
  const url = `./backend/getinfo_events.php?fecha_inicio=${encodeURIComponent(
    fechaInicio
  )}&fecha_fin=${encodeURIComponent(fechaFin)}&ubicacion=${encodeURIComponent(
    ubicacion
  )}`;

  // Hacer la petición GET
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Error en la red");
      }
      return response.json();
    })
    .then((data) => {
      // Renderizar la información en el HTML
      document.querySelector(".total_events .circle").textContent =
        data.total_eventos;
      document.querySelector(
        ".events_info .card_event_info:nth-child(1) .secondary_circles"
      ).textContent = data.capacidad_total;
      document.querySelector(
        ".events_info .card_event_info:nth-child(2) .secondary_circles"
      ).textContent = data.asientos_vendidos;
      document.querySelector(
        ".events_info .card_event_info:nth-child(3) .secondary_circles"
      ).textContent = data.asientos_disponibles;

      // Limpiar la sección de eventos antes de renderizar
      const listEventsSection = document.querySelector(".list_events");
      listEventsSection.innerHTML = ""; // Limpiar eventos anteriores

      // Renderizar cada evento
      data.eventos.forEach((evento) => {
        const eventDiv = document.createElement("div");
        eventDiv.classList.add("event", evento.color_class); // Añadir clase según 'color_class'

        // Añadir enlace con el ID del evento como parámetro GET
        eventDiv.innerHTML = `
                    <a id="name_event" href="detallesEvento.php?id=${evento.id}">${evento.nombre}</a>
                    <p id="date">${evento.fecha}</p>
                    <p id="place">${evento.ubicacion}</p>
                `;

        listEventsSection.appendChild(eventDiv);
      });

      // Limpiar y renderizar las leyendas dinámicamente
      const leyendsDiv = document.querySelector(".leyends");
      leyendsDiv.innerHTML = ""; // Limpiar leyendas anteriores

      // Crear un set para evitar leyendas duplicadas por ubicaciones
      const ubicaciones = new Set();
      data.eventos.forEach((evento) => {
        if (!ubicaciones.has(evento.ubicacion)) {
          ubicaciones.add(evento.ubicacion);

          const labelDiv = document.createElement("div");
          labelDiv.classList.add("label_info");

          // Añadir la clase del color y el nombre de la ubicación
          labelDiv.innerHTML = `
    <div class="bar" style="border: 2px solid ${evento.color_class}"></div>
    <span>${evento.ubicacion}</span>
`;

          leyendsDiv.appendChild(labelDiv);
        }
      });
    })
    .catch((error) => {
      console.error("Hubo un problema con la petición Fetch:", error);
    });
}

// Añadir el event listener al botón de filtrar
document.querySelector(".filter").addEventListener("click", filtrarEventos);
