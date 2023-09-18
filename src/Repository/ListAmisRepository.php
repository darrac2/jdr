<?php

namespace App\Repository;

use App\Entity\ListAmis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListAmis>
 *
 * @method ListAmis|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListAmis|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListAmis[]    findAll()
 * @method ListAmis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListAmisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListAmis::class);
    }

//    /**
//     * @return ListAmis[] Returns an array of ListAmis objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ListAmis
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
