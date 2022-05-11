<?php

namespace App\Repository;

use App\Entity\AgeRestriction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AgeRestriction>
 *
 * @method AgeRestriction|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgeRestriction|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgeRestriction[]    findAll()
 * @method AgeRestriction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgeRestrictionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgeRestriction::class);
    }

    public function add(AgeRestriction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AgeRestriction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getAll(): array
    {
        return $this->createQueryBuilder('g')
            ->select('g.title', 'g.id')
            //->where('g.active = 1')
            ->getQuery()
            ->execute();
    }

//    /**
//     * @return AgeRestriction[] Returns an array of AgeRestriction objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AgeRestriction
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
