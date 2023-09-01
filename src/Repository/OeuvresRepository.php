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

//    /**
//     * @return Oeuvres[] Returns an array of Oeuvres objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Oeuvres
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

// public function findCategorie($categorie)
// {
//     return $this->createQueryBuilder("p")
//     ->leftJoin("p.categorie","c")
//     ->andWhere("c.id=:categorie")
//     ->setParameter("categorie",$categorie)
//     ->getQuery()
//     ->getResult()
//       ; 
// }



// public function findFiltre(OeuvreFilter $filter)
// {
    
//  $query=$this->createQueryBuilder("p")
//  ->leftJoin("p.categorie","c")
 

// ;

// if($filter->recherche)
// {
//     $query=$query
//     ->andWhere("p.titre LIKE :recherche")
//     ->orWhere("p.prix LIKE :recherche")
//     ->orWhere("p.description LIKE :recherche")
//     ->orWhere("c.nom LIKE :recherche")
   
//     ->setParameter("recherche","%".$filter->recherche."%")
//     ;

// }


// if($filter->categories)
// {
//     $query=$query
//     ->andWhere("c.id IN (:categories)")
//     ->setParameter("categories",$filter->categories)
//     ;
// }

// if($filter->min)
// {
//     $query=$query
//     ->andWhere("p.prix >= :min")
//     ->setParameter("min",$filter->min)
//     ;
// }

// if($filter->max)
// {
//     $query=$query
//     ->andWhere("p.prix >= :min")
//     ->setParameter("max",$filter->max)
//     ;
// }

// if($filter->order==1)
// {
//     $query=$query
//     ->orderBy("p.prix", "ASC")
//     ;
// }

// if($filter->order==2)
// {
//     $query=$query
//     ->orderBy("p.prix", "DESC")
//     ;
// }
// if($filter->order==3)
// {
//     $query=$query
//     ->orderBy("p.prix", "DESC")
//     ;
// }
// if($filter->order==4)
// {
//     $query=$query
//     ->orderBy("p.prix", "ASC")
//     ;
// }


// return $query
// ->getQuery()
// ->getResult()
// ;




// }


// public function findSomeThing($recherche)
//     {
//         return $this->createQueryBuilder("p")
//         ->leftJoin("p.categorie","c")
  

//         ->andWhere("p.titre LIKE :recherche")
//         ->orWhere("p.prix LIKE :recherche")
//         ->orWhere("p.description LIKE :recherche")
       
//         ->setParameter("recherche","%$recherche%")
//         ->getQuery()
//         ->getResult()
//         ;




// 
// }
public function findFiltre(OeuvreFilter $filter)
{
    $query = $this->createQueryBuilder('p')
        ->leftJoin('p.categorie', 'c')
        ->leftJoin('p.oeuvreMatiere', 'om')
        ->leftJoin('om.matiere', 'mt');
    if ($filter->recherche) {
        $query = $query
            ->andWhere('p.titre LIKE :recherche')
            ->orWhere('p.prix LIKE :recherche')
            ->orWhere('p.description LIKE :recherche')
            ->orWhere('c.nom LIKE :recherche')
            // ->orWhere('mq.titre LIKE :recherche')
            ->setParameter('recherche', '%' . $filter->recherche . '%');
    }

    // if ($filter->marques) {
    //     $query = $query
    //         ->andWhere('mq.id IN (:marques)')
    //         ->setParameter('marques', $filter->marques);
    // }

    if ($filter->matieres) {
        $query = $query
            ->andWhere('mt.id IN (:matieres)')
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

