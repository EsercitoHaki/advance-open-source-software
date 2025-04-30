<?php

namespace App\DTOs;

class StoreItemDTO
{
    public readonly string $item_name;
    public readonly string $item_type;
    public readonly int $item_price;
    public readonly ?string $mascot_pic;
    public readonly ?int $lives_amount;

    public function __construct(
        string $item_name,
        string $item_type,
        int $item_price,
        ?string $mascot_pic = null,
        ?int $lives_amount = null
    ) {
        $this->item_name = $item_name;
        $this->item_type = $item_type;
        $this->item_price = $item_price;
        $this->mascot_pic = $mascot_pic;
        $this->lives_amount = $lives_amount;
    }

    public function toArray(): array
    {
        return [
            'item_name' => $this->item_name,
            'item_type' => $this->item_type,
            'item_price' => $this->item_price,
            'mascot_pic' => $this->mascot_pic,
            'lives_amount' => $this->lives_amount,
        ];
    }
}
