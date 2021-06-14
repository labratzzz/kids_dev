<?php


namespace App\Form\UpdateType;


use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionUpdateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('line', TextType::class, [
                'label' => 'Вопрос',
                'required' => false,
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
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                /** @var Question $question */
                $question = $event->getData();
                $form = $event->getForm();

                $form->add('correctAnswer', EntityType::class, [
                    'label' => 'Правильный ответ',
                    'class' => Answer::class,
                    'required' => true,
                    'attr' => ['class' => 'form-control my-2'],
                    'choices' => $question->getAnswers()
                ]);
            })
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
            'data_class' => Question::class
        ]);
    }
}