<?php

namespace Uppler\CommentBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommentSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CommentEvent::NAME => 'publish',
        ];
    }

    public function publish(CommentEvent $event)
    {
        $comment = $event->getComment();
        $comment->setPublicationDate(new \DateTime());

        return $event;
    }
}
