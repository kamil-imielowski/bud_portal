<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\CMS;
use AppBundle\Form\testType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CMSController extends Controller
{

    /**
     * @Route("/regulamin", name="termsOfServices")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function termsOfServicesAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $termsOfService = $entityManager->getRepository(CMS::class)->findOneBy(["place" => "regulamin"]);
        return $this->render("cms/term_of_services.html.twig", ["termsOfService" => $termsOfService]);
    }

    /**
     * @Route("/polityka-prywatnosci", name="privacyPolicy")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function privacyPolicyAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $privacyPolicy = $entityManager->getRepository(CMS::class)->findOneBy(["place" => "polityka prywatności"]);
        return $this->render("cms/privacy_policy.html.twig", ["privacyPolicy" => $privacyPolicy]);
    }

    /**
     * @Route("/cennik", name="prices")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function pricesAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $prices = $entityManager->getRepository(CMS::class)->findOneBy(["place" => "cennik"]);
        return $this->render("cms/prices.html.twig", ["prices" => $prices]);
    }

    /**
     * @Route("/kontakt", name="contact")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(){
        $form = $this->createForm(testType::class, null);
        $entityManager = $this->getDoctrine()->getManager();
        $contact = $entityManager->getRepository(CMS::class)->findOneBy(["place" => "kontakt"]);
        return $this->render("cms/contact.html.twig", ["form" => $form->createView(), "contact" => $contact]);
    }
}