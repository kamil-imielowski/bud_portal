<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\VerbalQuestion;
use AppBundle\Entity\WrittenQuestion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class QuestionController extends Controller
{

    /**
     * @Route("/pytania/ustne", name="verbalQuestions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verbalQuestionsAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $questions = $entityManager->getRepository(VerbalQuestion::class)->findBy(["isFree" => true]);
        return $this->render("question/verbalQuestions.html.twig", [
            "questions" => $questions
        ]);
    }

    /**
     * @Route("pytania/pisemne", name="writtenQuestions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function writtenQuestionsAction(){
        $entityManager = $this->getDoctrine()->getManager();
        $questions = $entityManager->getRepository(WrittenQuestion::class)->findBy(["isFree" => true]);
        return $this->render("question/writtenQuestions.html.twig", [
            "questions" => $questions
        ]);
    }
}