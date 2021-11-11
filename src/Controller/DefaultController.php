<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     *
     * @Route("/", name="name")
     *
     */
    public function indexAction(): Response
    {
        return new Response('This is my home page');
    }
    /**
     *
     * @Route("/{name}", name="show-name")
     */
    public function showNameTwoAction($name): Response
    {
        return $this->render('base.html.twig', [
            'name' => $name
        ]);
    }
    /**
     *
     * @Route("/name/{name}", name="show-name")
     */
    public function showNameAction($name): Response
    {
        return $this->render('Order/show.html.twig', [
            'name' => $name
        ]);
    }
//    /**
//     *
//     * @Route("/print-your-name")
//     */
//
//    public function printDefaultNameAction(): Response
//    {
//
//        return new Response('Hello world');
//    }
//
//    /**
//     *
//     * @Route("/print-your-name/{name}")
//     */
//
//    public function printYourNameAction(string $name): Response
//    {
//        $output = sprintf('Hello %s', $name);
//
//        return new Response($output);
//    }

}
