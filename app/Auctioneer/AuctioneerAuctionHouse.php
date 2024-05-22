<?php

namespace App\Auctioneer;

use Illuminate\Support\Collection;

class AuctioneerAuctionHouse
{
    public string $ahKey = '';
    public array $auctions = [];
    public array $auctionIdsByItemKey = [];
    public string $nextAuctionId = '';
    public array $updates = [];
    public string $version = '';

    public function __construct(array $ah)
    {
        $this->ahKey = $ah['ahKey'] ?? '';
        $this->auctions = $ah['auctions'] ?? [];
        $this->auctionIdsByItemKey = $ah['auctionIdsByItemKey'] ?? [];
        $this->nextAuctionId = $ah['nextAuctionId'] ?? 0;
        $this->updates = $ah['updates'] ?? [];
        $this->version = $ah['version'] ?? '';
    }

    /**
     * @return Collection<int, Auction>
     */
    public function getAuctions(): Collection
    {
        $auctions = collect([]);

        foreach ($this->auctions as $auctionCsv) {
            $auctionArray = Auction::formatInputString($auctionCsv);

            if (Auction::validate($auctionArray)) {
                $auctions->push(new Auction($auctionArray));
            }
        }

        return $auctions;
    }

    public function getAuctionsByItemKey(string $itemKey): Collection
    {
        $auctionIds = (string) ($this->auctionIdsByItemKey[$itemKey] ?? '');
        $auctionIds = explode(';', $auctionIds);
        $auctions = collect([]);

        foreach ($auctionIds as $auctionId) {
            $auctionId = intval($auctionId);
            $auctionCsv = $this->getAuctionByIndex($auctionId);
            $auctionArray = Auction::formatInputString($auctionCsv);

            if (Auction::validate($auctionArray)) {
                $auctions->push(new Auction($auctionArray));
            }
        }

        return $auctions;
    }

    public function getAuctionByIndex(int $index): string
    {
        return $this->auctions[$index - 1] ?? '';
    }
}
