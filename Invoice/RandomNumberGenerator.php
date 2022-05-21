<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Invoice;

use App\Invoice\InvoiceModel;
use App\Invoice\NumberGeneratorInterface;

/**
 * Class RandomNumberGenerator is meant for testing purpose only.
 */
class RandomNumberGenerator implements NumberGeneratorInterface
{
    /**
     * @var InvoiceModel
     * @phpstan-ignore-next-line
     */
    private $model;

    public function setModel(InvoiceModel $model): void
    {
        $this->model = $model;
    }

    public function getInvoiceNumber(): string
    {
        return (string) rand(1000000, 9999999);
    }

    public function getId(): string
    {
        return 'random';
    }
}
