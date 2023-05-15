<?php

namespace App\Controller;

use App\Repository\KibanRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopController extends AbstractController
{
    /**
     * @Route("/", name="app_top")
     */
    public function index(KibanRepository $KibanRepository): Response
    {
        // ここのところ遅いんでリファクタリングしたかったらしてくれ
        $kosu = [
            'main'=> count($KibanRepository->findByVariousField('main')),
            'sub' => count($KibanRepository->findByVariousField('sub')),
            'wl' => count($KibanRepository->findByVariousField('wl')),
        ];
        return $this->render('top/index.html.twig', [
            'kosu' => $kosu,
            'controller_name' => 'TopController',
        ]);
    }
}


