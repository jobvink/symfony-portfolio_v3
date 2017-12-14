<?php

namespace App\Controller;

use App\Entity\Competence;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\PortfolioService;

class CompetenceController extends Controller
{

    /**
     *
     * @Route("/competence/create", name="competence_create")
     */
    public function create(Request $request, PortfolioService $portfolioService) {

        $competence = new Competence();
        $form = $this->createForm('App\Form\CompetenceType', $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $portfolioService->storeFile($competence, '/public/assets/img/competence');
            $em->persist($competence);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->redirectToRoute('home');
    }

}
