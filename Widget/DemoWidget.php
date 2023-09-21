<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Widget;

use App\Repository\Query\UserQuery;
use App\Repository\UserRepository;
use App\Widget\Type\AbstractWidget;
use App\Widget\WidgetInterface;

class DemoWidget extends AbstractWidget
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function getWidth(): int
    {
        return WidgetInterface::WIDTH_FULL;
    }

    public function getHeight(): int
    {
        return WidgetInterface::HEIGHT_MAXIMUM;
    }

    /**
     * @param array<string, string|bool|int|null> $options
     * @return array<string, string|bool|int|null>
     */
    public function getOptions(array $options = []): array
    {
        return array_merge(['id' => 'DemoWidget'], parent::getOptions($options));
    }

    /**
     * @param array<string, string|bool|int|null> $options
     */
    public function getData(array $options = []): mixed
    {
        $query = new UserQuery();
        $query->setSystemAccount(false);
        $amount = $this->repository->countUsersForQuery($query);

        return [
            'amount' => $amount,
            'users' => $this->repository->getUsersForQuery($query)
        ];
    }

    public function getId(): string
    {
        return 'DemoWidget';
    }

    public function getTitle(): string
    {
        return 'Demo widget';
    }

    public function getTemplateName(): string
    {
        return '@Demo/widget.html.twig';
    }
}
