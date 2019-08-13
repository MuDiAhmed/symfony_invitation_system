<?php

namespace App\Repository;

use App\Entity\Invitaion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Invitaion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invitaion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invitaion[]    findAll()
 * @method Invitaion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitaionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Invitaion::class);
    }

    // /**
    //  * @return Invitaion[] Returns an array of Invitaion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Invitaion
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
