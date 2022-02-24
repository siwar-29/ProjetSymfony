<?php

namespace App\Repository;

use App\Entity\SearchByCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SearchByCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchByCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchByCategory[]    findAll()
 * @method SearchByCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchByCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchByCategory::class);
    }

    // /**
    //  * @return SearchByCategory[] Returns an array of SearchByCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SearchByCategory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
