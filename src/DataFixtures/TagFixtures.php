<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 25; $i++) {
            $tag = new Tag();

            $tag->setSlug('tag-' . $i);
            $tag->setTitle('Meal Tag ' . $i);

            $manager->persist($tag);
            $this->addReference("tag_$i", $tag);

        }
        $manager->flush();
    }
}
