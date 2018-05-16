<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Baner;
use AppBundle\Entity\Blog;
use AppBundle\Entity\NewsletterRecipient;
use AppBundle\Form\NewsletterRecipientType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $ad1 = $this->forward('AppBundle:Advertising:place', array('place' => 1));
        $ad2 = $this->forward('AppBundle:Advertising:place', array('place' => 2));
        $ad3 = $this->forward('AppBundle:Advertising:place', array('place' => 3));

        $em = $this->getDoctrine()->getManager();
        $baners = $em->getRepository(Baner::class)->findAll();

        $blogs = $em->getRepository(Blog::class)->getLastPublishedBlogs();

        return $this->render('default/index.html.twig', [
            'baners' => $baners,
            'blogs' => $blogs,
            'ad1' => $ad1,
            'ad2' => $ad2,
            'ad3' => $ad3,
        ]);
    }

    /**
     * @Route("/newsletterRecipientAdd", name="newsletterRecipientAdd")
     * @param Request $request
     * @return Response
     */
    public function newsletterRecipientAddAction(Request $request){
        $nR = new NewsletterRecipient();

        $form = $this->createForm(NewsletterRecipientType::class, $nR);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityMenager = $this->getDoctrine()->getManager();
            $entityMenager->persist($nR); // ma zapisac obiekt
            $entityMenager->flush(); // wykonanie sql
            $referer = $request->headers->get('referer');
            return new Response(json_encode(array('status'=>'success', 'class' => 'alert alert-success', 'message' => "Dodano adres {$nR->getEmail()} do subskrybcji")));
        }elseif($form->isSubmitted() && !$form->isValid()){
            $error = str_replace('ERROR: ', '', $form['email']->getErrors());
            return new Response(json_encode(array('status'=>'failed', 'class' => 'alert alert-danger', 'message' => "$error")));
        }

        return $this->render("default/newsletterRecipientForm.html.twig", ['form' => $form->createView()]);
    }


//    /**
//     * @Route("/import")
//     * @return Response
//     */
//    public function import(){
//        $file = fopen('C:\Users\toma4\projects\last.csv', 'r');
//        $em = $this->getDoctrine()->getManager();
//        while (($line = fgetcsv($file)) !== FALSE) {
//            //$line is an array of the csv elements
//            $line = str_replace("&&*", ",", $line[0]);
//            //$line = str_replace("&*&", ",", $line);
//            $data = explode(";", $line);
//            $question = new WrittenQuestion();
//            $question->setQuestion(str_replace("&*&", ";", $data[1]))
//                ->setAnswerA(str_replace("&*&", ";", $data[2]))
//                ->setAnswerB(str_replace("&*&", ";", $data[3]))
//                ->setAnswerC(str_replace("&*&", ";", $data[4]))
//                ->setPrompt(str_replace("&*&", ";", $data[5]))
//                ->setIsFree(rand(0,1) == 1 ? true : false);
//            $em->persist($question);
//            $em->flush();
//        }
//        fclose($file);
//
//        return new Response("OK");
//    }
}
