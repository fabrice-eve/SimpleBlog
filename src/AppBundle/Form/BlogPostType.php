<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 08/11/17
 * Time: 11:24
 */

namespace AppBundle\Form;

use AppBundle\Entity\BlogPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
                'required' => true
            ))
            ->add('body', TextareaType::class, array(
                'required' => true
            ))
            ->add('submit', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => BlogPost::class
        ));
    }

    public function getBlockPrefix()
    {
        return 'new_message_blog';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}