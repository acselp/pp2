<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(MovieRepository $movieRepository): Response
    {
        $title = $_GET['req'];

        $movie = $movieRepository->getOneByTitle($title);

        return new JsonResponse(json_encode($movie));
    }


}
