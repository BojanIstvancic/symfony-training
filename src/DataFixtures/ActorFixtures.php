<?php

namespace App\DataFixtures;

use App\Entity\Actors;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actor = new Actors();
        $actor->setName('Cristian Bale');
        $manager->persist($actor);

        $actor2 = new Actors();
        $actor2->setName('Heath Ledger');
        $manager->persist($actor2);

        $actor3 = new Actors();
        $actor3->setName('Rovert Downey Jr');
        $manager->persist($actor3);

        $actor4 = new Actors();
        $actor4->setName('Chris Evans');
        $manager->persist($actor4);

        $manager->flush();

        // add data to pivot table
        $this->addReference('actor_1', $actor);
        $this->addReference('actor_2', $actor2);
        $this->addReference('actor_3', $actor3);
        $this->addReference('actor_4', $actor4);
    }
}
