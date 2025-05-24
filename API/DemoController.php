<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\API;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandlerInterface;
use KimaiPlugin\DemoBundle\Entity\DemoEntity;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/demos')]
#[OA\Tag(name: 'Demo')]
#[IsGranted('API')]
final class DemoController extends AbstractController
{
    public function __construct(private readonly ViewHandlerInterface $viewHandler)
    {
    }

    /**
     * Fetch a collection of demo entities
     */
    #[OA\Response(response: 200, description: 'Returns a collection of demo entities', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/DemoEntity')))]
    #[Rest\QueryParam(name: 'counter', requirements: '\d+', strict: true, nullable: true, description: 'The counter to be included in the answer (default: 1)')]
    #[Route(methods: ['GET'])]
    public function cgetAction(ParamFetcherInterface $paramFetcher): Response
    {
        $demo = new DemoEntity();
        $demo->setId(1);

        if (null !== ($counter = $paramFetcher->get('counter')) && is_numeric($counter)) {
            $demo->setCounter((int) $counter);
        }

        $view = new View([$demo], 200);
        $view->getContext()->setGroups(['Default', 'Collection', 'Demo']);

        return $this->viewHandler->handle($view);
    }

    /**
     * Fetch demo entity
     */
    #[OA\Response(response: 200, description: 'Returns one demo entity (if you pass id = 0, a NotFoundException will be thrown)', content: new OA\JsonContent(ref: '#/components/schemas/DemoEntity'))]
    #[OA\Parameter(name: 'id', in: 'path', description: 'Demo ID to fetch', required: true)]
    #[Route(methods: ['GET'], path: '/{id}')]
    public function getAction(int $id): Response
    {
        if (0 === $id) {
            throw $this->createNotFoundException('Unsupported demo ID');
        }

        $demo = new DemoEntity();
        $demo->setId($id);

        $view = new View($demo, 200);
        $view->getContext()->setGroups(['Default', 'Entity', 'Demo']);

        return $this->viewHandler->handle($view);
    }
}
