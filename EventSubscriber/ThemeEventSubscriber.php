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
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ThemeEventSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ThemeEvent::STYLESHEET => ['renderStylesheet', 100],
        ];
    }

    /**
     * @param ThemeEvent $event
     */
    public function renderStylesheet(ThemeEvent $event)
    {
        $css = '
<style type="text/css">
    span.dot {
      animation: dotColors 20s;
      -webkit-animation: dotColors 20s;
    }

    @keyframes dotColors
    {
      0%   {background: red;}
      25%  {background: yellow;}
      50%  {background: blue;}
      75%  {background: green;}
      100% {background: red;}
    }

    @-webkit-keyframes dotColors
    {
      0%   {background: red;}
      25%  {background: yellow;}
      50%  {background: blue;}
      75%  {background: green;}
      100% {background: red;}
    }
</style>';

        $event->addContent($css);
    }
}
