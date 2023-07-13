<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230712120340 extends AbstractMigration
{
    //rework migration to create db with tables and relations
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
        
        SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
        SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
        SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

        CREATE SCHEMA IF NOT EXISTS `foods` DEFAULT CHARACTER SET utf8 ;
        USE `foods` ;
        
        
        CREATE TABLE IF NOT EXISTS `foods`.`ingredient` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(255) NOT NULL,
          `slug` VARCHAR(255) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
        ENGINE = InnoDB;

        
        CREATE TABLE IF NOT EXISTS `foods`.`category` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(255) NOT NULL,
          `slug` VARCHAR(255) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
        ENGINE = InnoDB;
        
        
        CREATE TABLE IF NOT EXISTS `foods`.`meal` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(45) NOT NULL,
          `description` VARCHAR(45) NOT NULL,
          `status` VARCHAR(45) NOT NULL,
          `created_at` DATETIME NULL,
          `deleted_at` DATETIME NULL,
          `updated_at` VARCHAR(45) NULL,
          `category_id` INT NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
          INDEX `fk_meal_category1_idx` (`category_id` ASC) VISIBLE,
          CONSTRAINT `fk_meal_category1`
            FOREIGN KEY (`category_id`)
            REFERENCES `foods`.`category` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;

        
        CREATE TABLE IF NOT EXISTS `foods`.`language` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `name` VARCHAR(45) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
        ENGINE = InnoDB;
        
        
        CREATE TABLE IF NOT EXISTS `foods`.`translation` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `key` VARCHAR(255) NOT NULL,
          `value` VARCHAR(255) NOT NULL,
          `language_id` INT NOT NULL,
          PRIMARY KEY (`id`, `language_id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE,
          INDEX `fk_translation_language_idx` (`language_id` ASC) VISIBLE,
          CONSTRAINT `fk_translation_language`
            FOREIGN KEY (`language_id`)
            REFERENCES `foods`.`language` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;
        
        
        CREATE TABLE IF NOT EXISTS `foods`.`tag` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `title` VARCHAR(255) NOT NULL,
          `slug` VARCHAR(255) NOT NULL,
          PRIMARY KEY (`id`),
          UNIQUE INDEX `id_UNIQUE` (`id` ASC) VISIBLE)
        ENGINE = InnoDB;
       
        
        CREATE TABLE IF NOT EXISTS `foods`.`meal_has_ingredient` (
          `meal_id` INT NOT NULL,
          `ingredient_id` INT NOT NULL,
          PRIMARY KEY (`meal_id`, `ingredient_id`),
          INDEX `fk_meal_has_ingredient_ingredient1_idx` (`ingredient_id` ASC) VISIBLE,
          INDEX `fk_meal_has_ingredient_meal1_idx` (`meal_id` ASC) VISIBLE,
          CONSTRAINT `fk_meal_has_ingredient_meal1`
            FOREIGN KEY (`meal_id`)
            REFERENCES `foods`.`meal` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_meal_has_ingredient_ingredient1`
            FOREIGN KEY (`ingredient_id`)
            REFERENCES `foods`.`ingredient` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;
        

        CREATE TABLE IF NOT EXISTS `foods`.`meal_has_tag` (
          `meal_id` INT NOT NULL,
          `tag_id` INT NOT NULL,
          PRIMARY KEY (`meal_id`, `tag_id`),
          INDEX `fk_meal_has_tag_tag1_idx` (`tag_id` ASC) VISIBLE,
          INDEX `fk_meal_has_tag_meal1_idx` (`meal_id` ASC) VISIBLE,
          CONSTRAINT `fk_meal_has_tag_meal1`
            FOREIGN KEY (`meal_id`)
            REFERENCES `foods`.`meal` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
          CONSTRAINT `fk_meal_has_tag_tag1`
            FOREIGN KEY (`tag_id`)
            REFERENCES `foods`.`tag` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION)
        ENGINE = InnoDB;
        
        
        SET SQL_MODE=@OLD_SQL_MODE;
        SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("
        DROP TABLE IF EXISTS `foods`.`ingredient` ;
        DROP TABLE IF EXISTS `foods`.`category` ;
        DROP TABLE IF EXISTS `foods`.`meal` ;
        DROP TABLE IF EXISTS `foods`.`language` ;
        DROP TABLE IF EXISTS `foods`.`translation` ;
        DROP TABLE IF EXISTS `foods`.`tag` ;
        DROP TABLE IF EXISTS `foods`.`meal_has_ingredient` ;
        DROP TABLE IF EXISTS `foods`.`meal_has_tag` ;
        DROP SCHEMA IF EXISTS `foods` ;
        ");
    }
}
