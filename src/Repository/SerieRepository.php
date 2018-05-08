<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Item\Serie;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    /**
     * @param Serie $serie
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public
    function save(Serie $serie)
    {
        $this->getEntityManager()->persist($serie);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Serie $serie
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public
    function delete(Serie $serie)
    {
        $this->getEntityManager()->remove($serie);
        $this->getEntityManager()->flush();
    }
}