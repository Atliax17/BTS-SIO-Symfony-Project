<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 09/06/2019
 * Time: 19:18
 */

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends Controller
{
    public function facture(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $panier = $session->get('panier');
        $commande = array();
        $totalHT = 0;

        $produits = $em->getRepository('App:Article')->findArray(array_keys($session->get('panier')));

        foreach($produits as $produit)
        {
            $prixHT = ($produit->getPrice() * $panier[$produit->getId()]);
            $totalHT += $prixHT;

            $commande['reference'][$produit->getId()] = $produit->getName();
            $commande['quantite'][$produit->getId()] = $panier[$produit->getId()];
            $commande['prix'][$produit->getId()] = round($produit->getPrice(),2);
        }
        $commande['prixHT'] = round($totalHT,2);
        return $commande;
    }

    /**
     * @Route("/achat", name="achat")
     */
    public function prepareCommandeAction(Request $request)
    {
        $session = $request->getSession();

        $commande = new Commande();

        $commande->setDate(new \DateTime());
        $commande->setUser($this->container->get('security.token_storage')->getToken()->getUser());
        $commande->setCommande($this->facture($request));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($commande);
        $entityManager->flush();

        $session->remove('adresse');
        $session->remove('panier');
        $session->remove('commande');
        return $this->redirect($this->generateUrl('home'));
    }
}