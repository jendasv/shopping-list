<?php

namespace App\Controller\Api;

use App\Service\ItemService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/lists/{id}/', name: 'api_items_')]
final class ItemController extends AbstractController
{

    private ItemService $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    #[Route('item', name: 'create', methods: ['POST'])]
    public function createItem(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $list = $this->itemService->createItemForList($id, $data);

        return $this->json($list, 201);
    }

    #[Route('items/{itemId}', name: 'detail', methods: ['GET'])]
    public function getItem(int $id, int $itemId): JsonResponse
    {
        $item = $this->itemService->getItem($itemId);

        return $this->json($item);
    }

    #[Route('items/{itemId}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id, int $itemId): JsonResponse
    {
        $this->itemService->deleteItem($id, $itemId);

        return $this->json(null, 204);
    }

    #[Route('items/{itemId}', name: 'update', methods: ['PUT'])]
    public function update($id, $itemId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $item = $this->itemService->updateItem($id, $itemId, $data);

        return $this->json($item, 200);
    }

}
