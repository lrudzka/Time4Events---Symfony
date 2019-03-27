<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\StubAuthenticator;
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
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager=$this->getDoctrine()->getManager();
            $emailAlreadyExists = $entityManager->getRepository(User::class)->findOneBy(["email" => $form->get('email')->getData()]);
            $nameAlreadyExists = $entityManager->getRepository(User::class)->findOneBy(["name" => $form->get('name')->getData()]);
            
            if ($emailAlreadyExists)
            {
                $this->addFlash("error", "Podany adres email jest już zarejestrowany w bazie");
            }
            elseif ($nameAlreadyExists)
            {
                $this->addFlash("error", "Podana nazwa użytkownika jest już zajęta");
            }
            else
            {
                $user->setRoles(['ROLE_USER']);
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash("success", "Rejestracja przebiegła poprawnie. Możesz się zalogować.");

                return $this->redirectToRoute('app_login');
            }
            
            
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
