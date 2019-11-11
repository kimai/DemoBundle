<?php

/*
 * This file is part of the Kimai DemoBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Entity;

class DemoEntity
{
    private $counter = 0;

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): DemoEntity
    {
        $this->counter = $counter;

        return $this;
    }

    public function increaseCounter(): DemoEntity
    {
        $this->counter++;

        return $this;
    }
}
