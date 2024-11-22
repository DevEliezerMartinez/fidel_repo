<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $table = 'seats';

    protected $fillable = [
        'table_id',
        'seat_number',
        'is_reserved',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }
}
