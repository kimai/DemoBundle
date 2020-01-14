<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Controller;

use App\Controller\AbstractController;
use KimaiPlugin\DemoBundle\Configuration\DemoConfiguration;
use KimaiPlugin\DemoBundle\Entity\DemoEntity;
use KimaiPlugin\DemoBundle\Form\DemoType;
use KimaiPlugin\DemoBundle\Repository\DemoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin/demo")
 * @Security("is_granted('demo')")
 */
final class DemoController extends AbstractController
{
    /**
     * @var DemoRepository
     */
    private $repository;
    /**
     * @var DemoConfiguration
     */
    private $configuration;

    public function __construct(DemoRepository $repository, DemoConfiguration $configuration)
    {
        $this->repository = $repository;
        $this->configuration = $configuration;
    }

    /**
     * @Route(path="", name="demo", methods={"GET", "POST"})

     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $entity = $this->repository->getDemoEntity();

        $entity->increaseCounter();
        $this->repository->saveDemoEntity($entity);

        return $this->render('@Demo/index.html.twig', [
            'entity' => $entity,
            'configuration' => $this->configuration,
        ]);
    }

    /**
     * @param DemoEntity $entity
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getEditForm(DemoEntity $entity)
    {
        return $this->createForm(DemoType::class, $entity, [
            'action' => $this->generateUrl('demo'),
        ]);
    }
}
