<?php

namespace Uppler\CommentBundle\Model;

interface CommentInterface
{
    public function getId();
    public function getContent();
    public function setContent($content);
    public function getAuthor();
    public function setAuthor($author);
    public function getPublicationDate();
    public function setPublicationDate(\DateTime $publicationDate);
}
