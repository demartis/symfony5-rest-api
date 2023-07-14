<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="meal_has_tag")
 */
class MealHasTag
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Meal")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id", nullable=false)
     */
    private $meal;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id", nullable=false)
     */
    private $tag;
    
    public function getMeal(): ?Meal
    {
        return $this->meal;
    }

    public function setMeal(Meal $meal): void
    {
        $this->meal = $meal;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(Tag $tag): void
    {
        $this->tag = $tag;
    }
}
