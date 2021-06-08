<?php


namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionCreateType;
use App\Form\QuestionUpdateType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles CRUD operations for question entity.
 *
 * Class QuestionController
 * @package App\Controller
 *
 * @Route("/question", name="question.")
 */
class QuestionController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $question = new Question();

        $form = $this->createForm(QuestionCreateType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            $this->addFlash('success', "Вопрос успешно создан.");

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/question/question.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/question.svg',
            'title' => 'Создание вопроса'
        ]);
    }

    /**
     * @param Question $question
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Question $question, Request $request)
    {
        $form = $this->createForm(QuestionUpdateType::class, $question);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            $this->addFlash('success', 'Вопрос успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/question/question.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/question.svg',
            'title' => 'Изменение вопроса'
        ]);
    }

    /**
     * @param Question  $question
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Question $question, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();

        $this->addFlash('success', 'Вопрос успешно удален.');

        return new RedirectResponse($this->generateUrl('page.home'));
    }

}