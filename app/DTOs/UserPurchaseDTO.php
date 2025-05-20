<?php

namespace App\DTOs;

use App\Models\UserPurchase;

class UserPurchaseDTO
{
    public readonly string $user_id;
    public readonly int $item_id;
    public readonly ?string $purchase_date;
    public readonly ?bool $active; 

    public function __construct(
        string $user_id,
        int $item_id,
        ?string $purchase_date = null,
        ?bool $active = null       
    ) {
        $this->user_id = $user_id;
        $this->item_id = $item_id;
        $this->purchase_date = $purchase_date;
        $this->active = $active;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'item_id' => $this->item_id,
            'purchase_date' => $this->purchase_date ?? now(),
            'active' => $this->active,  
        ];
    }

    public static function fromModel(UserPurchase $purchase): self
    {
        return new self(
            user_id: $purchase->user_id,
            item_id: $purchase->item_id,
            purchase_date: $purchase->purchase_date,
            active: $purchase->active   
        );
    }
}
