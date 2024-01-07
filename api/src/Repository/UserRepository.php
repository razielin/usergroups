<?php

namespace App\Repository;

use App\DTO\UserReportItem;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $entityManager;


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $registry->getManager();
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function remove(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * @return UserReportItem[]
     */
    public function getUsersWithGroups(): array
    {
        $conn = $this->entityManager->getConnection();
        $res = $conn->query("
            SELECT user_id, name, email, 
                   GROUP_CONCAT(group_name) as user_groups, 
                   GROUP_CONCAT(group_id) as group_ids
            FROM user_groups
            LEFT JOIN `user` USING (user_id)
            LEFT JOIN `groups` USING (group_id)
            GROUP BY user_id
        ")->fetchAll();
        return array_map(
            fn($user) => new UserReportItem(
                $user['user_id'], $user['name'], $user['email'], $user['user_groups'], $user['group_ids']
            ),
            $res
        );
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
