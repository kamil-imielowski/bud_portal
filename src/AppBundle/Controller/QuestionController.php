<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\CMS;
use AppBundle\Entity\User;
use AppBundle\Entity\VerbalQuestion;
use AppBundle\Entity\WrittenQuestion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class QuestionController extends Controller
{

    /**
     * @Route("/pytania/ustne", name="verbalQuestions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verbalQuestionsAction(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if( !is_null($user) && $user->hasRole("ROLE_VIP")){
            $questions = $entityManager->getRepository(VerbalQuestion::class)->findAll();
        }elseif(!is_null($user)){
            $questions = $entityManager->getRepository(VerbalQuestion::class)->findBy(["isFree" => true]);
        }

        if(!is_null($user)){
            $paginator  = $this->get('knp_paginator');
            $questions = $paginator->paginate(
                $questions, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit', 10)/*limit per page*/
            );
        }else{
            $cms = $entityManager->getRepository(CMS::class)->findOneBy(["place" => "pytania ustne"]);
        }
        return $this->render("question/verbalQuestions.html.twig", [
            "questions" => isset($questions) ? $questions : null,
            'cms' => isset($cms) ? $cms : null
        ]);
    }

    /**
     * @Route("pytania/pisemne", name="writtenQuestions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function writtenQuestionsAction(Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $questions = $entityManager->getRepository(WrittenQuestion::class)->findBy(["isFree" => true]);

        $paginator  = $this->get('knp_paginator');
        $questions = $paginator->paginate(
            $questions, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*limit per page*/
        );
        $cms = $entityManager->getRepository(CMS::class)->findOneBy(["place" => "pytania pisemne"]);

        return $this->render("question/writtenQuestions.html.twig", [
            "questions" => $questions,
            "cms" => $cms
        ]);
    }

    /**
     * @Route("/egzamin/lobby", name="exam_lobby")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function beforeExamAction(Request $request){
        if(!$this->getUser()->hasRole("ROLE_VIP")){
            return $this->redirectToRoute('memberPlans');
        }
        if($request->getMethod() == "POST"){
            $this->get('session')->getFlashBag()->add('from', $request->get('route'));
            $this->get('session')->getFlashBag()->add('pytan', $request->get('questions'));
            return $this->redirectToRoute('exam');
        }

        return $this->render("question/beforeExam.html.twig");
    }

    /**
     * @Route("/egzamin", name="exam")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function examAction(){
        if(is_null($this->getUser())){
            return $this->redirectToRoute('fos_user_security_login');
        }
        if(!$this->getUser()->hasRole("ROLE_VIP")){
            return $this->redirectToRoute('memberPlans');
        }
        $from = $this->get('session')->getFlashBag()->get('from');
        $egzamin = $this->get('session')->get('egzamin');
        if((empty($from) || $from[0] != 'exam_lobby') && is_null($egzamin)){
            return $this->redirectToRoute('exam_lobby');
        }else{
            //inicjalizacja egzaminu
            if(is_null($egzamin['pytan'])){
                $egzamin['pytan'] = $this->get('session')->getFlashBag()->get('pytan')[0];
                $egzamin['pytania'] = $this->generateQuestions($egzamin['pytan']);
                $egzamin['init'] = 0;
            }
            $this->get('session')->set('egzamin', $egzamin);
        }

        return $this->render("question/exam.html.twig");
    }

    /**
     * @Route("/egzamin/zakoncz", name="exam_end")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function endExamAction(){
        $this->get('session')->remove('egzamin');
        return $this->redirectToRoute('exam_lobby');
    }

    /**
     * @Route("/written-question", name="exam_get_question")
     * @param Request $request
     * @return Response
     */
    public function loadQuestionAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(WrittenQuestion::class)->findOneBy(['id' => $request->get('id')]);
        $answers = array();
        $answers[] = $question->getAnswerA();
        $answers[] = $question->getAnswerB();
        $answers[] = $question->getAnswerC();
        shuffle($answers);
        $egzamin = $this->get('session')->get('egzamin');
        $egzamin['init'] = $request->get('qk');
        $this->get('session')->set('egzamin', $egzamin);
        return $this->render('question/examQuestionContent.html.twig', array(
            'question' => $question,
            'resolved' => $request->get('resolved'),
            'qk' => $request->get('qk'),
            'answers' => $answers
        ));
    }

    /**
     * @Route("/answerQuestion", name="answer-question")
     * @param Request $request
     * @return Response
     */
    public function answerAction(Request $request){
        $egzamin = $this->get('session')->get('egzamin');
        $egzamin['pytania'][$request->get('qk')]['resolved'] = true;
        $egzamin['pytania'][$request->get('qk')]['correct'] = $request->get('correct');
        $this->get('session')->set('egzamin', $egzamin);
        return new Response('OK');
    }

    /**
     * @param int $questions
     * @return array
     */
    private function generateQuestions($questions){
        $em = $this->getDoctrine()->getManager();
        $min = $em->getRepository(WrittenQuestion::class)->getAllIds();
        $j = 0;
        $rand = array();
        $max = count($min) - 1;
        while($j<$questions){
            $r = mt_rand(0, $max);
            if(!in_array($min[$r]['id'], $rand)){
                $rand[$j]['id'] = $min[$r]['id'];
                $rand[$j]['resolved'] = false;
                $rand[$j]['correct'] = null;
                $j++;
            }
        }

        return $rand;
    }

    /**
     * @Route("/refreshQuestionState", name="refreshQuestionState")
     * @return JsonResponse
     */
    public function refreshQuestionStateAction(){
        $egzamin = $this->get('session')->get('egzamin');
        return new JsonResponse($egzamin['pytania']);
    }
}