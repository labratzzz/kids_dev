<?php


namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerCreateType;
use App\Form\AnswerUpdateType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles CRUD operations for answers to the question.
 *
 * Class AnswerController
 * @package App\Controller
 *
 * @Route("/answer", name="answer.")
 */
class AnswerController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $answer = new Answer();

        $form = $this->createForm(AnswerCreateType::class, $answer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            $this->addFlash('success', "Вариант ответа успешно создан.");

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/answer/answer.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/answer.svg',
            'title' => 'Создание варианта ответа'
        ]);
    }

    /**
     * @param Answer $answer
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Answer $answer, Request $request)
    {
        $form = $this->createForm(AnswerUpdateType::class, $answer);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            $this->addFlash('success', 'Вариант ответа успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/answer/answer.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/answer.svg',
            'title' => 'Изменение варианта ответа'
        ]);
    }

    /**
     * @param Answer $answer
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Answer $answer, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($answer);
        $em->flush();

        $this->addFlash('success', 'Вариант ответа успешно удален.');

        return new RedirectResponse($this->generateUrl('page.home'));
    }

}