<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use \Datetime;

/**
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Evento $entity, bool $flush = true): void
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
    public function remove(Evento $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    
    /**
     * @return Evento[] Returns an array of Evento objects
     */
    
    public function findByTypeEvents($types) : array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.tipo_evento IN (:types)')
            ->setParameter('types', $types)
            ->orderBy('e.fecha', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    /**
     * @return Evento[] Returns an array of Evento objects
     */
    
    public function findByMonthEvents($month) : array
    {
        $actual_year = (new DateTime)->format("Y");
        return $this->createQueryBuilder('e')
            ->andWhere('MONTH(e.fecha) = :month and YEAR(e.fecha) = :actual_year')
            ->setParameter('month', $month)
            ->setParameter('actual_year', $actual_year)
            ->orderBy('e.fecha', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    /**
     * @return Evento[] Returns an array of Evento objects
     */
    
    public function findEventsByMonthAndType($month, $types)
    {
        $actual_year = (new DateTime)->format("Y");

        return $this->createQueryBuilder('e')
            ->andWhere('MONTH(e.fecha) = :month and YEAR(e.fecha) = :actual_year and e.tipo_evento in (:types)')
            ->setParameter('month', $month)
            ->setParameter('actual_year', $actual_year)
            ->setParameter('types', $types)
            ->orderBy('e.fecha', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    
}
