<?php

namespace Uppler\CommentBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Uppler\CommentBundle\Model\CommentInterface;

/**
 * The comment.published event is dispatched each time a comment is successfully flushed in database.
 */
class CommentEvent extends Event
{
    const NAME = 'comment.saved';

    protected $comment;

    public function __construct(CommentInterface $comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }
}
