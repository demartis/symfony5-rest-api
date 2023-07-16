<?php

namespace App\Helper;

use App\Repository\LanguageRepository;
use App\Repository\TranslationRepository;



class MealHelper
{
    private $translationRepository;
    private $languageRepository;

    public function __construct(
        TranslationRepository $translationRepository,
        LanguageRepository $languageRepository
    )
    {
        $this->translationRepository = $translationRepository;
        $this->languageRepository = $languageRepository;

    }

    public function countTotalItems($queryBuilder): int
    {
        $alias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->resetDQLPart('select')->select('COUNT(DISTINCT ' . $alias . '.id)');

        return (int)$queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function generateUrl($request, $page): string
    {
        $queryParameters = $request->query->all();
        $queryParameters['page'] = $page;
        $queryString = http_build_query($queryParameters);

        return $request->getSchemeAndHttpHost() . $request->getPathInfo() . '?' . $queryString;
    }

    public function translate(string $keyword, string $lang): ?string
    {
        $translation = $this->translationRepository->findOneBy(['keyword' => $keyword, 'language' => $lang]);

        return $translation ? $translation->getValue() : null;
    }

    public function getLanguageId(string $name): ?int
    {
        return $this->languageRepository->findByName($name)->getId();
    }
}
