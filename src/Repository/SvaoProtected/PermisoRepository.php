<?php

namespace App\Repository\SvaoProtected;

use App\Entity\SvaoProtected\Permiso;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Permiso|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permiso|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permiso[]    findAll()
 * @method Permiso[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermisoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permiso::class);
    }

    // /**
    //  * @return Permiso[] Returns an array of Permiso objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Permiso
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findGroupsBy(){

        $list=$this->createQueryBuilder('q')
            ->andWhere('q.protegido= :val')
            ->setParameter('val',false)
            ->select('q.grupo')
            ->distinct()
            ->getQuery()
            ->getResult();

        return $list;
    }

}
