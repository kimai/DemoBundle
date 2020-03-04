<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Configuration\FormConfiguration;
use App\Entity\User;
use App\Entity\UserPreference;
use App\Event\PrepareUserEvent;
use App\Event\UserPreferenceEvent;
use App\Form\Type\CalendarViewType;
use App\Form\Type\InitialViewType;
use App\Form\Type\LanguageType;
use App\Form\Type\SkinType;
use App\Form\Type\ThemeLayoutType;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\Constraints\Range;

class UserPreferenceSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserPreferenceEvent::class => ['loadUserPreferences', 200],
        ];
    }

    public function loadUserPreferences(UserPreferenceEvent $event)
    {
        $user = $event->getUser();

        $event->addPreference(
            (new UserPreference())
                ->setName('demo_money')
                ->setValue(1)
                ->setOrder(900)
                ->setType(MoneyType::class)
                ->setEnabled(true)
                ->setOptions(['help' => 'A help text'])
                ->addConstraint(new Range(['min' => 1]))
        );
    }
}
