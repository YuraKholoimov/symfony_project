<?php

namespace App\Controller;

use App\Entity\Request;
use App\Form\Type\FormRequestType;
use App\Repository\RequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/show-adding-form", name="request.add.new")
     */
    public function showAddingRequestFormAction(): Response
    {
        $request = new Request("Новый запрос", "Новое сообщение");

        $form = $this->createForm(FormRequestType::class, $request, [
            'action' => $this->generateUrl('request.add')
        ]);

        return $this->renderForm('request/add.html.twig' , [
            'addingForm' => $form,
        ]);
    }

    /**
     * @Route("/add", name="request.add")
     */
    public function addRequestAction(): Response
    {
        $request = new Request("Новый запрос", "Новое сообщение");

        $form = $this->createForm(FormRequestType::class, $request);

        return $this->renderForm('request/add.html.twig' , [
            'addingForm' => $form,
        ]);
    }

}