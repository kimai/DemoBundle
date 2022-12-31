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
use KimaiPlugin\DemoBundle\Configuration\DemoConfiguration;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ThemeEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private DemoConfiguration $demoConfiguration)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ThemeEvent::STYLESHEET => ['renderStylesheet', 100],
        ];
    }

    public function renderStylesheet(ThemeEvent $event): void
    {
        if (!$this->demoConfiguration->isColorChangeActivated()) {
            return;
        }

        $css = '
<style type="text/css">
    span.label-customer span.badge,
    span.label-project span.badge, 
    span.label-activity span.badge 
    {
      animation: dotColors 4s step-end infinite;
    }

    @keyframes dotColors
    {
        0% { opacity: 1; }
        10% { opacity: 0.9; }
        20% { opacity: 0.8; }
        30% { opacity: 0.7; }
        40% { opacity: 0.6; }
        50% { opacity: 0.5; }
        60% { opacity: 0.4; }
        70% { opacity: 0.3; }
        80% { opacity: 0.2; }
        90% { opacity: 0.1; }
        100% { opacity: 0; }
    }
</style>';

        $event->addContent($css);
    }
}
