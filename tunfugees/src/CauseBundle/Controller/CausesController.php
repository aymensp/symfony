<?php

namespace CauseBundle\Controller;

use CauseBundle\Entity\Cause;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CausesController extends Controller

{
    /**
     * @Route("/cause", name="da_cause_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();
        $Cause = $em->getRepository('CauseBundle:Cause')->findAll();
        return $this->render('@Cause/Cause/index.html.twig', array(
            'cause' => $Cause,

        ));
    }
    /**
     * @Route("/allcauses", name="da_json")
     * @Method("GET")
     */
    public function allAction()
    {
        $task = $this->getDoctrine()->getManager()->getRepository(Cause::class)->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formated=$serializer->normalize($task);
        return new  JsonResponse($formated);
    }

    /**
     * Creates a new Categorie et cause entity.
     *
     * @Route("/cause/new", name="da_cause_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $cause = new Cause();
        $formCause = $this->createForm('EcoBundle\Form\CauseType',$cause);
        $formCause->handleRequest($request);
        if($formCause->isSubmitted() && $formCause->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $cause->setGoals(0);
            $cause->setRaised(0);
            $cause->setEtat("Disponible");
            $cause->setUser($user);
            $em->persist($cause);
            $em->flush();
            return $this->redirectToRoute('da_cause_index');
        }
        return $this->render('@Cause/Cause/new.html.twig', array(

            'formCause' => $formCause->createView()
        ));

    }
    /**
     * Displays a form to edit an existing cause entity.
     *
     * @Route("/cause/{id}/edit/cause", name="da_cause_cat_edit")
     * @Method({"GET", "POST"})
     */
    public function editCauseAction(Request $request, Cause $cause)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $editFormcat = $this->createForm('CauseBundle\Form\CauseType', $cause);
        $editFormcat->handleRequest($request);
        if ($editFormcat->isSubmitted() && $editFormcat->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('da_cause_index');
        }
        return $this->render('@Cause/Cause//editCat.html.twig', array(
            'Cause' => $cause,
            'formcat'    => $editFormcat->createView(),
        ));

    }

    /**
     * Deletes a cause entity.
     *
     * @Route("/cause/delete/{id}", name="da_cause_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteCauseAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $annonce = $this->getDoctrine()->getRepository('CauseBundle:Cause')->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($annonce);
        $em->flush();

        return $this->redirectToRoute('da_cause_index');
    }
    /**
     * Finds and displays a user entity.
     *
     * @Route("/cause/{id}", name="da_cause_show")
     * @Method("GET")
     */
    public function showAction(Cause $cause)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        return $this->render('@Cause/Cause//show.html.twig', array(
            'cause' => $cause,
        ));
    }

    /**
     * Displays a form to edit an existing Cause entity.
     *
     * @Route("/statiAdmin", name="da_cause_stat")
     * @Method({"GET", "POST"})
     */
    public function statAction()
    {


        $em = $this->getDoctrine()->getManager();
        //nb1
        $RAW_QUERY = 'SELECT  COUNT(*) as nb1 from annonce where (date_creation >= \'2019-01-01\') AND (date_creation <= \'2019-01-31\');';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $nb1 = $statement->fetch();
        //nb2
        $RAW_QUERY2 = 'SELECT  COUNT(*) as nb2  from annonce where (date_creation >= \'2019-02-01\') AND (date_creation <= \'2019-02-31\');';
        $statement2 = $em->getConnection()->prepare($RAW_QUERY2);
        $statement2->execute();
        $nb2 = $statement2->fetch();

        //nb3
        $RAW_QUERY3 = 'SELECT  COUNT(*) as nb3  from annonce where (date_creation >= \'2019-03-01\') AND (date_creation <= \'2019-03-31\');';
        $statement3 = $em->getConnection()->prepare($RAW_QUERY3);
        $statement3->execute();
        $nb3 = $statement2->fetch();

        //nb4
        $RAW_QUERY4 = 'SELECT  COUNT(*) as nb4  from annonce where (date_creation >= \'2019-04-01\') AND (date_creation <= \'2019-04-31\');';
        $statement4 = $em->getConnection()->prepare($RAW_QUERY4);
        $statement4->execute();
        $nb4 = $statement4->fetch();

        //nb5
        $RAW_QUERY5 = 'SELECT  COUNT(*) as nb5  from annonce where (date_creation >= \'2019-05-01\') AND (date_creation <= \'2019-05-31\');';
        $statement5 = $em->getConnection()->prepare($RAW_QUERY5);
        $statement5->execute();
        $nb5 = $statement5->fetch();

        //nb6
        $RAW_QUERY6 = 'SELECT  COUNT(*) as nb6  from annonce where (date_creation >= \'2019-06-01\') AND (date_creation <= \'2019-06-31\');';
        $statement6 = $em->getConnection()->prepare($RAW_QUERY6);
        $statement6->execute();
        $nb6 = $statement6->fetch();

        //nb7
        $RAW_QUERY7 = 'SELECT  COUNT(*) as nb7  from annonce where (date_creation >= \'2019-07-01\') AND (date_creation <= \'2019-07-31\');';
        $statement7= $em->getConnection()->prepare($RAW_QUERY7);
        $statement7->execute();
        $nb7 = $statement7->fetch();

        //nb8
        $RAW_QUERY8 = 'SELECT  COUNT(*) as nb8  from annonce where (date_creation >= \'2019-08-01\') AND (date_creation <= \'2019-08-31\');';
        $statement8= $em->getConnection()->prepare($RAW_QUERY8);
        $statement8->execute();
        $nb8 = $statement8->fetch();

        //nb9
        $RAW_QUERY9 = 'SELECT  COUNT(*) as nb9  from annonce where (date_creation >= \'2019-09-01\') AND (date_creation <= \'2019-09-31\');';
        $statement9= $em->getConnection()->prepare($RAW_QUERY9);
        $statement9->execute();
        $nb9 = $statement8->fetch();

        //nb10
        $RAW_QUERY10 = 'SELECT  COUNT(*) as nb10  from annonce where (date_creation >= \'2019-10-01\') AND (date_creation <= \'2019-10-31\');';
        $statement10= $em->getConnection()->prepare($RAW_QUERY10);
        $statement10->execute();
        $nb10 = $statement10->fetch();

        //nb11
        $RAW_QUERY11 = 'SELECT  COUNT(*) as nb11  from annonce where (date_creation >= \'2019-11-01\') AND (date_creation <= \'2019-11-31\');';
        $statement11= $em->getConnection()->prepare($RAW_QUERY11);
        $statement11->execute();
        $nb11 = $statement11->fetch();

        //nb12
        $RAW_QUERY12 = 'SELECT  COUNT(*) as nb12  from annonce where (date_creation >= \'2019-12-01\') AND (date_creation <= \'2019-12-31\');';
        $statement12= $em->getConnection()->prepare($RAW_QUERY12);
        $statement12->execute();
        $nb12 = $statement12->fetch();

        $jan=intval($nb1['nb1']);
        $fev=intval($nb2['nb2']);
        $mars=intval($nb3['nb3']);
        $avril=intval($nb4['nb4']);
        $mai=intval($nb5['nb5']);
        $juin=intval($nb6['nb6']);
        $jui=intval($nb7['nb7']);
        $aout=intval($nb8['nb8']);
        $sep=intval($nb9['nb9']);
        $oct=intval($nb10['nb10']);
        $nov=intval($nb11['nb11']);
        $dec=intval($nb12['nb12']);


        $tab=array();
        $tab[1]=$jan;
        $tab[2]=$fev;
        $tab[3]=$mars;
        $tab[4]=$avril;
        $tab[5]=$mai;
        $tab[6]=$juin;
        $tab[7]=$jui;
        $tab[8]=$aout;
        $tab[9]=$sep;
        $tab[10]=$oct;
        $tab[11]=$nov;
        $tab[12]=$dec;

        return $this->render('@Cause/Cause/stat_cause.html.twig',array('tab'=> $tab));

    }

}
