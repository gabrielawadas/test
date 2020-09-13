<?php
/**
 * Action Repository.
 */

namespace App\Repository;

use App\Entity\Action;
use App\Entity\Wallet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 10;

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
            ->addOrderBy('a.date', 'DESC');
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
     * @param Action $action Action entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Action $action): void
    {
        $this->_em->persist($action);
        $this->_em->flush($action);
    }

    /**
     * Get balance.
     *
     * @param Action $wallet Action entity
     * @param Wallet
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getBalance(Wallet $wallet): array
    {
        $queryBuilder = $this->createQueryBuilder('action')
            ->andwhere('action.wallet= :wallet')
            ->select('SUM(action.amount) AS balance')
            ->setParameter('wallet', $wallet);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $date1
     * @param $date2
     * @param $wallet
     * @return array
     */
    public function searchByDates($date1, $date2, $wallet): array
    {
        if ($wallet) {
            $queryBuilder = $this->createQueryBuilder('action')
                ->select('SUM(action.amount) AS balance')
                ->andwhere('action.date >= :date1')
                ->andwhere('action.date <= :date2')
                ->andwhere('action.wallet <= :wallet')
                ->setParameter('date1', $date1)
                ->setParameter('date2', $date2)
                ->setParameter('wallet', $wallet);

            try {
                return $queryBuilder->getQuery()->getOneOrNullResult();
            } catch (NonUniqueResultException $e) {
            }
        }

        return [];
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
