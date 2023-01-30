<?php

namespace App\Repository;
use App\Entity\Categorie;
use App\Entity\Financement;
use App\Entity\Maturite;
use App\Entity\Projet;
use App\Entity\SearchData;
use App\Entity\Statut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Projet>
 *
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    public function add(Projet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Projet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    public function findAll(){
//        return $this->createQueryBuilder('projet')
////            ->where('projet.etat = :etats')
////            ->setParameter('etats', false)
//            ->getQuery()
//            ->getResult()
//            ;
//    }

    public function findAllByApprouve(){
        return $this->createQueryBuilder('projet')
            ->where('projet.approuver = :approuv')
            ->setParameter('approuv', true )
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByEnAttente(){
        return $this->createQueryBuilder('projet')
            ->where('projet.approuver = :approuv')
            ->setParameter('approuv', false )
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByArron(){
        return $this->createQueryBuilder('projet')
            ->select('projet')
            ->join('projet.arrondissement', 'a', 'WITH', 'projet.region IS NULL')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllApprouvByArron(){
        return $this->createQueryBuilder('projet')
            ->select('projet')
            ->join('projet.arrondissement', 'a', 'WITH', 'projet.region IS NULL AND projet.approuver = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByRegion(){
        return $this->createQueryBuilder('projet')
            ->where('projet.arrondissement IS NULL')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllApprouvByRegion(){
        return $this->createQueryBuilder('projet')
            ->where('projet.arrondissement IS NULL AND projet.approuver = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByEtat(){
        return $this->createQueryBuilder('projet')
            ->where('projet.etat = :etats')
            ->setParameter('etats', true)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllByReject(){
        return $this->createQueryBuilder('projet')
            ->where('projet.reject = :reject')
            ->setParameter('reject', true)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllApprouveByIdDesc(){
        return $this->createQueryBuilder('projet')
            ->where('projet.approuver = :approuv')
            ->setParameter('approuv', true )
            ->orderBy('projet.id', 'DESC')
        ;
    }

    public function findProjetByCategory(Categorie $categorie): array
    {
        return $this->createQueryBuilder('projet')
            -> join('projet.secteur', 'secteur')
            ->andWhere('secteur = :category')
            ->setParameter('category', $categorie)
            ->andWhere('projet.approuver = true')
            ->getQuery()
            ->getResult()
            ;
    }

    // find projet by parameter of statut
    public function findAllByStatutParameter(Statut $statut):array
    {
        return $this->createQueryBuilder('p')
            ->join('p.statut', 's')
            ->andWhere('s = :statut')
            ->setParameter('statut', $statut)
            ->getQuery()
            ->getResult()
            ;
    }

    // find projet by parameter of financement
    public function findAllByFinancementParameter(Financement $financement):array
    {
        return $this->createQueryBuilder('p')
            ->join('p.financement', 'f')
            ->andWhere('f = :financement')
            ->setParameter('financement', $financement)
            ->getQuery()
            ->getResult()
            ;
    }

    // find count projects grouped by arrondissement joined with departement and region
    public function findCountProjetsByArrondissement(): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as count, a.nom as arrondissement, d.nom as departement, r.nom as region')
            ->join('p.arrondissement', 'a')
            ->join('a.departement', 'd')
            ->join('d.region', 'r')
            ->where('p.approuver = true')
            ->groupBy('a.id')
            ->getQuery();

        return $query->getResult();
    }

    // find count projet by region on maps
    public function findCountProjetsByArrondissementApi(): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as count, a.nom as arrondissement, d.nom as departement, r.nom as region, r.lat as lat, r.lon as lon')
            ->join('p.arrondissement', 'a')
            ->join('a.departement', 'd')
            ->join('d.region', 'r')
            ->groupBy('a.id')
            ->getQuery();

        return $query->getResult();
    }

    // find count projet by commune on maps
    public function findCountProjetsByCommuneApi(): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.id as id, p.institule as institule, p.couts as couts, p.objectifs as objectifs, COUNT(p.id) as count, a.nom as commune, a.ville as ville, a.lat as lat, a.lon as lon, s.nom_categorie as secteur, m.nom_maturite as maturite')
            ->join('p.arrondissement', 'a')
             ->join("p.secteur", 's')
            ->join("p.maturite", "m")
            ->where('p.approuver = true')
            ->groupBy('p.id')
            ->getQuery();

        return $query->getResult();
    }

    // find  projet with all region
    public function findProjetsWithRegionApi(): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('p.id as id, p.institule as institule, p.couts as couts, p.objectifs as objectifs, COUNT(p.id) as count, r.nom as region, r.ville as ville, r.lat as lat, r.lon as lon, s.nom_categorie as secteur, m.nom_maturite as maturite')
            ->join('p.region', 'r')
            ->join("p.secteur", 's')
            ->join("p.maturite", "m")
            ->where('p.approuver = true')
            ->groupBy('p.id')
//            ->groupBy('a.id')
            ->getQuery();

        return $query->getResult();
    }

    // find count projet by region join maturity
    public function findCountProjetsByMaturiteApi(): array
    {
        $query = $this->createQueryBuilder('p')
            ->select('COUNT(p.id) as count, m.nom_maturite as maturite, a.nom as arrondissement, d.nom as departement, r.nom as region, r.lat as lat, r.lon as lon')
            ->join('p.arrondissement', 'a')
            ->join('a.departement', 'd')
            ->join('p.region', 'r')
            ->join('p.maturite', 'm')
            ->groupBy('p.id')
            ->getQuery();

        return $query->getResult();
    }

    // find all by projets filter
    public function findAllByFilters(
        array $maturites,
        array $categories,
        array $pregions,
        string $search,
        int|null $region,
        int|null $departement,
        int|null $arrondissement,
        bool $isArrondissementProjectList = false,
    ): array
    {
        if(
            empty($maturites)
            && empty($categories)
            && empty($pregions)
            && empty($search)
            && empty($region)
            && empty($departement)
            && empty($arrondissement)
        ) return $this->findAllByApprouve();

        $query = $this->createQueryBuilder('p');
        $query->where('p.approuver = true');
        if($isArrondissementProjectList) {
            $query->andWhere('p.region IS NULL');
        }
        if($search) {
            $query->andWhere('p.institule LIKE :mot OR p.objectifs LIKE :mot OR p.resultats LIKE :mot')
                ->setParameter('mot', "%{$search}%");
        }
        if($maturites) {
            $query
                ->join('p.maturite', 'maturite')
                ->andWhere('maturite IN (:maturites)')
                ->setParameter('maturites', $maturites);
        }
        if($categories) {
            $query
                ->join('p.secteur', 'secteur')
                ->andWhere('secteur IN (:secteurs)')
                ->setParameter('secteurs', $categories);
        }
        if($pregions) {
            $query
                ->join('p.region', 'r')
                ->andWhere('r.id IN (:regions)')
                ->setParameter('regions', $pregions);
        }
        if($region) {
            $query
//                ->join('p.region', 'r')
                ->leftJoin('p.arrondissement', 'arrondissement')
                ->leftJoin('arrondissement.departement', 'departement')
                ->leftJoin('departement.region', 'region')
//                ->where('r.id = :reg')
//                ->setParameter('reg', $region)
                ->andWhere('region.id = (:rId)')
                ->setParameter('rId', $region);
            if($departement) {
                $query
                    ->andWhere('departement.id = (:dId)')
                    ->setParameter('dId', $departement);
            }
            if($arrondissement) {
                $query
                    ->andWhere('arrondissement.id = (:aId)')
                    ->setParameter('aId', $arrondissement);
            }
        }
        return $query
            ->getQuery()
            ->getResult()
        ;
    }

    // find all by commune filters
    public function findAllByCommuneFilters(
        array $maturites,
        array $categories,
        string $search,
        int|null $region,
        int|null $departement,
        int|null $arrondissement,
        bool $isArrondissementProjectList = false,
    ): array
    {
        if(
            empty($maturites)
            && empty($categories)
            && empty($search)
            && empty($region)
            && empty($departement)
            && empty($arrondissement)
        ) return $this->findAllApprouvByArron();

        $query = $this->createQueryBuilder('p');
        $query->where('p.approuver = true');
        if($isArrondissementProjectList) {
            $query->andWhere('p.region IS NULL');
        }
        if($search) {
            $query->andWhere('p.institule LIKE :mot OR p.objectifs LIKE :mot OR p.resultats LIKE :mot')
                ->setParameter('mot', "%{$search}%");
        }
        if($maturites) {
            $query
                ->join('p.maturite', 'maturite')
                ->andWhere('maturite IN (:maturites)')
                ->setParameter('maturites', $maturites);
        }
        if($categories) {
            $query
                ->join('p.secteur', 'secteur')
                ->andWhere('secteur IN (:secteurs)')
                ->setParameter('secteurs', $categories);
        }
        if($region) {
            $query
                ->leftJoin('p.arrondissement', 'arrondissement')
                ->leftJoin('arrondissement.departement', 'departement')
                ->leftJoin('departement.region', 'region')
                ->andWhere('region.id = (:rId)')
                ->setParameter('rId', $region);
            if($departement) {
                $query
                    ->andWhere('departement.id = (:dId)')
                    ->setParameter('dId', $departement);
            }
            if($arrondissement) {
                $query
                    ->andWhere('arrondissement.id = (:aId)')
                    ->setParameter('aId', $arrondissement);
            }
        }
        return $query
            ->getQuery()
            ->getResult()
            ;
    }

    // find all by region filters
    public function findAllByRegionsFilters(
        array $categories,
        string $search,
        array $region
    ): array
    {
        if(
            empty($categories)
            && empty($search)
            && empty($region)
        ) return $this->findAllApprouvByRegion();

        $query = $this->createQueryBuilder('p')
            ->where('p.arrondissement IS NULL')
            ->andWhere('p.approuver = true');

        if($search) {
            $query->andWhere('p.institule LIKE :mot OR p.objectifs LIKE :mot OR p.resultats LIKE :mot')
                ->setParameter('mot', "%{$search}%");
        }
        if($categories) {
            $query
                ->join('p.secteur', 'secteur')
                ->andWhere('secteur IN (:secteurs)')
                ->setParameter('secteurs', $categories);
        }
        if($region) {
            $query
                ->join('p.region', 'r')
                ->andWhere('r.id IN (:regions)')
                ->setParameter('regions', $region);
        }
        return $query
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * Recupere les projets en lien avec la recherche
     */
    public function findSearch(SearchData $search)
    {
        $query =  $this->createQueryBuilder('p')
                ->where('p.approuver = true');
        if(!empty($search->mot)) {
            $query
                ->where('p.institule LIKE :mot OR p.objectifs LIKE :mot OR p.resultats LIKE :mot')
                ->setParameter('mot', "%{$search->mot}%");
        }
        if(!empty($search->maturites)) {
            $query
                ->join('p.maturite','m')
                ->andWhere('m.id = :mId')
                ->setParameter('mId', $search->maturites->getId());
        }
        if(!empty($search->categories)) {
            $query
                ->join('p.secteur','c')
                ->andWhere('c.id = :sId')
                ->setParameter('sId', $search->categories->getId());
        }

        return $query
            ->getQuery()
            ->getResult();
    }

    // Find user's project
    public function findByUser($userId) {
        return $this->createQueryBuilder('p')
           ->andWhere('p.user = :userId')
           ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    // Find user's project rejected by admin
    public function findByUserRejectProject($userId) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :userId')
            ->andWhere('p.reject = :reject')
            ->setParameter('reject',true )
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

    // Find user's project approuv by admin
    public function findByUserApprouvProject($userId) {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :userId')
            ->andWhere('p.approuver = true')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Projet[] Returns an array of Projet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Projet
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
