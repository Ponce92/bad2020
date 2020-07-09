<?php

namespace App\Repository\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Aerolinea|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aerolinea|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aerolinea[]    findAll()
 * @method Aerolinea[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AerolineaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aerolinea::class);
    }

    // /**
    //  * @return Aerolineas[] Returns an array of Aerolineas objects
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
    public function findOneBySomeField($value): ?Aerolineas
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getCode($name){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select FN_GENERATE_CODE_AEROLINEAS(:name);';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch(0);
        $stmt = $conn->prepare($sql);
    }
}
