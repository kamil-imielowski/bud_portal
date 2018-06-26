<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 26.06.2018
 * Time: 12:46
 */

namespace AppBundle\Service;


use AppBundle\Entity\IncorrectAnswer;
use AppBundle\Entity\WrittenQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Exam
{
    private $user; //aktualnie zalogowany user
    private $em; //aktualnie zalogowany user

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->user = $tokenStorage->getToken()->getUser(); //pobranie aktualnie zalogowanego usera
        $this->em = $em; //inicjalizacja EM
    }

    /**
     * @param int $questions
     * @return array
     * @throws \Exception
     */
    public function generateQuestions($questions, $categories, $incorrectAnswers, $questionQuantityCheck, $examType){
        //$em = $this->container->getDoctrine()->getManager();
        $min = array();
        if(!$incorrectAnswers){
            if(empty($categories)){
                $min = $this->em->getRepository(WrittenQuestion::class)->getAllIds();
            }else{
                //pobranie pytan pod kategorie odpowiednie
                foreach ($categories as $c){
                    $a = $this->em->getRepository(WrittenQuestion::class)->getAllIdsForCategory($c);
                    $min = array_merge ($min, $a);
                }
            }
        }else{
            // pytania tylko z blednych odp
            /** @var IncorrectAnswer $ia */
            if(empty($categories)) {
                $ica = $this->user->getIncorrectAnswer();
            }else{
                foreach($this->user->getIncorrectAnswer() as $i => $ia){
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
        }

        if(!$questionQuantityCheck && $examType != "examRadio"){
            $questions = count($min);
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
}