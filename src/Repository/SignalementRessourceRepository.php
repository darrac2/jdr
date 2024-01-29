<?php

namespace App\Repository;

use App\Entity\SignalementRessource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SignalementRessource>
 *
 * @method SignalementRessource|null find($id, $lockMode = null, $lockVersion = null)
 * @method SignalementRessource|null findOneBy(array $criteria, array $orderBy = null)
 * @method SignalementRessource[]    findAll()
 * @method SignalementRessource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignalementRessourceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SignalementRessource::class);
    }

//    /**
//     * @return SignalementRessource[] Returns an array of SignalementRessource objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SignalementRessource
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
