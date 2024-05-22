<?php

namespace App\Auctioneer;

use Illuminate\Support\Collection;

class AuctioneerItemDB
{
    public Auctioneer $auctioneer;
    public string $version;
    public array $items;
    /** @var Collection<int, Item> $parsedItems */
    public Collection $parsedItems;
    public array $inventoryTypes;
    public array $textures;
    public array $auctionItemClasses;
    public array $auctionItemSubClasses;

    public function __construct(array $data, Auctioneer $auctioneer)
    {
        $this->auctioneer = $auctioneer;
        $this->version = $data['version'] ?? '';
        $this->items = $data['items'] ?? [];
        $this->inventoryTypes = $data['inventoryTypes'] ?? [];
        $this->textures = $data['textures'] ?? [];
        $this->auctionItemClasses = $data['auctionItemClasses'] ?? [];
        $this->auctionItemSubClasses = $data['auctionItemSubClasses'] ?? [];
    }

    public function postCreate()
    {
        $this->parseItems();
    }

    public function getTextureNameByIndex(int $index): string
    {
        return $this->textures[$index - 1] ?? '';
    }

    public function getInventoryTypeByIndex(int $index): string
    {
        return $this->inventoryTypes[$index - 1] ?? '';
    }

    public function getAuctionItemClassNameByIndex(int $index): string
    {
        return $this->auctionItemClasses[$index - 1] ?? '';
    }

    public function getAuctionItemSubClassNameByIndex(int $index): string
    {
        return $this->auctionItemSubClasses[$index - 1] ?? '';
    }

    /**
     * @return Collection<int, Item>
     */
    public function getParsedItems(): Collection
    {
        return $this->parsedItems;
    }

    public function parseItems()
    {
        $itemsData = collect([]);

        foreach ($this->items as $itemKey => $itemValue) {
            $item = Item::createItemFromStrings($itemKey, $itemValue, $this->auctioneer);
            if ($item) {
                $itemsData->put(
                    $itemKey,
                    $item
                );
            }
        }

        $this->parsedItems = $itemsData;
    }

    public function getItemByItemKey(string $itemKey): ?Item
    {
        return $this->parsedItems->get($itemKey, null);
    }
}
