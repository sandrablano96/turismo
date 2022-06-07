<?php

namespace App\Repository;

use App\Entity\OpinionesVisitasGuiadas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OpinionesVisitasGuiadas|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpinionesVisitasGuiadas|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpinionesVisitasGuiadas[]    findAll()
 * @method OpinionesVisitasGuiadas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinionesVisitasGuiadasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpinionesVisitasGuiadas::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(OpinionesVisitasGuiadas $entity, bool $flush = true): void
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
    public function remove(OpinionesVisitasGuiadas $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return OpinionesVisitasGuiadas[] Returns an array of OpinionesVisitasGuiadas objects
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

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function findOneByUserAndVisit($v, $u): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.usuario = :user and o.visitaGuiada = :visit')
            ->setParameter('user', $u)
            ->setParameter('visit', $v)
            ->setMaxResults(2)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
