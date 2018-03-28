<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:40
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PracticeController extends Controller
{
    /**
     * @Route("/praktyka/w-biurze", name="practice_office")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function projectOfficeAction(){
        return $this->render("practice/projectOffice.html.twig");
    }

    /**
     * @Route("/praktyka/na-budowie", name="practice_onBuild")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onBuildingAction(){
        return $this->render("practice/onBuild.html.twig");
    }

    /**
     * @Route("/praktyka/umowy", name="practice_contracts")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contractsAction(){
        return $this->render("practice/contracts.html.twig");
    }
}