<?php

namespace App\Controller;

use App\Entity\Users;
use App\Service\JWTService;
use App\Service\SendMailService;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/rregister', name: 'app_rregister')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            //on genere le jwt de l'utilisateur
            // on cree le hearder
            $header =[
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //on crée le payload
            $payload =[
                'user_id' => $user->getId()
            ];

            //on genere le token

            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
           
            return $this->render('emails/register.html.twig', [
                'token' => $token,
            ]);

            

            // on envoie un email
            $mail->send(
                'no-reply@monsite.net',
                $user->getEmail(),
                'Activation de votre compte sue le site E-commerce',
                'register',
                [
                    compact('user', 'token')
                ]
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/rregister.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token): Response 
    {
        dd($token);
    }
}
