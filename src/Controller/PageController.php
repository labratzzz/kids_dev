<?php


namespace App\Controller;

use App\Entity\Child;
use App\Entity\ChildAnswer;
use App\Entity\Discipline;
use App\Entity\Educator;
use App\Entity\Question;
use App\Entity\Test;
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
            $childPage = $request->query->get('cpage', 1);
            $educatorPage = $request->query->get('epage', 1);

            $childrenQb = $this->getDoctrine()->getRepository(Child::class)->getAllQueryBuilder();
            $children = $this->paginate($childrenQb->getQuery(), $childPage, $childPages);
            $educatorsQb = $this->getDoctrine()->getRepository(Educator::class)->getAllQueryBuilder();
            $educators = $this->paginate($educatorsQb->getQuery(), $educatorPage, $educatorPages);

            return $this->render('pages/home/admin.html.twig', [
                'pagetitle' => 'Панель администрирования',
                'children' => $children,
                'child_page' => $childPage,
                'child_pages' => $childPages,
                'educators' => $educators,
                'educator_page' => $educatorPage,
                'educator_pages' => $educatorPages
            ]);
        } else if ($user instanceof Child) {
            $testQb = $this->getDoctrine()->getRepository(Test::class)->getAllQueryBuilder();
            $lastTests = $this->paginate($testQb->getQuery(), 1, $testPages, 5);

            return $this->render('pages/home/child.html.twig', [
                'lasttests' => $lastTests,
                'pagetitle' => 'Домашняя',
                'is_educator' => false
            ]);
        } else {
            return $this->render('pages/home/educator.html.twig', [
                'pagetitle' => 'Домашняя',
                'is_educator' => true
            ]);
        }
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
        $disciplinePage = $request->query->get('dpage', 1);

        $disciplineQb = $this->getDoctrine()->getRepository(Discipline::class)->getAllQueryBuilder();
        $disciplines = $this->paginate($disciplineQb->getQuery(), $disciplinePage, $disciplinePages);

        return $this->render('pages/disciplines/disciplines.html.twig', [
            'pagetitle' => 'Предметы',
            'disciplines' => $disciplines,
            'discipline_page' => $disciplinePage,
            'discipline_pages' => $disciplinePages,
            'has_access' => $this->getUser() instanceof Educator
        ]);
    }

    /**
     * @Route("tests", name="tests", methods={"GET"})
     * @param Request $request
     * @return Response|null
     */
    public function testsPage(Request $request)
    {
        $testPage = $request->query->get('tpage', 1);

        $testQb = $this->getDoctrine()->getRepository(Test::class)->getAllQueryBuilder();
        $tests = $this->paginate($testQb->getQuery(), $testPage, $testPages);

        return $this->render('pages/tests/tests.html.twig', [
            'pagetitle' => 'Все тесты',
            'tests' => $tests,
            'test_page' => $testPage,
            'test_pages' => $testPages,
            'has_access' => $this->getUser() instanceof Educator,
            'is_child' => $this->getUser() instanceof Child,
        ]);
    }

}