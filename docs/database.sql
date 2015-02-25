SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `exam` ;
CREATE SCHEMA IF NOT EXISTS `exam` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `exam` ;

-- -----------------------------------------------------
-- Table `exam`.`Exam`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exam`.`Exam` ;

CREATE TABLE IF NOT EXISTS `exam`.`Exam` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `slug_UNIQUE` (`slug` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exam`.`Question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exam`.`Question` ;

CREATE TABLE IF NOT EXISTS `exam`.`Question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `exam_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `choice_id` INT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  `slug` VARCHAR(25) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Question_1_idx` (`exam_id` ASC),
  CONSTRAINT `fk_Question_1`
    FOREIGN KEY (`exam_id`)
    REFERENCES `exam`.`Exam` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exam`.`Choice`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exam`.`Choice` ;

CREATE TABLE IF NOT EXISTS `exam`.`Choice` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Option_1_idx` (`question_id` ASC),
  CONSTRAINT `fk_Option_1`
    FOREIGN KEY (`question_id`)
    REFERENCES `exam`.`Question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exam`.`Apply`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exam`.`Apply` ;

CREATE TABLE IF NOT EXISTS `exam`.`Apply` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `exam_id` INT NOT NULL,
  `user` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Apply_1_idx` (`exam_id` ASC),
  CONSTRAINT `fk_Apply_1`
    FOREIGN KEY (`exam_id`)
    REFERENCES `exam`.`Exam` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `exam`.`Attempt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `exam`.`Attempt` ;

CREATE TABLE IF NOT EXISTS `exam`.`Attempt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `apply_id` INT NOT NULL,
  `choice_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Try_1_idx` (`apply_id` ASC),
  INDEX `fk_Try_2_idx` (`choice_id` ASC),
  CONSTRAINT `fk_Try_1`
    FOREIGN KEY (`apply_id`)
    REFERENCES `exam`.`Apply` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Try_2`
    FOREIGN KEY (`choice_id`)
    REFERENCES `exam`.`Choice` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
