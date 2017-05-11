<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected function getRepository($alias)
    {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository($alias)
        ;
    }
    protected function getEntityFactory($alias)
    {
        return $this->get('app.entity_factory.factory_collector')->get($alias);
    }
}
