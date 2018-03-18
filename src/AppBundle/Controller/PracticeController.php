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
     * @Route("/praktyka", name="practice")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function practiceAction(){
        return $this->render("lawbook/index.html.twig");
    }
}