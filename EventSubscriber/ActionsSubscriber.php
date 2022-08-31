<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\PageActionsEvent;
use App\EventSubscriber\Actions\AbstractActionsSubscriber;

class ActionsSubscriber extends AbstractActionsSubscriber
{
    public static function getActionName(): string
    {
        return 'demo';
    }

    public function onActions(PageActionsEvent $event): void
    {
        $payload = $event->getPayload();

        if (!isset($payload['counter'])) {
            return;
        }

        // TODO show this counter
        $counter = (int) $payload['counter'];
        $event->addAction('counter', ['icon' => false, 'title' => $counter, 'onclick' => 'alert("You visited this page ' . $counter . ' times"); return false;', 'url' => '#']);

        if ($this->isGranted('system_configuration')) {
            $event->addSettings($this->path('system_configuration_section', ['section' => 'demo_config']));
        }
    }
}
