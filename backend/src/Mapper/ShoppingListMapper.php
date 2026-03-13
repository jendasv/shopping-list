<?php

namespace App\Mapper;

use App\Entity\Item;
use App\Entity\ShoppingList;

class ShoppingListMapper
{

    private ItemMapper $itemMapper;

    public function __construct(ItemMapper $itemMapper) {
        $this->itemMapper = $itemMapper;
    }

    public function map(ShoppingList $shoppingList): array
    {

        $items = [];

        /**
         * @var Item $item
         */
//        foreach ($shoppingList->getItems() as $item) {
//            $items[] = [
//                'id' => $item->getId(),
//                'name' => $item->getName(),
//                'quantity' => $item->getQuantity(),
//                'is_completed' => $item->isCompleted(),
//                'createdAt' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
//                'updatedAt' => $item->getUpdatedAt()->format('Y-m-d H:i:s'),
//            ];
//        }

        foreach ($shoppingList->getItems() as $item) {
            $items[] = $this->itemMapper->map($item);
        }

        return [
            'id' => $shoppingList->getId(),
            'name' => $shoppingList->getName(),
            'items' => $items,
        ];
    }

}
