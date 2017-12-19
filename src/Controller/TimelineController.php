<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\PortfolioInterface;
use App\Entity\Timeline;
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

class TimelineController extends Controller
{

    /**
     *
     * @Route("/timeline/create", name="timeline_create")
     */
    public function create(Request $request, PortfolioService $portfolioService) {

        $timeline = new Timeline();
        $form = $this->createForm('App\Form\TimelineType', $timeline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $form->get('logo')->getNormData();

            $name = $portfolioService->storeFile($file, $this->getParameter('images'));

            $timeline->setLogo($name);

            $em->persist($timeline);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->redirectToRoute('home');
    }

    /**
     *
     * @Route("/timeline/{id}/update", name="timeline_update")
     * @param Request $request
     * @param Timeline $timeline
     * @param PortfolioService $portfolioService
     * @return JsonResponse
     */
    public function update(Request $request, Timeline $timeline, PortfolioService $portfolioService) {
        $type = $request->get('type');
        $data = $request->get('data');

        if ($type == 'attachment') {
            $portfolioService->storeAjaxFile($timeline, $data, $this->getParameter('images'));
        } else {
            $timeline->{'set' . ucfirst($type)}($data);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($timeline);
        $em->flush();

        return new JsonResponse([$type, $data, $timeline]);
    }

    /**
     * @param Timeline $timeline
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/timeline/{id}/delete", name="timeline_delete")
     */
    public function delete(Timeline $timeline) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($timeline);
        $em->flush();

        return $this->redirectToRoute('home');
    }



}
