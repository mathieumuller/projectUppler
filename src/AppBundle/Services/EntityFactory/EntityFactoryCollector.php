<?php

namespace AppBundle\Services\EntityFactory;

class EntityFactoryCollector
{
    private $factories = [];

    public function get($repositoryAlias)
    {
        if (!isset($this->factories[$repositoryAlias])) {
            throw new \Exception('This entity does not exists.');
        }

        return $this->factories[$repositoryAlias];
    }

    public function addFactory(EntityFactoryInterface $factory, $alias)
    {
        if (!isset($this->factories[$alias])) {
            $this->factories[$alias] = $factory;

            return;
        }

        throw new \Exception('The "app.entity_factory" services alias must be unique');
    }
}
