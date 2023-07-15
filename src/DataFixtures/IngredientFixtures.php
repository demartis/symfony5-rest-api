<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 20; $i++) {
            $ingredient = new Ingredient();

            $ingredient->setSlug('ingredient-' . $i);
            $ingredient->setTitle('Ingredient name ' . $i);


            $manager->persist($ingredient);
            $this->addReference("ingredient_$i", $ingredient);

        }

        $manager->flush();
    }
}
