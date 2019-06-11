<?php
/**
 * Created by PhpStorm.
 * User: Jean-baptiste
 * Date: 06/06/2019
 * Time: 22:46
 */

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function byFacture($user){
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.user = :user')
            ->orderBy('p.id')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();;

    }
}