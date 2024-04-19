-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema tasks
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `tasks` ;

-- -----------------------------------------------------
-- Schema tasks
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `tasks` DEFAULT CHARACTER SET utf8 ;
USE `tasks` ;

-- -----------------------------------------------------
-- Table `tasks`.`task`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tasks`.`task` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `status` ENUM('pendents', 'en execució', 'acabades') NOT NULL,
  `dateTimeStarted` DATETIME NULL,
  `dateTimeFinished` DATETIME NULL,
  `user` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
