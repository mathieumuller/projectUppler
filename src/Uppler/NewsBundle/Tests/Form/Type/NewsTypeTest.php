<?php

namespace Uppler\NewsBundle\Tests\Form\Extension;

use Uppler\NewsBundle\Model\News;
use Uppler\NewsBundle\Form\Type\NewsType;
use Symfony\Component\Form\Test\TypeTestCase;

class NewsTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'My new post',
            'content' => 'Lorem ipsum et coetera...',
        ];

        $form = $this->factory->create(NewsType::class);
        $object = new News();
        $object->setTitle($formData['title'])
            ->setContent($formData['content'])
        ;

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
