<?php


namespace App\Controller;

use App\Entity\Child;
use App\Entity\ChildAnswer;
use App\Entity\Question;
use App\Form\CreateType\ChildAnswerCreateType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles creating user's choice.
 *
 * Class ChildAnswerController
 * @package App\Controller
 *
 * @Route("/childanswer", name="childanswer.")
 */
class ChildAnswerController extends AbstractController
{
    /**
     * @param Question $question
     * @param Request $request
     * @return Response|null
     * @Route("/create/{id}", name="create")
     */
    public function create(Question $question, Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof Child) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $childAnswer = new ChildAnswer();
        $childAnswer->setChild($user);

        $form = $this->createForm(ChildAnswerCreateType::class, $childAnswer);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if       ($form->get('var_1')->getData() == true) {
                $answer = $question->getAnswers()->toArray()[0];
            } elseif ($form->get('var_2')->getData() == true) {
                $answer = $question->getAnswers()->toArray()[1];
            } elseif ($form->get('var_3')->getData() == true) {
                $answer = $question->getAnswers()->toArray()[2];
            } elseif ($form->get('var_4')->getData() == true) {
                $answer = $question->getAnswers()->toArray()[3];
            }

            $childAnswer->setAnswer($answer);

            $em = $this->getDoctrine()->getManager();
            $alreadyInDb = $em->getRepository(ChildAnswer::class)->findOneBy(['child' => $user, 'answer' => $answer]);
            if (!$alreadyInDb) {
                $em->persist($childAnswer);
                $em->flush();
            }

            $questions = $question->getTest()->getQuestions();
            $index = $questions->indexOf($question);

            $nextQuestion = $questions->get($index+1);
            if ($nextQuestion)
                return new RedirectResponse($this->generateUrl('childanswer.create', ['id' => $nextQuestion->getId()]));
            else {
                $testName = $question->getTest()->getName();

                $this->addFlash('success', "Поздравляем! Тест $testName успешно пройден!");

                return new RedirectResponse($this->generateUrl('page.home'));
            }
        }

        return $this->render('forms/question/pass.html.twig', [
            'question' => $question,
            'answers' => $question->getAnswers(),
            'form' => $form->createView(),
            'image' => 'img/question.svg',
            'title' => $question->getTest()->getName()
        ]);
    }
}