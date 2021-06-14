<?php


namespace App\Controller;

use App\Entity\Educator;
use App\Entity\User;
use App\Form\CreateType\EducatorCreateType;
use App\Form\UpdateType\EducatorPasswordUpdateType;
use App\Form\UpdateType\EducatorUpdateType;
use App\Service\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller that handles CRUD operations and another features of educator usertype.
 *
 * Class EducatorController
 * @package App\Controller
 *
 * @Route("/educator", name="educator.")
 */
class EducatorController extends AbstractController
{
    /**
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(UserManager $userManager, Request $request)
    {
        $educator = new Educator();

        $form = $this->createForm(EducatorCreateType::class, $educator);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $setDefaultPassword = $form->get('defaultPassword')->getData();
            if ($setDefaultPassword) {
                $educator->setPlainPassword(User::DEFAULT_PASSWORD);
            }
            $userManager->hashPassword($educator);
            $em = $this->getDoctrine()->getManager();
            $em->persist($educator);
            $em->flush();

            $username = $educator->getUsername();
            $this->addFlash('success', "Пользователь $username успешно создан");

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/educator/educator.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/registration.svg',
            'title' => 'Регистрация педагога'
        ]);
    }

    /**
     * @param Educator $educator
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Educator $educator, Request $request)
    {
        $form = $this->createForm(EducatorUpdateType::class, $educator);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($educator);
            $em->flush();

            $username = $educator->getUsername();
            $this->addFlash('success', "Данные пользователя $username успешно обновлены.");

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/educator/educator.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/registration.svg',
            'title' => 'Обновление данных'
        ]);
    }

    /**
     * @param Educator $educator
     * @param UserManager $userManager
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/password", name="password")
     */
    public function updatePassword(Educator $educator, UserManager $userManager, UserPasswordEncoderInterface $encoder, Request $request)
    {
        $form = $this->createForm(EducatorPasswordUpdateType::class, $educator);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if (!$encoder->isPasswordValid($educator, $oldPassword)) {
                $this->addFlash('fail', 'Старый пароль введен неверно.');

                return new RedirectResponse($this->generateUrl('page.home'));
            }
            $userManager->hashPassword($educator);
            $em = $this->getDoctrine()->getManager();
            $em->persist($educator);
            $em->flush();

            $this->addFlash('success', 'Пароль успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/educator/educator.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/registration.svg',
            'title' => 'Смена пароля'
        ]);
    }

    /**
     * @param Educator $educator
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Educator $educator, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($educator);
        $em->flush();

        $username = $educator->getUsername();
        $this->addFlash('success', "Аккаунт пользователя $username успешно удален.");

        return new RedirectResponse($this->generateUrl('page.home'));
    }

    /**
     * @param Educator $educator
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/reset", name="reset")
     */
    public function resetPassword(Educator $educator, UserManager $userManager, Request $request)
    {
        $educator->setPlainPassword(User::DEFAULT_PASSWORD);
        $userManager->hashPassword($educator);

        $em = $this->getDoctrine()->getManager();
        $em->persist($educator);
        $em->flush();

        $username = $educator->getUsername();
        $this->addFlash('success', "Пароль пользователя $username успешно сброшен к значению по умолчанию.");

        return new RedirectResponse($this->generateUrl('page.home'));
    }
}