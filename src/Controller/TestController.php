<?php

namespace App\Controller;

use App\Entity\Test;
use App\Entity\User;
use App\Entity\Questiontest ;
use App\Form\TestType;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use App\Repository\QuestiontestRepository ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/test")
 */
class TestController extends AbstractController
{
    /**
     * @Route("/{id}", name="test_index", methods={"GET"})
     */
    public function index(TestRepository $testRepository,$id): Response
    {
        return $this->render('test/index.html.twig', [
            'tests' => $testRepository->findBy(array('idFormateur'=> $id)),
        ]);
    }

    /**
     * @Route("/new/{id}", name="test_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id) ;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $test->setIdFormateur($user) ;
            $entityManager->persist($test);
            $entityManager->flush();

            return $this->redirectToRoute('test_index',['id' => $test->getIdFormateur()->getId() ] );
        }

        return $this->render('test/new.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="test_show", methods={"GET"})
     */
    public function show(Test $test): Response
    {
        return $this->render('test/show.html.twig', [
            'test' => $test,
            'questiontests' => $this->getDoctrine()->getRepository(QuestionTest::class)
                                ->findBy(array('idTest'=> $test->getId()))
        ]);
    }

    /**
     * @Route("/{id}/edit", name="test_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Test $test): Response
    {
        $form = $this->createForm(TestType::class, $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('test_index',['id' => $test->getIdFormateur()->getId() ] );
        }

        return $this->render('test/edit.html.twig', [
            'test' => $test,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="test_delete", methods={"POST"})
     */
    public function delete(Request $request, Test $test): Response
    {
        if ($this->isCsrfTokenValid('delete'.$test->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($test);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_index',['id' => $test->getIdFormateur()->getId() ] );
    }
}
