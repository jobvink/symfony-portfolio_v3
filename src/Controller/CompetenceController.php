<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\PortfolioInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
            $file = $form->get('logo')->getNormData();

            $name = $portfolioService->storeFile($file, $this->getParameter('images'));

            $competence->setLogo($name);

            $em->persist($competence);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->redirectToRoute('home');
    }

    /**
     *
     * @Route("/competence/{id}/update", name="competence_update")
     * @param Request $request
     * @param Competence $competence
     * @return JsonResponse
     */
    public function update(Request $request, Competence $competence, PortfolioService $portfolioService) {
        $type = $request->get('type');
        $data = $request->get('data');

        if ($type == 'attachment') {
            $portfolioService->storeAjaxFile($competence, $data, $this->getParameter('images'));
        } else {
            $competence->{'set' . ucfirst($type)}($data);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($competence);
        $em->flush();

        return new JsonResponse([$type, $data, $competence]);
    }

    /**
     * @param Competence $competence
     *
     * @Route("/competence/{id}/delete", name="competence_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Competence $competence) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($competence);
        $em->flush();

        return $this->redirectToRoute('home');
    }



}
