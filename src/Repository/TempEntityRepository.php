<?php

namespace App\Repository;

use App\Entity\TempEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TempEntity>
 *
 * @method TempEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TempEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TempEntity[]    findAll()
 * @method TempEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TempEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TempEntity::class);
    }

//    /**
//     * @return TempEntity[] Returns an array of TempEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TempEntity
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
