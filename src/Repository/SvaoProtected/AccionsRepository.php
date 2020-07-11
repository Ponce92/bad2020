<?php

namespace App\Repository\SvaoProtected;

use App\Entity\SvaoProtected\Accions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Accions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accions[]    findAll()
 * @method Accions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accions::class);
    }

    // /**
    //  * @return Accions[] Returns an array of Accions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Accions
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
