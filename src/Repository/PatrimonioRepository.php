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
    /**
     * @return Patrimonio[] Returns an array of Patrimonio objects
     */
   
    public function findAdvancedHeritage($name, $type) : array
    {
        $this->createQueryBuilder('p');
        if(!$type->is_null() && !$name->is_null()){
            $this->andWhere('p.nombre LIKE :nombre and p.tipo = :tipo')
            ->setParameter('nombre', '&'.$name.'&')
            ->setParameter('tipo', $type)
            ->orderBy('p.nombre', 'ASC');
        } else if(!$name->is_null()){
            $this->andWhere('p.nombre LIKE :nombre')
            ->setParameter('nombre', '&'.$name.'&')
            ->orderBy('p.nombre', 'ASC');
        } else{
            $this->andWhere('p.tipo = :tipo')
            ->setParameter('tipo', $type)
            ->orderBy('p.tipo', 'ASC');
        }
    
            return $this->getQuery()->getResult();
            
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
