<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\ThemeEvent;
use App\Plugin\Plugin;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class PluginActionsSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $security;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router, AuthorizationCheckerInterface $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'actions.plugin' => ['onPluginEvent'],
        ];
    }

    public function onPluginEvent(ThemeEvent $event)
    {
        $payload = $event->getPayload();

        if (!isset($payload['actions']) || !isset($payload['plugin'])) {
            return;
        }

        /** @var Plugin $plugin */
        $plugin = $payload['plugin'];

        if ($plugin->getId() !== 'DemoBundle') {
            return;
        }

        if (!$this->security->isGranted('demo')) {
            return;
        }

        $payload['actions']['divider'] = null;

        $payload['actions']['settings'] = [
            'url' => $this->router->generate('system_configuration_section', ['section' => 'demo_config']),
            'class' => 'modal-ajax-form',
        ];

        $payload['actions']['details'] = [
            'url' => $this->router->generate('demo', []),
        ];

        $event->setPayload($payload);
    }
}
