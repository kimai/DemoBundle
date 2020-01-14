<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Entity;

class DemoEntity
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $counter = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): DemoEntity
    {
        $this->id = $id;

        return $this;
    }

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
