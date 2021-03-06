<?php
/**
 * Created by PhpStorm.
 * User: toma4
 * Date: 22.03.2018
 * Time: 11:31
 */

namespace AppBundle\Form;


use AppBundle\Entity\Blog;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub
        $builder
            ->add('title', TextType::class, array('label' => 'Tytuł'))
            ->add('image', FileType::class, array('label' => 'Zdjęcie'))
            ->add('content', CKEditorType::class, array('label' => 'treść'))
            ->add("submit", 'Symfony\Component\Form\Extension\Core\Type\SubmitType', ["label" => "zapisz"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        //parent::configureOptions($resolver); // TODO: Change the autogenerated stub
        $resolver->setDefaults(array(
            'data_class' => Blog::class,
        ));
    }
}