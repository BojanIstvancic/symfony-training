<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $movie = new Movie();
    $movie->setTitle('The Dark Knight');
    $movie->setYear(2008);
    $movie->setDescription('This is the description of the Dark Knight');
    $movie->setImagePath('https://cdn.pixabay.com/photo/2018/04/25/08/59/super-heroes-3349031_960_720.jpg');
    //add data to pivot table
    $movie->addActor($this->getReference('actor_1'));
    $movie->addActor($this->getReference('actor_2'));
    $manager->persist($movie);

    $movie1 = new Movie();
    $movie1->setTitle('Avengers: Endgame');
    $movie1->setYear(2019);
    $movie1->setDescription('This is the description of Avengers');
    $movie1->setImagePath('https://cdn.pixabay.com/photo/2022/04/26/08/44/cosplay-7157777_960_720.jpg');
    $movie1->addActor($this->getReference('actor_3'));
    $movie1->addActor($this->getReference('actor_4'));
    $manager->persist($movie1);

    $manager->flush();
  }
}
