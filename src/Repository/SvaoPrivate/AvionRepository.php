<?php

namespace App\Repository\SvaoPrivate;

use App\Entity\SvaoPrivate\Aerolinea;
use App\Entity\SvaoPrivate\Avion;
use App\Entity\SvaoPrivate\Pais;
use App\Entity\SvaoPrivate\TipoAvion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Avion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Avion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Avion[]    findAll()
 * @method Avion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Avion::class);
    }

    // /**
    //  * @return Avion[] Returns an array of Avion objects
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
    public function findOneBySomeField($value): ?Avion
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getCode(Aerolinea $linea,TipoAvion $tipoAvion){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'select FN_GENERATE_CODE_AVION(:id1,:id2);';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id1' => $linea->getId(),'id2'=>$tipoAvion->getId()]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetch(0);
        $stmt = $conn->prepare($sql);
    }
}
