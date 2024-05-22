<?php

namespace App\Auctioneer;

use Illuminate\Support\Collection;

class AuctioneerSnapshotDB
{
    /**
     * @var AuctioneerAuctionHouse[]
     */
    public array $auctionHouses = [];

    /**
     * @param array{string:array{ahKey:string,auctionIdsByItemKey:array{string:string},auctions:array}} $data
     * @return void
     */
    public function __construct(array $data, Auctioneer $auctioneer)
    {
        foreach ($data as $ahKey => $ah) {
            $this->auctionHouses[$ahKey] = new AuctioneerAuctionHouse($ah);
        }
    }

    /**
     * @param string $itemKey
     * @return array<string, Collection<int, Auction>>
     */
    public function getAuctionsByItemKey(string $itemKey): array
    {
        $auctions = [];

        foreach ($this->auctionHouses as $ah) {
            $auctions[$ah->ahKey] = $ah->getAuctionsByItemKey($itemKey);
        }

        return $auctions;
    }

    /**
     * @return array<string, Collection<int, Auction>>
     */
    public function getAuctions(): array
    {
        $auctions = [];

        foreach ($this->auctionHouses as $ah) {
            $auctions[$ah->ahKey] = $ah->getAuctions();
        }

        return $auctions;
    }
}
