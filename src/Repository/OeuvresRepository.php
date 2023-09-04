<?php

namespace App\Repository;

use App\Entity\Oeuvres;
use App\filter\OeuvreFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Oeuvres>
 *
 * @method Oeuvres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvres[]    findAll()
 * @method Oeuvres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oeuvres::class);
    }

    public function add(Oeuvres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Oeuvres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


public function findFiltre(OeuvreFilter $filter)
{
    $query = $this->createQueryBuilder('p')
        ->leftJoin('p.categorie', 'c')
        ->leftJoin('p.matiere', 'm');
        
    if ($filter->recherche) {
        $query = $query
            ->andWhere('p.titre LIKE :recherche')
            ->orWhere('p.prix LIKE :recherche')
            ->orWhere('p.description LIKE :recherche')
            ->orWhere('c.nom LIKE :recherche')
            // ->orWhere('mq.titre LIKE :recherche')
            ->setParameter('recherche', '%' . $filter->recherche . '%');
    }

   

    if ($filter->matieres) {
        $query = $query
            ->andWhere('c.id IN (:matieres)')
            ->setParameter('matieres', $filter->matieres);
    }

    if ($filter->categories) {
        $query = $query
            ->andWhere('c.id IN (:categories)')
            ->setParameter('categories', $filter->categories);
    }
    if ($filter->min) {
        $query = $query
            ->andWhere('p.prix >= :min')
            ->setParameter('min', $filter->min);
    }
    if ($filter->max) {
        $query = $query
            ->andWhere('p.prix <= :max')
            ->setParameter('max', $filter->max);
    }

    if ($filter->order) {
        switch ($filter->order) {
            case 1:
                $query->orderBy('p.prix', 'ASC');
                break;
            case 2:
                $query->orderBy('p.prix', 'DESC');
                break;
            case 3:
                $query->orderBy('p.titre', 'ASC');
                break;
            case 4:
                $query->orderBy('p.titre', 'DESC');
                break;
        }
    }

    return $query->getQuery()->getResult();
}


}

