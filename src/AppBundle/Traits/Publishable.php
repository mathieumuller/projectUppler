<?php

namespace AppBundle\Traits;

trait Publishable
{
    public function publish()
    {
        $this->setPublicationDate(new \DateTime());
    }
}
