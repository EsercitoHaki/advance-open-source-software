<?php

namespace App\DTOs;

use App\Models\StoreItem;

class StoreItemDTO
{
    public readonly string $item_id;
    public readonly string $item_name;
    public readonly string $item_type;
    public readonly int $item_price;
    public readonly ?string $mascot_pic;
    public readonly ?int $lives_amount;

    public function __construct(
        string $item_id,
        string $item_name,
        string $item_type,
        int $item_price,
        ?string $mascot_pic = null,
        ?int $lives_amount = null
    ) {
        $this->item_id = $item_id;
        $this->item_name = $item_name;
        $this->item_type = $item_type;
        $this->item_price = $item_price;
        $this->mascot_pic = $mascot_pic;
        $this->lives_amount = $lives_amount;
    }

    public static function fromModel(StoreItem $item): self
    {
        return new self(
            $item->item_id,
            $item->item_name,
            $item->item_type,
            $item->item_price,
            $item->mascot_pic ?? null,
            $item->lives_amount ?? null
        );
    }

}
