<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Repository\EntrepriseRepository;
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

    #[Route('/home/{id}', name: 'showEntreprise')]
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('home/show.html.twig', [
            'entreprise'=>$entreprise,
            'name'=>'Robert',
        ]);
    }
}
