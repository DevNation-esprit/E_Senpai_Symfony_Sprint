<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Quiz;
use App\Entity\Test;
use App\Repository\QuizRepository;
use App\Repository\TestRepository;

/**
 * @Route("/quiz_front")
 */
class QuizAndTestFrontController extends AbstractController
{
    /**
     * @Route("/", name="quiz_and_test_front")
     */
    public function index(): Response
    {
        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findAll() ;
        $tests = $this->getDoctrine()->getRepository(Test::class)->findAll() ;

        return $this->render('quiz_and_test_front/index.html.twig', [
            'listQuiz' => $quizzes ,
            'listTest' => $tests ,
        ]);
    }

    /**
     * @Route("/takeQuiz/{id}", name="take_quiz", methods={"GET","POST"})
     */
    public function takeQuiz($id) : Response
    {
        $q= $this->getDoctrine()->getRepository(Quiz::class)->find($id) ;
        return $this->render('quiz_and_test_front/take_quiz.html.twig', [
            'quiz' => $q ,
        ]);

    }

    /**
     * @Route("/takeTest/{id}", name="take_test", methods={"GET","POST"})
     */
    public function takeTest($id) : Response
    {
        $t= $this->getDoctrine()->getRepository(Test::class)->find($id) ;
        return $this->render('quiz_and_test_front/take_test.html.twig', [
            'test' => $t ,
        ]);

    }
}
