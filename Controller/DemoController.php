<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Controller;

use App\Configuration\LocaleService;
use App\Controller\AbstractController;
use App\Entity\Timesheet;
use KimaiPlugin\DemoBundle\Configuration\DemoConfiguration;
use KimaiPlugin\DemoBundle\Form\DemoType;
use KimaiPlugin\DemoBundle\Repository\DemoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/admin/demo")
 * @Security("is_granted('demo')")
 */
final class DemoController extends AbstractController
{
    public function __construct(private DemoRepository $repository, private DemoConfiguration $configuration)
    {
    }

    /**
     * @Route(path="", name="demo", methods={"GET", "POST"})
     */
    public function index(LocaleService $localeService): Response
    {
        // some demo data, which can be viewed in the "test locale" box
        $begin = 240 * 3600 + rand(1, 3 * 3600);
        $end = $begin + (rand(10 * 3600, 15 * 3600));
        $timesheet = new Timesheet();
        $timesheet->setBegin(new \DateTime('-' . $begin . 'seconds'));
        $timesheet->setEnd(new \DateTime('-' . $end . 'seconds'));
        $timesheet->setDuration($end - $begin);
        $timesheet->setHourlyRate(48.25);
        $timesheet->setRate(1241.25);

        $entity = $this->repository->getDemoEntity();

        $entity->increaseCounter();
        $this->repository->saveDemoEntity($entity);

        $form = $this->createForm(DemoType::class, $entity, [
            'action' => $this->generateUrl('demo'),
        ]);

        return $this->render('@Demo/index.html.twig', [
            'entity' => $entity,
            'configuration' => $this->configuration,
            // for locale testing
            'now' => new \DateTime(),
            'timesheet' => $timesheet,
            'locales' => $localeService->getAllLocales(),
            // TODO - unused
            'form' => $form->createView(),
        ]);
    }
}
