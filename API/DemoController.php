<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\API;

use App\API\NotFoundException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use KimaiPlugin\DemoBundle\Entity\DemoEntity;
use Nelmio\ApiDocBundle\Annotation\Security as ApiSecurity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @RouteResource("Demo")
 * @Security("is_granted('ROLE_USER')")
 */
final class DemoController extends AbstractController
{
    /**
     * @var ViewHandlerInterface
     */
    private $viewHandler;

    public function __construct(ViewHandlerInterface $viewHandler)
    {
        $this->viewHandler = $viewHandler;
    }

    /**
     * Returns a collection of demo entities
     *
     * @SWG\Response(
     *      response=200,
     *      description="Returns a collection of demo entities",
     *      @SWG\Schema(
     *          type="array",
     *          @SWG\Items(ref="#/definitions/DemoCollection")
     *      )
     * )
     * @Rest\QueryParam(name="counter", requirements="\d+", strict=true, nullable=true, description="The counter to be included in the answer (default: 1)")
     *
     * @ApiSecurity(name="apiUser")
     * @ApiSecurity(name="apiToken")
     */
    public function cgetAction(ParamFetcherInterface $paramFetcher): Response
    {
        $demo = new DemoEntity();
        $demo->setId(1);

        if (null !== ($counter = $paramFetcher->get('counter'))) {
            $demo->setCounter($counter);
        }

        $view = new View([$demo], 200);
        $view->getContext()->setGroups(['Default', 'Collection', 'Demo']);

        return $this->viewHandler->handle($view);
    }

    /**
     * Returns one demo entity
     *
     * @SWG\Response(
     *      response=200,
     *      description="Returns one demo entity (if you pass id = 0, a NotFoundException will be thrown)",
     *      @SWG\Schema(ref="#/definitions/DemoEntity"),
     * )
     * @SWG\Parameter(
     *      name="id",
     *      in="path",
     *      type="integer",
     *      description="Demo ID to fetch",
     *      required=true,
     * )
     *
     * @ApiSecurity(name="apiUser")
     * @ApiSecurity(name="apiToken")
     */
    public function getAction(int $id): Response
    {
        if (0 === $id) {
            throw new NotFoundException();
        }

        $demo = new DemoEntity();
        $demo->setId($id);

        $view = new View($demo, 200);
        $view->getContext()->setGroups(['Default', 'Entity', 'Demo']);

        return $this->viewHandler->handle($view);
    }
}
