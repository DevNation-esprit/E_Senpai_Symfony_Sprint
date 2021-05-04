<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class UsersApiController extends AbstractController
{
    /**
     * @Route("/users_api", name="users_api")
     */
    public function getUsers(SerializerInterface $serializer): Response
    {
        $donnees = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        $json = $serializer->serialize($donnees,'json',['groups'=>'user']);
        dump($json);
        die;
    }

    /**
     * @Route("/users_api_add", name="users_api_add")
     */
    public function addUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): Response
    {
        $content=$request->getContent();
        $data=$serializer->deserialize($content,User::class,'json');
        $em->persist($data);
        $em->flush();
        return new Response('Utilisateur ajouté avec succés');
    }
}
