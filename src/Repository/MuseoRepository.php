<?php

namespace App\Repository;

use App\Entity\Museo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Museos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Museos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Museos[]    findAll()
 * @method Museos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MuseoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Museo::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Museo $entity, bool $flush = true): void
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
    public function remove(Museo $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @return Museos[] Returns an array of Museos objects
     */
    
    public function findByNameMuseum($name)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.nombre LIKE :name')
            ->setParameter('name', '&'.$name.'&')
            ->orderBy('m.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Museos
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
