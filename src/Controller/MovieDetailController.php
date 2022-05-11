<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailController extends AbstractController
{

    private $moviesRepo;

    public function __construct(MovieRepository $mRepo) {
        $this->moviesRepo = $mRepo;
    }


    #[Route('/movie/detail/{id}', name: 'app_movie_detail')]
    public function index($id): Response
    {

        $movie = $this->moviesRepo->getOneWithJoin($id)[0];
        //dd($movie);
        return $this->render('movie_detail/index.html.twig', [
            'movie' => $movie
        ]);
    }
}
