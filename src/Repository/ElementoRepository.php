<?php

namespace App\Repository;

use App\Entity\Elemento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Elemento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Elemento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Elemento[]    findAll()
 * @method Elemento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElementoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Elemento::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Elemento $entity, bool $flush = true): void
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
    public function remove(Elemento $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    /**
     * @return Elemento[] Returns an array of Elementos objects
     */
    
    public function findAllDesc() : array
    {
        return $this->createQueryBuilder('m')
            ->addOrderBy('m.nombre', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Elemento[] Returns an array of Elementos objects
     */
    
    public function findAllAsc() : array
    {
        return $this->createQueryBuilder('m')
            ->addOrderBy('m.nombre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
     /**
     * @return Patrimonio[] Returns an array of Patrimonio objects
     */
    
    public function findByTypeHeritage($type) : array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.tipo = :type')
            ->setParameter('type', $type)
            ->orderBy('p.tipo', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    // /**
    //  * @return Elemento[] Returns an array of Elemento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Elemento
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
