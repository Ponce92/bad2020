<?php

namespace App\Repository\SvaoPrivate;

use App\Entity\SvaoPrivate\Aeropuerto;
use App\Entity\SvaoPrivate\Ciudad;
use App\Entity\SvaoPrivate\Vuelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vuelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vuelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vuelo[]    findAll()
 * @method Vuelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VueloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vuelo::class);
    }

    // /**
    //  * @return Vuelo[] Returns an array of Vuelo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vuelo
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getCode(Aeropuerto $origen,Aeropuerto $destino ){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select FN_GENERATE_CODE_VUELO(:id1,:id2);';
        $stmt = $conn->prepare($sql);
        $stmt->execute(
            [
                'id1' =>$origen->getCiudad()->getId(),
                'id2' =>$destino->getCiudad()->getId(),
            ]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch(0);
        $stmt = $conn->prepare($sql);
    }
}
