<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 02/06/2019
 * Time: 14:20
 */

namespace App\Repository;

use App\Entity\Article;
use App\Entity\ArticleSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Query
     */
    public function findAllVisibleQuery(ArticleSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getPrixMin()){
            $query = $query
                ->andWhere('p.price > :prixMin')
                ->setParameter('prixMin', $search->getPrixMin());
        }

        if ($search->getPrixMax()){
            $query = $query
                ->andWhere('p.price < :prixMax')
                ->setParameter('prixMax', $search->getPrixMax());
        }

        return $query->getQuery();
    }

    public function findArray($array)
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->Where('u.id IN (:array)')
            ->setParameter('array', $array)
            ->getQuery()
            ->getResult();
    }

    public function findByCategory($category)
    {
        return $this->createQueryBuilder('c')
            ->where('c.category = :category')->setParameter('category', $category)
            ->getQuery()
            ;
    }

    /**
     * @return Article[]
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.created_at','ASC');
    }
}