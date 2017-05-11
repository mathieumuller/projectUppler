<?php

namespace AppBundle\Services\EntityFactory;

use AppBundle\Entity\Comment;
use Uppler\CommentBundle\Event\CommentEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Uppler\CommentBundle\Event\CommentSubscriber as UpplerCommentSubscriber;
use AppBundle\Event\CommentSubscriber;

class CommentFactory extends AbstractEntityFactory implements EntityFactoryInterface
{
    public function save($entity)
    {
        $this->checkInstance($entity);
        $event = new CommentEvent($entity);
        $dispatcher = new EventDispatcher();

        if ($this->persist($entity)) {
            $dispatcher->addSubscriber(new UpplerCommentSubscriber());
        }

        $dispatcher->addSubscriber(new CommentSubscriber());

        // Dispatch the comment.saved event after saving
        $dispatcher->dispatch(CommentEvent::NAME, $event);

        $this->em->flush();
    }
}
