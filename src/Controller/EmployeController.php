<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(EmployeRepository $employeRepository): Response
    {
        $employes=$employeRepository->findAll();
        return $this->render('employe/index.html.twig', [
            'controller_name' => 'EmployeController',
            'employes'=>$employes
        ]);
    }

    #[Route('/employe/new', name: 'NewEmploye')]
    #[Route('/employe/{id}/edit', name: 'editEmploye')]
    public function new_edit(Employe $employe = null,Request $request, EntityManagerInterface $entityManager):Response
    {
        if(!$employe){
            $employe = new Employe();
        }
        $form = $this->createForm(EmployeType::class,$employe);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $employe=$form->getData();
            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('app_employe');
        }

        return $this->render('employe/new.html.twig',[
            'employe'=>$employe,
            'formAddEmploye'=>$form,
            'edit'=>$employe->getId()
        ]);
    }

    #[Route('/employe/{id}/delete', name: 'deleteEmploye')]
    public function deleteEmploye(Employe $employe, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute('app_employe');
    }

    #[Route('/employe/{id}', name: 'showEmploye')]
    public function show(Employe $employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe'=>$employe,
            'name'=>'Robert'
        ]);
    }
}
