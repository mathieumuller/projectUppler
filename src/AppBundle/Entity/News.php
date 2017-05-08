<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Uppler\CommentBundle\Model\CommentInterface;
use Symfony\Component\Security\Core\User\User;
use Uppler\NewsBundle\Model\News as BaseNews;

class News extends BaseNews
{
    use \AppBundle\Traits\Publishable;

    const IMAGE_PATH = '/public/images/news';
    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_LANDSCAPE = 'landscape';

    private $comments;
    private $countComments = 0;
    private $image;
    private $orientation;

    // this property is not persisted in database
    // but used to trnasform the uploaded file into a path
    private $imageFile;

    public function __construct(User $user = null)
    {
        if (!is_null($user)) {
            $this->setAuthor($user->getUsername());
        }

        $this->comments = new ArrayCollection();
    }

    /**
     * Gets the value of countComments.
     *
     * @return mixed
     */
    public function getCountComments()
    {
        return $this->countComments;
    }

    /**
     * Sets the value of countComments.
     *
     * @param mixed $countComments the count comments
     *
     * @return self
     */
    public function setCountComments($countComments)
    {
        $this->countComments = $countComments;

        return $this;
    }

    /**
     * Gets the value of comments.
     *
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Adds a value to comments.
     *
     * @param CommentInterface $comment the comment
     *
     * @return self
     */
    public function addComments(CommentInterface $comment)
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
        }

        return $this;
    }

    /**
     * Removes a value from comments.
     *
     * @param CommentInterface $comment the comment
     *
     * @return self
     */
    public function removeComments(CommentInterface $comment)
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
        }

        return $this;
    }

    /**
     * Gets the value of image.
     *
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the value of image.
     *
     * @param mixed $image the image
     *
     * @return self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Gets the value of imageFile.
     *
     * @return mixed
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Sets the value of imageFile.
     *
     * @param mixed $imageFile the image file
     *
     * @return self
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    /**
     * Gets the value of orientation.
     *
     * @return mixed
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Sets the value of orientation.
     *
     * @param mixed $orientation the orientation
     *
     * @return self
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }
}
