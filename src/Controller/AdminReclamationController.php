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
    public function repoReclamation(Reclamation $reclamation, User $user, Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(RepondreReclamationType::class);
        $form->handleRequest($request);
        $receiver = $this->getDoctrine()
        ->getRepository(User::class)
        ->findBy(array('id' => $reclamation->getIdUser()->getId()));

        if ($form->isSubmitted() && $form->isValid()) {

            $rep = $form->getData();

            $message = (new \Swift_Message('Réponse Réclamation'))
                        ->setFrom('esenpai.devnation@gmail.com')
                        ->setTo($receiver[0]->getEmail())
                        ->setBody($rep['reponse']);
            
            $mailer->send($message);

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
