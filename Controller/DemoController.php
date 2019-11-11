<?php

/*
 * This file is part of the Kimai DemoBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Controller;

use App\Controller\AbstractController;
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

    public function __construct(DemoRepository $repository)
    {
        $this->repository = $repository;
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
