<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserTypeRepository;
use Doctrine\DBAL\Types\JsonType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Json;

class UserCrudController extends AbstractCrudController
{

    private $roles_repo;

    public function __construct(UserTypeRepository $user_type_repo) {
        $this->roles_repo = $user_type_repo;
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {



        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('email'),
            ArrayField::new('roles')
                ->setHelp('Available roles: ROLE_ADMIN, ROLE_USER'),
            TextField::new('password'),
        ];
    }

}
