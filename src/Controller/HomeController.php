<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        // Hardcoded category type is to be changed
        $featured = $this->getDoctrine()->getRepository(Category::class)
            ->find(42);
        //
        $page = $request->get('page', 1) - 1;
        $limit = 10;
        // Fetch posts
        $query = $this->getDoctrine()->getRepository(Post::class)
            ->createQueryBuilder('post')
            ->setMaxResults($limit)
            ->setFirstResult($page * $limit);
        // Paginate
        $posts = new Paginator($query);
        $count = count($posts);
        // View
        return $this->render('home/index.html.twig', [
            'featured' => $featured,
            'posts' => $posts,
            'total' => $count,
            'limit' => $limit,
            'page' => $page
        ]);
    }
}
