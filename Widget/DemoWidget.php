<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Widget;

use App\Entity\User;
use App\Repository\Query\UserQuery;
use App\Repository\UserRepository;
use App\Widget\Type\SimpleWidget;
use App\Widget\Type\UserWidget;

class DemoWidget extends SimpleWidget implements UserWidget
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;

        $this->setId('DemoWidget');
        $this->setTitle('Demo widget');
        $this->setOptions([
            'user' => null,
            'id' => '',
        ]);
    }

    public function setUser(User $user): void
    {
        $this->setOption('user', $user);
    }

    public function getOptions(array $options = []): array
    {
        $options = parent::getOptions($options);

        if (empty($options['id'])) {
            $options['id'] = 'DemoWidget';
        }

        return $options;
    }

    public function getData(array $options = [])
    {
        $options = $this->getOptions($options);

        /** @var User $user */
        $user = $options['user'];

        $query = new UserQuery();
        $amount = $this->repository->countUsersForQuery($query);

        return [
            'amount' => $amount,
            'users' => $this->repository->getUsersForQuery($query)
        ];
    }

    public function getTemplateName(): string
    {
        return '@Demo/widget.html.twig';
    }
}
