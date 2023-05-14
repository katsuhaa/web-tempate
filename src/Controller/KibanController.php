<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KibanController extends AbstractController
{
    /**
     * @Route("/kiban", name="app_kiban")
     */
    public function index(): Response
    {
        return $this->render('kiban/index.html.twig', [
            'controller_name' => 'KibanController',
        ]);
    }
}
