<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\Meal;
use App\Entity\MealHasIngredient;
use App\Entity\MealHasTag;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MealFixtures extends Fixture implements DependentFixtureInterface
{

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $numCategories = 10;

        for ($i = 1; $i <= 20; $i++) {
            $meal = new Meal();
            $meal->setTitle("Meal Name $i");
            $meal->setDescription($this->generateDescription($i));
            $meal->setStatus("created");
            $meal->setCreatedAt(new \DateTime());
            // Set random category (1 in 3 meals won't have a category)
            if ($i % 3 !== 0) {
                /** @var Category $category */
                $categoryId = ($i - 1) % $numCategories + 1;
                $category = $this->getReference("category_$categoryId");
                $meal->setCategory($category);
            }
            $manager->persist($meal);

            // Generate random number of tags (1-3)
            $numTags = mt_rand(1, 3);
            for ($j = 1; $j <= $numTags; $j++) {
                /** @var Tag $tag */
                $tag = $this->getReference("tag_" . mt_rand(1, 10));
                $mealHasTag = new MealHasTag();
                $mealHasTag->setMeal($meal);
                $mealHasTag->setTag($tag);
                $manager->persist($mealHasTag);
            }

            // Generate random number of ingredients (1-3)
            $numIngredients = mt_rand(1, 3);
            for ($k = 1; $k <= $numIngredients; $k++) {
                /** @var Ingredient $ingredient */
                $ingredient = $this->getReference("ingredient_" . mt_rand(1, 10));
                $mealHasIngredient = new MealHasIngredient();
                $mealHasIngredient->setMeal($meal);
                $mealHasIngredient->setIngredient($ingredient);
                $manager->persist($mealHasIngredient);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            TagFixtures::class,
            IngredientFixtures::class,
        ];
    }

    private function generateDescription($index)
    {
        $faker = Factory::create();
        $faker->seed(1111);

        return $faker->text(40) . ' - ' . $index;
    }
}
