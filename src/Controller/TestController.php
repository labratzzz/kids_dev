<?php


namespace App\Controller;

use App\Entity\Test;
use App\Form\TestCreateType;
use App\Form\TestUpdateType;
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
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $test = new Test();

        $form = $this->createForm(TestCreateType::class, $test);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            $this->addFlash('success', "Тест успешно создан.");

            return new RedirectResponse($this->generateUrl('page.home'));
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
        $form = $this->createForm(TestUpdateType::class, $test);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($test);
            $em->flush();

            $this->addFlash('success', 'Тест успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.profile'));
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
        $em = $this->getDoctrine()->getManager();
        $em->remove($test);
        $em->flush();

        $this->addFlash('success', 'Тест успешно удален.');

        return new RedirectResponse($this->generateUrl('page.home'));
    }

}