<?php

namespace App\Controller\Admin;

use App\Entity\UserType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserType::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title')
        ];
    }

}
