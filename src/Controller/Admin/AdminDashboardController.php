<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class AdminDashboardController extends AbstractDashboardController
{
    private EntityManagerInterface $em;

    // Inject EntityManager via constructor
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function index(): Response
    {
        // Agora usamos $this->em
        $postsCount = $this->em->getRepository(Post::class)->count([]);
        $commentsCount = $this->em->getRepository(Comment::class)->count([]);
        $latestPosts = $this->em->getRepository(Post::class)->findBy([], ['createdAt' => 'DESC'], 5);

        $posts = $this->em->getRepository(Post::class)->findAll();
        $postsByMonth = [];
        foreach ($posts as $post) {
            $month = $post->getCreatedAt()->format('Y-m');
            $postsByMonth[$month] = ($postsByMonth[$month] ?? 0) + 1;
        }

        $comments = $this->em->getRepository(Comment::class)->findAll();
        $commentsByPost = [];
        foreach ($comments as $comment) {
            $title = $comment->getPost()->getTitle();
            $commentsByPost[$title] = ($commentsByPost[$title] ?? 0) + 1;
        }

        return $this->render('admin/dashboard.html.twig', [
            'posts_count' => $postsCount,
            'comments_count' => $commentsCount,
            'latest_posts' => $latestPosts,
            'posts_by_month' => $postsByMonth,
            'comments_by_post' => $commentsByPost,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('The Cabbage World');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Posts', 'fas fa-newspaper', Post::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comment::class);
    }
}
