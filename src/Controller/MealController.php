<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Helper\MealHelper;
use App\Validator\ParamsValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api', name: 'api_')]
class MealController extends AbstractController
{

    private $mealHelper;
    private $paramsValidator;
    public function __construct(MealHelper $mealHelper, ParamsValidator $paramsValidator)
    {
        $this->mealHelper = $mealHelper;
        $this->paramsValidator = $paramsValidator;
    }

    #[Route('/meals', name: 'meals_get', methods:['get'])]
    public function index(Request $request): JsonResponse
    {

        $errors = $this->paramsValidator->validateParameters($request);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => $errors], 400);
        }

        $perPage = $request->query->get('per_page', 10);
        $page = $request->query->get('page', 1);
        $category = $request->query->get('category');
        $tags = $request->query->get('tags');
        $with = $request->query->get('with');
        $lang = $request->query->get('lang');
        $diffTime = $request->query->get('diff_time');

        $repository = $this->getDoctrine()->getRepository(Meal::class);
        $queryBuilder = $repository->createQueryBuilder('m')
            ->select('m.id, t.title, t.description, m.status')
            ->leftJoin('m.category', 'c')
            ->leftJoin('m.tags', 't2')
            ->leftJoin('m.ingredients', 'i');

        if ($diffTime > 0) {
            $queryBuilder->andWhere('m.created_at >= :diffTime OR m.updated_at >= :diffTime OR m.deleted_at >= :diffTime')
                ->setParameter('diffTime', $diffTime);
        }

        if ($category) {
            $queryBuilder->andWhere('c.id = :category')
                ->setParameter('category', $category);
        }

        if ($tags) {
            $tagIds = explode(',', $tags);
            $queryBuilder->andWhere('t2.id IN (:tagIds)')
                ->setParameter('tagIds', $tagIds)
                ->groupBy('m.id')
                ->having('COUNT(DISTINCT t2.id) = :tagCount')
                ->setParameter('tagCount', count($tagIds));
        }

        $queryBuilder->setMaxResults($perPage)
            ->setFirstResult(($page - 1) * $perPage);

        $results = $queryBuilder->getQuery()->getArrayResult();

        $totalItems = $this->mealHelper->countTotalItems($queryBuilder);
        $totalPages = ceil($totalItems / $perPage);

        $response = [
            'meta' => [
                'currentPage' => $page,
                'totalItems' => $totalItems,
                'itemsPerPage' => $perPage,
                'totalPages' => $totalPages,
            ],
            'data' => $results,
            'links' => [
                'prev' => ($page > 1) ? $this->mealHelper->generateUrl($request, $page - 1) : null,
                'next' => ($page < $totalPages) ? $this->mealHelper->generateUrl($request, $page + 1) : null,
                'self' => $this->mealHelper->generateUrl($request, $page),
            ],
        ];

        return new JsonResponse($response);
    }
}
