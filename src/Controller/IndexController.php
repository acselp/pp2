<?php

namespace App\Controller;

use App\Repository\MovieRepository;
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
    public function index(): Response
    {
        $res = $this->moviesRepo->getAllWithJoin();
        $movies = array();
        //dd($res);
        foreach ($res as $r) {
            $movies[] = $r;
        }

//        if ($this->isGranted('ROLE_USER') == false) {
//            dd('Not auth');
//        }
//        else {
//            dd('Authed');
//        }

        return $this->render('index/index.html.twig',
            ['movies' => $movies]
        );
    }
}
