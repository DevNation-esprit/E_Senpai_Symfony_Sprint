<?php

namespace App\Form;

use App\Entity\Questionquiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionquizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('reponseCorrecte')
            ->add('reponseFausse1')
            ->add('reponseFausse2')
            ->add('reponseFausse3')
            ->add('note')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Questionquiz::class,
        ]);
    }
}
