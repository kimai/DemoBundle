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
use App\Security\CurrentUser;
use App\Widget\Type\SimpleWidget;

class DemoWidget extends SimpleWidget
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(CurrentUser $user, UserRepository $repository)
    {
        $this->repository = $repository;

        $this->setId('DemoWidget');
        $this->setTitle('Demo widget');
        $this->setOptions([
            'user' => $user->getUser(),
            'id' => '',
        ]);
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
        $query->setPageSize(8);

        return [
            'amount' => $amount,
            'users' => $this->repository->getPagerfantaForQuery($query)
        ];
    }

    public function getTemplateName(): string
    {
        return '@Demo/widget.html.twig';
    }
}
