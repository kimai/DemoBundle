<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\PageActionsEvent;
use App\EventSubscriber\Actions\AbstractActionsSubscriber;
use App\Plugin\Plugin;

final class PluginActionsSubscriber extends AbstractActionsSubscriber
{
    public static function getActionName(): string
    {
        return 'plugin';
    }

    public function onActions(PageActionsEvent $event): void
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

        if (!$this->isGranted('demo')) {
            return;
        }

        $event->addDivider();
        $event->addAction('settings', [
            'url' => $this->path('system_configuration_section', ['section' => 'demo_config']),
            'class' => 'modal-ajax-form',
        ]);

        $event->addAction('details', [
            'url' => $this->path('demo', []),
        ]);
    }
}
