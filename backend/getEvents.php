<?php
header('Content-Type: application/json');

// Simulación de datos de eventos falsos
$events = [
    [
        'id' => 1,
        'nombre' => 'Concierto de Rock',
        'fecha' => '2024-10-20',
        'ubicacion' => 'Auditorio Nacional',
        'descripcion' => 'Un gran concierto de rock con bandas locales e internacionales.',
    ],
    [
        'id' => 2,
        'nombre' => 'Exposición de Arte',
        'fecha' => '2024-11-05',
        'ubicacion' => 'Museo de Arte Moderno',
        'descripcion' => 'Una exposición que muestra obras de artistas emergentes.',
    ],
    [
        'id' => 3,
        'nombre' => 'Feria de Comida',
        'fecha' => '2024-11-15',
        'ubicacion' => 'Plaza Mayor',
        'descripcion' => 'Un evento gastronómico con diferentes tipos de comida de todo el mundo.',
    ],
    [
        'id' => 4,
        'nombre' => 'Maratón de la Ciudad',
        'fecha' => '2024-12-01',
        'ubicacion' => 'Centro Histórico',
        'descripcion' => 'Participa en el maratón y corre por las calles de la ciudad.',
    ],
];

// Devolver los eventos como JSON
echo json_encode(['eventos' => $events]);
?>
