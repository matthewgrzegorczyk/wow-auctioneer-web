<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $players = [
            'Evthereal',
            'PsychiX',
            'Papiko',
            'Persi',
            'Shatanblack',
            'Finezja',
            'Miklon',
            'Xetrin',
        ];

        return view(
            'index',
            [
                'players' => $players,
            ]
        );
    }
}
