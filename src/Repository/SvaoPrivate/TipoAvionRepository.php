<?php

namespace App\Repository\SvaoPrivate;

use App\Entity\SvaoPrivate\TipoAvion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoAvion|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoAvion|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoAvion[]    findAll()
 * @method TipoAvion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoAvionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoAvion::class);
    }

    // /**
    //  * @return TipoAvion[] Returns an array of TipoAvion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TipoAvion
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
