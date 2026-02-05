<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PoolType;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(PersonnageRepository $personnage, EntityManagerInterface $em, Request $request, SessionInterface $session, #[CurrentUser] ?User $user): Response
    {

        $form = $this->createForm(PoolType::class);
        $form->handleRequest($request);



        if ($form->isSubmitted()) {
            $data = $form->getData();

            $totalA = count($data['equipeA'] ?? []);

            $erreurs = [];

            if ($totalA !== 3) {
                $erreurs[] = "L'équipe A doit contenir exactement 3 personnages (actuellement : $totalA).";
            }

            if (!empty($erreurs)) {
                foreach ($erreurs as $msg) {
                    $this->addFlash('error', $msg);
                }

                return $this->render('team/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            $equipeA = $data['equipeA']->toArray();

            $equipeA = array_map(fn($p) => clone $p, $equipeA);

            $equipeA = $data['equipeA']->toArray();
            $equipeAIds = array_map(fn($perso) => $perso->getId(), $equipeA);
            $user->setTeam([
                'equipeA' => $equipeAIds,
            ]);

            $em->flush();

            $user->setIsWaiting(true);

            return $this->redirectToRoute('app_wait');
        }
        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
            'form' => $form->createView(),
        ]);
    }
}
