<?php

namespace App\Repository;

use App\Entity\Likeforum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Likeforum>
 *
 * @method Likeforum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Likeforum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Likeforum[]    findAll()
 * @method Likeforum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeforumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Likeforum::class);
    }

//    /**
//     * @return Likeforum[] Returns an array of Likeforum objects
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

//    public function findOneBySomeField($value): ?Likeforum
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
