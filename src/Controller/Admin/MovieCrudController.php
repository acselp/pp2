<?php

namespace App\Controller\Admin;

use App\Entity\AgeRestriction;
use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\Quality;
use App\Repository\AgeRestrictionRepository;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use App\Repository\QualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieCrudController extends AbstractCrudController
{
    private $entityManager;
    private $moviesRepo;
    private $ageRepo;
    private $genreRepo;
    private $qualityRepo;

    public function __construct(EntityManagerInterface $em, MovieRepository $mRepo, GenreRepository $gRepo, QualityRepository $qRepo, AgeRestrictionRepository $ageRepo) {
        $this->entityManager = $em;
        $this->moviesRepo = $mRepo;
        $this->genreRepo = $gRepo;
        $this->qualityRepo = $qRepo;
        $this->ageRepo = $ageRepo;
    }



    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        //Pentru gen
        $repo = $this->entityManager->getRepository(Genre::class);
        $cats = $this->genreRepo->getAll();
        $cat = array();
        //dd($cats);
        foreach($cats as $c) {
            $cat[$c['title']] = $c['id'];
        }
        //dd($cat);

        //Pentru varsta
        $repo = $this->entityManager->getRepository(AgeRestriction::class);
        $ages = $this->ageRepo->getAll();
        $age = array();
        foreach($ages as $a) {
            $age[$a['title']] = $a['id'];
        }
        //dd($age);

        //Pentru calitate
        $repo = $this->entityManager->getRepository(Quality::class);
        $qualities = $this->qualityRepo->getAll();
        $quality = array();
        foreach($qualities as $q) {
            $quality[$q['title']] = $q['id'];
        }


        return [
            BooleanField::new('active', "Active")->setValue(true)->hideWhenUpdating(),
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Title'),
            TextField::new('country', 'Country'),
            ImageField::new('path', 'Video file')->setBasePath('public\\upload\\movies\\video')->setUploadDir('public\\upload\\movies\\video')->setUploadedFileNamePattern('[year][month][day][contenthash].[extension]'),
            ChoiceField::new('genre_id', 'Genre')->setChoices($cat),
            ImageField::new('image', 'Image')->setUploadDir('public\\upload\\movies\\image')->setUploadedFileNamePattern('[year][month][day][contenthash].[extension]'),
            IntegerField::new('release_year', 'Release year'),
            IntegerField::new('running_time', 'Running time (min)'),
            TextareaField::new('short_summary', 'Short summary')->onlyWhenCreating(),
            ChoiceField::new('quality', 'Quality')->setChoices($quality),
            ChoiceField::new('age_restriction', 'Age restriction')->setChoices($age)

        ];
    }

}
