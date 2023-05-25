<?php

namespace App\Controller;

use App\Entity\Kiban;
use App\Form\KibanType;
use App\Repository\KibanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/kiban")
 */
class KibanController extends AbstractController
{
    /**
     * @Route("/", name="app_kiban_index", methods={"GET"})
     */
    public function index(Request $request, KibanRepository $kibanRepository, PaginatorInterface $paginator): Response
    {

        /* フィルター用選択リスト作成
         */
        /* 基板種類
         */
        $various_list = [];
        foreach( $kibanRepository->createQueryBuilder('k')
                                 ->groupBy('k.various')
                                 ->orderBy('k.various', 'ASC')
                                 ->getQuery()
                                 ->getResult() as $recode) {
            $various_list[] = $recode->getVarious();
        }
        /* 振替可否
         */
        $furikae_list = [];
        foreach( $kibanRepository->createQueryBuilder('k')
                                 ->groupBy('k.furikae')
                                 ->orderBy('k.furikae', 'ASC')
                                 ->getQuery()
                                 ->getResult() as $recode) {
            if ($recode->getFurikae() != NULL and $recode->getFurikae() != "") {
                $furikae_list[] = $recode->getFurikae();
            }
        }
        /* 使用状況
         */
        $status_list = [];
        foreach( $kibanRepository->createQueryBuilder('k')
                                 ->groupBy('k.status')
                                 ->orderBy('k.status', 'ASC')
                                 ->getQuery()
                                 ->getResult() as $recode) {
            if ($recode->getStatus() != NULL and $recode->getStatus() != "") {
                $status_list[] = $recode->getStatus();
            }
        }

        /* クエリー文字列から選択、ソートを作成
        */
        $query = $kibanRepository->createQueryBuilder('k')
                                 ->orderBy('k.id', 'ASC');
        $various = $request->query->get('various');
        if ($various == "" or mb_strtolower($various) == 'all') {
            $various = 'all';
        } else {
            $query->andWhere('k.various like :val')
                  ->setParameter('val', '%'.$various.'%');
        }
        $furikae = $request->query->get('furikae');
        if ($furikae != "") {
            $query->andWhere('k.furikae like :furival')
                  ->setParameter('furival', '%'.$furikae.'%');
        }
        $status = $request->query->get('status');
        if ($status != "") {
            $query->andWhere('k.status like :statval')
                  ->setParameter('statval', '%'.$status.'%');
        }
        
        /** @var SlidingPagination $pagination */
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );
        return $this->render('kiban/index.html.twig', [
            'various' => $various,
            'various_list' => $various_list,
            'furikae' => $furikae,
            'furikae_list' => $furikae_list,
            'status' => $status,
            'status_list' => $status_list,
            'kibans' => $kibanRepository->findAll(),
            'pagination' => $pagination,
        ]);
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
            $kiban->setUpdateDate(new \DateTime());
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
            $kiban->setUpdateDate(new \DateTime());
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
