<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 31/05/2019
 * Time: 14:34
 */

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repository)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $articles = $repository->findLatest();
        return $this->render('homepage/home.html.twig', [
            'articles'=>$articles
        ]);
    }
}