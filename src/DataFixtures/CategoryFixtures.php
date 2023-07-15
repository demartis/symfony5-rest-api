<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 10; $i++) {
            $category = new Category();

            $category->setSlug('category-' . $i);
            $category->setTitle('Meal Category ' . $i);

            $manager->persist($category);
            $this->addReference("category_$i", $category);

        }

        $manager->flush();
    }
}
