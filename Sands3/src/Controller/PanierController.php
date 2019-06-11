<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 02/06/2019
 * Time: 23:56
 */

namespace App\Controller;

use App\Entity\Livraison;
use App\Form\LivraisonType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PanierController extends Controller
{
    /**
     * @Route("/ajouter/{id}", name="ajouter")
     */
    public function ajouterAction(Request $request,$id) {
        //Création variable session "panier"
        $session = $request->getSession();
        //Si le panier dans la session est vide, initialisation
        if (!$session->has('panier'))
            $session->set('panier', array());
            $panier = $session->get('panier');

        //Assigne une quantité à l'article
        if (array_key_exists($id, $panier)){
            if ($request->query->get('qte') !=null)
                $panier[$id] = $request->query->get('qte');
        } else {
            if ($request->query->get('qte') !=null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;
        }

        //Genere un tableau "panier" dans la session
        $session->set('panier', $panier);
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/supprimer/{id}", name="supprimer")
     */
    public function supprimerAction(Request $request,$id){
        $session =  $request->getSession();
        $panier = $session->get('panier');

        if (array_key_exists($id, $panier)){
            unset($panier[$id]);
            $session->set('panier',$panier);
        }
        return $this->redirect($this->generateUrl('panier'));
    }

    /**
     * @Route("/panier", name="panier")
     */
    public function panierAction(Request $request){
        $session = $request->getSession();
        if (!$session->has('panier'))
            $session->set('panier', array());
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('App:Article')->findArray(array_keys($session->get('panier')));

        return $this->render('panier/index.html.twig', array(
            'articles' => $articles, 'panier' => $session->get('panier')));
    }

    /**
     * @Route("/livraison", name="livraison")
     */
    public function livraisonAction(Request $request){
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $livraison = new Livraison();
        $form = $this->createForm(LivraisonType::class, $livraison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraison->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livraison);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('livraison'));
        }

        return $this->render('panier/livraison.html.twig',[
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("livraison/delete/{id}", name="delete_livraison")
     * @Method({"DELETE"})
     */
    public function livraisonDelete($id){
        // On récupere l'article en question à l'aide son id
        $adresse = $this->getDoctrine()
            ->getRepository('App:Livraison')
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        // On supprime l'article à l'aide de remove
        $entityManager->remove($adresse);
        $entityManager->flush();
        return $this->redirect($this->generateUrl('livraison'));
    }

    public function setLivraisonOnSession(Request $request)
    {
        $session =  $request->getSession();

        if (!$session->has('adresse')) $session->set('adresse',array());
        $adresse = $session->get('adresse');

        if ($request->request->get('livraison') != null)
        {
            $adresse['livraison'] = $request->request->get('livraison');
        } else {
            return $this->redirect($this->generateUrl('validation'));
        }

        $session->set('adresse',$adresse);
        return $this->redirect($this->generateUrl('validation'));
    }

    /**
     * @Route("/validation", name="validation")
     */
    public function validationAction(Request $request)
    {
        if($request->getMethod() == 'POST')
            $this->setLivraisonOnSession($request);

        $em = $this->getDoctrine()->getManager();

        $session =  $request->getSession();
        $adresse = $session->get('adresse');

        $articles = $em->getRepository('App:Article')->findArray(array_keys($session->get('panier')));
        $livraison = $em->getRepository('App:Livraison')->find($adresse['livraison']);

        return $this->render('panier/validation.html.twig', array(
            'articles' => $articles,
            'livraison' => $livraison,
            'panier' => $session->get('panier')
        ));
    }
}