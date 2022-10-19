<?php

namespace App\Repository;

use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Region>
 *
 * @method Region|null find($id, $lockMode = null, $lockVersion = null)
 * @method Region|null findOneBy(array $criteria, array $orderBy = null)
 * @method Region[]    findAll()
 * @method Region[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Region::class);
    }

    public function add(Region $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Region $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // return name and count relation with all region
    public function findAllWithProjetsCount(): array
    {
        $query = $this->createQueryBuilder('r')
            ->select('r.id, r.nom, COUNT(p.id) AS projetCount')
            ->leftJoin('r.projets', 'p')
            ->groupBy('r.id')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllByRegionsWithProjetsCount(array $regions): array  {
        if(empty($regions)) return $this->findAllWithProjetsCount();

        $query = $this->createQueryBuilder('r')
            ->select('r.id, r.nom, COUNT(p.id) AS projetCount')
            ->join('r.departements', 'd')
            ->join('d.arrondissements', 'a')
            ->join('a.projets', 'p')
            ->join('p.secteur', 's')
            ->where('s.id IN (:regions)')
            ->setParameter('regions', $regions)
            ->groupBy('r.id')
            ->getQuery();

        return $query->getResult();
    }

//    /**
//     * @return Region[] Returns an array of Region objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Region
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
