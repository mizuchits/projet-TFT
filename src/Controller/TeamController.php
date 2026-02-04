<?php

namespace App\Controller;

use App\Form\PoolType;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(PersonnageRepository $personnage, EntityManagerInterface $em, Request $request, SessionInterface $session): Response
    {

        $form = $this->createForm(PoolType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $equipeA = $data['equipeA']->toArray();
            $equipeB = $data['equipeB']->toArray();

            $equipeA = array_map(fn($p) => clone $p, $equipeA);
            $equipeB = array_map(fn($p) => clone $p, $equipeB);

            $session = $request->getSession();
            $session->set('combat_equipeA', $equipeA);
            $session->set('combat_equipeB', $equipeB);

            return $this->redirectToRoute('app_game');
        }
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
            'form' => $form->createView(),
        ]);
    }
}
