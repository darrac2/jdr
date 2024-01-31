<?php

namespace App\Repository;

use App\Entity\Signalementforumcommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Signalementforumcommentaire>
 *
 * @method Signalementforumcommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Signalementforumcommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Signalementforumcommentaire[]    findAll()
 * @method Signalementforumcommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignalementforumcommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Signalementforumcommentaire::class);
    }

//    /**
//     * @return Signalementforumcommentaire[] Returns an array of Signalementforumcommentaire objects
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

//    public function findOneBySomeField($value): ?Signalementforumcommentaire
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
