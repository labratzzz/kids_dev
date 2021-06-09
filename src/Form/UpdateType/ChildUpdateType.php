<?php


namespace App\Form\UpdateType;


use App\Entity\Child;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildUpdateType extends UserUpdateType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('birthday', DateType::class, [
                'label' => 'День рождения',
                'required' => true,
                'html5' => true,
                'input' => 'datetime',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'my-2',
                    'min' => (new \DateTime())->sub(new \DateInterval('P5Y'))->format('Y-m-d'),
                    'max' => (new \DateTime())->format('Y-m-d')
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Обновить',
                'attr' => ['class' => 'btn btn-warning float-start max-rounded px-5 my-2 me-2']
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Отменить',
                'attr' => ['class' => 'btn btn-danger float-start max-rounded px-5 my-2 me-2']
            ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Child::class
        ]);
    }
}