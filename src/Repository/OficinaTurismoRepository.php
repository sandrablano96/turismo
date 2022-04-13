<?php

namespace App\Repository;

use App\Entity\OficinaTurismo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OficinaTurismo|null find($id, $lockMode = null, $lockVersion = null)
 * @method OficinaTurismo|null findOneBy(array $criteria, array $orderBy = null)
 * @method OficinaTurismo[]    findAll()
 * @method OficinaTurismo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OficinaTurismoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OficinaTurismo::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OficinaTurismo $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(OficinaTurismo $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return OficinaTurismo[] Returns an array of OficinaTurismo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OficinaTurismo
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
