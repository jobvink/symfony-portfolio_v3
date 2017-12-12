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

        if ($request->get('name') && $request->get('description')) {



            $competence = new Competence();
            $competence->setName($request->get('name'))
                ->setDescription($request->get('description'));

            dump($request->get('logo'));

            $portfolioService->storeAjaxFile($competence, $request->get('logo'), '/public/assets/img/competenties/');

            $em = $this->getDoctrine()->getManager();
            $em->persist($competence);
            $em->flush();
            return new JsonResponse(['succes' => 'true']);
        } else {
            return new JsonResponse(['succes' => false]);
        }
    }

}
