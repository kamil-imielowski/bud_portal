<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:42
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LawbookController extends Controller
{

    /**
     * @Route("/ustawy", name="lawbook")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lawbookAction(){
        return $this->render("lawbook/index.html.twig");
    }
}