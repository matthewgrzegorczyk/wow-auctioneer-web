<?php

namespace App\Auctioneer;

use function Ramsey\Uuid\v1;

class Auctioneer
{
    public array $config = [];
    public ?AuctioneerItemDB $itemDB = null;
    public ?AuctioneerSnapshotDB $snapshotDB = null;
    public array $historyDB = [];
    public array $fixedPriceDB = [];
    public array $transactionDB = [];

    public function __construct()
    {
        $this->itemDB = new AuctioneerItemDB(Auctioneer::getItemDB(), $this);
        $this->itemDB->postCreate();
        $this->snapshotDB = new AuctioneerSnapshotDB(Auctioneer::getSnapshotDB(), $this);
    }

    public static function getJsonData(string $filePath): array
    {
        $data = [];

        if (file_exists($filePath)) {
            $json = file_get_contents($filePath);
            $data = json_decode($json, true);
        }

        return $data ?? [];
    }


    /**
     * Get the item database from the AuctioneerItemDB.json file.
     *
     * @return array{items: array, inventoryTypes: array, textures: array, auctionItemClasses: array, auctionItemSubClasses: array}
     */
    public static function getItemDB(): array
    {
        return static::getJsonData(storage_path('app/auctioneer_data/AuctioneerItemDB.json'));
    }

    public static function getSnapshotDB(): array
    {
        return static::getJsonData(storage_path('app/auctioneer_data/AuctioneerSnapshotDB.json'));
    }

    public function getAuctionsByItemKey(string $itemKey)
    {
        return $this->snapshotDB->getAuctionsByItemKey($itemKey);
    }

    public function getAuctionsByCharacterName(string $characterName)
    {
        return $this->snapshotDB->getAuctionsByCharacterName($characterName);
    }

    /**
     * @return array{gold: int, silver: int, copper: int}
     */
    public static function formatPrice(int $price): array
    {
        $gold = floor($price / 10000);
        $silver = floor(($price % 10000) / 100);
        $copper = $price % 100;

        return [
            'gold' => $gold,
            'silver' => $silver,
            'copper' => $copper,
        ];
    }

    public static function formatPriceAsString(int $price): string
    {
        list($gold, $silver, $copper) = static::formatPrice($price);

        return ($gold ? "{$gold}g " : '') . ($silver ? "{$silver}s " : '') . ($copper ? "{$copper}c" : '');
    }
}
