<?php

namespace App\Controller;

use App\Entity\Questionquiz;
use App\Entity\Questiontest;
use App\Entity\Quiz;
use App\Entity\Test;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/quiz_front_json")
 */
class QuizFrontJsonController extends AbstractController
{
    /**
     * @Route("/", name="quiz_front_json")
     */
    public function index(NormalizerInterface $normalizer): Response
    {
        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findAll() ;

        $jsonContent = $normalizer->normalize($quizzes,'json',['groups'=>'post:read']) ;

        return new Response(json_encode($jsonContent)) ;
    }

    /**
     * @Route("/show_quiz/{id}", name="quiz_show_json")
     */
    public function showQuiz(NormalizerInterface $normalizer,$id,Request $request): Response
    {
        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->find($id) ;
        $jsonContent = $normalizer->normalize($quizzes,'json',['groups'=>'post:read']) ;

        return new Response(json_encode($jsonContent)) ;
    }

    /**
     * @Route("/get_questions/{id}", name="get_questions_json")
     */
    public function getQuestions(NormalizerInterface $normalizer,$id,Request $request) : Response
    {
        $questions = $this->getDoctrine()->getRepository(Questionquiz::class)
            ->findBy(array('idQuiz'=> $id)) ;
        $jsonContent = $normalizer->normalize($questions,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/get_one_question/{id}", name="get_question_json")
     */
    public function getSingleQuestion(NormalizerInterface $normalizer,$id,Request $request) : Response
    {
        $questions = $this->getDoctrine()->getRepository(Questionquiz::class)
            ->find($id) ;
        $jsonContent = $normalizer->normalize($questions,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/get_questions_test/{id}", name="get_questionstest_json")
     */
    public function getQuestionsTest(NormalizerInterface $normalizer,$id,Request $request) : Response
    {
        $questions = $this->getDoctrine()->getRepository(Questiontest::class)
            ->findBy(array('idTest'=> $id)) ;
        $jsonContent = $normalizer->normalize($questions,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/quiz_formateur/{id}", name="quiz_formateur_json")
     */
    public function getQuizFormateur(NormalizerInterface $normalizer,Request $request,$id): Response
    {
        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findBy(array('idFormateur'=> $id)) ; ;
        $jsonContent = $normalizer->normalize($quizzes,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/test_formateur/{id}", name="test_formateur_json")
     */
    public function getTestFormateur(NormalizerInterface $normalizer,Request $request,$id): Response
    {
        $tests = $this->getDoctrine()->getRepository(Test::class)->findBy(array('idFormateur'=> $id)) ;
        $jsonContent = $normalizer->normalize($tests,'json',['groups'=>'post:read']) ;
        $index = 0 ;
        foreach($tests as $test){
            $formation = $test->getIdFormation()->getTitre() ;
            $jsonContent[$index]['formation']= $formation;
            $index = $index + 1 ;
        }
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/addNewQuiz/", name="add_quiz_json")
     */
    public function addNewQuiz(NormalizerInterface $normalizer,Request $request): Response
    {
        $idFormateur = $request->query->get('id');
        $sujet = $request->query->get('sujet');
        $user = $this->getDoctrine()->getRepository(User::class)->find($idFormateur) ;
        $quiz = new Quiz();
        $quiz->setIdFormateur($user) ;
        $quiz->setSujet($sujet) ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($quiz);
        $entityManager->flush();

        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findBy(array('idFormateur'=> $idFormateur)) ; ;
        $jsonContent = $normalizer->normalize($quizzes,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/updateQuiz/", name="update_quiz_json")
     */
    public function updateQuiz(NormalizerInterface $normalizer,Request $request): Response
    {
        $idquiz = $request->query->get('id');
        $sujet = $request->query->get('sujet');
        $idFormateur = $request->query->get('idF');

        $quiz = new Quiz();
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($idquiz) ;
        $quiz->setSujet($sujet) ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findBy(array('idFormateur'=> $idFormateur)) ; ;
        $jsonContent = $normalizer->normalize($quizzes,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/deleteQuiz/", name="delete_quiz_json")
     */
    public function deleteQuiz(NormalizerInterface $normalizer,Request $request): Response
    {
        $idquiz = $request->query->get('id');
        $idFormateur = $request->query->get('idF');
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($idquiz) ;
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($quiz) ;
        $entityManager->flush();

        $quizzes = $this->getDoctrine()->getRepository(Quiz::class)->findBy(array('idFormateur'=> $idFormateur)) ; ;
        $jsonContent = $normalizer->normalize($quizzes,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/addNewQuestion/", name="add_question_json")
     */
    public function addNewQuestion(NormalizerInterface $normalizer,Request $request): Response
    {
        $qposee = $request->query->get('qposee');
        $rep = $request->query->get('rep');
        $prop1 = $request->query->get('prop1');
        $prop2 = $request->query->get('prop2');
        $prop3 = $request->query->get('prop3');
        $note = $request->query->get('note');
        $idquiz = $request->query->get('idQ');

        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($idquiz) ;
        $question = new Questionquiz() ;
        $question->setDesignation($qposee) ;
        $question->setReponseCorrecte($rep) ;
        $question->setReponseFausse1($prop1) ;
        $question->setReponseFausse2($prop2) ;
        $question->setReponseFausse3($prop3) ;
        $question->setNote($note) ;
        $question->setIdQuiz($quiz) ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($question);
        $entityManager->flush();

        $questions = $this->getDoctrine()->getRepository(Questionquiz::class)
            ->findBy(array('idQuiz'=> $idquiz)) ;
        $jsonContent = $normalizer->normalize($questions,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }

    /**
     * @Route("/updateQuestion/", name="update_question_json")
     */
    public function updateQuestion(NormalizerInterface $normalizer,Request $request): Response
    {
        $qposee = $request->query->get('qposee');
        $rep = $request->query->get('rep');
        $prop1 = $request->query->get('prop1');
        $prop2 = $request->query->get('prop2');
        $prop3 = $request->query->get('prop3');
        $note = $request->query->get('note');
        $idquiz = $request->query->get('idQ');
        $id = $request->query->get('id');

        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($idquiz) ;
        $question = $this->getDoctrine()->getRepository(Questionquiz::class)->find($id) ;
        $question->setDesignation($qposee) ;
        $question->setReponseCorrecte($rep) ;
        $question->setReponseFausse1($prop1) ;
        $question->setReponseFausse2($prop2) ;
        $question->setReponseFausse3($prop3) ;
        $question->setNote($note) ;

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        $questions = $this->getDoctrine()->getRepository(Questionquiz::class)
            ->findBy(array('idQuiz'=> $idquiz)) ;
        $jsonContent = $normalizer->normalize($questions,'json',['groups'=>'post:read']) ;
        $JsonTxt = json_encode($jsonContent) ;

        return new Response(json_encode($jsonContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ;
    }


}
