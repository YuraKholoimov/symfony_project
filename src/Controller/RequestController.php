<?php

namespace App\Controller;


use App\Entity\Request;
use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/request")
 */
class RequestController extends AbstractController
{
    /**
     * @Route("/list", name="request.list")
     */
    public function getListAction(RequestRepository $requestRepository): Response
    {

        $requestList = $requestRepository->findAll();

        return $this->render('request/list.html.twig', [
            'requestList' => $requestList
        ]);
    }

    /**
     * @Route("/show/{id}", name="request.show")
     */
    public function showAction(int $id, RequestRepository $requestRepository): Response
    {
        $request = $requestRepository->findById($id);

        if(is_null($request))
            throw new NotFoundHttpException("Запрос не найден");

        return $this->render('request/show.html.twig', [
            'request' => $request
        ]);
    }

    /**
     * @Route("/add", name="request.add")
     */
    public function addRequestAction(): Response
    {
        $request = new Request("Новый запрос", "Новое сообщение");

        $form = $this->createFormBuilder($request)
            ->add('title', TextType::class)
            ->add('message', TextareaType::class)
            ->add('save', SubmitType::class, ['label' => 'Добавить'])
            ->getForm();

        return $this->renderForm('request/add.html.twig', [
            'adding_form' => $form,
        ]);
    }





}