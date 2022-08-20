<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Invoice;

use App\Invoice\CalculatorInterface;
use App\Invoice\InvoiceItem;
use App\Invoice\InvoiceItemInterface;

/**
 * A calculator that sums up the invoice item records by activity.
 */
class DemoSortActivityInvoiceCalculator extends AbstractSumInvoiceCalculator implements CalculatorInterface
{
    protected function calculateSumIdentifier(InvoiceItemInterface $invoiceItem): string
    {
        if (null === $invoiceItem->getActivity()) {
            return '__NULL__';
        }

        return (string) $invoiceItem->getActivity()->getId();
    }

    protected function mergeSumInvoiceItem(InvoiceItem $invoiceItem, InvoiceItemInterface $entry)
    {
        if (null === $entry->getActivity()) {
            return;
        }

        if ($entry->getActivity()->getInvoiceText() !== null) {
            $invoiceItem->setDescription($entry->getActivity()->getInvoiceText());
        } else {
            $invoiceItem->setDescription($entry->getActivity()->getName());
        }
    }

    public function getEntries()
    {
        $entries = $this->model->getEntries();
        if (empty($entries)) {
            return [];
        }

        /** @var InvoiceItem[] $invoiceItems */
        $invoiceItems = [];

        foreach ($entries as $entry) {
            $id = $this->calculateIdentifier($entry);

            if (!isset($invoiceItems[$id])) {
                $invoiceItems[$id] = new InvoiceItem();
            }
            $invoiceItem = $invoiceItems[$id];
            $this->mergeInvoiceItems($invoiceItem, $entry);
            $this->mergeSumInvoiceItem($invoiceItem, $entry);
        }

        $result_array = array_values($invoiceItems);
        usort($result_array, function ($a, $b) {
            $compare_a = $a->getActivity()->getName();
            $compare_b = $b->getActivity()->getName();
    
            if ($compare_a == $compare_b) {
                return 0;
            };
            return ($compare_a < $compare_b) ? -1 : 1;
        });
    
        return $result_array;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return 'sortbyActivity';
    }
}
