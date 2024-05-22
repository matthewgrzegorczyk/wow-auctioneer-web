<?php

namespace App\Http\Controllers;

use App\Auctioneer\Auctioneer;
use Illuminate\Http\Request;

class AuctioneerController extends Controller
{
    public function index(Auctioneer $auctioneer, Request $request)
    {
        $itemsCollection = $auctioneer->itemDB->parsedItems;
        $search = $request->query('search', '');

        if ($search) {
            $itemsCollection = $itemsCollection->filter(fn ($item) => Str::contains($item->name, $search, true));
        }

        $page = intval($request->query('page', 1));
        $perPage = 100;
        $pagesCount = intval(ceil($itemsCollection->count() / $perPage));
        $pages = [];

        for ($i = 1; $i <= $pagesCount; $i++) {
            if ($i === 1 || $i === $pagesCount || (abs($page - $i) <= 3)) {
                $pages[$i] = $i === $page;
            } else if (abs($page - $i) === 4) {
                $pages[$i] = null;
            }
        }

        return view('auctioneer', [
            'items' => $itemsCollection->forPage($page, $perPage)->all(),
            'snapshotDB' => $auctioneer->snapshotDB,
            'page' => $page,
            'pages' => $pages,
        ]);
    }

    public function auctions(Auctioneer $auctioneer, Request $request) {
        $auctionsByAH = $auctioneer->snapshotDB->getAuctions();
        $search = $request->query('search', '');
        $owner = $request->query('owner', '');
        $minCount = $request->query('minCount', 1);
        $maxCount = $request->query('maxCount', 20);

        if ($search || $owner || $minCount || $maxCount) {
            foreach ($auctionsByAH as $ahKey => &$auctions) {
                // $auctionsByAH[$ahKey] = $auctions->filter(function($auction) use ($search, $owner, $minCount, $maxCount) {
                //     return Str::contains($auction->owner, $owner, true) || ($auction->count >= $minCount && $auction->count <= $maxCount);
                // });

                $auctions = $auctions->where('count', '>=', $minCount)
                    ->where('count', '<=', $maxCount);

                if (!empty($search)) {
                    $auctions = $auctions->filter(fn ($auction) => Str::contains($auction->item->name, $search, true));
                }

                if (!empty($owner)) {
                    $auctions = $auctions->filter(fn ($auction) => Str::contains($auction->owner, $owner, true));
                }
            }
        }

        $page = intval($request->query('page', 1));
        $perPage = 50;
        $pagesCount = intval(ceil(reset($auctionsByAH)->count() / $perPage));
        $pages = [];

        for ($i = 1; $i <= $pagesCount; $i++) {
            if ($i === 1 || $i === $pagesCount || (abs($page - $i) <= 3)) {
                $pages[$i] = $i === $page;
            } else if (abs($page - $i) === 4) {
                $pages[$i] = null;
            }
        }


        foreach ($auctionsByAH as $ahKey => $auctions) {
            $auctionsByAH[$ahKey] = $auctions->forPage($page, $perPage)->all();
        }

        return view(
            'auctions',
            [
                'auctionsByAH' => $auctionsByAH,
            ]
        );
    }
}
