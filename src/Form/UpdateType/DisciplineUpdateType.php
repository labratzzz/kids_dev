<?php


namespace App\Form\UpdateType;


use App\Entity\Discipline;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisciplineUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
                'required' => true,
                'attr' => ['class' => 'my-2']
            ])
            ->add('image', FileType::class, [
                'label' => 'Изображение',
                'required' => false,
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'mapped' => false
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
            'data_class' => Discipline::class
        ]);
    }
}