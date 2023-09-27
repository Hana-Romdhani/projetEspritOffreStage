<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function save(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findBynomUtilisateur($nom)
    {
        return $this->createQueryBuilder('s')
            ->where('s.nom LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%')
            ->orderBy('s.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findOrderByDatedecreation()
    {
        return $this->createQueryBuilder('a')
            ->where('a.isdelete = :isdeleted')
            ->setParameter('isdeleted', 1)
            ->orderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    public function findOrderByDatedecreationsup()
    {
        return $this->createQueryBuilder('a')
            ->where('a.isdelete = :isdelete')
            ->setParameter('isdelete', 0)
            ->orderBy('a.date', 'DESC')
            ->getQuery()
            ->getResult();
    }
public function findOneByEmail($email)
    {
        $qb = $this->createQueryBuilder('u');

        $qb->andWhere('u.email = :email')
           ->setParameter('email', $email)
           ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
    public function deleteByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->delete()
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->execute();
    }
    // public function getLoginCountByDay()
    // {
    //     $qb = $this->createQueryBuilder('u');
    //     $qb->select("DATE_FORMAT(u.datederniereconnx, '%Y-%m-%d') as loginDay, COUNT(u.Id_utilisateur) as loginCount")
    //         ->groupBy('loginDay');
    //     return $qb->getQuery()->getResult();
    // }
//     public function getLoginCountByDay()
// {
//     $rsm = new ResultSetMappingBuilder($this->_em);
//     $rsm->addScalarResult('loginDay', 'loginDay');
//     $rsm->addScalarResult('loginCount', 'loginCount');

//     $query = $this->_em->createNativeQuery('SELECT DATE_FORMAT(u.datederniereconnx, \'%Y-%m-%d\') as loginDay, COUNT(u.Id_utilisateur) as loginCount FROM users u GROUP BY loginDay', $rsm);
//     return $query->getResult();
// }
// public function getLoginCountByDay()
// {
//     $qb = $this->createQueryBuilder('u');
//     $qb->select("DATE_FORMAT(u.datederniereconnx, '%Y-%m-%d') as loginDay, COUNT(u.idUtilisateur) as loginCount")
//         ->groupBy('loginDay');
//     return $qb->getQuery()->getResult();
// }


public function getLoginCountByDay()
{
    $qb = $this->createQueryBuilder('u');
    $qb->select("DATE_FORMAT(u.date, '%Y-%m-%d') as loginDay, COUNT(u.idUtilisateur) as loginCount")
        ->where('u.roles IN (:types)')
        ->setParameter('types', array('freelancer', 'societe'))
        ->groupBy('loginDay');
    return $qb->getQuery()->getResult();
}





//    /**
//     * @return Utilisateur[] Returns an array of Utilisateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Utilisateur
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
