<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Repository;

use KimaiPlugin\DemoBundle\Entity\DemoEntity;

final class DemoRepository
{
    /**
     * @var string
     */
    private $storage;

    public function __construct(string $dataDirectory)
    {
        $this->storage = $dataDirectory . '/demo.json';
    }

    public function getDemoEntity(): DemoEntity
    {
        $entity = new DemoEntity();

        if (!file_exists($this->storage)) {
            return $entity;
        }

        $data = file_get_contents($this->storage);
        $json = json_decode($data, true);

        if (array_key_exists('counter', $json)) {
            $entity->setCounter($json['counter']);
        }

        return $entity;
    }

    public function saveDemoEntity(DemoEntity $entity)
    {
        $vars = [];

        if (file_exists($this->storage)) {
            $data = file_get_contents($this->storage);
            $vars = json_decode($data, true);
        }

        $vars['counter'] = $entity->getCounter();

        file_put_contents($this->storage, json_encode($vars));
    }
}
