<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 12-12-17
 * Time: 20:53
 */

namespace App\Controller;


use App\Entity\Competence;
use App\Entity\Timeline;
use App\Service\AttachementUpdater;
use App\Service\Deleter;
use App\Service\Updater;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends Controller
{

    /**
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function portfolio(Updater $updater, Deleter $deleter, AttachementUpdater $attachementUpdater)
    {
        $em = $this->getDoctrine()->getManager();
        $competenceRepository = $em->getRepository('App:Competence');
        $timelineRepository = $em->getRepository('App:Timeline');

        $timelines = $timelineRepository->findAll();
        $competences = $competenceRepository->findAll();
        $new = [
            'competence' => $this->createForm(
                'App\Form\CompetenceType',
                new Competence(),
                [
                    'method' => 'POST',
                    'action' => $this->generateUrl('competence_create')
                ])
                ->createView(),
            'timeline' => $this->createForm(
                'App\Form\TimelineType',
                new Timeline(),
                [
                    'method' => 'POST',
                    'action' => $this->generateUrl('timeline_create')
                ])->createView()
        ];

        return $this->render('base.html.twig', [
            'competences' => $competences,
            'timelines' => $timelines,
            'new' => $new,
            'updater' => $updater,
            'deleter' => $deleter,
            'imgupdater' => $attachementUpdater
        ]);
    }

    /**
     * @Route("/admin")
     */
    public function admin()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }
}