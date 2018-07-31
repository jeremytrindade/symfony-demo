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
     */
    public function create(Request $request, ObjectManager $manager){
        $article = new Article();

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
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();
        
        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView()
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
