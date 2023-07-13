<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealController extends AbstractController
{
    /**
     * @Route("/meal", name="app_meal")
     */
    public function index(): Response
    {
        return $this->render('meal/index.html.twig', [
            'controller_name' => 'MealController',
        ]);
    }
}
