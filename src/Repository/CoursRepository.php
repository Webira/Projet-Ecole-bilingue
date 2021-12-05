<?php

namespace App\Repository;

use App\Entity\Cours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cours|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cours|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cours[]    findAll()
 * @method Cours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cours::class);
    }

    /**
     // * @return Cours[] Returns an array of Cours objects
      /*/

    public function findByDateAt($dataAt)
    {
        return $this->createQueryBuilder('c')

            ->orderBy('c.dateAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }


     public function findByEleve($eleve)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.eleve','e')
            ->andWhere('e.id = :eleve')
            ->setParameter('eleve', $eleve)
            ->orderBy('c.eleve', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    /*public function findByDateAt($dataAt, $id)
 {
     return $this->createQueryBuilder('c')
         ->andWhere('c.dateAt = :dateAt')
         //->setParameter('dateAt', $dateAt)
         ->orderBy('c.id', 'ASC')
         ->setMaxResults(10)
         ->getQuery()
         ->getResult()
     ;
 }*/

    /*
    public function findOneBySomeField($value): ?Cours
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
