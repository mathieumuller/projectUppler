<?php

namespace Uppler\CommentBundle\Tests\Form\Type;

use Uppler\CommentBundle\Model\Comment;
use Uppler\CommentBundle\Form\Type\CommentType;
use Symfony\Component\Form\Test\TypeTestCase;

class CommentTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'content' => 'Lorem ipsum et coetera...',
        ];

        $form = $this->factory->create(CommentType::class);
        $object = new Comment();
        $object->setContent($formData['content']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
