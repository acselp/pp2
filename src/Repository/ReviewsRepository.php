<?php

namespace App\Repository;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Reviews;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reviews>
 *
 * @method Reviews|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reviews|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reviews[]    findAll()
 * @method Reviews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewsRepository extends ServiceEntityRepository
{
    public $em;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reviews::class);
        $this->em = $registry;
    }

    public function add(Reviews $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reviews $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getAverageRateForMovie($id)
    {
        $reviews = $this->createQueryBuilder('r')

            ->select('avg(r.rate)')
            ->where('r.movie_id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();


        return round($reviews[0][1], 1);
    }


    public function getAllWithJoinForOneMovie($id)
    {
        $reviews = $this->createQueryBuilder('r')

            ->innerJoin(User::class, 'u', 'WITH', 'r.author_id = u.id')
            ->innerJoin(Movie::class, 'm', 'WITH', 'r.movie_id = m.id')
            ->select('r, u, m')
            ->where('m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getScalarResult();


        return $reviews;
    }

//    /**
//     * @return Reviews[] Returns an array of Reviews objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reviews
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
