<?php


namespace App\Controller;

use App\Entity\Discipline;
use App\Form\CreateType\DisciplineCreateType;
use App\Form\UpdateType\DisciplineUpdateType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller that handles CRUD operations for discipline entity.
 *
 * Class DisciplineController
 * @package App\Controller
 *
 * @Route("/discipline", name="discipline.")
 */
class DisciplineController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $discipline = new Discipline();

        $form = $this->createForm(DisciplineCreateType::class, $discipline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discipline);
            $em->flush();

            $this->addFlash('success', "Предмет успешно создан.");

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/discipline/discipline.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/blackboard.svg',
            'title' => 'Создание предмета'
        ]);
    }

    /**
     * @param Discipline $discipline
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Discipline $discipline, Request $request)
    {
        $form = $this->createForm(DisciplineUpdateType::class, $discipline);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($discipline);
            $em->flush();

            $this->addFlash('success', 'Предмет успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/discipline/discipline.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/blackboard.svg',
            'title' => 'Изменение предмета'
        ]);
    }

    /**
     * @param Discipline $discipline
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Discipline $discipline, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($discipline);
        $em->flush();

        $this->addFlash('success', 'Предмет и содержащиеся в нем тесты успешно удалены.');

        return new RedirectResponse($this->generateUrl('page.home'));
    }

}