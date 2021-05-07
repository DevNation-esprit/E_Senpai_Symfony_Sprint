<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        return new JsonResponse($json, 200);
    }

    /**
     * @Route("/users_api_add", name="users_api_add")
     */
    public function addUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $content=$request->getContent();
        $data=$serializer->deserialize($content,User::class,'json');
        if($data instanceof \App\Entity\User){
            $data->setPassword($passwordEncoder->encodePassword(
                $data,
                $data->getPassword()
            ));
            $em->persist($data);
            $em->flush();
            $users = $this->getDoctrine()
                ->getRepository(User::class)
                ->findBy(array('email' => $data->getEmail()));
            
                foreach($users as $user){
                    $id = $user->getId();
                }
            return new JsonResponse('ID : '.$id, 200);
        }
        else{
            return new JsonResponse('Not Success', 200);
        }
       
    }

    /**
     * @Route("/user_auth", name="user_auth")
     */
    public function authUser(Request $request, SerializerInterface $serializer, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $content=$request->getContent();
        $ch= substr($content,11);
        $final=substr($ch,1,-4);
        $pos=strpos($final,'"');

        $emailSent=substr($final,0,$pos);
        $passwordSent=substr($final,$pos+16,strlen($final));

        $exist=false;
        $passTrue=false;
        $id=0;
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('email' => $emailSent));
        
        foreach($users as $user){
            $myemail = $user->getEmail();
            $mypassword = $user->getPassword();
            $exist=true;
            $passTrue=$passwordEncoder->isPasswordValid($user, $passwordSent);
            $id = $user->getId();
        }
        
        if($exist==true && $passTrue==true)
        {
            $ok="ok";
        }
        else{
            $ok="not ok";
        }
        
        return new JsonResponse($ok, 200);
    }

    /**
     * @Route("/users_api_edit", name="users_api_edit")
     */
    public function editUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $content=$request->getContent();
        $data=$serializer->deserialize($content,User::class,'json');

        $ch=substr($content,8);
        $pos=strpos($ch,',');
        $idSent=substr($ch,0,$pos);

        if($data instanceof \App\Entity\User){
            $conn=$em->getConnection();
            $data->setPassword($passwordEncoder->encodePassword(
                $data,
                $data->getPassword()
            ));
            $sql='UPDATE User SET nom=:nom, prenom=:prenom, date_naissance=:date_naissance, sexe=:sexe, email=:email,login=:login, password=:password, photo_profil=:photo_profil, biography=:biography, curriculum_vitae=:cv WHERE id=:id';
            $stmt = $conn->prepare($sql);
            $stmt->execute(['nom' => $data->getNom(), 'prenom' => $data->getPrenom(),'date_naissance' => $data->getDateNaissance(),'sexe' => $data->getSexe(),'email' => $data->getEmail(),'login' => $data->getEmail(),'password' => $data->getPassword(),'photo_profil' => $data->getPhotoProfil(),'biography' => $data->getBiography(),'cv' => $data->getCurriculumVitae(),'id' => (int) $idSent]);
            return new JsonResponse("Success", 200);
        }
        else{
            return new JsonResponse('Not Success', 200);
        }
       
    }
}
