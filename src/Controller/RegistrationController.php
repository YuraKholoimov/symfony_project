<?php

namespace App\Controller;


use App\DTO\UserDTO;
use App\Entity\User;
use App\Form\Type\FormRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registration")
*/

class RegistrationController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="app.registration")
     */
    public function registrationAction(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $userDto = new userDto();

        $form = $this->createForm(FormRegistrationType::class, $userDto, [
            "action" => $this->generateUrl("app.registration")
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $user = new User();

            $user->setEmail($userDto->getEmail());

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $userDto->getPlainPassword()
            );


            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

           return $this->redirectToRoute("index");
        }

        return $this->renderForm("app/registration.html.twig", [
            "form" => $form
        ]);
    }
}