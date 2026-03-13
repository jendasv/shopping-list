<?php

namespace App\Service;

use App\Entity\Item;
use App\Entity\ShoppingList;
use App\Exception\Domain\ResourceNotFoundException;
use App\Exception\Domain\ValidationException;
use App\Exception\Infrastructure\DatabaseOperationException;
use App\Mapper\ItemMapper;
use App\Mapper\ShoppingListMapper;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{

    private EntityManagerInterface $em;

    private ShoppingListMapper $shoppingListMapper;

    private ItemMapper $itemMapper;

    public function __construct(EntityManagerInterface $em, ShoppingListMapper $shoppingListMapper, ItemMapper $itemMapper)
    {
        $this->em = $em;
        $this->shoppingListMapper = $shoppingListMapper;
        $this->itemMapper = $itemMapper;
    }

    public function getItem(int $id): array
    {
        $item = $this->em->getRepository(Item::class)->find($id);

        if (!$item) {
            throw new ResourceNotFoundException('Item not found');
        }

        return $this->itemMapper->map($item);
    }

    public function createItem(array $data, ?ShoppingList $shoppingList = null): Item
    {

        $exception = new ValidationException();

        if (empty($data['name'])) {
            $exception->addError('name', 'Item name is required');
        }

        if (count($exception->getErrors()) > 0) {
            throw $exception;
        }

        $item = new Item();
        $item->setName($data['name']);
        $item->setQuantity($data['quantity'] ?? 1);

        if ($shoppingList) {
            $item->setShoppingList($shoppingList);
        }

        try {
            $this->em->persist($item);
        } catch (\Throwable $e) {
            throw new DatabaseOperationException(
                'Failed to create item. ' . $e->getMessage()
            );
        }

        return $item;
    }

    public function createItemForList(int $shoppingListId, array $data): array
    {
        $this->validateItemData($data);

        $list = $this->em->getRepository(ShoppingList::class)->find($shoppingListId);

        if (!$list) {
            throw new ResourceNotFoundException('Shopping list not found');
        }

        $item = $this->createItem($data, $list);

        $list->addItem($item);

        try {
            $this->em->persist($item);
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new DatabaseOperationException('Failed to create item. ' . $e->getMessage());
        }

        return $this->shoppingListMapper->map($list);
    }

    public function updateItem(int $shoppingListId, int $itemId, array $data): array
    {
        $item = $this->em->getRepository(Item::class)->find($itemId);

        if (!$item) {
            throw new ResourceNotFoundException('Item not found');
        }

        if ($item->getShoppingList()->getId() !== $shoppingListId) {
            throw new ValidationException(['shopping_list_id' => 'Item does not belong to the specified shopping list']);
        }

        if (isset($data['name'])) {
            $item->setName($data['name']);
        }

        if (isset($data['quantity'])) {
            $item->setQuantity($data['quantity']);
        }

        if (isset($data['is_completed'])) {
            $item->setIsCompleted($data['is_completed']);
        }

        try {
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new DatabaseOperationException(
                'Failed to update item. ' . $e->getMessage()
            );
        }

        return $this->itemMapper->map($item);
    }

    public function deleteItem(int $shoppingListId, int $id): void
    {
        $item = $this->em->getRepository(Item::class)->find($id);

        if (!$item) {
            throw new ResourceNotFoundException('Item not found');
        }

        if ($item->getShoppingList()->getId() !== $shoppingListId) {
            throw new ValidationException(['shopping_list_id' => 'Item does not belong to the specified shopping list']);
        }

        try {
            $this->em->remove($item);
            $this->em->flush();
        } catch (\Throwable $e) {
            throw new DatabaseOperationException('Failed to delete item. ' . $e->getMessage());
        }
    }

    public function validateItemData(array $data, int $itemId = null): void
    {
        $exception = new ValidationException();

        if (empty($data['name'])) {
            $exception->addError('name', 'Item name is required');
        }

        if (!empty($data['quantity'])) {
            is_numeric($data['quantity']) || $exception->addError('quantity', 'Quantity must be a number');
        }

        if (isset($data['is_completed'])) {
            is_bool($data['is_completed']) || $exception->addError('is_completed', 'Is completed must be a boolean');
        }

        if (!$itemId) {
            $item = $this->em->getRepository(Item::class)->findOneBy(['name' => $data['name']]);
            if ($item) {
                $exception->addError('name', 'Item with this name already exists');
            }
        }

        if (count($exception->getErrors()) > 0) {
            throw $exception;
        }
    }

    public function completeItem(int $shoppingListId, int $itemId)
    {

    }

}
