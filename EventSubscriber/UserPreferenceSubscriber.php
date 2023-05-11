<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Entity\UserPreference;
use App\Event\UserPreferenceEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Validator\Constraints\Range;

class UserPreferenceSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserPreferenceEvent::class => ['loadUserPreferences', 200],
        ];
    }

    public function loadUserPreferences(UserPreferenceEvent $event): void
    {
        $event->addPreference(
            (new UserPreference('demo_money', 1))
                ->setOrder(900)
                ->setType(MoneyType::class)
                ->setEnabled(true)
                ->setOptions(['help' => 'A help text', 'label' => 'Demo user preference'])
                ->addConstraint(new Range(['min' => 1]))
                ->setSection('demo')
        );
    }
}
