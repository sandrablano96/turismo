<?php

namespace App\Repository;

use App\Entity\FavoritosUsuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavoritosUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavoritosUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavoritosUsuario[]    findAll()
 * @method FavoritosUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavoritosUsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoritosUsuario::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(FavoritosUsuario $entity, bool $flush = true): void
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
    public function remove(FavoritosUsuario $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return FavoritosUsuario[] Returns an array of FavoritosUsuario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FavoritosUsuario
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
