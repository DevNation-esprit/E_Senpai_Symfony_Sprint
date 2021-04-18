<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Quiz;
use App\Entity\Test;
use App\Entity\Questionquiz ;
use App\Entity\Questiontest ;
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

    /**
     * @Route("/validateQuiz/{id}", name="validate_quiz", methods={"GET","POST"})
     */
    public function  validateQuiz(Request $request,$id)
    {
        $note = 0 ;
        $pourcentage = 0 ;
        $q = new Quiz();
        $q= $this->getDoctrine()->getRepository(Quiz::class)->find($id) ;
        $responses = new ArrayCollection() ;
        foreach($q->getQuestions() as $question){
            $questPosee = $question->getDesignation();
            $param = str_replace(" ", "_", $questPosee, $count);
            $responses->add([$questPosee =>$request->request->get($param)]) ;
        }

        foreach($responses as $rep){
            $questRep = array_keys($rep)[0] ;
            $valRep = array_values($rep)[0] ;
            foreach($q->getQuestions() as $question)
            {
                if( (strcmp($questRep, $question->getDesignation()) === 0) && (strcmp($valRep, $question->getReponseCorrecte()) === 0) )
                {
                    $note = ($note + $question->getNote()) ;
                }
            }

        }
        $totalPoints = $q->getTotalPoint() ;
        $pourcentage = round(($note / $totalPoints) *100);

        return $this->render('quiz_and_test_front/quiz_result.html.twig', [
            'quiz' => $q ,
            'note' => $note ,
            'percent' => $pourcentage ,
            'totalpoints' => $totalPoints,
        ]);
    }

    /**
     * @Route("/answersQuiz/{id}", name="answers_quiz", methods={"GET","POST"})
     */
    public function ShowQuizAnswers($id) : Response
    {
        $q= $this->getDoctrine()->getRepository(Quiz::class)->find($id) ;
        return $this->render('quiz_and_test_front/show_answers_quiz.html.twig', [
            'quiz' => $q ,
        ]);

    }
}
