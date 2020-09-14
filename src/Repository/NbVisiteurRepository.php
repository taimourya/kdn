<?php

namespace App\Repository;

use App\Entity\NbVisiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NbVisiteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method NbVisiteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method NbVisiteur[]    findAll()
 * @method NbVisiteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NbVisiteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NbVisiteur::class);
    }

    // /**
    //  * @return NbVisiteur[] Returns an array of NbVisiteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NbVisiteur
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
