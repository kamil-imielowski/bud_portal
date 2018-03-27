<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Blog;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $blogs = $entityManager->getRepository(Blog::class)->findBy(["published" => true]);
        return $this->render("blog/index.html.twig", ["blogs" => $blogs]);
    }

    /**
     * @Route("/blog/{id}/{urlTitle}", name="blog_details")
     * @param Blog $blog
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailsAction(Blog $blog){
        // update views
        $blog->setViews($blog->getViews()+1);
        $entityMenager = $this->getDoctrine()->getManager();
        $entityMenager->persist($blog); // ma zapisac obiekt
        $entityMenager->flush(); // wykonanie sql

        return $this->render("blog/details.html.twig", ["blog" => $blog]);
    }

    public function testAction(){
        //$logger = $this->container->get('vich_uploader.namer_uniqid')
    }
}