<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 07.03.2018
 * Time: 13:43
 */

namespace AppBundle\Controller;


use AppBundle\Entity\CMS;
use AppBundle\Entity\IncorrectAnswer;
use AppBundle\Entity\User;
use AppBundle\Entity\VerbalQuestion;
use AppBundle\Entity\WrittenQuestion;
use AppBundle\Entity\WrittenQuestionCategory;
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
            $this->get('session')->getFlashBag()->add('examType', $request->get('examType'));
            $this->get('session')->getFlashBag()->add('pytan', empty($request->get('questions')) ? 60 : $request->get('questions'));
            $this->get('session')->getFlashBag()->add('categories', $request->get('category'));
            $this->get('session')->getFlashBag()->add('incorrectAnswersExam', ($request->get('examType') == "incorrectAnswersRadio") ? true : false );
            $this->get('session')->getFlashBag()->add('questionQuantityCheck', empty($request->get('questionQuantityCheck')) ? false : true );
            return $this->redirectToRoute('exam');
        }

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(WrittenQuestionCategory::class)->getNotEmptyCategories();

        return $this->render("question/beforeExam.html.twig",[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/egzamin", name="exam")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function examAction(){
        //brak usera zalogowanego
        if(is_null($this->getUser())){
            return $this->redirectToRoute('fos_user_security_login');
        }

        //brak uprawnien do egzaminu
        if(!$this->getUser()->hasRole("ROLE_VIP")){
            return $this->redirectToRoute('memberPlans');
        }


        $from = $this->get('session')->getFlashBag()->get('from');
        $egzamin = $this->get('session')->get('egzamin');

        //czy z lobby wyslanego, a nie z palca routing wpisany
        if((empty($from) || $from[0] != 'exam_lobby') && is_null($egzamin)){
            return $this->redirectToRoute('exam_lobby');
        }else{
            //inicjalizacja egzaminu
            if(is_null($egzamin['pytan'])){
                $egzamin['pytan'] = $this->get('session')->getFlashBag()->get('pytan')[0];
                $egzamin['examType'] = $this->get('session')->getFlashBag()->get('examType')[0];
                $egzamin['categories'] = $this->get('session')->getFlashBag()->get('categories')[0];
                $egzamin['incorrectAnswersExam'] = $this->get('session')->getFlashBag()->get('incorrectAnswersExam')[0];
                $egzamin['questionQuantityCheck'] = $this->get('session')->getFlashBag()->get('questionQuantityCheck')[0];
                try{
                    $egzamin['pytania'] = $this->generateQuestions($egzamin['pytan'], $egzamin['categories'], $egzamin['incorrectAnswersExam'], $egzamin['questionQuantityCheck']);
                    $egzamin['pytan'] = count($egzamin['pytania']);
                }catch (\Exception $e){
                    $this->get('session')->getFlashBag()->add('error', $e->getMessage());
                    return $this->redirectToRoute('exam_lobby');
                }
                $egzamin['init'] = 0;
            }
            $this->get('session')->set('egzamin', $egzamin);
        }

        return $this->render("question/exam.html.twig");
    }

    /**
     * @Route("/egzamin/podsumowanie", name="exam_end")
     * @return Response
     */
    public function endExamAction(){
        $egzamin = $this->get('session')->get('egzamin');
        $this->get('session')->remove('egzamin');

        if(empty($egzamin)){
            return $this->redirectToRoute('exam_lobby');
        }

        $correct = 0;


        foreach ($egzamin['pytania'] as $pytanie){
            if($pytanie['correct'] == true){
                $correct++;
            }
        }

        $all = count($egzamin['pytania']);
        $progressBar = round($correct/$all);
        $zdane = ($correct/$all > 50.0) ? true : false;
        return $this->render("question/summaryExam.html.twig", [
            "correct" => $correct,
            "all" => $all,
            'progessBar' => $progressBar,
            "zdane" => $zdane
        ]);
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

        /** @var User $user */
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository(WrittenQuestion::class)->findOneBy(['id' => $request->get('id')]);
        $incorrectAnswer = $em->getRepository(IncorrectAnswer::class)->findOneBy(['user' => $user, 'question' => $question]);
        $correct = $request->get('correct') == 'false' ? false : true;
        if(!$correct){
            //dodanie pytania do błędnych odp
            if(empty($incorrectAnswer)){
                $incorrectAnswer = new IncorrectAnswer();
                $incorrectAnswer->setUser($user);
                $incorrectAnswer->setQuestion($question);
                $em->persist($incorrectAnswer);
                $em->flush();
            }
        }else{
            // usuniecie pytania z blednych odp
            if(!is_null($incorrectAnswer)) {
                $em->remove($incorrectAnswer);
                $em->flush();
            }
        }
        $this->get('session')->set('egzamin', $egzamin);
        return new Response('OK');
    }

    /**
     * @param int $questions
     * @return array
     * @throws \Exception
     */
    private function generateQuestions($questions, $categories, $incorrectAnswers, $questionQuantityCheck){
        $em = $this->getDoctrine()->getManager();
        $min = array();
        if(!$incorrectAnswers){
            if(empty($categories)){
                $min = $em->getRepository(WrittenQuestion::class)->getAllIds();
            }else{
                //pobranie pytan pod kategorie odpowiednie
                foreach ($categories as $c){
                    $a = $em->getRepository(WrittenQuestion::class)->getAllIdsForCategory($c);
                    $min = array_merge ($min, $a);
                }
            }
        }else{
            // pytania tylko z blednych odp
            /** @var User $user */
            $user = $this->getUser();
            if(empty($categories)) {
                $ica = $user->getIncorrectAnswer();
            }else{
                foreach($user->getIncorrectAnswer() as $i => $ia){
                    foreach ($categories as $c){
                        if($ia->getQuestion()->getCategory()->getId() == $c){
                            $ica[] = $ia;
                        }
                    }
                }
            }
            foreach ($ica as $i => $ia){
                $min[$i]['id'] = $ia->getQuestion()->getId();
            }
            if(count($min) == 0){
                throw new \Exception("Nie posiadasz błędnych odpowiedzi");
            }
            if(!$questionQuantityCheck){
                $questions = count($min);
            }
        }

        $minC = count($min);
        if($questions > $minC){
            throw new \Exception("Liczba pytań w wybranych kategoriach wynosi $minC, zmiejsz liczbę pytań");
        }
        $j = 0;
        $rand = array();
        $max = $minC - 1;
        while($j<$questions){
            $r = mt_rand(0, $max);
            if(!$this->searchForUnique($min[$r]['id'], $rand)){
                $rand[$j]['id'] = $min[$r]['id'];
                $rand[$j]['resolved'] = false;
                $rand[$j]['correct'] = null;
                $j++;
            }
        }

        return $rand;
    }

    private function searchForUnique($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return true;
            }
        }
        return false;
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