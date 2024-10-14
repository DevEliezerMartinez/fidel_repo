 // Inicializar Flatpickr para fecha de inicio
 flatpickr("#date_start", {
    dateFormat: "Y-m-d", // Formato de fecha (Año-Mes-Día)
    onChange: function(selectedDates, dateStr, instance) {
        console.log("Fecha de inicio seleccionada:", dateStr);
    }
});

// Inicializar Flatpickr para fecha de fin
flatpickr("#date_end", {
    dateFormat: "Y-m-d", // Formato de fecha (Año-Mes-Día)
    onChange: function(selectedDates, dateStr, instance) {
        console.log("Fecha de fin seleccionada:", dateStr);
    }
});