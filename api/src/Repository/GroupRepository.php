<?php

namespace App\Repository;

use App\DTO\GroupReportItem;
use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Group>
 *
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Group::class);
        $this->entityManager = $registry->getManager();
    }

    public function add(Group $group): void
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
    }

    public function remove(Group $group): void
    {
        $this->entityManager->getConnection()->exec(
            'DELETE FROM user_groups WHERE group_id = ' . $group->getGroupId(),
        );
        $this->entityManager->remove($group);
        $this->entityManager->flush();
    }

    public function getGroupsWithUsers(): array
    {
        $conn = $this->entityManager->getConnection();
        $res = $conn->query("
            SELECT group_id, group_name, 
                   GROUP_CONCAT(name) as group_users 
            FROM user_groups
            LEFT JOIN `user` USING (user_id)
            LEFT JOIN `groups` USING (group_id)
            GROUP BY group_id
        ")->fetchAll();
        return array_map(
            fn($group) => new GroupReportItem(
                $group['group_id'], $group['group_name'], $group['group_users']
            ),
            $res
        );
    }

//    /**
//     * @return Group[] Returns an array of Group objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Group
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
