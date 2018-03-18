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

class QuestionController extends Controller
{

    /**
     * @Route("/pytania/ustne", name="verbalQuestions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verbalQuestionsAction(){
        return $this->render("lawbook/index.html.twig");
    }

    /**
     * @Route("pytania/pisemne", name="writtenQuestions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function writtenQuestionsAction(){
        return $this->render("lawbook/index.html.twig");
    }
}