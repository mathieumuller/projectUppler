<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\User;
use Uppler\CommentBundle\Model\Comment as BaseComment;
use Uppler\NewsBundle\Model\NewsInterface;

class Comment extends BaseComment
{
    use \AppBundle\Traits\Publishable;

    private $news;

    public function __construct(User $user = null)
    {
        if (!is_null($user)) {
            $this->setAuthor($user->getUsername());
        }
    }

    /**
     * Gets the value of news.
     *
     * @return mixed
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Sets the value of news.
     *
     * @param mixed $news the news
     *
     * @return self
     */
    public function setNews(NewsInterface $news)
    {
        $this->news = $news;

        return $this;
    }

    public function incrementNewsCommentsCount()
    {
        $news = $this->getNews();
        $currentCount = $news->getCountComments();
        $news->setCountComments(++$currentCount);
    }
}
