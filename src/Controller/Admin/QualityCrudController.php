<?php

namespace App\Controller\Admin;

use App\Entity\Quality;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QualityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quality::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
        ];
    }

}
