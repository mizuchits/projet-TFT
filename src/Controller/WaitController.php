<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class WaitController extends AbstractController
{
    #[Route('/wait', name: 'app_wait')]

    public function index(EntityManagerInterface $em, SessionInterface $session): Response
    {
        $user = $this->getUser();
        // dd($user);
        $adversaire = $this->findOpponent($em);
        // dd($adversaire);

        if ($adversaire) {
            $teamAdversaire = $adversaire->getTeam();
            $nameAdversaire = $adversaire->getUsername();

            if ($teamAdversaire && isset($teamAdversaire['equipeA'])) {
                $session->set('adversaire', $teamAdversaire['equipeA']);
                $session->set('adversairename', $nameAdversaire);
                return $this->redirectToRoute('app_game');
            } else {
                $adversaire = $this->findOpponent($em);
            }
        }
        return $this->render('team/index.html.twig', [
            'controller_name' => 'WaitController',
        ]);
    }
    public function findOpponent(EntityManagerInterface $em): ?User
    {

        $usersEnAttente = $em->getRepository(User::class)
            ->findBy(['IsWaiting' => true]);

        // if (empty($usersEnAttente)) {
        //     $usersEnAttente = $em->getRepository(User::class)
        //         ->findBy(['IsWaiting' => true]);
        // }

        return $usersEnAttente[array_rand($usersEnAttente)];
    }


}
