<?php

namespace App\Repository;

use App\Entity\PatrimonioArquitectonico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PatrimonioArquitectonico|null find($id, $lockMode = null, $lockVersion = null)
 * @method PatrimonioArquitectonico|null findOneBy(array $criteria, array $orderBy = null)
 * @method PatrimonioArquitectonico[]    findAll()
 * @method PatrimonioArquitectonico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatrimonioArquitectonicoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PatrimonioArquitectonico::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PatrimonioArquitectonico $entity, bool $flush = true): void
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
    public function remove(PatrimonioArquitectonico $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PatrimonioArquitectonico[] Returns an array of PatrimonioArquitectonico objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PatrimonioArquitectonico
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
