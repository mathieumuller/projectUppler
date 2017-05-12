<?php

namespace AppBundle\Services\EntityFactory;

interface EntityFactoryInterface
{
    public function createFromArray(array $values = []);
    public function save($entity);
}
