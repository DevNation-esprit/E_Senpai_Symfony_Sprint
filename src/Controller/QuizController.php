<?php

namespace App\Controller;

use App\Entity\Questionquiz;
use App\Entity\Quiz;
use App\Entity\User;
use App\Form\QuizType;
use App\Repository\QuizRepository;
use App\Repository\QuestionquizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier ;

/**
 * @Route("/quiz")
 */
class QuizController extends AbstractController
{
    /**
     * @Route("/{id}", name="quiz_index", methods={"GET"})
     */
    public function index(QuizRepository $quizRepository,$id): Response
    {
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizRepository->findBy(array('idFormateur'=> $id)),
        ]);
    }

    /**
     * @Route("/new/{id}", name="quiz_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id,FlashyNotifier $flashy): Response
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id) ;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $quiz->setIdFormateur($user) ;
            $entityManager->persist($quiz);
            $entityManager->flush();
            $flashy->success('Quiz crée avec succes!');
            return $this->redirectToRoute('quiz_index', ['id' => $quiz->getIdFormateur()->getId() ] );
        }

        return $this->render('quiz/new.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="quiz_show", methods={"GET"})
     */
    public function show(Quiz $quiz,$id): Response
    {
        return $this->render('quiz/show.html.twig', [
            'quiz' => $this->getDoctrine()->getRepository(Quiz::class)->find($id),
            'questionquizzes' => $this->getDoctrine()->getRepository(Questionquiz::class)
                ->findBy(array('idQuiz'=> $quiz->getId()))
        ]);
    }

    /**
     * @Route("/{id}/edit", name="quiz_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quiz $quiz,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $flashy->success('Quiz modifié avec succes!');
            return $this->redirectToRoute('quiz_index', ['id' => $quiz->getIdFormateur()->getId() ] );
        }

        return $this->render('quiz/edit.html.twig', [
            'quiz' => $quiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="quiz_delete", methods={"POST"})
     */
    public function delete(Request $request, Quiz $quiz,FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quiz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quiz);
            $entityManager->flush();
        }
        $flashy->success('Quiz supprimé avec succes!');
        return $this->redirectToRoute('quiz_index', ['id' => $quiz->getIdFormateur()->getId() ] );
    }
}
