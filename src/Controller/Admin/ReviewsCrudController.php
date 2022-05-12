<?php

namespace App\Controller\Admin;

use App\Entity\Reviews;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReviewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reviews::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextField::new('author_id'),
            TextField::new('rate'),
            TextField::new('movie_id'),
            TextEditorField::new('text'),
        ];
    }

}
