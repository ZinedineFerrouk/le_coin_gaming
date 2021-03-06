<?php

namespace App\Repository;

use App\Entity\Jeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Jeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jeu[]    findAll()
 * @method Jeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jeu::class);
    }

    public function findAllPublishedGames($itemPerPage, $offset)
    {
        return $this->createQueryBuilder('j')
            ->where('j.status = ?1')
            ->setParameter(1, 'Publié')

            ->setFirstResult($offset)
            ->setMaxResults($itemPerPage)
            ->getQuery()
            ->getResult();
    }


    public function getSearchResult($input)
    {
        return $this->createQueryBuilder('j')
            ->select('j.id', 'j.titre')
            ->where('j.titre LIKE :input')
            ->setParameter('input', '%' . $input . '%')

            ->getQuery()
            ->getResult();
    }

    public function getLastResults($limit, $offset)
    {
        return $this->createQueryBuilder('j')
            ->select('j.id', 'j.titre', 'j.image')
            ->orderBy('j.date_sortie', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }


    public function jeuxNonPublier()
    {
        return $this->createQueryBuilder('j')
            ->where('j.status = ?1')
            ->setParameter(1, 'Non-Publié')
            ->getQuery()
            ->getResult()
        ;
    }
    
    // public function findAllPaginate()
    // {
    //     return $this->createQueryBuilder('j')

    //         ->getQuery()
    //         ->getResult();
    // }

    // /**
    //  * @return Jeu[] Returns an array of Jeu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */



    /*
    public function findOneBySomeField($value): ?Jeu
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
