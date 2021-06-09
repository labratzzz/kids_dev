<?php


namespace App\Form\UpdateType;


use App\Entity\Child;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildPasswordUpdateType extends UserPasswordUpdateType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class,
        ]);
    }
}