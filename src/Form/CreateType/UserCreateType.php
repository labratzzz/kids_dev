<?php


namespace App\Form\CreateType;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Логин',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Фамилия',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Имя',
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
            ])
            ->add('defaultPassword', CheckboxType::class, [
                'label' => 'Установить пароль по умолчанию',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'my-2']
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Пароли должны совпадать.',
                'options' => ['attr' => ['class' => 'password-field my-2']],
                'required' => false,
                'first_options' => ['label' => 'Пароль'],
                'second_options' => ['label' => 'Повторите пароль']
            ]);
    }
}