<?php

namespace App\Repository;

use App\Entity\GameNight;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameNight|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameNight|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameNight[]    findAll()
 * @method GameNight[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameNightRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameNight::class);
    }

    // /**
    //  * @return GameNight[] Returns an array of GameNight objects
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
    public function findOneBySomeField($value): ?GameNight
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
