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
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ActionsSubscriber extends AbstractActionsSubscriber
{
    public function __construct(AuthorizationCheckerInterface $auth, UrlGeneratorInterface $urlGenerator, private string $environment)
    {
        parent::__construct($auth, $urlGenerator);
    }

    public static function getActionName(): string
    {
        return 'demo';
    }

    public function onActions(PageActionsEvent $event): void
    {
        $payload = $event->getPayload();

        $route = 'demo_error';
        if ($this->environment === 'dev') {
            $route = '_preview_error';
        }

        foreach (['403', '404', '500'] as $code) {
            $event->addAction('error_' . $code, [
                'icon' => 'fas fa-bug',
                'title' => 'Error ' . $code,
                'url' => $this->path($route, ['code' => $code])
            ]);
        }

        if (!isset($payload['counter'])) {
            return;
        }

        // TODO show this counter
        $counter = (int) $payload['counter'];
        $event->addAction('counter', ['icon' => false, 'title' => $counter, 'onclick' => 'alert("You visited this page ' . $counter . ' times"); return false;', 'url' => '#']);
    }
}
