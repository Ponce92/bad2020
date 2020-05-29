<?php

namespace App\Repository\SvaoPrivate;

use App\Entity\SvaoPrivate\ModeloAvion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ModeloAvion|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModeloAvion|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModeloAvion[]    findAll()
 * @method ModeloAvion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModeloAvionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModeloAvion::class);
    }

    // /**
    //  * @return ModeloAvion[] Returns an array of ModeloAvion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ModeloAvion
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
