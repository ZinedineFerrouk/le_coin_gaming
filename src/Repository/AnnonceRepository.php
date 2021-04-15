<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }


    public function findAllAnnonce()
    {
        return $this->createQueryBuilder('a')
            ->addselect('a','j','p')
            ->leftJoin('a.jeu','j')
            ->leftJoin('a.plateforme','p')
            ->getQuery()
            ->getResult()
            ;
    }


    public function annonceNonPublie()
    {
        return $this->createQueryBuilder('a')
            ->addselect('a','j','p')
            ->leftJoin('a.jeu','j')
            ->leftJoin('a.plateforme','p')
            ->where('a.status = ?1')
            ->setParameter(1, 'Non-Publié')
            ->getQuery()
            ->getResult()
        ;
    }

    public function annoncePublie($id)
    {
        return $this->createQueryBuilder('a')
            ->addselect('a','j','p')
            ->leftJoin('a.jeu','j')
            ->leftJoin('a.plateforme','p')
            ->where('a.status = ?1')
            ->andWhere('j.id = :id')
            ->setParameters([1 => 'Publié', 'id' => $id])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAnnonceById($id)
    {
        return $this->createQueryBuilder('a')
            ->addselect('a','j','p')
            ->leftJoin('a.jeu','j')
            ->leftJoin('a.plateforme','p')
            ->where("a.id = ?1")
            ->setParameter(1, $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getLastResults($limit, $offset)
    {
        return $this->createQueryBuilder('a')
            ->where('a.status = :status')
            ->orderBy('a.created_at', 'DESC')
            ->setParameter('status', 'Publié')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
