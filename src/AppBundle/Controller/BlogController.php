<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Blog;
use AppBundle\Entity\BlogCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function blogAction(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $cat = $request->query->getInt('category', null);
        if(!empty($cat)){
            $category = explode("_", $cat);
            $c = $entityManager->getRepository(BlogCategory::class)->findOneBy(["id" => $category[0]]);
            $blogs = $entityManager->getRepository(Blog::class)->findBy(["published" => true, "category" => $c]);

        }else{
            $blogs = $entityManager->getRepository(Blog::class)->findBy(["published" => true]);
        }
        $categories = $entityManager->getRepository(BlogCategory::class)->findAll();
        return $this->render("blog/index.html.twig", [
            "blogs" => $blogs,
            "categories" => $categories
        ]);
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