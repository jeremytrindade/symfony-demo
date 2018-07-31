<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <=10; $i++){
            $article = new Article();
            $article->setTitle("Titre de l'article nº$i")
                    ->setContent("<p>Contenu de l'article nº$i")
                    ->setImage("http://placehold.it/350x150")
                    ->setCreateAt(new \DateTime());
                    
            $manager->persist($article);
        }

        $manager->flush();
    }
}
