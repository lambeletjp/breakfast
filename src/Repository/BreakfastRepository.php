<?php

namespace App\Repository;

use App\Entity\Breakfast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Breakfast>
 *
 * @method Breakfast|null find($id, $lockMode = NULL, $lockVersion = NULL)
 * @method Breakfast|null findOneBy(array $criteria, array $orderBy = NULL)
 * @method Breakfast[]    findAll()
 * @method Breakfast[]    findBy(array $criteria, array $orderBy = NULL, $limit
 *   = NULL, $offset = NULL)
 */
class BreakfastRepository extends ServiceEntityRepository {

  public function __construct(ManagerRegistry $registry) {
    parent::__construct($registry, Breakfast::class);
  }

  public function save(Breakfast $entity, bool $flush = FALSE): void {
    $this->getEntityManager()->persist($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function remove(Breakfast $entity, bool $flush = FALSE): void {
    $this->getEntityManager()->remove($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  //    /**
  //     * @return Breakfast[] Returns an array of Breakfast objects
  //     */
  //    public function findByExampleField($value): array
  //    {
  //        return $this->createQueryBuilder('b')
  //            ->andWhere('b.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->orderBy('b.id', 'ASC')
  //            ->setMaxResults(10)
  //            ->getQuery()
  //            ->getResult()
  //        ;
  //    }

  //    public function findOneBySomeField($value): ?Breakfast
  //    {
  //        return $this->createQueryBuilder('b')
  //            ->andWhere('b.exampleField = :val')
  //            ->setParameter('val', $value)
  //            ->getQuery()
  //            ->getOneOrNullResult()
  //        ;
  //    }
}
