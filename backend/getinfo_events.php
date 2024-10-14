<?php
// Verifica si se recibieron las fechas y la ubicación a través de GET
if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin']) && isset($_GET['ubicacion'])) {
    // Obtiene las fechas y la ubicación de la URL
    $fechaInicio = $_GET['fecha_inicio'];
    $fechaFin = $_GET['fecha_fin'];
    $ubicacion = $_GET['ubicacion'];

    // Validar que las fechas no estén vacías o que la ubicación sea válida
    if (empty($fechaInicio) || empty($fechaFin) || empty($ubicacion)) {
        // Si algún campo está vacío, retornar un error
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Las fechas y la ubicación son obligatorias.']);
        exit;
    }

    // Convierte las fechas a formato de objetos DateTime para compararlas
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinObj = new DateTime($fechaFin);

    if ($fechaFinObj < $fechaInicioObj) {
        // Si la fecha de fin es anterior a la fecha de inicio, retornar un error
        header('Content-Type: application/json');
        echo json_encode(['error' => 'La fecha de fin no puede ser anterior a la fecha de inicio.']);
        exit;
    }

    // Simulamos una lista de eventos con colores asociados a cada ubicación
    $eventos = [
        [
            'id' => '1',
            'nombre' => 'Fiesta Mexicana',
            'fecha' => '2024-09-15', // Formato ISO para las fechas
            'ubicacion' => 'Princess mundo imperial',
            'color_class' => 'alternative_blue' // Clase de color para esta ubicación
        ],
        [
            'id' => '2',
            'nombre' => 'Fiesta random',
            'fecha' => '2024-09-22',
            'ubicacion' => 'Palacio mundo imperial',
            'color_class' => 'blue' // Clase de color para esta ubicación
        ]
    ];

    // Filtra los eventos según la ubicación recibida
    if ($ubicacion !== "Todos") {
        $eventos = array_filter($eventos, function($evento) use ($ubicacion) {
            return $evento['ubicacion'] === $ubicacion;
        });
    }

    // Crea el arreglo que contendrá la información a retornar
    $respuesta = [
        'fechas' => [
            'inicio' => $fechaInicio,
            'fin' => $fechaFin
        ],
        'ubicacion' => $ubicacion,
        'total_eventos' => count($eventos), // Total de eventos filtrados
        'capacidad_total' => 5600, // Capacidad total (esto es un ejemplo, podrías cambiarlo)
        'asientos_vendidos' => 1400, // Asientos vendidos (ejemplo)
        'asientos_disponibles' => 4200, // Asientos disponibles (ejemplo)
        'eventos' => array_values($eventos) // Lista filtrada de eventos
    ];

    // Establece el encabezado de tipo de contenido JSON
    header('Content-Type: application/json');
    
    // Retorna la respuesta en formato JSON
    echo json_encode($respuesta);
} else {
    // Si no se reciben los parámetros, retorna un mensaje de error
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Faltan parámetros en la solicitud.']);
}
