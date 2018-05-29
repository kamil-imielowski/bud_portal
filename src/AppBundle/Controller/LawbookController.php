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
use AppBundle\Entity\User;
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
        /**
         * @var $user User
         */
        $user = $this->getUser();
        $lawbookCategories =  !is_null($user) && $user->hasRole("ROLE_VIP") ? $entityManager->getRepository(LawbookCategory::class)->getVipCategoriesData() : $entityManager->getRepository(LawbookCategory::class)->getPublicCategoriesData();
        return $this->render("lawbook/index.html.twig", [
            "lawbookCategories" => $lawbookCategories
        ]);
    }

    /**
     * @Route("/ustawa/{id}", name="lawbookContentT")
     * @param Lawbook $lawbook
     * @return Response
     */
    public function  lawbookViewTextAction(Lawbook $lawbook){
        $lawbook->setViews($lawbook->getViews() + 1);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($lawbook);
        $entityManager->flush();

        return $this->render("lawbook/rawLawbookContent.html.twig", [
            'lawbook' => $lawbook
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

    /**
     * @Route("/downloadLawbook/{name}", name="download_lawbook_file")
     * @param $name
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFileAction($name){
        $em = $this->getDoctrine()->getManager();
        $f = $em->getRepository(Lawbook::class)->findOneBy(['file' => $name]);
        $filePath = $this->getParameter('kernel.project_dir') . '/web' . $this->getParameter('app.lawbook.files').$name;
        $path_parts = pathinfo($filePath);
        return $this->file($filePath, "{$f->getName()}.{$path_parts['extension']}");
    }
}