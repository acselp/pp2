<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\ReviewFormType;
use App\Repository\MovieRepository;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieDetailController extends AbstractController
{

    private $moviesRepo;

    public function __construct(MovieRepository $mRepo) {
        $this->moviesRepo = $mRepo;
    }


    #[Route('/movie/detail/{id}', name: 'app_movie_detail')]
    public function index($id, Request $request, ReviewsRepository $reviewsRepo): Response
    {

        $movie = $this->moviesRepo->getOneWithJoin($id)[0];
        $reviewsAll = $reviewsRepo->getAllWithJoinForOneMovie($id);
        $avg_rate = $reviewsRepo->getAverageRateForMovie($id);
        //dd($avg_rate);

        $review = new Reviews();
        $review->setAuthorId($this->getUser()->getUserIdentifier());
        $review->setMovieId($id);
        //$date = new \DateTime('@' . strtotime('now'));
        //$review->setDate($date->get);
        //dd($date->);




        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);



        if ($form->isSubmitted() ) {
            //dd($review);

            $reviewsRepo->em->getManager()->persist($review);
            $reviewsRepo->em->getManager()->flush();

        }
        else if(!$this->isGranted('ROLE_USER')) {
            $this->redirectToRoute('app_login');
        }

        return $this->render('movie_detail/index.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
            'reviews' => $reviewsAll,
            'avg_rate' => $avg_rate
        ]);
    }
}
