<?php

namespace App\Repository;

use App\Entity\Signalementforum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Signalementforum>
 *
 * @method Signalementforum|null find($id, $lockMode = null, $lockVersion = null)
 * @method Signalementforum|null findOneBy(array $criteria, array $orderBy = null)
 * @method Signalementforum[]    findAll()
 * @method Signalementforum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignalementforumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Signalementforum::class);
    }

//    /**
//     * @return Signalementforum[] Returns an array of Signalementforum objects
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

//    public function findOneBySomeField($value): ?Signalementforum
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
