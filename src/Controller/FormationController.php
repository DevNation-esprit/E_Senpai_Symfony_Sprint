<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Slide;
use App\Entity\User;
use App\Form\FormationType;
use App\Form\SlideType;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/indexmesform/{id}", name="formation_mesformindex", methods={"GET","POST"})
     */
    public function mesFormation( $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Formation::class);
        $formations = $repo->findBy(array('idFormateur' =>$id));

        return $this->render('formation/index.html.twig', [
            'formations' => $formations,

        ]);
    }
    
    /**
     * @Route("/indexform", name="formation_index", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->findAll();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        if($request ->isMethod("POST")){
            $titre = $request->get("titre");
            if(!empty($titre)) {
                $formations = $entityManager->getRepository(Formation::class)->findBy(array('titre' => $titre));
            }else{
                $formations = $this->getDoctrine()
                    ->getRepository(Formation::class)
                    ->findAll();
            }
        }
        return $this->render('formation/showforms.html.twig', [
            'formations' => $formations,
            'users'=>$user,
        ]);
    }
    /**
     * @Route("/accueilForm", name="accueil_Form", methods={"GET"})
     */
    public function accueilFormation(): Response
    {


        return $this->render('formation/accueilformation.html.twig', [

        ]);
    }
    /**
     * @Route("/new/{id}", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
            $entityManager = $this->getDoctrine()->getManager();
            $formation->setNote(0);
            $formation->setIdFormateur($user);
            $formation->setDescription("");
            $formation->setTitre("");
            $entityManager->persist($formation);
            $entityManager->flush();
        return $this->redirectToRoute('formation_create', ['id' => $formation->getId()]);
        if ($form->isSubmitted() && $form->isValid()) {
            $form = $this->createForm(FormationType::class, $formation);
            $form->handleRequest($request);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showSingleForm/{id}", name="formation_showsingleform", methods={"GET"})
     */
    public function show(Formation $formation ): Response
    {
       $idUser = $formation->getIdFormateur();
        $user = $this->getDoctrine()->getRepository(User::class)->find($idUser);
        $repo = $this->getDoctrine()->getRepository(Slide::class);
        $slide = $repo->findBy(array('idFormation' =>$formation));
        return $this->render('formation/showsingleform.html.twig', [
            'formation' => $formation,
            'slides'=>$slide,
            'user'=>$user,
        ]);
    }

    /**
     * @Route("/{id}/create", name="formation_create", methods={"GET","POST"})
     */
    public function editWithCreate(Request $request, Formation $formation): Response
    {
        $slide1 = $this->getDoctrine()->getRepository(Slide::class)->findBy(array('idFormation' => $formation));

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        $slide = new Slide();
        $form2 = $this->createForm(SlideType::class, $slide);
        $form2->handleRequest($request);
            if (($form->isSubmitted() && $form->isValid())) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('formation_index');
        }
        $form1 = $this->createForm(SlideType::class, $slide);
        $form1->handleRequest($request);
        if ($form1->isSubmitted()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form1['imageFile']->getData();

            if( $uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/img/formcontenu';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(),PATHINFO_FILENAME);
                #file name
                $newFilename = $originalFilename.'.'.$uploadedFile->guessExtension();
                $e=$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename

                );
                if($e == 'jpg' ||$e == 'png' || $e == 'jpeg'){
                $slide->setImageSlide($newFilename);
                    $slide->setVideoSlide("");
                    $slide->setIdFormation($formation);
                    $slide->setTextSlide("");
                    $slide->setOrdre(0);
                }elseif($e == 'mp4'){
                    $slide->setVideoSlide($newFilename);
                    $slide->setImageSlide("");
                    $slide->setIdFormation($formation);
                    $slide->setTextSlide("");
                    $slide->setOrdre(0);
                }else{
                    $slide->setTextSlide($newFilename);
                    $slide->setImageSlide("");
                    $slide->setIdFormation($formation);
                    $slide->setVideoSlide("");
                    $slide->setOrdre(0);
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($slide);
            $entityManager->flush();
            return $this->redirectToRoute('formation_create',['id' => $formation->getId()]);
        }
        return $this->render('formation/editCreate.html.twig', [
            'formation' => $formation,
            'slide'=> $slide,
            'form' => $form->createView(),
            'form1'=> $form2->createView(),
            'slides' => $slide1
        ]);
    }
    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $slide1 = $this->getDoctrine()->getRepository(Slide::class)->findBy(array('idFormation' => $formation));
        $slide = new Slide();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        $form1 = $this->createForm(SlideType::class, $slide);
        $form1->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_index');
        }
        if ($form1->isSubmitted()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form1['imageFile']->getData();

            if( $uploadedFile){
                $destination = $this->getParameter('kernel.project_dir').'/public/img/formcontenu';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(),PATHINFO_FILENAME);
                #file name
                $newFilename = $originalFilename.'.'.$uploadedFile->guessExtension();
                $e=$uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename

                );
                if($e == 'jpg' ||$e == 'png' || $e == 'jpeg'){
                    $slide->setImageSlide($newFilename);
                    $slide->setVideoSlide("");
                    $slide->setIdFormation($formation);
                    $slide->setTextSlide("");
                    $slide->setOrdre(0);
                }elseif($e == 'mp4'){
                    $slide->setVideoSlide($newFilename);
                    $slide->setImageSlide("");
                    $slide->setIdFormation($formation);
                    $slide->setTextSlide("");
                    $slide->setOrdre(0);
                }else{
                    $slide->setTextSlide($newFilename);
                    $slide->setImageSlide("");
                    $slide->setIdFormation($formation);
                    $slide->setVideoSlide("");
                    $slide->setOrdre(0);
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($slide);
            $entityManager->flush();

            return $this->redirectToRoute('formation_edit',['id' => $formation->getId()]);
        }


        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
            'form1'=> $form1->createView(),
            'slides' => $slide1
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $slides = $entityManager->getRepository(Slide::class)->findBy(array('idFormation' => $formation));
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager1 = $this->getDoctrine()->getManager();
            foreach ($slides as $slide){
            $entityManager1->remove($slide);
            }
            $entityManager1->flush();
            $entityManager2 = $this->getDoctrine()->getManager();
            $entityManager2->remove($formation);
            $entityManager2->flush();

        }

        return $this->redirectToRoute('formation_index');
    }
    /**
     * @Route("/{id}", name="formation_showslide", methods={"POST"})
     */
    public function showSlide(Request $request, Slide $slide): Response
    {
        if ($this->isCsrfTokenValid('showslide'.$slide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }

    }
}
