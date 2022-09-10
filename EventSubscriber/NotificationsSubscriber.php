<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use KevinPapst\TablerBundle\Event\NotificationEvent;
use KevinPapst\TablerBundle\Helper\Constants as ThemeConstants;
use KevinPapst\TablerBundle\Model\NotificationModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NotificationsSubscriber implements EventSubscriberInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotificationEvent::class => ['onNotificationEvent', 100],
        ];
    }

    public function onNotificationEvent(NotificationEvent $event): void
    {
        $model = new NotificationModel('demo-test', 'Test Demo notification', ThemeConstants::TYPE_INFO);
        $model->setUrl($this->urlGenerator->generate('demo'));
        $event->addNotification($model);
    }
}
