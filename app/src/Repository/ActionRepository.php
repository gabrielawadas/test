<?php

namespace App\Repository;

use App\Entity\Action;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Action|null find($id, $lockMode = null, $lockVersion = null)
 * @method Action|null findOneBy(array $criteria, array $orderBy = null)
 * @method Action[]    findAll()
 * @method Action[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionRepository extends ServiceEntityRepository
{
    /**
     * ActionRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Action::class);
    }

    /**
     * @return mixed
     */
    public function findAllOrdered()
    {
        $qb = $this->createQueryBuilder('a')
            ->addOrderBy('a.name', 'ASC');
        $query = $qb->getQuery();

        return $query->execute();
    }

    /**
     * @param string $categoryName Category name
     *
     * @return QueryBuilder
     */
    public function findAllByCategory($categoryName): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->innerJoin('a.category', 'c')
            ->andWhere('c.name = :category')
            ->setParameter('category', $categoryName)
            ->orderBy('a.name', 'ASC');

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @param string $categoryName Category name
     *
     * @return QueryBuilder
     */
    public function findAllByDate($date): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->andWhere('a.date = :date')
            ->setParameter('date', $date)
            ->orderBy('a.name', 'ASC');

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Action $action Action entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Action $action): void
    {
        $this->_em->persist($action);
        $this->_em->flush($action);
    }

    /**
     * Get balance.
     *
     * @param \App\Entity\Action  $wallet Action entity
     * @param \App\Entity\Wallet
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     */
    public function getBalance(Wallet $wallet): array
    {
        $queryBuilder = $this->createQueryBuilder('action')
            ->andwhere('action.wallet= :wallet')
            ->select('SUM(action.amount) AS balance')
            ->setParameter('wallet', $wallet);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Action
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
