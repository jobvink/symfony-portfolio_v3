<?php
/**
 * Created by PhpStorm.
 * User: jobvink
 * Date: 12-12-17
 * Time: 20:53
 */

namespace App\Controller;


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
    public function number()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App:Competence');
        $competences = $repo->findAll();
        $new = [
            'competence' => $this->createForm(
                'App\Form\CompetenceType',
                null,
                [
                    'method' => 'POST',
                    'action' => $this->generateUrl('competence_create')
                ])
                ->createView()
        ];

        return $this->render('base.html.twig', [
            'competences' => $competences,
            'new' => $new
        ]);
    }
}