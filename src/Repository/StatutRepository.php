<?php

namespace App\Repository;

use App\Entity\Region;
use App\Entity\Statut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Statut>
 *
 * @method Statut|null find($id, $lockMode = null, $lockVersion = null)
 * @method Statut|null findOneBy(array $criteria, array $orderBy = null)
 * @method Statut[]    findAll()
 * @method Statut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Statut::class);
    }

    public function add(Statut $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Statut $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Find all approuv projects by statut
    public function findAllByApprouv(): array
    {
        $query = $this->createQueryBuilder('s')
            ->select('s.id, s.nom,  COUNT(p.id) AS projetCount')
            ->leftJoin('s.projet', 'p', 'WITH', 's.id = p.statut AND p.approuver = true')
            ->groupBy('s.id')
            ->getQuery();

        return $query->getResult();
    }

    public function findByUserApprouv($userId) {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.projet', 'p', 'WITH', 's.id = p.statut AND p.approuver = true')
            ->join('p.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    public function findAllByRegion(Region $region)
    {
        return $this->createQueryBuilder('s')
            ->join('s.projet', 'p')
            ->where('p.region = :region')
            ->setParameter('region', $region)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Statut[] Returns an array of Statut objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Statut
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
