<?php

use App\Auctioneer\Auctioneer;
use App\Http\Controllers\AuctioneerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StatsController;
use App\Models\ServerStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/stats', [StatsController::class, 'index'])->name('stats');

Route::get('/auctioneer', [AuctioneerController::class, 'index'])->name('auctioneer');
Route::get('/auctioneer/auctions', [AuctioneerController::class, 'auctions'])->name('auctions');

Route::get('/auctioneer/auctions/item/{itemKey}', function (Auctioneer $auctioneer, $itemKey) {
    // Each auctions are grouped by auction house -> servername-faction
    // e.g. netherwing-horde
    $auctionsByAH = $auctioneer->getAuctionsByItemKey($itemKey);

    // foreach ($auctionsByAH as $ahKey => $auctions) {
    //     $auctionsByAH[$ahKey] = $auctions->filter(fn($auction) => Str::contains($auction->owner, 'papiko', true))->all();
    // }

    return view(
        'auctions',
        [
            'auctionsByAH' => $auctionsByAH,
        ]
    );
})->name('auctionsByItemKey');

Route::get('/auctioneer/character/{characterName}', function (Auctioneer $auctioneer, $characterName) {
    $auctions = $auctioneer->snapshotDB->getAuctionsByCharacterName($characterName);

    return view(
        'auctions',
        [
            'auctionsByAH' => $auctions,
        ]
    );
})->name('auctionsByCharacterName');
