<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\ShoppingList;
use App\Exception\Domain\ResourceNotFoundException;
use App\Exception\Domain\ValidationException;
use App\Exception\Infrastructure\DatabaseOperationException;
use App\Mapper\ShoppingListMapper;
use Doctrine\ORM\EntityManagerInterface;

class ShoppingListService
{

    private EntityManagerInterface $em;

    private ItemService $itemService;

    private ShoppingListMapper $shoppingListMapper;

    public function __construct(EntityManagerInterface $em, ItemService $itemService, ShoppingListMapper $shoppingListMapper)
    {
        $this->em = $em;
        $this->itemService = $itemService;
        $this->shoppingListMapper = $shoppingListMapper;
    }

    public function findList(int $id): ?ShoppingList
    {
        return $this->em->getRepository(ShoppingList::class)->find($id);
    }

    public function getList(int $id): array
    {
        $shoppingList = $this->findList($id);

        if (!$shoppingList) {
            throw new ResourceNotFoundException('Shopping list not found.');
        }

        return $this->shoppingListMapper->map($shoppingList);
    }

    public function createList(array $data): array
    {
        if (empty($data['name'])) {
            throw new ValidationException([
                'name' => 'Missing parameter: name',
            ]);
        }

        $newList = new ShoppingList();
        $newList->setName($data['name']);

        if (!empty($data['items'])) {
            foreach ($data['items'] as $item) {
                $item = $this->itemService->createItem($item);
                $newList->addItem($item);
            }
        }

        try {
            $this->em->persist($newList);
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new DatabaseOperationException(
                'Failed to create shopping list. ' . $e->getMessage(),
                0
            );
        }

        return $this->shoppingListMapper->map($newList);
    }

    public function deleteList(int $id): void
    {
        $shoppingList = $this->findList($id);

        if (!$shoppingList) {
            throw new ResourceNotFoundException('Shopping list not found.');
        }

        try {
            $this->em->remove($shoppingList);
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new DatabaseOperationException(
                'Failed to delete shopping list. ' . $e->getMessage(),
                0
            );
        }
    }
}
