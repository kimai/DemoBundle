<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\DependencyInjection;

use App\Plugin\AbstractPluginExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Yaml\Parser;

class DemoExtension extends AbstractPluginExtension implements PrependExtensionInterface
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerBundleConfiguration($container, $config);
        $container->setParameter('demo_settings', $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $yamlParser = new Parser();

        $config = $yamlParser->parse(
            file_get_contents(__DIR__ . '/../Resources/config/jms_serializer.yaml')
        );
        $container->prependExtensionConfig('jms_serializer', $config['jms_serializer']);

        $config = $yamlParser->parse(
            file_get_contents(__DIR__ . '/../Resources/config/nelmio_api_doc.yaml')
        );
        $container->prependExtensionConfig('nelmio_api_doc', $config['nelmio_api_doc']);

        $container->prependExtensionConfig('kimai', [
            'invoice' => [
                'documents' => [
                    'var/plugins/DemoBundle/Resources/invoices/',
                ]
            ],
            'permissions' => [
                'roles' => [
                    'ROLE_SUPER_ADMIN' => [
                        'demo',
                    ],
                ],
            ],
        ]);
    }
}
