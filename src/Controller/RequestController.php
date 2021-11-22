<?php

namespace App\Controller;


use App\DTO\RequestDTO;;
use App\Entity\Request as RequestEntity;
use App\Form\Type\FormRequestType;
use App\Repository\RequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/request")
 */
class RequestController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

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

//    /**
//     * @Route("/show-adding-form", name="request.add.new")
//     */
//    public function showAddingRequestFormAction(): Response
//    {
//        $request = new Request("Новый запрос", "Новое сообщение");
//
//        $form = $this->createForm(FormRequestType::class, $request, [
//            'action' => $this->generateUrl('request.add')
//        ]);
//
//        return $this->renderForm('request/add.html.twig' , [
//            'addingForm' => $form,
//        ]);
//    }
    /**
     * @Route("/add", name="request.add")
     */

    public function addRequestAction(Request $request): Response
    {
        $requestDTO = new RequestDTO();

        $form = $this->createForm(FormRequestType::class, $requestDTO, [
            "action" => $this->generateUrl("request.add")
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestEntity = RequestEntity::createFromDTO($requestDTO);
            $this->entityManager->persist($requestEntity);
            $this->entityManager->flush();

            return $this->redirectToRoute('request.show', [
                "id" => $requestEntity->getId()
            ]);
        }

        return $this->renderForm('request/add.html.twig' , [
            'addingForm' => $form,
        ]);
    }

}