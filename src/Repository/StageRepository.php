<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    /**
     * @return Stage[] Returns an array of Stage objects
     */

    public function findByEntreprise($nom)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
            ->andWhere('e.nom = :val')
            ->setParameter('val', $nom)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Stage[] Returns an array of Stage objects
     */
     public function findByFormation($intitule)
     {
      //recuperer le gestionnzaire d'entité
      $entityManager = $this->getEntityManager();
      // construction de la requete
      $requete = $entityManager->createQuery(
        'SELECT s
        FROM App\Entity\Stage s
        JOIN s.formation f
        WHERE f.intitule = :intitule');
        $requete->setParameter('intitule',$intitule);
        return $requete->execute();

     }

     /**
      * @return Stage[] Returns an array of Stage objects
      */

     public function findByAccueilEtEntreprise()
     {
       //recuperer le gestionnzaire d'entité
       $entityManager = $this->getEntityManager();
       // construction de la requete
       $requete = $entityManager->createQuery(
         'SELECT s , e
         FROM App\Entity\Stage s
         JOIN s.entreprise e
         ORDER BY s.id DESC');
         return $requete->execute();
     }
}
