<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 29.03.2018
 * Time: 04:29
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
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

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
//            ->add('surname')
//            ->add('city')
//            ->add('zone', ChoiceType::class, array('placeholder' => "wybierz województwo", 'required' => true, 'choices' => $this->zones))
//            ->add('phone')
//            ->add('birthdate', DateType::class, array('widget' => 'single_text', 'html5' => false,'attr' => ['class' => 'datepickerB'],))
//            ->add('birthdate', DateType::class, array('required'=> false, 'widget' => 'single_text'))
//            ->add('studio')
//            ->add('graduation')
//            ->add('degree', ChoiceType::class, array('placeholder' => "tytuł zawodowy", 'required' => true, 'choices' => $this->degree))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}