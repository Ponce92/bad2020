<?php

namespace App\Controller\SvaoPrivate;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AeropuertosController extends AbstractController
{
    /**
     * @Route("/svao/private/aeropuertos", name="aeropuertos.list")
     */
    public function index()
    {
        return $this->render('svao_private/aeropuertos/index.html.twig', [
            'controller_name' => 'AeropuertosController',
        ]);
    }
}
