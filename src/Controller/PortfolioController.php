<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 12-12-17
 * Time: 20:53
 */

namespace App\Controller;


use App\Entity\Competence;
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
        $repo = $em->getRepository('App:Competence');
        $competences = $repo->findAll();
        $new = [
            'competence' => $this->createForm(
                'App\Form\CompetenceType',
                new Competence(),
                [
                    'method' => 'POST',
                    'action' => $this->generateUrl('competence_create')
                ])
                ->createView()
        ];

        return $this->render('base.html.twig', [
            'competences' => $competences,
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