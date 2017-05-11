<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Uppler\CommentBundle\Event\CommentEvent;

class CommentSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CommentEvent::NAME => 'incrementCommentNumber',
        ];
    }

    public function incrementCommentNumber(CommentEvent $event)
    {
        $comment = $event->getComment();
        $comment->incrementNewsCommentsCount();

        return $event;
    }
}
