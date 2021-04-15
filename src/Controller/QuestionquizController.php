<?php

namespace App\Controller;

use App\Entity\Questionquiz;
use App\Entity\Quiz;
use App\Form\QuestionquizType;
use App\Repository\QuestionquizRepository;
use App\Repository\QuizRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/questionquiz")
 */
class QuestionquizController extends AbstractController
{
    /**
     * @Route("/", name="questionquiz_index", methods={"GET"})
     */
    public function index(QuestionquizRepository $questionquizRepository): Response
    {
        return $this->render('questionquiz/index.html.twig', [
            'questionquizzes' => $questionquizRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="questionquiz_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $questionquiz = new Questionquiz();
        $form = $this->createForm(QuestionquizType::class, $questionquiz);
        $form->handleRequest($request);
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->find($id) ;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $questionquiz->setIdQuiz($quiz) ;
            $entityManager->persist($questionquiz);
            $entityManager->flush();

            return $this->redirectToRoute('quiz_show', ['id' => $questionquiz->getIdQuiz()->getId() ] );
        }

        return $this->render('questionquiz/new.html.twig', [
            'questionquiz' => $questionquiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="questionquiz_show", methods={"GET"})
     */
    public function show(Questionquiz $questionquiz): Response
    {
        return $this->render('questionquiz/show.html.twig', [
            'questionquiz' => $questionquiz,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="questionquiz_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Questionquiz $questionquiz): Response
    {
        $form = $this->createForm(QuestionquizType::class, $questionquiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('quiz_show', ['id' => $questionquiz->getIdQuiz()->getId() ] );
        }

        return $this->render('questionquiz/edit.html.twig', [
            'questionquiz' => $questionquiz,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="questionquiz_delete", methods={"POST"})
     */
    public function delete(Request $request, Questionquiz $questionquiz): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionquiz->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($questionquiz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('quiz_show', ['id' => $questionquiz->getIdQuiz()->getId() ] );
    }
}
