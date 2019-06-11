<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 02/06/2019
 * Time: 16:12
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class AdminController extends Controller
{
    /**
     * @Route("/administration", name="admin")
     */
    public function indexArticle(PaginatorInterface $paginator, Request $request) {
        $articles = $paginator->paginate(
            $this->getDoctrine()->getRepository('App:Article')->findBy(array('etat'=>'0')),
            $request->query->getInt('page', 1),
            5);
        return $this->render('admin/pages/article.html.twig', [
            'articles'=>$articles
        ]);
    }
}