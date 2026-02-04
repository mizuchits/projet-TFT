<?php

namespace App\Repository;

use App\Entity\Personnage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Personnage>
 */
class PersonnageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnage::class);
    }
//    /**
//     * @return Personnage[] Returns an array of Personnage objects
//     */

    public function createPool(): ?Personnage
    {
        return $this->createQueryBuilder('p')
            ->orderBy('RAND()')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
       ;
    }

}

