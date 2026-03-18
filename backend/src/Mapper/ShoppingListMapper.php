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

    public function map(ShoppingList $shoppingList, bool $listOnly = false): array
    {

        $data = [
            'id' => $shoppingList->getId(),
            'name' => $shoppingList->getName(),
            'createdAt' => $shoppingList->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $shoppingList->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];

        $items = [];

        if (!$listOnly) {
            /**
             * @var Item $item
             */
            foreach ($shoppingList->getItems() as $item) {
                $items[] = $this->itemMapper->map($item);
            }

            $data['items'] = $items;
        }


        return $data;
    }

}
