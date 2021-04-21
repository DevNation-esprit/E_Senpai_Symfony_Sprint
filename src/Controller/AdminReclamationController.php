<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Form\RepondreReclamationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class AdminReclamationController extends AbstractController
{
    /**
     * @Route("/admin/reclamation", name="admin_reclamation")
     */
    public function reclamation(): Response
    {
        $reclamations = $this->getDoctrine()
        ->getRepository(Reclamation::class)
        ->findAll();
        return $this->render('admin_reclamation/admin_reclamation.html.twig',[
            'reclamations' => $reclamations
        ]);
    }

    /**
     * @Route("/admin/reclamation/{id}/reponse/{idu}", name="admin_reclamation_reponse")
     * @Entity("user", expr="repository.find(idu)")
     */
    public function repoReclamation(Reclamation $reclamation, User $user, Request $request): Response
    {
        $form = $this->createForm(RepondreReclamationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setStatut("Résolue");
            $reclamation->setAdminTrait($user->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_reclamation');
        }
        return $this->render('admin_reclamation/repondre_reclamation.html.twig',[
            'reclamation' => $reclamation,
            'form' =>$form->createView()
        ]);
    }
}
