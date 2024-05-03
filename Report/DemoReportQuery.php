<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Report;

final class DemoReportQuery
{
    public function __construct(private \DateTimeInterface $month)
    {
    }

    public function getMonth(): \DateTimeInterface
    {
        return $this->month;
    }

    public function setMonth(?\DateTime $month): void
    {
        $this->month = $month;
    }
}
