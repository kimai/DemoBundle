<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Configuration;

use App\Configuration\SystemConfiguration;

final class DemoConfiguration
{
    public function __construct(private SystemConfiguration $configuration)
    {
    }

    public function getSomeSetting(): string
    {
        $e = $this->configuration->find('demo.some_setting');

        if (\is_string($e)) {
            return $e;
        }

        return '**empty**';
    }

    public function isColorChangeActivated(): bool
    {
        $e = $this->configuration->find('demo.activate_dots');

        if (\is_string($e) || \is_int($e)) {
            return (bool) $e;
        }

        return false;
    }
}
