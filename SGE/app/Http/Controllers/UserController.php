<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255', // Asegúrate de validar el apellido
            'correo' => 'required|email|unique:users,email',
            'puesto' => 'string|max:255',
            'permisos' => 'required|string|in:1,2,3',
        ]);

        $username = strtolower(substr($validated['nombre'], 0, 1) . substr($validated['apellido'], 0, 1));

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $validated['nombre'],
            'lastname' => $validated['apellido'],
            'username' => $username,
            'email' => $validated['correo'],
            'puesto' => $validated['puesto'], // Si no se asigna, se pone 'Sin asignar'
            'role_id' => $validated['permisos'], // Asegúrate de tener un campo para roles
            'password' => bcrypt('12345678'), // Establece una contraseña por defecto
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('adminUsuarios')->with('success', 'Usuario creado exitosamente.');
    }

    public function editJson(User $user)
    {
        return response()->json([
            'nombre' => $user->name,
            'apellido' => $user->lastname,
            'correo' => $user->email,
            'puesto' => $user->puesto ?: 'Sin asignar',
            'permisos' => $user->role_id,
        ]);
    }

    // Método para actualizar los datos del usuario
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'correo' => 'required|email|unique:users,email,' . $user->id,
            'puesto' => 'nullable|string|max:255',
            'permisos' => 'required|string|in:1,2,3',
        ]);

        $user->update([
            'name' => $validated['nombre'],
            'lastname' => $validated['apellido'],
            'email' => $validated['correo'],
            'puesto' => $validated['puesto'] ?? 'Sin asignar',
            'role_id' => $validated['permisos'],
        ]);

        return redirect()->route('adminUsuarios')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
{
    // Buscar al usuario por ID
    $user = User::findOrFail($id);

    // Eliminar al usuario
    $user->delete();

    // Responder con un código 200 para indicar que se eliminó correctamente
    return response()->json(['success' => true]);
}

}
