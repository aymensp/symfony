<?php

namespace RefugiesBundle\Controller;

use CampsBundle\Entity\Camps;
use RefugiesBundle\Entity\Refugies;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 *
 * @Route("da")
 */
class RefugiesBackController extends Controller
{
    /**
     * @Route("/refugies", name="da_refugies_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();
        $refugies = $em->getRepository('RefugiesBundle:Refugies')->findAll();
        return $this->render('@Refugies/indexBack.html.twig', array(
            'refugies' => $refugies,
        ));
    }
    /**
     * Deletes a Refugies entity.
     *
     * @Route("/refugies/delete/{idref}", name="da_refugies_delete")
     * @Method({"GET", "DELETE"})
     */
    public function deleteAction($idref)
    {

        $refugies = $this->getDoctrine()->getRepository('RefugiesBundle:Refugies')->find($idref);
        $em = $this->getDoctrine()->getManager();
        $em->remove($refugies);
        $em->flush();

        return $this->redirectToRoute('da_refugies_index');
    }
    /**
     * Creates a new Refugies entity.
     *
     * @Route("/refugies/new", name="da_refugies_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $refugies = new Refugies();


        $formrefugies = $this->createForm('RefugiesBundle\Form\RefugiesType',$refugies);

        $formrefugies->handleRequest($request);

        if($formrefugies->isSubmitted() && $formrefugies->isValid())
        {
            /**
             * @var UploadedFile $file
             */
            $file = $refugies->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$fileName
            );
            $age=$refugies->getAge();
            $Categories= ['null'];
            switch ($age) {
                case  (0<=$age && $age<=3) :
                    $Categories=['Infancy(0-3)'];
                    break;
                case (4<=$age && $age<=8):
                    $Categories=['Childhood(4-8)'];
                    break;
                case (9<=$age && $age<=13):
                    $Categories=['Puberty(9-13)'];
                    break;
                case (14<=$age && $age<=18):
                    $Categories=['Teenager(14-18)'];
                    break;
                case (19<=$age && $age<=39):
                    $Categories=['Adult(19-39)'];
                    break;
                case (40<=$age && $age<=59):
                    $Categories=['Middle age(40-59)'];
                    break;
                case (60<=$age && $age<=200):
                    $Categories=['old age(60-99)'];
                    break;
                    return $Categories;
            }

            $em = $this->getDoctrine()->getManager();
            $array_projet=$em->getRepository(Camps::class)->findBy(array('Categories' => $Categories));
            if ($array_projet!=null)
            {
                $one_projet_objet=$array_projet[0];
                $refugies->setCamps($one_projet_objet);
                $refugies->setImage($fileName);
                $em->persist( $refugies );
                $em->flush();
                return $this->redirectToRoute('da_refugies_index');
            }
            else
            {
                return new Response('nonnnn');
            }

        }
        return $this->render('@Refugies/newRef.html.twig', array(
            'formrefugies' => $formrefugies->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing rep entity.
     *
     * @Route("/refugies/{id}/edit", name="da_ref_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Refugies $refugies)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Vous n'êtes pas autorisés à accéder à cette page!", Response::HTTP_FORBIDDEN);
        }
        $deleteForm = $this->createDeleteForm($refugies);
        $editForm = $this->createForm('RefugiesBundle\Form\RefugiesType', $refugies);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('da_ref_edit', array('id' => $refugies->getIdref()));
        }

        return $this->render('@Refugies/editrep.html.twig', array(
            'user' => $refugies,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Creates a form to delete a user entity.
     *
     * @param Refugies $refugies The AnnounceReparation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Refugies $refugies)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('da_refugies_delete', array('idref' => $refugies->getIdref())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    /**
     * Displays a form to edit an existing Annonce entity.
     *
     * @Route("/statiAdmin", name="da_ref_stat")
     * @Method({"GET", "POST"})
     */
    public function statAction()
    {


        $em = $this->getDoctrine()->getManager();
        //nb1
        $RAW_QUERY = 'SELECT  COUNT(*) as nb1  from refugies where (pays = \'tunisie\')';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $nb1 = $statement->fetch();
        //nb2
        $RAW_QUERY = 'SELECT  COUNT(*) as nb2  from refugies where (pays = \'syrie\')';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $nb2 = $statement->fetch();
        //nb1
        $RAW_QUERY = 'SELECT  COUNT(*) as nb3  from refugies where (pays = \'libye\')';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();
        $nb3 = $statement->fetch();


        $tunisie=intval($nb1['nb1']);
        $syrie=intval($nb2['nb2']);
        $lybie=intval($nb3['nb3']);



        $tab=array();
        $tab[1]=$tunisie;
        $tab[2]=$syrie;
        $tab[3]=$lybie;

        return $this->render('@Refugies/stat_Refugies.html.twig',array('tab'=> $tab));

    }
    /**
     * @Route("/trier/{val}", name="da_ref_trier")
     * @Method("GET")
     */
    public function TrierAction(Request $request)
    {

        $val = $request->get('val');
        //dump($val);exit();
        if ($val == 'PE') {
            $em = $this->getDoctrine()->getManager();

            $produits = $em->getRepository('RefugiesBundle:Refugies')->trierageElv();

        } elseif ($val == 'PB') {
            $em = $this->getDoctrine()->getManager();

            $produits = $em->getRepository('RefugiesBundle:Refugies')->trierageBas();


        }
        return $this->render('@Refugies/indexT.html.twig', array(
            "refugies" => $produits));
    }
    /**
     * @Route("/pdf/{id}", name="da_refugies_pdf")
     */

    public function generate_pdfsAction(Request $request){
        //$id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $tache = $em->getRepository('RefugiesBundle:Refugies');
        $options = new Options();
        $options->set('defaultFont', 'Roboto');
        $dompdf = new Dompdf($options);
        $data = array(
            'headline' => 'my headline'
        );
        $html = $this->renderView('@Refugies/indexBack.html.twig', array(
            'tache' => $tache
        ));
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("testspdf.pdf", [
            "Attachment" => true
        ]);
    }



}
