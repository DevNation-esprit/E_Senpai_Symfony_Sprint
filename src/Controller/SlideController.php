<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SlideController extends AbstractController
{
    /**
     * @Route("/slide", name="slide")
     */
    public function index(): Response
    {
        return $this->render('slide/index.html.twig', [
            'controller_name' => 'SlideController',
        ]);
    }
}
