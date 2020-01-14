<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\PermissionSectionsEvent;
use App\Model\PermissionSection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class PermissionSectionSubscriber implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PermissionSectionsEvent::class => ['onEvent', 100],
        ];
    }

    public function onEvent(PermissionSectionsEvent $event)
    {
        $event->addSection(new PermissionSection('Demo (plugin) - sweet, right?', 'demo'));
    }
}
