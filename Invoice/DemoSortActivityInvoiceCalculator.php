<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Invoice;

use App\Entity\ExportableItem;
use App\Invoice\Calculator\AbstractSumInvoiceCalculator;
use App\Invoice\CalculatorInterface;
use App\Invoice\InvoiceItem;

/**
 * A calculator that sums up the invoice item records by activity.
 */
class DemoSortActivityInvoiceCalculator extends AbstractSumInvoiceCalculator implements CalculatorInterface
{
    protected function calculateSumIdentifier(ExportableItem $invoiceItem): string
    {
        if (null === $invoiceItem->getActivity()) {
            return '__NULL__';
        }

        return (string) $invoiceItem->getActivity()->getId();
    }

    protected function mergeSumInvoiceItem(InvoiceItem $invoiceItem, ExportableItem $entry): void
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

    public function getEntries(): array
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
        usort($result_array, function (InvoiceItem $a, InvoiceItem $b) {
            $compare_a = $a->getActivity()?->getName();
            $compare_b = $b->getActivity()?->getName();

            if ($compare_a == $compare_b) {
                return 0;
            }

            return ($compare_a < $compare_b) ? -1 : 1;
        });

        return $result_array;
    }

    public function getId(): string
    {
        return 'sortbyActivity';
    }
}
