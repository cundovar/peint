<?php

namespace App\Repository;

use App\Entity\OeuvreMatieres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OeuvreMatieres>
 *
 * @method OeuvreMatieres|null find($id, $lockMode = null, $lockVersion = null)
 * @method OeuvreMatieres|null findOneBy(array $criteria, array $orderBy = null)
 * @method OeuvreMatieres[]    findAll()
 * @method OeuvreMatieres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreMatieresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OeuvreMatieres::class);
    }

    public function add(OeuvreMatieres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OeuvreMatieres $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OeuvreMatieres[] Returns an array of OeuvreMatieres objects
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

//    public function findOneBySomeField($value): ?OeuvreMatieres
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
