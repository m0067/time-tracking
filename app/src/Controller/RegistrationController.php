<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthentificator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        LoginFormAuthentificator $login,
        GuardAuthenticatorHandler $guard
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles([User::ROLE_ADMIN]);

            $entityManager->persist($user);
            $entityManager->flush();

            return $guard->authenticateUserAndHandleSuccess($user, $request, $login, 'main');
        }

        return $this->render(
            'registration/register.html.twig',
            [
                'registrationForm' => $form->createView(),
            ]
        );
    }
}
