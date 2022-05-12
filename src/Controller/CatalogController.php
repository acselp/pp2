<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\QualityRepository;
use App\Repository\ReviewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogController extends AbstractController
{
    #[Route('/catalog', name: 'app_catalog')]
    public function index(GenreRepository $genreRepo, QualityRepository $qualityRepo, ReviewsRepository $rateRepo, MovieRepository $movieRepo): Response
    {

        $genres = $genreRepo->getAll();
        $qualities = $qualityRepo->getAll();
        $movies = $movieRepo->getAllWithJoin();
        //dd($movies);
        //dd($_GET);


        $movies2 = array();
        foreach($movies as $movie)
        {
            $movie['rate'] = $rateRepo->getAverageRateForMovie($movie['m_id']);
            $movies2[] = $movie;
        }

        $movies = $movies2;

        //dd($movies);



        return $this->render('catalog/index.html.twig', [
            'controller_name' => 'CatalogController',
            'genres' => $genres,
            'qualities' => $qualities,
            'movies' => $movies

        ]);
    }


    #[Route('/catalog/ajax', name: 'app_catalog_ajax')]
    public function catalogAjax(MovieRepository $movieRepo, ReviewsRepository $rateRepo)
    {
        $movies = $movieRepo->getAllWithFilter($_GET['genre'], $_GET['quality']);

        $movies2 = array();
        foreach($movies as $movie)
        {
            $movie['rate'] = $rateRepo->getAverageRateForMovie($movie['m_id']);
            $movies2[] = $movie;
        }

        $movies = $movies2;

        //dd($movies);

        return new JsonResponse(json_encode($movies));

    }
}
