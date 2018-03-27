<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:42
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Lawbook;
use AppBundle\Entity\LawbookCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LawbookController extends Controller
{

    /**
     * @Route("/ustawy", name="lawbook")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lawbookAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $lawbookCategories = $entityManager->getRepository(LawbookCategory::class)->getPublicCategoriesData();
        return $this->render("lawbook/index.html.twig", [
            "lawbookCategories" => $lawbookCategories
        ]);
    }

    /**
     * @Route("/lawbook/{id}", name="lawbookContent")
     * @param Lawbook $lawbook
     * @return Response
     */
    public function  lawbookViewAction(Lawbook $lawbook){
        $lawbook->setViews($lawbook->getViews() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lawbook);
        $entityManager->flush();

        return new Response($lawbook->getContent());
    }
}