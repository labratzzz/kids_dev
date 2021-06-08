<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User as AdminUser;

/**
 * Controller that handles general app templates and builds primary visual environment.
 *
 * Class PageController
 * @package App\Controller
 *
 * @Route(name="page.")
 */
class PageController extends AbstractController
{

    /**
     * @Route("", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function startPage(Request $request)
    {
        return new RedirectResponse('home');
    }

    /**
     * @Route("home", name="home", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function homePage(Request $request)
    {
        $user = $this->getUser();
        if ($user instanceof AdminUser) {
            return $this->render('pages/admin/admin.html.twig', [
                'pagetitle' => 'Панель администрирования'
            ]);
        }

        return $this->render('pages/home/home.html.twig', [
            'pagetitle' => 'Домашняя'
        ]);
    }

    /**
     * @Route("about", name="about", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function aboutPage(Request $request)
    {
        return $this->render('pages/about/about.html.twig', [
            'pagetitle' => 'О нас'
        ]);
    }

    /**
     * @Route("disciplines", name="disciplines", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function disciplinesPage(Request $request)
    {
        return $this->render('pages/disciplines/disciplines.html.twig', [
            'pagetitle' => 'Предметы'
        ]);
    }

    /**
     * @Route("tests", name="tests", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function testsPage(Request $request)
    {
        return $this->render('pages/tests/tests.html.twig', [
            'pagetitle' => 'Тесты'
        ]);
    }

}