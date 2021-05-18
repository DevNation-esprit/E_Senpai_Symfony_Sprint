<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizFrontJsonController extends AbstractController
{
    /**
     * @Route("/quiz/front/json", name="quiz_front_json")
     */
    public function index(): Response
    {
        return $this->render('quiz_front_json/index.html.twig', [
            'controller_name' => 'QuizFrontJsonController',
        ]);
    }
}
