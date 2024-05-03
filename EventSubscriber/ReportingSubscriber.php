<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Event\ReportingEvent;
use App\Reporting\Report;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class ReportingSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly AuthorizationCheckerInterface $security)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ReportingEvent::class => ['onReporting'],
        ];
    }

    public function onReporting(ReportingEvent $event): void
    {
        $auth = $this->security;

        if (!$auth->isGranted('view_reporting')) {
            return;
        }

        $event->addReport(new Report('demo_report', 'demo_report', 'Demo Report', 'fas fa-snowman'));
    }
}
