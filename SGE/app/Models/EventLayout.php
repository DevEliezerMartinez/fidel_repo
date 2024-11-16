<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventLayout extends Model
{
    use HasFactory;

    protected $table = 'event_layouts';

    protected $fillable = [
        'event_id',
        'layout_json',
        'created_at',
        'updated_at',
    ];
}
