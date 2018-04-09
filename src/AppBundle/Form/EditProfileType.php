<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 31.03.2018
 * Time: 05:00
 */

namespace AppBundle\Form;


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
        "magister" => "magister",
        "inżynier" => "inżynier",
        "architekt" => "architekt",
        "inżynier architekt" => "inżynier architekt",
    );

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('city')
            ->add('zone', ChoiceType::class, array('placeholder' => "wybierz województwo", 'required' => true, 'choices' => $this->zones))
            ->add('phone')
            ->add('birthdate', TextType::class, array('required'=> false))
            ->add('studio')
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