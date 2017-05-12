<?php

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class EntityFactoryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        // Do not continue if the collector does not exist
        if (!$container->has('app.entity_factory.factory_collector')) {
            return;
        }

        // Get collector definition
        $definition = $container->findDefinition('app.entity_factory.factory_collector');

        // Get target services
        $taggedServices = $container->findTaggedServiceIds('app.entity_factory');

        // Add target services to the collector
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $tag) {
                if (isset($tag['alias'])) {
                    $definition->addMethodCall(
                        'addFactory',
                        [
                            new Reference($id),
                            $tag['alias'],
                        ]
                    );
                } else {
                    throw new \Exception("The 'app.entity_factory' tag requires the 'alias' option");
                }
            }
        }
    }
}
