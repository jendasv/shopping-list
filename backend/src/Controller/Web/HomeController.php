<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('', name: 'home', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Shopping List API',
            'status' => 'ok',
        ]);
    }
}
