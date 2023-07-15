<?php

namespace App\Helper;


class MealHelper
{

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
}
