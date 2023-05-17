<?php

namespace App\Controller;

use App\Entity\ChThread;
use App\Form\ChThreadType;
use App\Repository\ChThreadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ch/thread")
 */
class ChThreadController extends AbstractController
{
    /**
     * @Route("/", name="app_ch_thread_index", methods={"GET"})
     */
    public function index(ChThreadRepository $chThreadRepository): Response
    {
        return $this->render('ch_thread/index.html.twig', [
            'ch_threads' => $chThreadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ch_thread_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ChThreadRepository $chThreadRepository): Response
    {
        $chThread = new ChThread();
        $form = $this->createForm(ChThreadType::class, $chThread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chThreadRepository->add($chThread, true);

            return $this->redirectToRoute('app_ch_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ch_thread/new.html.twig', [
            'ch_thread' => $chThread,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ch_thread_show", methods={"GET"})
     */
    public function show(ChThread $chThread): Response
    {
        return $this->render('ch_thread/show.html.twig', [
            'ch_thread' => $chThread,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ch_thread_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ChThread $chThread, ChThreadRepository $chThreadRepository): Response
    {
        $form = $this->createForm(ChThreadType::class, $chThread);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chThreadRepository->add($chThread, true);

            return $this->redirectToRoute('app_ch_thread_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ch_thread/edit.html.twig', [
            'ch_thread' => $chThread,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ch_thread_delete", methods={"POST"})
     */
    public function delete(Request $request, ChThread $chThread, ChThreadRepository $chThreadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chThread->getId(), $request->request->get('_token'))) {
            $chThreadRepository->remove($chThread, true);
        }

        return $this->redirectToRoute('app_ch_thread_index', [], Response::HTTP_SEE_OTHER);
    }
}
