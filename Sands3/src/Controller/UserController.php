<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 03/06/2019
 * Time: 11:02
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Knp\Component\Pager\PaginatorInterface;

class UserController extends Controller
{
    /**
     * @Route("/profil/{id}", name="profil")
     * Method({"GET", "POST"})
     */
    public function profil(PaginatorInterface $paginator,Request $request,$id) {
        $user = $this->getDoctrine()
            ->getRepository('App:User')
            ->find($id);
        $newUser = new User();
        $articles = $paginator->paginate(
            $this->getDoctrine()->getRepository('App:Article')->findBy(array('etat'=>'0')),
            $request->query->getInt('page', 1),
            5);
        $factures = $this->getDoctrine()->getRepository('App:Commande')->byFacture($this->getUser());
        $form = $this->createFormBuilder($newUser)
            ->add('solde',MoneyType::class,array(
                'currency' => false,
                'label'=>false,
                'attr' => array('placeholder' => 'Choissisez un montant')))
            ->getForm();
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        $user->setSolde($newUser->getSolde()+$user->getSolde());
        if ($form->isSubmitted() && $newUser->getSolde() > 0 /*&& $form->isValid()*/) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'Votre solde est mis à jour.');
            //return $this->redirectToRoute('login');
        }
        return $this->render('profil/index.html.twig', [
            'user'=>$user,
            'articles'=>$articles,
            'factures'=>$factures,
            'form' => $form->createView()
        ]);
    }
}