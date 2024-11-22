<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_layout_id',
        'table_number',
        'total_seats',
        'available_seats',
    ];

    public function eventLayout()
    {
        return $this->belongsTo(EventLayout::class, 'event_layout_id');
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'table_id');
    }
}
