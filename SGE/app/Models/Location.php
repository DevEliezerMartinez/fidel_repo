<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'location';

    // Definir los campos que se pueden asignar masivamente (mass assignable)
    protected $fillable = [
        'name', 
        'administrator',
    ];

    // Relación con Space
    public function spaces()
    {
        return $this->hasMany(Space::class);
    }

    // Opcional: Si estás utilizando timestamps personalizados, puedes agregarlos
    // protected $timestamps = true;
}
