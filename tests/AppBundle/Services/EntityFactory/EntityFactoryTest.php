<?php

namespace tests\AppBundle\Services\EntityFactory;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\News;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\PropertyAccess\PropertyAccess;

class EntityFactoryTest extends TestCase
{
    /**
     * Test that the entity is correctly hydrated from an.
     *
     * @param array $values [description]
     *
     * @return [type] [description]
     */
    public function testCreateFromArray(array $values = [])
    {
        foreach ($this->getDataToTest() as $test) {
            $repository = $this
                ->getMockBuilder(EntityRepository::class)
                ->disableOriginalConstructor()
                ->getMock();
            $repository->expects($this->once())
                ->method('getClassName')
                ->will($this->returnValue($test['entityClassName']));

            $em = $this
                ->getMockBuilder(EntityManager::class)
                ->disableOriginalConstructor()
                ->getMock();
            $em->expects($this->once())
                ->method('getRepository')
                ->will($this->returnValue($repository));

            $factoryClass = $test['factoryClass'];
            $factory = new $factoryClass($em, $test['repositoryAlias']);

            $entity = $factory->createFromArray($test['data']);

            $accessor = PropertyAccess::createPropertyAccessor();
            $tested = [];
            foreach (array_keys($test['data']) as $property) {
                $tested[] = $accessor->getValue($entity, $property);
            }

            $expected = array_values($test['data']);

            // Test that the created entity is of the good instance
            $this->assertEquals(get_class($entity), $test['entityClassName']);
            // Test that the given values has been correctly set to the entity
            $this->assertEquals($tested, $expected);
        }
    }

    protected function getDataToTest()
    {
        return [
            [
                'entityClassName' => 'AppBundle\\Entity\\News',
                'factoryClass' => 'AppBundle\\Services\\EntityFactory\\NewsFactory',
                'repositoryAlias' => 'AppBundle:News',
                'data' => [
                    'author' => 'Toto',
                    'title' => 'Tata',
                    'content' => 'Titi',
                ],
            ],
            [
                'entityClassName' => 'AppBundle\\Entity\\Comment',
                'factoryClass' => 'AppBundle\\Services\\EntityFactory\\CommentFactory',
                'repositoryAlias' => 'AppBundle:Comment',
                'data' => [
                    'author' => 'Toto',
                    'content' => 'Titi',
                ],
            ],
        ];
    }
}
