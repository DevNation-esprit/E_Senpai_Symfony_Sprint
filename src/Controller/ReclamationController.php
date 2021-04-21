<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\AddReclamationType;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation/{id}", name="reclamation")
     */
    public function reclamation(User $user): Response
    {
        $reclamations = $this->getDoctrine()
        ->getRepository(Reclamation::class)
        ->findBy(array('idUserRec' => $user->getId()));
        return $this->render('reclamation/reclamation.html.twig',[
            'reclamations' => $reclamations
        ]);
    }

    /**
     * @Route("/reclamation/{id}/add", name="add_reclamation")
     */
    public function addReclamation(User $user, Request $request): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(AddReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setStatut("En attente");
            $reclamation->setAdminTrait(0);
            $reclamation->setIdUser($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reclamation', array('id' => $user->getId()));
        }
        return $this->render('reclamation/add_reclamation.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
