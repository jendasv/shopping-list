<?php

namespace App\Controller\Api;

use App\Service\ShoppingListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/lists', name: 'api_lists_')]
final class ShoppingListController extends AbstractController
{

    private ShoppingListService $shoppingListService;

    public function __construct(ShoppingListService $shoppingListService)
    {
        $this->shoppingListService = $shoppingListService;
    }

    #[Route('/{id}/items', name: 'get', methods: ['GET'])]
    public function getList(int $id): JsonResponse
    {
        $data = $this->shoppingListService->getList($id);

        return $this->json($data, 200);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function createList(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $shoppingList = $this->shoppingListService->createList($data);

        return $this->json($shoppingList, 201);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteList(int $id): JsonResponse
    {
        $this->shoppingListService->deleteList($id);

        return $this->json(
            null,
            204
        );
    }
}
