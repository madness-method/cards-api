<?php

namespace App\Repository;

use App\Entity\Match;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Match|null find($id, $lockMode = null, $lockVersion = null)
 * @method Match|null findOneBy(array $criteria, array $orderBy = null)
 * @method Match[]    findAll()
 * @method Match[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Match::class);
    }

    /**
     * @return Match[] Returns an array of Match objects
     */
    public function findUserWinCount()
    {
        $connection = $this->getEntityManager()->getConnection();
        $sql = "SELECT 
                    COUNT(user_win) AS wins,
                    user_name AS userName
                FROM match 
                GROUP BY user_name
                ORDER BY user_win DESC";
        
        $statement = $connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }
}
