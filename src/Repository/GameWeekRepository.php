<?php

namespace App\Repository;

use App\Entity\GameWeek;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameWeek|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameWeek|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameWeek[]    findAll()
 * @method GameWeek[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameWeekRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameWeek::class);
    }

    // /**
    //  * @return GameWeek[] Returns an array of GameWeek objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GameWeek
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
