<?php


namespace App\Controller;


use App\Entity\Child;
use App\Entity\User;
use App\Form\CreateType\ChildCreateType;
use App\Form\UpdateType\ChildPasswordUpdateType;
use App\Form\UpdateType\ChildUpdateType;
use App\Service\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller that handles CRUD operations and another features of child usertype.
 *
 * Class ChildController
 * @package App\Controller
 *
 * @Route("/child", name="child.")
 */
class ChildController extends AbstractController
{

    /**
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/create", name="create")
     */
    public function create(UserManager $userManager, Request $request)
    {
        $child = new Child();

        $form = $this->createForm(ChildCreateType::class, $child);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $setDefaultPassword = $form->get('defaultPassword')->getData();
            if ($setDefaultPassword) {
                $child->setPlainPassword(User::DEFAULT_PASSWORD);
            }
            $userManager->hashPassword($child);
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $username = $child->getUsername();
            $this->addFlash('success', "Пользователь $username успешно создан");

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/child/child.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/registration.svg',
            'title' => 'Регистрация ребенка'
        ]);
    }

    /**
     * @param Child $child
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Child $child, Request $request)
    {
        $form = $this->createForm(ChildUpdateType::class, $child);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.home'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $username = $child->getUsername();
            $this->addFlash('success', "Данные пользователя $username успешно обновлены.");

            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        return $this->render('forms/child/child.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/edit.svg',
            'title' => 'Обновление данных'
        ]);
    }

    /**
     * @param Child $child
     * @param UserManager $userManager
     * @param UserPasswordEncoderInterface $encoder
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/password", name="password")
     */
    public function updatePassword(Child $child, UserManager $userManager, UserPasswordEncoderInterface $encoder, Request $request)
    {
        $form = $this->createForm(ChildPasswordUpdateType::class, $child);

        $form->handleRequest($request);

        if ($form->get('cancel')->isClicked()) {
            return new RedirectResponse($this->generateUrl('page.profile'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if (!$encoder->isPasswordValid($child, $oldPassword)) {
                $this->addFlash('fail', 'Старый пароль введен неверно.');

                return new RedirectResponse($this->generateUrl('page.home'));
            }
            $userManager->hashPassword($child);
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $this->addFlash('success', 'Пароль успешно обновлен.');

            return new RedirectResponse($this->generateUrl('page.home'));
        }

        return $this->render('forms/child/child.html.twig', [
            'form' => $form->createView(),
            'image' => 'img/edit.svg',
            'title' => 'Смена пароля'
        ]);
    }

    /**
     * @param Child $child
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Child $child, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($child);
        $em->flush();

        if ($this->getUser() === $child) {
            $this->get('security.token_storage')->setToken(null);
            $request->getSession()->invalidate();
        }

        $username = $child->getUsername();
        $this->addFlash('success', "Аккаунт пользователя $username успешно удален.");

        return new RedirectResponse($this->generateUrl('page.home'));
    }

    /**
     * @param Child $child
     * @param UserManager $userManager
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/reset", name="reset")
     */
    public function resetPassword(Child $child, UserManager $userManager, Request $request)
    {
        $child->setPlainPassword(User::DEFAULT_PASSWORD);
        $userManager->hashPassword($child);

        $em = $this->getDoctrine()->getManager();
        $em->persist($child);
        $em->flush();

        $username = $child->getUsername();
        $this->addFlash('success', "Пароль пользователя $username успешно сброшен к значению по умолчанию.");

        return new RedirectResponse($this->generateUrl('page.home'));
    }
}