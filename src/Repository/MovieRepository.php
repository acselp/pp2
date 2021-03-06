<?php

namespace App\Repository;

use App\Entity\AgeRestriction;
use App\Entity\Country;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Quality;
use App\Entity\Reviews;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getAllWithJoin(): array
    {
        $movies = $this->createQueryBuilder('m')

            ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
            ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
            ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
            ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
            ->select('m, q, a, g, c')
            ->where('m.active = 1')
            ->getQuery()
            ->getScalarResult();

        return $movies;
    }





    public function getAll(): array
    {
        return $this->createQueryBuilder('g')
            ->select('g.title', 'g.id', 'g.active')
            ->where('g.active = 1')
            ->getQuery()
            ->execute();
    }

    public function getOneByTitle($title): array
    {
        $movies = $this->createQueryBuilder('m')

            ->select('m')
            ->where('m.active = 1 AND m.title = :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getScalarResult();

        return $movies;
    }

    public function getAllNew()
    {
        $movies = $this->createQueryBuilder('m')

            ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
            ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
            ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
            ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
            ->select('m, q, a, g, c')
            ->where('m.active = 1 AND m.new = 1')
            ->getQuery()
            ->getScalarResult();
        return $movies;
    }

    public function getOneWithJoin($id): array
    {
        $movies = $this->createQueryBuilder('m')

            ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
            ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
            ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
            ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
            ->select('m, q, a, g, c')
            ->where('m.active = 1 AND m.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getScalarResult();

//        $res = array();
//
//        for ($i = 0; $i < sizeof($movies); $i += 2) {
//            $res[] = array_merge($movies[$i], $movies[$i + 1]);
//        }
        //dd($movies);
        return $movies;
    }

    public function getRate($id)
    {
        return $this->createQueryBuilder('m')
            ->from(Reviews::class, 'r')
            ->select('avg(r.rate)')
            ->where('r.movie_id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getScalarResult()[0]
            ;
    }


    public function getAllWithFilter($genre, $quality)
    {
        if($quality === 'All' && $genre === 'All'){
        return $this->createQueryBuilder('m')

            ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
            ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
            ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
            ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
            ->select('m, q, a, g, c')
            ->where('m.active = 1')
            //->where('g.title = :genre and q.title = :quality')
            //->setParameters(['genre' => $genre, 'quality' => $quality])
            ->getQuery()
            ->getScalarResult();
        }
        else
        if($genre == 'All') {
            return $this->createQueryBuilder('m')

                ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
                ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
                ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
                ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
                ->select('m, q, a, g, c')
                ->where('m.active = 1')
                ->where('q.title = :quality')
                ->setParameters(['quality' => $quality])
                ->getQuery()
                ->getScalarResult();
        }
        else if($quality == 'All') {
            return $this->createQueryBuilder('m')

                ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
                ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
                ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
                ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
                ->select('m, q, a, g, c')
                ->where('m.active = 1')
                ->where('g.title = :genre')
                ->setParameters(['genre' => $genre])
                ->getQuery()
                ->getScalarResult();
        }


        return $this->createQueryBuilder('m')

            ->innerJoin(Genre::class, 'g', 'WITH', 'm.genre_id = g.id')
            ->innerJoin(Quality::class, 'q', 'WITH', 'm.quality = q.id')
            ->innerJoin(AgeRestriction::class, 'a', 'WITH', 'm.age_restriction = a.id')
            ->innerJoin(Country::class, 'c', 'WITH', 'm.country = c.id')
            ->select('m, q, a, g, c')
            ->where('m.active = 1')
            ->where('g.title = :genre and q.title = :quality')
            ->setParameters(['genre' => $genre, 'quality' => $quality])
            ->getQuery()
            ->getScalarResult();
    }

//    /**
//     * @return Movie[] Returns an array of Movie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Movie
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
