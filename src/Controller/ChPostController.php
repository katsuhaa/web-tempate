<?php

namespace App\Controller;

use App\Entity\ChPost;
use App\Form\ChPostType;
use App\Repository\ChPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ch/post")
 */
class ChPostController extends AbstractController
{
    /**
     * @Route("/", name="app_ch_post_index", methods={"GET"})
     */
    public function index(ChPostRepository $chPostRepository): Response
    {
        return $this->render('ch_post/index.html.twig', [
            'ch_posts' => $chPostRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_ch_post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ChPostRepository $chPostRepository): Response
    {
        $chPost = new ChPost();
        $form = $this->createForm(ChPostType::class, $chPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chPostRepository->add($chPost, true);

            return $this->redirectToRoute('app_ch_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ch_post/new.html.twig', [
            'ch_post' => $chPost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ch_post_show", methods={"GET"})
     */
    public function show(ChPost $chPost): Response
    {
        return $this->render('ch_post/show.html.twig', [
            'ch_post' => $chPost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_ch_post_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ChPost $chPost, ChPostRepository $chPostRepository): Response
    {
        $form = $this->createForm(ChPostType::class, $chPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chPostRepository->add($chPost, true);

            return $this->redirectToRoute('app_ch_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ch_post/edit.html.twig', [
            'ch_post' => $chPost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_ch_post_delete", methods={"POST"})
     */
    public function delete(Request $request, ChPost $chPost, ChPostRepository $chPostRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chPost->getId(), $request->request->get('_token'))) {
            $chPostRepository->remove($chPost, true);
        }

        return $this->redirectToRoute('app_ch_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
