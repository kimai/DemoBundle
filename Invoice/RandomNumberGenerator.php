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
 *
 * @author Kevin Papst <kevin@kevinpapst.de>
 */
class RandomNumberGenerator implements NumberGeneratorInterface
{
    /**
     * @var InvoiceModel
     */
    protected $model;

    /**
     * @param InvoiceModel $model
     */
    public function setModel(InvoiceModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber(): string
    {
        return rand(1000000, 9999999);
    }

    public function getId(): string
    {
        return 'random';
    }
}
