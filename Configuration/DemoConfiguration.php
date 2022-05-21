<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Configuration;

use App\Configuration\SystemConfiguration;

final class DemoConfiguration
{
    private $configuration;

    public function __construct(SystemConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getSomeSetting(): string
    {
        $config = $this->configuration->find('demo.some_setting');
        if (!\is_string($config)) {
            return 'NOT SET';
        }

        return $config;
    }
}
