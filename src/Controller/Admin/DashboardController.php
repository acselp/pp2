<?php

namespace App\Controller\Admin;

use App\Entity\AgeRestriction;
use App\Entity\Country;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Quality;
use App\Entity\Reviews;
use App\Entity\User;
use App\Entity\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Blog');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::subMenu('Users', 'fa fa-user')
            ->setSubItems([
                MenuItem::linkToCrud('User', '', User::class),
                MenuItem::linkToCrud('User Types', '', UserType::class)
            ]);

        yield MenuItem::subMenu('Movies', 'fa fa-film')
            ->setSubItems([
                MenuItem::linkToCrud('Movie', '', Movie::class),
                MenuItem::linkToCrud('Qualities', '', Quality::class),
                MenuItem::linkToCrud('Genre', '', Genre::class),
                MenuItem::linkToCrud('Age restriction', '', AgeRestriction::class),
                MenuItem::linkToCrud('Reviews', '', Reviews::class)
            ]);

        yield MenuItem::linkToCrud('Countries', 'fa fa-map-marker', Country::class);
    }
}
