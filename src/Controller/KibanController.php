<?php

namespace App\Controller;

use App\Entity\Kiban;
use App\Form\KibanType;
use App\Repository\KibanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kiban")
 */
class KibanController extends AbstractController
{
    /**
     * @Route("/", name="app_kiban_index", methods={"GET"})
     */
    public function index(Request $request, KibanRepository $kibanRepository): Response
    {
        $various = $request->query->get('various');
        dump($various);
        if ($various == "") {
            return $this->render('kiban/index.html.twig', [
                'various' => 'All',
                'kibans' => $kibanRepository->findAll(),
            ]);
        } else {
            return $this->render('kiban/index.html.twig', [
                'various' => $various,
                'kibans' => $kibanRepository->findByVariousField($various),
            ]);
        }
    }

    /**
     * @Route("/new", name="app_kiban_new", methods={"GET", "POST"})
     */
    public function new(Request $request, KibanRepository $kibanRepository): Response
    {
        $kiban = new Kiban();
        $form = $this->createForm(KibanType::class, $kiban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kibanRepository->add($kiban, true);

            return $this->redirectToRoute('app_kiban_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kiban/new.html.twig', [
            'kiban' => $kiban,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_kiban_show", methods={"GET"})
     */
    public function show(Kiban $kiban): Response
    {
        return $this->render('kiban/show.html.twig', [
            'kiban' => $kiban,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_kiban_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Kiban $kiban, KibanRepository $kibanRepository): Response
    {
        $form = $this->createForm(KibanType::class, $kiban);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kibanRepository->add($kiban, true);

            return $this->redirectToRoute('app_kiban_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('kiban/edit.html.twig', [
            'kiban' => $kiban,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_kiban_delete", methods={"POST"})
     */
    public function delete(Request $request, Kiban $kiban, KibanRepository $kibanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$kiban->getId(), $request->request->get('_token'))) {
            $kibanRepository->remove($kiban, true);
        }

        return $this->redirectToRoute('app_kiban_index', [], Response::HTTP_SEE_OTHER);
    }
}
