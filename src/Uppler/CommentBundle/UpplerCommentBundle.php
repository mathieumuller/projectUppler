<?php

namespace Uppler\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;

class UpplerCommentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->compileDoctrineMapping($container);
    }

    /**
     * This function defines where doctrine entities or mapped superclasses are defined/located and compile them with the bundle.
     *
     * @param ContainerBuilder $container
     */
    private function compileDoctrineMapping(ContainerBuilder $container)
    {
        $modelDir = realpath(__DIR__.'/Resources/config/doctrine/model');
        $mappings = [$modelDir => 'Uppler\CommentBundle\Model'];

        if (class_exists(DoctrineOrmMappingsPass::class)) {
            $container->addCompilerPass(DoctrineOrmMappingsPass::createYamlMappingDriver($mappings));
        }
    }
}
