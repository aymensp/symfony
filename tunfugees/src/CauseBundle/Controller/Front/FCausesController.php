<?php

namespace CauseBundle\Controller;

use CauseBundle\Entity\Cause;
use ProduitBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class FCausesController extends Controller

{
    /**
     * @Route("/", name="f_cause_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('CauseBundle:Cause')->findAll();
        $dql   = "SELECT a FROM CauseBundle:Cause a";
        $query = $em->createQuery($dql);
        $paginator= $this->get('knp_paginator');
        $cause= $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        $liste = $em->getRepository('CauseBundle:Cause')->findAll();

        $likes = $em->getRepository('CauseBundle:Cause')->likeCause();
        return $this->render
        ('@Cause/Front/Cause/causePagination.html.twig',
            array(
                'Cause' => $cause ,'liste' => $liste, 'likes' => $likes,
            ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="f_cause_show")
     * @Method("GET")
     */
    public function showAction(Cause $cause)
    {

        $cause->setgoals($cause->getgoals() + 1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->render('@Cause/Front/Cause/show.html.twig', array(
            'Cause' => $cause,
        ));
    }

    /**
     * @Route("/cause/{cat}", name="f_recherch_Cause")
     * @Method("GET")
     */
    public function RechercheCauseAction(Request $request, $cat)
    {

        $em = $this->getDoctrine()->getManager();
        $cause = $em->getRepository('CauseBundle:Cause')->findAll();
        $liste = $em->getRepository('CauseBundle:Cause')->findAll();
        $cause = new Cause();
        $cause = $em->getRepository('CauseBundle:Cause')->findByCategorie($cat);

        return $this->render('@Cause/Front/Cause/cause.html.twig', array(
            "Cause" => $cause, 'liste' => $liste

        ));
    }

    /**
     * Creates a new Cause entity.
     *
     * @Route("/jaime/new", name="f_cause_jaime")
     * @Method({"GET", "POST"})
     */
    public function newJaimeAction(Request $request)
    {

        if (($request->isXmlHttpRequest())) {
            $id = $request->get('Id');
            $em = $this->getDoctrine()->getManager();
            $cause = $em->getRepository('CauseBundle:Cause')->find($id);
            $cause->setLikes($cause->getLikes() + 1);
            $em->flush();
            return $this->redirectToRoute('du_cause_index');

        }
    }

    /**
     * @Route("/trier/{val}", name="f_cause_trier")
     * @Method("GET")
     */
    public function TrierAction(Request $request)
    {

        $val = $request->get('val');
        //dump($val);exit();
        if ($val == 'PE') {
            $em = $this->getDoctrine()->getManager();
            $liste = $em->getRepository('CauseBundle:Cause')->findAll();
            $cause = $em->getRepository('CauseBundle:Cause')->trierGoalsElv();
            $likes = $em->getRepository('CauseBundle:Cause')->likeCause();
        } elseif ($val == 'PB') {
            $em = $this->getDoctrine()->getManager();
            $liste = $em->getRepository('CauseBundle:Cause')->findAll();
            $cause = $em->getRepository('CauseBundle:Cause')->trierGoalsBas();
            $likes = $em->getRepository('CauseBundle:Cause')->likeCause();

        }
        return $this->render('@Cause/Front/Cause/cause.html.twig', array(
            "Cause" => $cause,  'likes' => $likes,'liste' => $liste
        ));
    }
    /**
     * @Route("/pdf/{id}", name="pdf")
     */

    public function pdfAction(Request $request)
    {
        $val = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $cause = $em->getRepository('CauseBundle:Cause')->find($val);


        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('@Cause/Front/Cause/causePdf.html.twig', array(
            'Cause' => $cause,
        ));

        $filename = 'Cause';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
    /**
     *
     * @Route("/cause/recherche", name="f_recherche")
     * @Method({"GET", "POST"})
     */
    public function rechercheAction(Request $request)
    {
        $keyWord = $request->get('keyWord');
        // dump($keyWord);
        if($keyWord == '')
        {
            $cause = $this->getDoctrine()->getRepository('CauseBundle:Cause')->findAll();
        }else
        {
            $cause = $this->getDoctrine()->getRepository('CauseBundle:Cause')->RechercheTitreCause($keyWord);

        }

        $template = $this->render( '@Cause/Front/Cause/Recherche.html.twig', array("cause" => $cause))->getContent();
        $json     = json_encode($template);
        $response = new Response($json, 200);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
