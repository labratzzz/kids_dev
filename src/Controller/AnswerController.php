<?php


namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Educator;
use App\Entity\Question;
use App\Form\CreateType\AnswerCreateType;
use App\Form\UpdateType\AnswerUpdateType;
use App\Util\Helper;
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
     * @param Question $question
     * @param Request $request
     * @return Response|null
     * @Route("/create/{id}", name="create")
     */
    public function create(Question $question, Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $answer = new Answer();
        $answer->setQuestion($question);
        $form = $this->createForm(AnswerCreateType::class, $answer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            $this->addFlash('success', "Вариант ответа успешно создан.");

            return new RedirectResponse($this->generateUrl('page.home'));
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('answer_create');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file)
            {
                $question->setImage($file);

                $em = $this->getDoctrine()->getManager();
                $em->persist($question);
                $em->flush();

                $this->addFlash('success', 'Вариант ответа успешно создан.');

                return new RedirectResponse($this->generateUrl('page.home'));
            } else {
                $this->addFlash('fail', 'Прикрепление изображения обязательно.');
            }
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
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $form = $this->createForm(AnswerUpdateType::class, $answer);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('answer_update');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file) {
                $answer->setImage($file);
            }
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