<?php

namespace App\Repository;

use App\Entity\Caravan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Caravan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caravan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caravan[]    findAll()
 * @method Caravan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaravanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caravan::class);
    }

    // /**
    //  * @return Caravan[] Returns an array of Caravan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Caravan
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
