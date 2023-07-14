<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="meal_has_ingredient")
 */
class MealHasIngredient
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Meal")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id", nullable=false)
     */
    private $meal;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ingredient")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id", nullable=false)
     */
    private $ingredient;

    
    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(Meal $meal): void
    {
        $this->meal = $meal;
    }

    public function getIngredient(): ?Ingredient
    {
        return $this->ingredient;
    }

    public function setIngredient(Ingredient $ingredient): void
    {
        $this->ingredient = $ingredient;
    }
}
