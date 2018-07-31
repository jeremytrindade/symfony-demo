<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;


class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        /*$repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find(12);
        $article = $repo->findOneByTitle('Titre de l\'article');
        $articles = $repo->findByTitle('Titre de l\'article');*/
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render('blog/home.html.twig',[
            'title' => "Bienvenue ici les amis !",
            'age' => 25 
        ]);
    }
    
    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager){
        if(!$article) {
            $article = new Article();
        }

        /* E para ser ainda menos trabalho
        $form = $this->createFormBuilder($article)
                     /*->add('title', TextType::class,[
                         'attr' => [
                             'placeholder' => "Titre de l'article"/*,
                             'class' => 'form-control'*//*
                         ]
                     ])
                     ->add('content', TextareaType::class,[
                         'attr' => [
                             'placeholder' => "Contenu de l'article"
                         ]
                     ])
                     ->add('image', TextType::class, [
                         'attr' => [
                             'placeholder' => "Image de l'article"
                         ]
                     ]) *//*
                     ->add('save', SubmitType::class,[
                         'label' => 'Enregister'
                     ])*/
                     /* E para ser ainda menos trabalho
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();
                     */
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }

            $manager->persist($article);
            $manager->flush();
            
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
        
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article){
    /*public function show(ArticleRepository $repo, $id){
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);*/
        return $this->render('blog/show.html.twig',[
            'article' => $article
        ]);
    }

    


}
