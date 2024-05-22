<?php

namespace App\Http\Controllers;

use App\Models\ServerStats;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function stats()
    {
        $serverStats = ServerStats::where('server_name', '=', 'Netherwing')->get();

        return view(
            'stats',
            [
                'serverStats' => $serverStats,
            ]
        );
    }
}
