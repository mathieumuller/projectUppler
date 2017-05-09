<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\News;
use AppBundle\Entity\Comment;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testIncrementNewsCommentsCount()
    {
        $news = new News();
        $news->setCountComments(1);
        $comment = new Comment();
        $comment->setNews($news);
        $comment->incrementNewsCommentsCount();

        $this->assertEquals(2, $news->getCountComments());
    }
}
