<?php

namespace App\Repository;

use App\Entity\Maturite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Maturite>
 *
 * @method Maturite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Maturite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Maturite[]    findAll()
 * @method Maturite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaturiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Maturite::class);
    }

    public function add(Maturite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Maturite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // return name and count relation with all maturite
    public function findAllWithProjetsCount(): array
    {
        $query = $this->createQueryBuilder('m')
            ->select('m.id, m.nom_maturite, COUNT(p.id) AS projetCount')
            ->leftJoin('m.projet', 'p')
            ->groupBy('m.id')
            ->getQuery();

        return $query->getResult();
    }


//    /**
//     * @return Maturite[] Returns an array of Maturite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Maturite
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
