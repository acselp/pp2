<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Repository\ReviewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $moviesRepo;

    public function __construct(MovieRepository $mRepo) {
        $this->moviesRepo = $mRepo;
    }

    #[Route('/', name: 'app_index')]
    public function index(ReviewsRepository $reviewsRepo): Response
    {
        $res = $this->moviesRepo->getAllNew();
        $movies = array();
        //dd($res);
        foreach ($res as $r) {
            //dd($r);
            $r['avg_rate'] = $reviewsRepo->getAverageRateForMovie($r['m_id']);
            $movies[] = $r;
        }

        $res = $this->moviesRepo->getAllWithJoin();
        $moviesAll = array();
        foreach ($res as $r) {
            //dd($r);
            $r['avg_rate'] = $reviewsRepo->getAverageRateForMovie($r['m_id']);
            $moviesAll[] = $r;
        }

        //dd($moviesAll);

        return $this->render('index/index.html.twig',
            ['movies' => $movies,
                'moviesAll' => $moviesAll]
        );
    }
}
