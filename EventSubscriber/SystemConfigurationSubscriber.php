<?php

/*
 * This file is part of the Kimai DemoBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\SystemConfigurationEvent;
use App\Form\Model\Configuration;
use App\Form\Model\SystemConfiguration as SystemConfigurationModel;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SystemConfigurationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            SystemConfigurationEvent::class => ['onSystemConfiguration', 100],
        ];
    }

    public function onSystemConfiguration(SystemConfigurationEvent $event)
    {
        $event->addConfiguration((new SystemConfigurationModel())
            ->setSection('demo_config')
            ->setConfiguration([
                (new Configuration())
                    ->setName('demo.some_setting')
                    ->setLabel('demo.some_setting')
                    ->setTranslationDomain('system-configuration')
                    ->setRequired(false)
                    ->setType(TextType::class),
            ])
        );
    }
}
