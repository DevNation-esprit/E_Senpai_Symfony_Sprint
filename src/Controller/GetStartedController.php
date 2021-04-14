<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetStartedController extends AbstractController
{
    /**
     * @Route("/get/started", name="get_started")
     */
    public function index(): Response
    {
        return $this->render('get_started/index.html.twig', [
            'controller_name' => 'GetStartedController',
        ]);
    }
}
