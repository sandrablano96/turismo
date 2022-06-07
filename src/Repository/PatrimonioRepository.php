<?php

namespace App\Repository;

use App\Entity\Patrimonio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Patrimonio|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patrimonio|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patrimonio[]    findAll()
 * @method Patrimonio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatrimonioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patrimonio::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Patrimonio $entity, bool $flush = true): void
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
    public function remove(Patrimonio $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Patrimonio[] Returns an array of Patrimonio objects
     */
    
    public function findHeritageElements($type) : array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.tipo = :type')
            ->setParameter('type', $type)
            ->orderBy('p.tipo', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Patrimonio[] Returns an array of Patrimonio objects
     */
    
    public function findAllDesc() : array
    {
        return $this->createQueryBuilder('p')
            ->addOrderBy('p.nombre', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Patrimonio[] Returns an array of Patrimonio objects
     */
    
    public function findAllAsc() : array
    {
        return $this->createQueryBuilder('p')
            ->addOrderBy('p.nombre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Patrimonio
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
