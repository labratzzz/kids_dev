<?php


namespace App\Controller;


use App\Entity\Child;
use App\Entity\User;
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
//        $user = new Child();
//
//        $form = $this->createForm(FormType::class, $user);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $userManager->hashPassword($user);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
//            $em->flush();
//
//            $this->addFlash('success', "flash_message");
//
//            return new RedirectResponse($this->generateUrl('app_login'));
//        }
//
//        return $this->render('forms/user/main.html.twig', [
//            'form' => $form->createView(),
//            'image' => 'img/logo.svg',
//            'title' => 'Регистрация'
//        ]);
        return new RedirectResponse($this->generateUrl('page.home'));
    }

    /**
     * @param Child $child
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/update", name="update")
     */
    public function update(Child $child, Request $request)
    {
//        $form = $this->createForm(FormType::class, $child);
//
//        $form->handleRequest($request);
//
//        if ($form->get('cancel')->isClicked()) {
//            return new RedirectResponse($this->generateUrl('page.home'));
//        }
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($child);
//            $em->flush();
//
//            $this->addFlash('success', 'Данные успешно обновлены.');
//
//            return new RedirectResponse($this->generateUrl('page.profile'));
//        }
//
//        return $this->render('forms/user/main.html.twig', [
//            'form' => $form->createView(),
//            'image' => 'img/user-edit.svg',
//            'title' => 'Изменение данных'
//        ]);
        return new RedirectResponse($this->generateUrl('page.home'));
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
//        $form = $this->createForm(FormType::class, $child);
//
//        $form->handleRequest($request);
//
//        if ($form->get('cancel')->isClicked()) {
//            return new RedirectResponse($this->generateUrl('page.profile'));
//        }
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $oldPassword = $form->get('oldPassword')->getData();
//            if (!$encoder->isPasswordValid($child, $oldPassword)) {
//                $this->addFlash('fail', 'Старый пароль введен неверно.');
//
//                return new RedirectResponse($this->generateUrl('page.home'));
//            }
//            $userManager->hashPassword($child);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($child);
//            $em->flush();
//
//            $this->addFlash('success', 'Пароль успешно обновлен.');
//
//            return new RedirectResponse($this->generateUrl('page.home'));
//        }
//
//        return $this->render('forms/user/main.html.twig', [
//            'form' => $form->createView(),
//            'image' => 'img/user-edit.svg',
//            'title' => 'Изменение пароля'
//        ]);
        return new RedirectResponse($this->generateUrl('page.home'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response|null
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(User $user, Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($user);
//        $em->flush();
//
//        $this->get('security.token_storage')->setToken(null);
//        $request->getSession()->invalidate();
//
//        $this->addFlash('success', 'Пользователь успешно удален.');
//
//        return new RedirectResponse($this->generateUrl('page.home'));
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
//        $child->setPlainPassword(User::RESET_PASSWORD_VALUE);
//        $userManager->hashPassword($child);
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($child);
//        $em->flush();
//
//        $this->addFlash('success', 'Пароль успешно сброшен к значению по умолчанию.');
//
//        return new RedirectResponse($this->generateUrl('page.home'));
        return new RedirectResponse($this->generateUrl('page.home'));
    }
}