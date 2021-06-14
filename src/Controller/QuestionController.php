<?php


namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Educator;
use App\Entity\Question;
use App\Entity\Test;
use App\Form\CreateType\QuestionCreateType;
use App\Form\UpdateType\QuestionUpdateType;
use App\Util\Helper;
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
     * @param Question $question
     * @param Request $request
     * @return Response|null
     * @Route("/view/{id}", name="view")
     */
    public function view(Question $question, Request $request)
    {
        $answerPage = $request->query->get('apage', 1);

        $answerQb = $this->getDoctrine()->getRepository(Answer::class)->getByQuestionQueryBuilder($question);
        $answers = $this->paginate($answerQb->getQuery(), $answerPage, $answerPages);

        return $this->render('forms/question/view.html.twig', [
            'question' => $question,
            'answers' => $answers,
            'answer_page' => $answerPage,
            'answer_pages' => $answerPages,
            'has_access' => $this->getUser() instanceof Educator
        ]);
    }

    /**
     * @param Question $question
     * @param Request $request
     * @return Response|null
     * @Route("/pass/{id}", name="pass")
     */
    public function pass(Question $question, Request $request)
    {
        $questions = $question->getTest()->getQuestions()->toArray();
        return $this->render('forms/question/pass.html.twig', [
//            'form' => $form->createView(),
            'image' => 'img/question.svg',
            'title' => 'Создание вопроса'
        ]);
    }

    /**
     * @param Test $test
     * @param Request $request
     * @return Response|null
     * @Route("/create/{id}", name="create")
     */
    public function create(Test $test, Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $question = new Question();
        $question->setTest($test);

        $form = $this->createForm(QuestionCreateType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('question_create');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file)
            {
                $question->setImage($file);

                $em = $this->getDoctrine()->getManager();
                $em->persist($question);
                $em->flush();

                $this->addFlash('success', 'Вопрос успешно создан.');

                return new RedirectResponse($this->generateUrl('page.home'));
            } else {
                $this->addFlash('fail', 'Прикрепление изображения обязательно.');
            }
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
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $form = $this->createForm(QuestionUpdateType::class, $question);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('question_update');
            if ($files) {
                $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
                if ($file) $question->setImage($file);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            $this->addFlash('success', 'Вопрос успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.home'));
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