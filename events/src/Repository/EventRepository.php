<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    /**
     * 
     * @return array
     */
    public function findEvents() {
        return $this
                ->getEntityManager()
                ->createQuery(
                    "SELECT 
                        e.id id, 
                        e.pictureUrl pictureUrl,
                        e.title title,
                        e.category category,
                        e.startsAt startsAt,
                        e.endsAt endsAt,
                        e.city city,
                        e.province province,
                        e.address address,
                        e.createdAt createdAt,
                        u.name user
                     FROM App:Event e
                     JOIN App:User u WITH e.owner=u.id
                     ORDER BY startsAt
                     "
                    )
                ->getResult();
    }
    
 
}
