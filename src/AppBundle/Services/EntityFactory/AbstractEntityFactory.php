<?php

namespace AppBundle\Services\EntityFactory;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class AbstractEntityFactory
{
    protected $em;
    protected $repository;
    protected $instance;

    public function __construct(EntityManagerInterface $em, $alias = null)
    {
        $this->em = $em;
        if (!is_null($alias)) {
            $this->repository = $this->em->getRepository($alias);
            $this->instance = $this->repository->getClassName();
        }
    }

    public function createFromArray(array $values = [])
    {
        $accessor = PropertyAccess::createPropertyAccessor();
        $entity = new $this->instance();

        foreach ($values as $property => $value) {
            if ($accessor->isWritable($entity, $property)) {
                $accessor->setValue($entity, $property, $value);
            }
        }

        return $entity;
    }

    public function save($entity)
    {
        $this->checkInstance($entity);
        $this->persist($entity);

        return $this->em->flush();
    }

    protected function persist($entity)
    {
        if (!$this->em->contains($entity)) {
            $this->em->persist($entity);

            return true;
        }

        return false;
    }

    protected function checkInstance($entity)
    {
        if (!$entity instanceof $this->instance) {
            throw new \Exception('The $entity parameter must be an instance of '.$this->instance);
        }
    }
}
