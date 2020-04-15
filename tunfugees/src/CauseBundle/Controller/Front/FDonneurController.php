<?php

namespace CauseBundle\Controller;

use CauseBundle\Entity\Donneur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FDonneurController extends Controller
{
    /**
     * Finds and displays a user entity.
     *
     * @Route("/new/{don_total}/{id_u}", name="ajout_donneur")
     * @Method("GET")
     */
    public function newAction($don,$id_u)
    {

        $em =$this->getDoctrine()->getManager();

        $liste_donneur = $em->getRepository('CauseBundle:Donneur')->findAll();
        $users = $em->getRepository('UserBundle:User')->findAll();

        $donneur=new Donneur();
        $date_auj=new \DateTime('now');
        $donneur->setId($id_u);
        $donneur->setDon($don);
        $em->persist($donneur);
        $em->flush();
        $id_com=$donneur->getId();

/*
        foreach ($liste_donneur as $article_panier)
        {
            $Ligne_commande=new LigneCommande();
            $prix=$article_panier->getPrix();
            $id_produit=$article_panier->getIdprod();
            $Ligne_commande->getIdprod($id_produit);
            $Ligne_commande->setPrixprod($prix);
            $Ligne_commande->setIdUtilisateur($id_u);
            $Ligne_commande->setIdCommande($id_com);

            $em->persist($Ligne_commande);
            $em->flush();
            $com_modif = $em->getRepository(Commande::class)->find($id_com);

        }

        $L=$em->getRepository(PanierProduit::class)->findAll();
        foreach ($L as $value)
        {
            $em->remove($value);
            $em->flush();
        }
        $commandes = $em->getRepository('ProduitBundle:Commande')->findAll();
        $lignes = $em->getRepository('ProduitBundle:LigneCommande')->findAll();
        $produits = $em->getRepository('ProduitBundle:Produits')->findAll();
        return $this->render('@Produit/DashboardUser/page_index_commande.html.twig',array(
            'commandes'=> $commandes,'lignes'=> $lignes,'produits'=> $produits));
*/


    }
    /**
     * Finds and displays a user entity.
     *
     * @Route("/show_ligne/{id_c}", name="ligne_show")
     * @Method("GET")
     */
    public function showLigneAction($id_c)
    {
        $em =$this->getDoctrine()->getManager();
        $L=$em->getRepository(Donneur::class)->findAll();

        $donneur = $em->getRepository('CauseBundle:Donneur')->findAll();
       $tab=array('id_don' => $id_c);

        return $this->render('@Cause/DashboardUser/detail_donneur.html.twig',array(
           'donneur'=> $donneur,'tab'=>$tab));


    }

    /**
     * @Route("/annuler_don/{id_c}", name="annuler_don")
     * @Method("GET")
     */
    public function annulerAction($id_c)
    {
        $em=$this->getDoctrine()->getManager();
        $donneur = $em->getRepository('CauseBundle:Donneru')->findAll();
        foreach ($donneur as $value)
        {
            if($value->getId()==$id_c)
            {
                $date_com=$value->getDateEmission();
                $DateNow = new \DateTime('now');;
                $TempsRestant = $DateNow->diff($date_com);
                if($TempsRestant->h >24 )
                {
                    echo "<script language=\"javascript\">alert(\"Vous ne pouvez pas annuler le don car avez dépassé les 24 heures  \");</script>";

                }
                else
                {
                    foreach ($donneur as $v)
                    {
                        if($v->getId()==$id_c)
                        {
                            $em->remove($v);
                            $em->flush();
                        }
                    }
                    $em->remove($value);
                    $em->flush();

                }
            }

        }
        $commandes = $em->getRepository('CauseBundle:Donneur')->findAll();
        return $this->render('@Cause/DashboardUser/page_index_donneur.html.twig', array(
            'donneur'=> $donneur
        ));

        /*
        foreach ($commandes as $value)
        {
            if($value->getId()==$id_c)
            {
                foreach ($lignes as $v)
                {
                    if($v->getIdCommande()==$id_c)
                    {
                        $em->remove($v);
                        $em->flush();
                    }
                }
                $em->remove($value);
                $em->flush();
            }
        }*/


    }

    /**
     * @Route("/show_donneur", name="show_donneur")
     * @Method("GET")
     */
    public function showAction()
    {
        $em=$this->getDoctrine()->getManager();
        $donneur = $em->getRepository('CauseBundle:Donneur')->findAll();
        return $this->render('@Cause/DashboardUser/page_index_donneur.html.twig', array(
            'donneur'=> $donneur
        ));
    }





}
