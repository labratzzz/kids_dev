<?php


namespace App\Form\UpdateType;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Имя',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Фамилия',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('surname', TextType::class, [
                'label' => 'Отчество',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Пол',
                'placeholder' => 'Укажите пол',
                'choices' => User::SEX_CHOICES,
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('phone', IntegerType::class, [
                'label' => 'Телефон',
                'required' => true,
                'attr' => [
                    'class' => 'number my-2',
                    'max-length' => 10,
                    'type' => 'number',
                    'min' => 0
                ]
            ]);
    }
}