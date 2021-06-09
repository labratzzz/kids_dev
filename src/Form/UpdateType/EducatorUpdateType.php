<?php


namespace App\Form\UpdateType;


use App\Entity\Educator;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducatorUpdateType extends UserUpdateType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Электронная почта',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Обновить',
                'attr' => ['class' => 'btn btn-warning float-start my-2 me-2']
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Отменить',
                'attr' => ['class' => 'btn btn-danger float-start my-2 me-2']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Educator::class
        ]);
    }
}