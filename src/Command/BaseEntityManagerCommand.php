<?php


namespace Bytes\CommandBundle\Command;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BaseEntityManagerCommand
 * @package Bytes\CommandBundle\Command
 */
abstract class BaseEntityManagerCommand extends BaseCommand
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * BaseEntityManagerCommand constructor.
     * @param EntityManagerInterface $entityManager
     * @param string|null $name
     */
    public function __construct(EntityManagerInterface $entityManager, string $name = null)
    {
        $this->entityManager = $entityManager;
        parent::__construct($name);
    }
}