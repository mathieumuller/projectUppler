<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\User;

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

    protected function getUsername()
    {
        return $this->getUser() instanceof User ? $this->getUser()->getUsername() : null;
    }
}
