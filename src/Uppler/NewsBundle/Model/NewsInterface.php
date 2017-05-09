<?php

namespace Uppler\NewsBundle\Model;

interface NewsInterface
{
    public function getId();
    public function getTitle();
    public function setTitle($title);
    public function getContent();
    public function setContent($content);
    public function getAuthor();
    public function setAuthor($author);
    public function getPublicationDate();
    public function setPublicationDate(\DateTime $publicationDate);
}
