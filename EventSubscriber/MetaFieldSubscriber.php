<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\EventSubscriber;

use App\Entity\MetaTableTypeInterface;
use App\Entity\TimesheetMeta;
use App\Event\TimesheetMetaDefinitionEvent;
use App\Event\TimesheetMetaDisplayEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class MetaFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            TimesheetMetaDefinitionEvent::class => ['loadTimesheetMeta', 200],
            TimesheetMetaDisplayEvent::class => ['loadTimesheetFields', 200],
        ];
    }

    private function getMetaField(): MetaTableTypeInterface
    {
        $definition = new TimesheetMeta();
        $definition->setName('demo_bundle');
        $definition->setLabel('Demo');
        $definition->setOptions(['label' => 'Demo form title', 'help' => 'A help text for the demo bundles meta field']);
        $definition->setType(TextType::class);
        $definition->addConstraint(new Length(['max' => 200]));
        $definition->setIsVisible(true);

        return $definition;
    }

    public function loadTimesheetMeta(TimesheetMetaDefinitionEvent $event): void
    {
        $event->getEntity()->setMetaField($this->getMetaField());
    }

    public function loadTimesheetFields(TimesheetMetaDisplayEvent $event): void
    {
        $event->addField($this->getMetaField());
    }
}
