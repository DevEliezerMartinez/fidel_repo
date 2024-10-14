<?php
// Simula una respuesta de usuarios falsos
$usuarios = [
    [
        'id' => 1,
        'nombre' => 'Juan Pérez',
        'correo' => 'juan.perez@example.com',
        'puesto' => 'Administrador'
    ],
    [
        'id' => 2,
        'nombre' => 'María Gómez',
        'correo' => 'maria.gomez@example.com',
        'puesto' => 'Editor'
    ],
    [
        'id' => 3,
        'nombre' => 'Luis Fernández',
        'correo' => 'luis.fernandez@example.com',
        'puesto' => 'Desarrollador'
    ],
    [
        'id' => 4,
        'nombre' => 'Ana Martínez',
        'correo' => 'ana.martinez@example.com',
        'puesto' => 'Diseñadora'
    ],
    [
        'id' => 5,
        'nombre' => 'Carlos Ruiz',
        'correo' => 'carlos.ruiz@example.com',
        'puesto' => 'Gerente de Proyectos'
    ]
];

// Retorna los usuarios en formato JSON
header('Content-Type: application/json');
echo json_encode(['usuarios' => $usuarios]);
?>
