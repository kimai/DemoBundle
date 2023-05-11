<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

#[Serializer\ExclusionPolicy('all')]
class DemoEntity
{
    /**
     * Unique entity ID
     */
    #[Serializer\Expose]
    #[Serializer\Groups(['Default'])]
    private int $id = 1;
    /**
     * Demo counter value
     */
    #[Serializer\Expose]
    #[Serializer\Groups(['Default'])]
    private int $counter = 0;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCounter(): int
    {
        return $this->counter;
    }

    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }

    public function increaseCounter(): void
    {
        $this->counter++;
    }
}
