<?php


namespace App\Form\CreateType;


use App\Entity\ChildAnswer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildAnswerCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('var_1', RadioType::class, [
                'label' => 'Выбрать',
                'required' => false,
                'attr' => ['class' => 'my-2'],
                'mapped' => false
            ])
            ->add('var_2', RadioType::class, [
                'label' => 'Выбрать',
                'required' => false,
                'attr' => ['class' => 'my-2'],
                'mapped' => false
            ])
            ->add('var_3', RadioType::class, [
                'label' => 'Выбрать',
                'required' => false,
                'attr' => ['class' => 'my-2'],
                'mapped' => false
            ])
            ->add('var_4', RadioType::class, [
                'label' => 'Выбрать',
                'required' => false,
                'attr' => ['class' => 'my-2'],
                'mapped' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Дальше',
                'attr' => ['class' => 'btn btn-warning float-start my-2 me-2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ChildAnswer::class
        ]);
    }
}