<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('content')
                ->setNumOfRows(20),
            DateTimeField::new('createdAt')
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->hideOnForm(),
            AssociationField::new('post')
                ->setRequired(true)
                ->setCrudController(PostCrudController::class)
                ->setFormTypeOption('choice_label', 'title'),
        ];
    }

    public function createEntity(string $entityFqcn): Comment
    {
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTimeImmutable());
        return $comment;
    }
}
