<?php

namespace Nkt\ImageBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Gusakov Nikita <dev@nkt.me>
 */
class NktImageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $imageManager = new Definition('Nkt\ImageBundle\Manager\ImageManager', array($config['upload_dir']));
        foreach ($config['types'] as $type => $options) {
            $imageManager->addMethodCall('addType', array($type, $options));
        }
        $container->setDefinition('nkt.image_manager', $imageManager);
    }
}
