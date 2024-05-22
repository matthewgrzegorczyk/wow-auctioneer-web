<?php

namespace App\Auctioneer;

use Illuminate\Support\Facades\Validator;

class Item
{
    public Auctioneer $auctioneer;

    public string $itemKey;
    public int $itemId;
    public int $suffixId;
    public int $enchantId;

    public array $itemData;

    public string $name;
    public string $quality;
    public string $useLevel;
    public string $categoryName;
    public string $subCategoryName;
    public string $stackCount;
    public string $equipLocName;
    public string $textureName;

    public function __construct(array $itemKey, array $itemData, Auctioneer $auctioneer)
    {
        // Hard dependency.
        $this->auctioneer = $auctioneer;

        $this->itemId = $itemKey[0] ?? 0;
        $this->suffixId = $itemKey[1] ?? 0;
        $this->enchantId = $itemKey[2] ?? 0;

        $this->itemData = $itemData;

        $this->name = $this->getName();
        $this->quality = $this->getQuality();
        $this->useLevel = $this->getUseLevel();
        $this->categoryName = $this->getCategoryNameFromDB();
        $this->subCategoryName = $this->getSubCategoryNameFromDB();
        $this->stackCount = $this->getStackCount();
        $this->equipLocName = $this->getEquipLocNameFromDB();
        $this->textureName = $this->getTextureNameFromDB();
    }

    public static function createItemFromStrings(string $itemKey, string $itemValue, Auctioneer $auctioneer): ?self
    {
        $itemKeyArray = self::formatItemKeyStringAsArray($itemKey);
        $itemValueArray = self::formatItemValue($itemValue);

        if (!self::validateItemKeyArray($itemKeyArray) || !self::validateItemValueArray($itemValueArray)) {
            return null;
        }

        $item = new self($itemKeyArray, $itemValueArray, $auctioneer);
        $item->itemKey = $itemKey;

        return $item;
    }

    /**
     * @param string $itemKey
     * @return array{itemId: string, suffixId: string, enchantId: string}
     */
    public static function formatItemKeyStringAsArray(string $itemKey): array
    {
        return explode(':', $itemKey);
    }

    public static function formatItemKeyArrayAsString(array $itemKeyArray): string
    {
        return implode(':', $itemKeyArray);
    }

    /**
     * Item key should be in the format "itemId:suffixId:enchantId" and as formatted as array consist of 3 elements.
     */
    public static function validateItemKeyArray(array $itemKeyArray): bool
    {
        return count($itemKeyArray) === 3 && Validator::make($itemKeyArray, [
            0 => 'required|integer',
            1 => 'required|integer',
            2 => 'required|integer',
        ])->passes();
    }

    public static function formatItemValue(string $itemValue): array
    {
        return explode(';', $itemValue);
    }

    public static function validateItemValueArray(array $parts): bool
    {
        $validator = Validator::make($parts, [
            0 => 'required|string',
            1 => 'required|integer',
            2 => 'required|integer',
            3 => 'required|integer',
            4 => 'required|integer',
            5 => 'required|integer',
            6 => 'required|integer',
            7 => 'required|integer',
        ]);

        return count($parts) === 8 && $validator->passes();
    }

    // Stored as string.
    public function getName(): string
    {
        return $this->itemData[0] ?? '';
    }

    // Stored as number.
    public function getQuality(): ?int
    {
        return $this->itemData[1] ?? null;
    }

    // Stored as number.
    public function getUseLevel(): ?int
    {
        return $this->itemData[2] ?? null;
    }

    // Mapped value.
    public function getCategoryName(): ?int
    {
        return $this->itemData[3] ?? null;
    }

    public function getCategoryNameFromDB(): string
    {
        return $this->auctioneer->itemDB->auctionItemClasses[$this->getCategoryName() - 1] ?? '';
    }

    // Mapped value.
    public function getSubCategoryName(): ?int
    {
        return $this->itemData[4] ?? null;
    }

    public function getSubCategoryNameFromDB(): string
    {
        return $this->auctioneer->itemDB->getAuctionItemSubClassNameByIndex(
            $this->getSubCategoryName()
        );
    }

    // Stored already as number.
    public function getStackCount(): ?int
    {
        return $this->itemData[5] ?? null;
    }

    // Mapped value.
    public function getEquipLocName(): ?int
    {
        return $this->itemData[6] ?? null;
    }

    public function getEquipLocNameFromDB(): string
    {
        return $this->auctioneer->itemDB->getInventoryTypeByIndex(
            $this->getEquipLocName()
        );
    }

    public function getTextureName(): ?int
    {
        return $this->itemData[7] ?? null;
    }

    public function getTextureNameFromDB(): string
    {
        return $this->auctioneer->itemDB->getTextureNameByIndex(
            $this->getTextureName()
        );
    }
}
