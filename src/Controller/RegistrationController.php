<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registration")
*/

class RegistrationController extends AbstractController
{
    /**
     * @Route("/", name="app.registration")
     */
    public function registrationAction(): Request
    {
        $userDTO = new userDto();
    }
}