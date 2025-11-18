<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;      
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;    

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('content')->setNumOfRows(10),
            ImageField::new('image')
                ->setBasePath('/uploads/images')
                ->setUploadDir('public/uploads/images')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired($pageName === Crud::PAGE_NEW),
            DateTimeField::new('createdAt')->setFormat('yyyy-MM-dd HH:mm:ss')->hideOnForm(),
            DateTimeField::new('updatedAt')->setFormat('yyyy-MM-dd HH:mm:ss')->hideOnForm(),
            AssociationField::new('comments')->hideOnForm(),
        ];
    }

        public function createEntity(string $entityFqcn): Post
    {
        $post = new Post();
        $post->setCreatedAt(new \DateTimeImmutable());
        return $post;
    }

    public function updateEntity($entityManager, $entityInstance): void
    {
        $entityInstance->setUpdatedAt(new \DateTimeImmutable());
        parent::updateEntity($entityManager, $entityInstance);
    }

    
}
