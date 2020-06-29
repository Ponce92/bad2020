<?php

namespace App\Repository\SvaoPrivate;

use App\Entity\SvaoPrivate\Ciudad;
use App\Entity\SvaoPrivate\HorarioVuelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HorarioVuelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method HorarioVuelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method HorarioVuelo[]    findAll()
 * @method HorarioVuelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorarioVueloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HorarioVuelo::class);
    }



    // /**
    //  * @return HorarioVuelo[] Returns an array of HorarioVuelo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HorarioVuelo
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findHorarios(Ciudad $origen,Ciudad $destino):array
    {

        $sql=$this->createQueryBuilder('t')
                ->where('t.tipo = :destino')
                ->setParameter('destino','out');

        $query=$sql->getQuery();

        return $query->execute();
    }
}
