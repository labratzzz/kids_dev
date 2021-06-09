<?php


namespace App\Form\UpdateType;


use App\Entity\Educator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducatorPasswordUpdateType extends UserPasswordUpdateType
{

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Educator::class,
        ]);
    }
}