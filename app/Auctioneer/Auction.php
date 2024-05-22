<?php

namespace App\Auctioneer;

use DateTime;

class Auction {
    // Given format create public properties for each and constructor
    // "$itemId;$suffixId;$enchantId;$uniqueId;$count;$minBid;$buyoutPrice;$owner;$bidAmount;$highBidder;$timeLeft;$lastSeen;$expiration"
    public Auctioneer $auctioneer;
    public string $ahKey;
    public ?Item $item = null;
    public int $itemId;
    public int $suffixId;
    public int $enchantId;
    public int $uniqueId;
    public int $count;
    public int $minBid;
    public int $buyoutPrice;
    public string $owner;
    public int $bidAmount;
    public string $highBidder;
    public string $timeLeft;
    public string $lastSeen;
    public string $expiration;

    public function __construct(array $data, string $ahKey = '') {
        $this->ahKey = $ahKey;
        $this->auctioneer = app()->make(Auctioneer::class);


        $this->itemId = (int) ($data[0] ?? '');
        $this->suffixId = (int) ($data[1] ?? '');
        $this->enchantId = (int) ($data[2] ?? '');
        $this->item = $this->auctioneer->itemDB->getItemByItemKey(
            Item::formatItemKeyArrayAsString([$this->itemId, $this->suffixId, $this->enchantId])
        );
        $this->uniqueId = (int) ($data[3] ?? '');
        $this->count = (int) ($data[4] ?? '');
        $this->minBid = (int) ($data[5] ?? '');
        $this->buyoutPrice = (int) ($data[6] ?? '');
        $this->owner = $data[7] ?? '';
        $this->bidAmount = (int) ($data[8] ?? '');
        $this->highBidder = $data[9] ?? '';
        $this->timeLeft = $data[10] ?? '';
        $this->lastSeen = (int) ($data[11] ?? '');
        $this->expiration = (int) ($data[12] ?? '');
    }

    public static function formatInputString(mixed $data): array {
        return is_string($data) ? explode(';', $data) : [];
    }

    public static function validate(array $data): bool {
        return count($data) === 13;
    }

    public function getLastSeen(): string
    {
        return date('Y-m-d H:i:s', $this->lastSeen);
    }

    public function getExpiration(): string
    {
        return date('Y-m-d H:i:s', $this->expiration);
    }

    public function getFormattedBuyoutPrice(): array
    {
        return Auctioneer::formatPrice($this->buyoutPrice);
    }
}
