<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerStats extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_name',
        'players_online',
        'horde_count',
        'alliance_count',
    ];
}
