<?php

namespace App\Controller\Admin;

use App\Entity\AgeRestriction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AgeRestrictionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AgeRestriction::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
