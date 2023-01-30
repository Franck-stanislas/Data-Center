<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Projet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorie>
 *
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function add(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllByApprouv() {
        return $this->createQueryBuilder('categorie')
            ->select('categorie.id, categorie.nom_categorie, categorie.imageName, categorie.iconeName, COUNT(projet.id) AS projetCount')
            ->leftJoin('categorie.projet', 'projet', 'WITH', 'categorie.id = projet.secteur AND  projet.approuver = true')
            ->groupBy('categorie.id')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllWithProjectsCount(): array {
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.nom_categorie, COUNT(p.id) AS projetCount')
            ->leftJoin('c.projet', 'p', 'WITH', 'p.approuver = true')
            ->groupBy('c.id')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllByArronWithProjectsCount(): array {
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.nom_categorie, COUNT(p.id) AS projetCount')
            ->leftJoin('c.projet', 'p', 'WITH', 'p.region IS NULL AND p.approuver = true')
            ->groupBy('c.id')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllByRegionWithProjectsCount(): array {
        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.nom_categorie, COUNT(p.id) AS projetCount')
            ->leftJoin('c.projet', 'p', 'WITH', 'p.arrondissement IS NULL AND p.approuver = true')
            ->groupBy('c.id')
            ->getQuery();

        return $query->getResult();
    }

    public function findAllByMaturitesWithProjectsCount(array $maturites): array {
        if(empty($maturites)) return $this->findAllByArronWithProjectsCount();

        $query = $this->createQueryBuilder('c')
            ->select('c.id, c.nom_categorie, COUNT(p.id) AS projetCount')
            ->join('c.projet', 'p')
            ->join('p.maturite', 'm')
            ->where('m.id IN (:maturites)')
            ->setParameter('maturites', $maturites)
            ->groupBy('c.id')
            ->getQuery();

        return $query->getResult();
    }

    // Get one projet by categorie
    public function findOneByProjet(Projet $projet): array
    {
        return $this->createQueryBuilder('categorie')
            -> join('categorie.projet', 'projet')
            ->andWhere('projet = :projet')
            ->setParameter('projet', $projet)
            ->getQuery()
            ->getResult()
        ;
    }



//    /**
//     * @return Categorie[] Returns an array of Categorie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Categorie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
