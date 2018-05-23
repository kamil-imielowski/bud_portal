<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 31.03.2018
 * Time: 05:00
 */

namespace AppBundle\Form;


use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditProfileType extends AbstractType
{
    private $zones = array(
        'dolnośląskie' => 'dolnośląskie',
        'kujawsko-pomorskie' => 'kujawsko-pomorskie',
        'lubelskie' => 'lubelskie',
        'lubuskie' => 'lubuskie',
        'łódzkie' => 'łódzkie',
        'małopolskie' => 'małopolskie',
        'mazowieckie' => 'mazowieckie',
        'opolskie' => 'opolskie',
        'podkarpackie' => 'podkarpackie',
        'podlaskie' => 'podlaskie',
        'pomorskie' => 'pomorskie',
        'śląskie' => 'śląskie',
        'świętokrzyskie' => 'świętokrzyskie',
        'warmińsko-mazurskie' => 'warmińsko-mazurskie',
        'wielkopolskie' => 'wielkopolskie',
        'zachodniopomorskie' => 'zachodniopomorskie',
    );

    private $degree = array(
        "Magister inżynier architektury" => "Magister inżynier architektury",
        "Inżynier architektury" => "Inżynier architektury",
        "Dr. mgr. inż. architektury" => "Dr. mgr. inż. architektury",
        "Inżynier budownictwa" => "Inżynier budownictwa",
        "Magister inżynier budownictwa" => "Magister inżynier budownictwa",
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('city')
            ->add('zone', ChoiceType::class, array('placeholder' => "wybierz województwo", 'required' => true, 'choices' => $this->zones))
            ->add('phone')
//            ->add('birthdate', DateType::class, array('required'=> false, 'widget' => 'single_text'))
//            ->add('studio')
            ->add('graduation')
            ->add('degree', ChoiceType::class, array('placeholder' => "tytuł zawodowy", 'required' => true, 'choices' => $this->degree))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}