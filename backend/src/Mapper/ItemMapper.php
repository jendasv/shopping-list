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
            'isCompleted' => $item->isCompleted(),
            'shoppingListId' => $item->getShoppingList()?->getId(),
            'createdAt' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $item->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

}
