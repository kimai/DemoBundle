<?php

/*
 * This file is part of the "DemoBundle" for Kimai.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\DemoBundle\Controller;

use App\Configuration\LocaleService;
use App\Controller\AbstractController;
use App\Entity\Timesheet;
use App\Utils\PageSetup;
use KimaiPlugin\DemoBundle\Configuration\DemoConfiguration;
use KimaiPlugin\DemoBundle\Form\DemoType;
use KimaiPlugin\DemoBundle\Report\DemoReportForm;
use KimaiPlugin\DemoBundle\Report\DemoReportQuery;
use KimaiPlugin\DemoBundle\Repository\DemoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/admin/demo')]
#[IsGranted('demo')]
final class DemoController extends AbstractController
{
    public function __construct(private DemoRepository $repository, private DemoConfiguration $configuration)
    {
    }

    #[Route(path: '', name: 'demo', methods: ['GET', 'POST'])]
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

        $page = new PageSetup('Demo');
        $page->setActionName('demo');
        $page->setActionPayload(['counter' => $entity->getCounter()]);

        return $this->render('@Demo/index.html.twig', [
            'page_setup' => $page,
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

    #[Route(path: '{code}', name: 'demo_error', methods: ['GET'])]
    public function error(string $code): Response
    {
        if ($code === '403') {
            throw $this->createAccessDeniedException();
        } elseif ($code === '404') {
            throw $this->createNotFoundException();
        }

        throw new \Exception('Error 500');
    }

    #[Route(path: '/report', name: 'demo_report', methods: ['GET', 'POST'])]
    public function report(Request $request): Response
    {
        $dateTimeFactory = $this->getDateTimeFactory();

        $values = new DemoReportQuery($dateTimeFactory->getStartOfMonth());

        $form = $this->createFormForGetRequest(DemoReportForm::class, $values, [
            'timezone' => $dateTimeFactory->getTimezone()->getName(),
        ]);

        $form->submit($request->query->all(), false);

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $values->setMonth($dateTimeFactory->getStartOfMonth());
            }
        }

        if ($values->getMonth() === null) {
            $values->setMonth($dateTimeFactory->getStartOfMonth());
        }

        /** @var \DateTime $start */
        $start = $values->getMonth();
        $start->modify('first day of 00:00:00');

        $end = clone $start;
        $end->modify('last day of 23:59:59');

        $previous = clone $start;
        $previous->modify('-1 month');

        $next = clone $start;
        $next->modify('+1 month');

        $data = [
            'report_title' => 'Demo report',
            'form' => $form->createView(),
            'current' => $start,
            'next' => $next,
            'previous' => $previous,
            'hasData' => false,
            'box_id' => 'demo_box_id',
        ];

        return $this->render('@Demo/report.html.twig', $data);
    }
}
