<?php

namespace App\Mapper;

use App\Entity\Item;

class ItemMapper
{

    public function map(Item $item): array
    {
        return [
            'id' => $item->getId(),
            'name' => $item->getName(),
            'quantity' => $item->getQuantity(),
            'is_completed' => $item->isCompleted(),
            'shopping_list_id' => $item->getShoppingList()?->getId(),
            'createdAt' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $item->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

}
