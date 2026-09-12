<?php

namespace Wexample\SymfonyPlatform\Repository;

use Wexample\SymfonyHelpers\Repository\AbstractRepository;
use Wexample\SymfonyPlatform\Entity\Configuration;
use Wexample\SymfonyPlatform\Entity\Traits\Manipulator\ConfigurationEntityManipulatorTrait;

/**
 * @method Configuration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Configuration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Configuration[]    findAll()
 * @method Configuration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfigurationRepository extends AbstractRepository
{
    use ConfigurationEntityManipulatorTrait;

    /**
     * A value read from the record sitting at that path.
     *
     * Nothing else is set: the record says which key it holds and what is under
     * it, so whoever wrote it hydrates the row from the file.
     */
    public function createNewConfiguration(string $path): Configuration
    {
        return new Configuration($path);
    }

    /**
     * What is written under that key, null when nothing is.
     *
     * @param string $prefix where the app holding it is mounted, the records of
     *                       every app sharing one table
     */
    public function findValue(
        string $key,
        string $prefix,
    ): mixed {
        return $this->findOneByKey($key, $prefix)?->getValue();
    }

    /**
     * The record that key was written in, null when it was never written.
     *
     * @param string $prefix where the app holding it is mounted
     */
    public function findOneByKey(
        string $key,
        string $prefix,
    ): ?Configuration {
        return $this->createQueryBuilder('configuration')
            ->where('configuration.key = :key')
            ->andWhere('configuration.path LIKE :prefix')
            ->setParameter('key', $key)
            ->setParameter('prefix', addcslashes($prefix, '%_\\').'/%')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
