<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Entity\User;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

final class GameController extends AbstractController
{
    #[Route('/game', name: 'app_game')]
    public function index(EntityManagerInterface $em, SessionInterface $session, PersonnageRepository $repo, #[CurrentUser] ?User $user): Response
    {
        $equipeAid = $session->get('myteam', []);

        $equipeBid = $session->get('adversaire', []);
        $equipeBname = $session->get('adversairename', []);

        $session->remove('myteam');
        $session->remove('adversaire');
        $session->remove('personnages_pool');
        $user->setIsWaiting(false);
        $em->flush();

        $equipeA = $repo->findBy(['id' => $equipeAid]);
        // dd($equipeA);
        $equipeB = $repo->findBy(['id' => $equipeBid]);

        if (empty($equipeA) || empty($equipeB)) {
            $this->addFlash('error', 'Aucune équipe trouvée. Veuillez recommencer.');
            return $this->redirectToRoute('app_team');
        }
        $logs = [];
        $tour = 1;

        $logs[] = 'Début du combat 3v3 contre ' . $equipeBname . ' !';
        $this->logHP($logs, $equipeA, $equipeB);

        while ($this->equipeEstVivant($equipeA) && $this->equipeEstVivant($equipeB)) {
            $logs[] = "──────── Tour $tour ────────";

            $logs[] = "Équipe A attaque :";
            foreach ($equipeA as $attaquant) {
                if (!$attaquant->estVivant()) {
                    continue;
                }

                $cible = $this->choisirCibleVivante($equipeB);
                if (!$cible) {
                    break;
                }

                $logs[] = "{$attaquant->getName()} attaque {$cible->getName()}";
                $attaquant->attaquer($cible);

                $this->logHP($logs, $equipeA, $equipeB);
            }

            if (!$this->equipeEstVivant($equipeB)) {
                break;
            }

            $logs[] = "Équipe B contre-attaque :";
            foreach ($equipeB as $attaquant) {
                if (!$attaquant->estVivant()) {
                    continue;
                }

                $cible = $this->choisirCibleVivante($equipeA);
                if (!$cible) {
                    break;
                }

                $logs[] = "{$attaquant->getName()} attaque {$cible->getName()}";
                $attaquant->attaquer($cible);

                $this->logHP($logs, $equipeA, $equipeB);
            }

            $tour++;
        }

        $vainqueur = $this->equipeEstVivant($equipeA) ? 'Équipe A' : 'Équipe B';
        $logs[] = " Victoire de $vainqueur !";
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'logs' => $logs ?? [],
            'vainqueur' => $vainqueur ?? null,
            'equipeA' => $equipeA ?? null,
            'equipeB' => $equipeB ?? null,
        ]);
    }

    public function equipeEstVivant(array $equipe): bool
    {
        foreach ($equipe as $perso) {
            if ($perso->estVivant()) {
                return true;
            }
        }
        return false;
    }

    public function choisirCibleVivante(array $equipe): ?Personnage
    {
        $vivants = array_filter($equipe, fn($p) => $p->estVivant());
        if (empty($vivants)) {
            return null;
        }
        $indexAleatoire = array_rand($vivants);
        return $vivants[$indexAleatoire];
    }

    public function logHP(array &$logs, array $equipeA, array $equipeB): void
    {
        $hpA = implode(' | ', array_map(fn($p) => $p->getName() . ':' . $p->getHpStat(), $equipeA));
        $hpB = implode(' | ', array_map(fn($p) => $p->getName() . ':' . $p->getHpStat(), $equipeB));
        $logs[] = "HP → A: $hpA  |  B: $hpB";
    }
}
