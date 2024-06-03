<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\UserRepository;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        // $entreprise = $entrepriseRepository->getRepository(Entreprise::class)->findAll();
        $entreprise = $entrepriseRepository->findBy([],['raisonSociale'=>'ASC']);
        return $this->render('home/index.html.twig', [
         'entreprises'=>$entreprise   
        ]);
    }

    #[Route('/home/new', name: 'NewEntreprise')]
    #[Route('home/{id}/edit', name: 'editEntreprise')]
    public function new_edit(Entreprise $entreprise = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$entreprise){
            $entreprise = new Entreprise();
        }

        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entreprise=$form->getData();
            $entityManager->persist($entreprise);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('home/new.html.twig', [
            'entreprise'=>$entreprise,
            'formAddEntreprise'=>$form,
            'edit'=> $entreprise->getId()
        ]);
    }
    
    #[Route('/home/{id}', name: 'showEntreprise')]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('home/show.html.twig', [
            'entreprise'=>$entreprise,
            'name'=>'Robert',
        ]);
    }
}
