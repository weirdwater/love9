<?php
$sql = "-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema " . DB_NAME . "
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema " . DB_NAME . "
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `" . DB_NAME . "` ;

-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`States`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`States` (
  `stateId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `code` VARCHAR(2) NOT NULL,
  `inUS` TINYINT(1) NOT NULL,
  PRIMARY KEY (`stateId`)),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`EyeColors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`EyeColors` (
  `eyeColorId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`eyeColorId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`HairColors`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`HairColors` (
  `hairColorId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`hairColorId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`People`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`People` (
  `personId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `surname` VARCHAR(45) NOT NULL,
  `dob` DATE NOT NULL,
  `sex` VARCHAR(1) NOT NULL,
  `preferredSex` VARCHAR(1) NOT NULL,
  `bio` TEXT(500) NULL,
  `city` VARCHAR(45) NULL,
  `stateId` INT NOT NULL,
  `eyeColorId` INT NOT NULL,
  `hairColorId` INT NOT NULL,
  `height` INT NULL,
  PRIMARY KEY (`personId`),
  INDEX `fk_People_States_idx` (`stateId` ASC),
  INDEX `fk_People_EyeColors1_idx` (`eyeColorId` ASC),
  INDEX `fk_People_HairColors1_idx` (`hairColorId` ASC),
  CONSTRAINT `fk_People_States`
    FOREIGN KEY (`stateId`)
    REFERENCES `" . DB_NAME . "`.`States` (`stateId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_People_EyeColors1`
    FOREIGN KEY (`eyeColorId`)
    REFERENCES `" . DB_NAME . "`.`EyeColors` (`eyeColorId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_People_HairColors1`
    FOREIGN KEY (`hairColorId`)
    REFERENCES `" . DB_NAME . "`.`HairColors` (`hairColorId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Users` (
  `userId` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(254) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `verified` TINYINT(1) NOT NULL,
  `ip` VARCHAR(45) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `People_personId` INT NULL,
  PRIMARY KEY (`userId`),
  INDEX `fk_Users_People1_idx` (`People_personId` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  CONSTRAINT `fk_Users_People1`
    FOREIGN KEY (`People_personId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Comments` (
  `commentId` INT NOT NULL AUTO_INCREMENT,
  `body` TEXT(300) NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `seen` TINYINT(1) NULL,
  `fromPersonId` INT NOT NULL,
  `toPersonId` INT NOT NULL,
  PRIMARY KEY (`commentId`),
  INDEX `fk_Comments_People1_idx` (`fromPersonId` ASC),
  INDEX `fk_Comments_People2_idx` (`toPersonId` ASC),
  CONSTRAINT `fk_Comments_People1`
    FOREIGN KEY (`fromPersonId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comments_People2`
    FOREIGN KEY (`toPersonId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Interests`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Interests` (
  `interestId` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`interestId`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Interests_has_People`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Interests_has_People` (
  `Interests_interestId` INT NOT NULL,
  `People_personId` INT NOT NULL,
  `likes` TINYINT(1) NOT NULL,
  PRIMARY KEY (`Interests_interestId`, `People_personId`),
  INDEX `fk_Interests_has_People_People1_idx` (`People_personId` ASC),
  INDEX `fk_Interests_has_People_Interests1_idx` (`Interests_interestId` ASC),
  CONSTRAINT `fk_Interests_has_People_Interests1`
    FOREIGN KEY (`Interests_interestId`)
    REFERENCES `" . DB_NAME . "`.`Interests` (`interestId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Interests_has_People_People1`
    FOREIGN KEY (`People_personId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Favorites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Favorites` (
  `personId` INT NOT NULL,
  `favoritedPersonId` INT NOT NULL,
  PRIMARY KEY (`personId`, `favoritedPersonId`),
  INDEX `fk_People_has_People_People2_idx` (`favoritedPersonId` ASC),
  INDEX `fk_People_has_People_People1_idx` (`personId` ASC),
  CONSTRAINT `fk_People_has_People_People1`
    FOREIGN KEY (`personId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_People_has_People_People2`
    FOREIGN KEY (`favoritedPersonId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Ratings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Ratings` (
  `personId` INT NOT NULL,
  `raterId` INT NOT NULL,
  `score` INT NOT NULL,
  PRIMARY KEY (`personId`, `raterId`),
  INDEX `fk_People_has_People_People4_idx` (`raterId` ASC),
  INDEX `fk_People_has_People_People3_idx` (`personId` ASC),
  CONSTRAINT `fk_People_has_People_People3`
    FOREIGN KEY (`personId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_People_has_People_People4`
    FOREIGN KEY (`raterId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `" . DB_NAME . "`.`Ratings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`Ratings` (
  `personId` INT NOT NULL,
  `raterId` INT NOT NULL,
  `score` INT NOT NULL,
  PRIMARY KEY (`personId`, `raterId`),
  INDEX `fk_People_has_People_People4_idx` (`raterId` ASC),
  INDEX `fk_People_has_People_People3_idx` (`personId` ASC),
  CONSTRAINT `fk_People_has_People_People3`
    FOREIGN KEY (`personId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_People_has_People_People4`
    FOREIGN KEY (`raterId`)
    REFERENCES `" . DB_NAME . "`.`People` (`personId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `" . DB_NAME . "`.`States`
-- -----------------------------------------------------
START TRANSACTION;
USE `" . DB_NAME . "`;
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Alabama', 'AL', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Alaska', 'AK', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Arizona', 'AZ', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Arkansas', 'AR', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('California', 'CA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Colorado', 'CO', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Connecticut', 'CT', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Delaware', 'DE', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Florida', 'FL', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Georgia', 'GA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Hawaii', 'HI', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Idaho', 'ID', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Illinois', 'IL', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Indiana', 'IN', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Iowa', 'IA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Kansas', 'KS', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Kentucky', 'KY', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Louisiana', 'LA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Maine', 'ME', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Maryland', 'MD', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Massachusetts', 'MA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Michigan', 'MI', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Minnesota', 'MN', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Mississippi', 'MS', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Missouri', 'MO', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Montanna', 'MT', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Nebraska', 'NE', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Nevada', 'NV', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('New Hampshire', 'NH', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('New Jersey', 'NJ', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('New Mexico', 'NM', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('New York', 'NY', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('North Carolina', 'NC', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('North Dakota', 'ND', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Ohio', 'OH', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Oklahoma', 'OK', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Oregon', 'OR', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Pennsylvania', 'PA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Rhode Island', 'RI', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('South Carolina', 'SC', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Tennessee', 'TN', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Texas', 'TX', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Utah', 'UT', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Vermont', 'VT', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Virginia', 'VA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Washington', 'WA', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('West Verginia', 'WV', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Wisonsin', 'WI', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES (, 'Wyoming', 'WY', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('American Samoa', 'AS', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('District of Colombia', 'DC', TRUE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Federated States of Micronesia', 'FM', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Guam', 'GU', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Marshall Islands', 'MH', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Northern Marshall Islands', 'MP', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Palau', 'PW', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Puerto Rico', 'PR', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Virgin Islands', 'VI', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('Netherlands, the', 'NL', FALSE);
INSERT INTO `" . DB_NAME . "`.`States` (`name`, `code`, `inUS`) VALUES ('United Kingdom, the', 'UK', FALSE);

COMMIT;


-- -----------------------------------------------------
-- Data for table `" . DB_NAME . "`.`EyeColors`
-- -----------------------------------------------------
START TRANSACTION;
USE `" . DB_NAME . "`;
INSERT INTO `" . DB_NAME . "`.`EyeColors` (`name`) VALUES ('Amber');
INSERT INTO `" . DB_NAME . "`.`EyeColors` (`name`) VALUES ('Blue');
INSERT INTO `" . DB_NAME . "`.`EyeColors` (`name`) VALUES ('Brown');
INSERT INTO `" . DB_NAME . "`.`EyeColors` (`name`) VALUES ('Gray');
INSERT INTO `" . DB_NAME . "`.`EyeColors` (`name`) VALUES ('Green');
INSERT INTO `" . DB_NAME . "`.`EyeColors` (`name`) VALUES ('Hazel');

COMMIT;


-- -----------------------------------------------------
-- Data for table `" . DB_NAME . "`.`HairColors`
-- -----------------------------------------------------
START TRANSACTION;
USE `" . DB_NAME . "`;
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Black');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Brown');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Blond');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Auburn');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Chestnut');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Red');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('Gray');
INSERT INTO `" . DB_NAME . "`.`HairColors` (`name`) VALUES ('White');

COMMIT;";
