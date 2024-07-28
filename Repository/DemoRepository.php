<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Repository;

use KimaiPlugin\DemoBundle\Entity\DemoEntity;

final class DemoRepository
{
    private string $storage;

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

        if ($data !== false) {
            $json = json_decode($data, true);

            if (\is_array($json) && \array_key_exists('counter', $json) && is_numeric($json['counter'])) {
                $entity->setCounter((int) $json['counter']);
            }
        }

        return $entity;
    }

    public function saveDemoEntity(DemoEntity $entity): void
    {
        $vars = [];

        if (file_exists($this->storage)) {
            $data = file_get_contents($this->storage);
            if ($data !== false) {
                $vars = json_decode($data, true);
                if (!\is_array($vars)) {
                    throw new \Exception('Failed reading demo content storage file at data/demo.json');
                }
            }
        }

        $vars['counter'] = $entity->getCounter();

        file_put_contents($this->storage, json_encode($vars));
    }
}
