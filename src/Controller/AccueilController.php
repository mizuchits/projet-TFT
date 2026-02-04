<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Form\PoolType;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(PersonnageRepository $personnage, EntityManagerInterface $em, Request $request): Response
    {

        



        return $this->render('accueil/index.html.twig', [
        ]);
    }

    
}
