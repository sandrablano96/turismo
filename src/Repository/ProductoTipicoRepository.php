<?php

namespace App\Repository;

use App\Entity\ProductoTipico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductoTipico|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductoTipico|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductoTipico[]    findAll()
 * @method ProductoTipico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoTipicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductoTipico::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ProductoTipico $entity, bool $flush = true): void
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
    public function remove(ProductoTipico $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    
    

    /*
    public function findOneBySomeField($value): ?ProductoTipico
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
