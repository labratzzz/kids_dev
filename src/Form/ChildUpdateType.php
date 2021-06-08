<?php


namespace App\Form;


use App\Entity\Child;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildUpdateType extends AbstractType
{


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class
        ]);
    }
}