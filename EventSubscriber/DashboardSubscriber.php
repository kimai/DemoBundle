<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\DashboardEvent;
use App\Widget\Type\CompoundRow;
use KimaiPlugin\DemoBundle\Widget\DemoWidget;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DashboardSubscriber implements EventSubscriberInterface
{
    /**
     * @var DemoWidget
     */
    private $widget;

    public function __construct(DemoWidget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            DashboardEvent::class => ['onDashboardEvent', 100],
        ];
    }

    /**
     * @param DashboardEvent $event
     */
    public function onDashboardEvent(DashboardEvent $event)
    {
        $section = new CompoundRow();
        $section->setTitle('What a great crowd!');
        $section->setOrder(20);

        $section->addWidget($this->widget);

        $event->addSection($section);
    }
}
