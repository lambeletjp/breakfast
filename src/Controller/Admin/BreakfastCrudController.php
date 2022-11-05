<?php

namespace App\Controller\Admin;

use App\Entity\Breakfast;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BreakfastCrudController extends AbstractCrudController {

  public static function getEntityFqcn(): string {
    return Breakfast::class;
  }

  public function configureFields(string $pageName): iterable {
    yield AssociationField::new('dishes');
    yield TextField::new('name');

    if (Crud::PAGE_EDIT === $pageName) {
      $createdAt = DateTimeField::new('createdAt')->setFormTypeOptions([
        'html5' => TRUE,
        'years' => range(date('Y'), date('Y') + 5),
        'widget' => 'single_text',
      ]);
      yield $createdAt->setFormTypeOption('disabled', TRUE);
    }

  }

}