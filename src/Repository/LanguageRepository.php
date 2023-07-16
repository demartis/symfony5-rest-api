<?php

namespace App\Repository;

use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;


class LanguageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Language::class);
    }

    public function findByName(string $name): ?Language
    {
        return $this->createQueryBuilder('l')
            ->where('l.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
    

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
