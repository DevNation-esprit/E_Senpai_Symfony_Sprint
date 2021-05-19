<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{

    /**
     * @Route("/addBlog/new" )
     */
    public function addBlog(Request $request , NormalizerInterface $normalizer){
        $em = $this->getDoctrine()->getManager();
        $Blog = new Blog();

        $Blog -> setTitre($request -> get('titre'));
        $Blog -> setContenu($request -> get('contenu'));


        $em->persist($Blog);
        $em->flush();
        $jsonContent = $normalizer->normalize($Blog,'json ');
        return new Response("Blog ajouté".json_encode($jsonContent));

    }

    /**
     * @Route("/", name="blog_index", methods={"GET"})
     */
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/Blogshow")
     */
    public function AllBlogs(NormalizerInterface $Normalizer){
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $Blog=$repository->findAll();
        $jsonContent = $Normalizer->normalize($Blog, 'json');
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/new", name="blog_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();
            $this->addFlash('success', 'Blog Ajouté');

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blog_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Blog modifié');

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_delete", methods={"POST"})
     */
    public function delete(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
            $this->addFlash('success', 'Blog supprimé');
        }

        return $this->redirectToRoute('blog_index');
    }


    /**
     * @Route ("/addResJSON/new" , name="addResJSON")
     */
    public function addResJSON(Request $request , NormalizerInterface $Normalizer) {
        $em = $this -> getDoctrine() -> getManager();
        $Blog = new Blog();

        $Blog -> setTitre($request -> get('titre'));
        $Blog -> setContenu($request -> get('contenu'));


        $em -> persist($Blog);
        $em -> flush();
        $jsonContent = $Normalizer -> normalize($Blog, 'json');
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/addnewBlog/new" , name="add")
     */
    public function addnewBlog(Request $request , NormalizerInterface $normalizer): Response
    {
        $em = $this->getDoctrine()->getManager();
        $Blog = new Blog();

        $Blog -> setTitre($request -> get('titre'));
        $Blog -> setContenu($request -> get('contenu'));


        $em->persist($Blog);
        $em->flush();
        $jsonContent = $normalizer->normalize($Blog,'json ');
        return new Response("Blog ajouté".json_encode($jsonContent));

    }

    /**
     * @Route ("/Blogshow")
     */
    public function AllPosts(NormalizerInterface $Normalizer): Response
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $Blog=$repository->findAll();
        $jsonContent = $Normalizer->normalize($Blog, 'json');
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/suppBlog/{id}")
     */
    public function deleteBlog (Request $request , NormalizerInterface $normalizer,$id){
        $em = $this->getDoctrine()->getManager();
        $Blog = $em->getRepository(Blog::class)->find($id);
        $em ->remove($Blog);
        $em->flush();
        $jsonContent = $normalizer->normalize($Blog,'json ');
        return new Response("Blog supprimé ".json_encode($jsonContent));

    }


    /**
     * @Route("/editBlog/{id}" , name="edit")
     */
    public function editBlog (Request $request , NormalizerInterface $normalizer,$id){
        $em = $this->getDoctrine()->getManager();
        $Blog = $em->getRepository(Blog::class)->find($id);

        $Blog -> setTitre($request -> get('titre'));
        $Blog -> setContenu($request -> get('contenu'));


        $em->flush();
        $jsonContent = $normalizer->normalize($Blog,'json ');
        return new Response("Blog modifié ".json_encode($jsonContent));

    }

}
