<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api', name: 'api_')]
class MealController extends AbstractController
{
    #[Route('/meals', name: 'meals_get', methods:['get'])]
    public function index(): JsonResponse
    {
        // Retrieve the collection of meals from your data source
        $meals = [
            "meal-1" => "aaaaa test",
        ];

        // Return the meals as a JSON response
        return $this->json($meals);
    }
}
