<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(){
        return $this->render("blog/index.html.twig");
    }

    public function testAction(){
        //$logger = $this->container->get('vich_uploader.namer_uniqid')
    }
}