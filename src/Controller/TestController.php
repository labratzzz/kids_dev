<?php


namespace App\Controller;

use App\Entity\Discipline;
use App\Entity\Educator;
use App\Entity\Question;
use App\Entity\Test;
use App\Enums\Image;
use App\Form\CreateType\DisciplineCreateType;
use App\Form\CreateType\TestCreateType;
use App\Form\UpdateType\TestUpdateType;
use App\Util\Helper;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles CRUD operations for answers to the question.
 *
 * Class TestController
 * @package App\Controller
 *
 * @Route("/test", name="test.")
 */
class TestController extends AbstractController
{

    /**
     * @param Test $test
     * @param Request $request
     * @return Response|null
     * @Route("/view/{id}", name="view")
     */
    public function view(Test $test, Request $request)
    {
        $questionPage = $request->query->get('tpage', 1);

        $questionQb = $this->getDoctrine()->getRepository(Question::class)->getByTestQueryBuilder($test);
        $questions = $this->paginate($questionQb->getQuery(), $questionPage, $questionPages);

        return $this->render('forms/test/view.html.twig', [
            'test' => $test,
            'questions' => $questions,
            'question_page' => $questionPage,
            'question_pages' => $questionPages,
            'has_access' => $this->getUser() instanceof Educator
        ]);
    }

    /**
     * @param Test $test
     * @param Request $request
     * @return Response|null
     * @Route("/pass/{id}", name="pass")
     */
    public function pass(Test $test, Request $request)
    {
       $questions = $test->getQuestions()->toArray();
       return new RedirectResponse($this->generateUrl('childanswer.create', ['id' => (array_shift($questions))->getId()]));
    }

    /**
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $test = new Test();
        $test->setCreator($this->getUser());

        $form = $this->createForm(TestCreateType::class, $test);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('test_create');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file)
            {
                $test->setImage($file);

                $em = $this->getDoctrine()->getManager();
                $em->persist($test);
                $em->flush();

                $this->addFlash('success', 'Тест успешно создан.');

                return new RedirectResponse($this->generateUrl('page.home'));
            } else {
                $this->addFlash('fail', 'Прикрепление изображения обязательно.');
            }
        }

        return $this->render('forms/test/test.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/test.svg',
            'title' => 'Создание теста'
        ]);
    }

    /**
     * @param Test $test
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Test $test, Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $form = $this->createForm(TestUpdateType::class, $test);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('test_update');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file) {
                $test->setImage($file);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            $this->addFlash('success', 'Тест успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/test/test.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/test.svg',
            'title' => 'Изменение теста'
        ]);
    }

    /**
     * @param Test $test
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Test $test, Request $request)
    {
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();

        $this->addFlash('success', 'Тест успешно удален.');

        return new RedirectResponse($this->generateUrl('page.home'));
    }

}