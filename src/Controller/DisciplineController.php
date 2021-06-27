<?php


namespace App\Controller;

use App\Entity\Child;
use App\Entity\Discipline;
use App\Entity\Educator;
use App\Entity\Test;
use App\Form\CreateType\DisciplineCreateType;
use App\Form\UpdateType\DisciplineUpdateType;
use App\Util\Helper;
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
     * @param Discipline $discipline
     * @param Request $request
     * @return Response|null
     * @Route("/view/{id}", name="view")
     */
    public function view(Discipline $discipline, Request $request)
    {
        $testPage = $request->query->get('tpage', 1);

        $testQb = $this->getDoctrine()->getRepository(Test::class)->getByDisciplineQueryBuilder($discipline);
        $tests = $this->paginate($testQb->getQuery(), $testPage, $testPages);

        return $this->render('forms/discipline/view.html.twig', [
            'discipline' => $discipline,
            'tests' => $tests,
            'test_page' => $testPage,
            'test_pages' => $testPages,
            'has_access' => $this->getUser() instanceof Educator,
            'is_child' => $this->getUser() instanceof Child
        ]);
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
        $discipline = new Discipline();

        $form = $this->createForm(DisciplineCreateType::class, $discipline);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('discipline_create');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file)
            {
                $discipline->setImage($file);

                $em = $this->getDoctrine()->getManager();
                $em->persist($discipline);
                $em->flush();

                $this->addFlash('success', 'Предмет успешно создан.');

                return new RedirectResponse($this->generateUrl('page.home'));
            } else {
                $this->addFlash('fail', 'Прикрепление изображения обязательно.');
            }
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
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            $this->addFlash('success', 'У вас нет доступа к этой странице.');
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $form = $this->createForm(DisciplineUpdateType::class, $discipline);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $request->files->get('test_update');
            $file = Helper::uploadFile(array_shift($files), $this->getParameter('upload_dir'));
            if ($file) {
                $discipline->setImage($file);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($discipline);
            $em->flush();

            $this->addFlash('success', 'Предмет успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.home'));
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
        $user = $this->getUser();
        if (!$user instanceof Educator) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($discipline);
        $em->flush();

        $this->addFlash('success', 'Предмет и содержащиеся в нем тесты успешно удалены.');

        return new RedirectResponse($this->generateUrl('page.disciplines'));
    }

}