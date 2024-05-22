<?php

namespace App\Http\Controllers;

use App\Models\ServerStats;

class StatsController extends Controller
{
    public function index()
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
