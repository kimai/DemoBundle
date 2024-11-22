<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\DependencyInjection;

use App\Plugin\AbstractPluginExtension;
use KimaiPlugin\DemoBundle\Entity\DemoEntity;
use KimaiPlugin\DemoBundle\Form\DemoType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

class DemoExtension extends AbstractPluginExtension implements PrependExtensionInterface
{
    /**
     * @param array<mixed> $configs
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerBundleConfiguration($container, $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('nelmio_api_doc', [
            'models' => [
                'names' => [
                    [
                        'alias' => 'DemoForm',
                        'type' => DemoType::class,
                        'groups' => ['Default', 'Entity', 'Demo'],
                    ],
                    [
                        'alias' => 'DemoEntity',
                        'type' => DemoEntity::class,
                        'groups' => ['Default', 'Entity', 'Demo'],
                    ],
                ],
            ]
        ]);

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

        $container->prependExtensionConfig('jms_serializer', [
            'metadata' => [
                'warmup' => [
                    'paths' => [
                        'included' => [
                            __DIR__ . '/../Entity/'
                        ],
                    ],
                ],
            ],
        ]);
    }
}
