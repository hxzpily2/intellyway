SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `amji` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `amji`;

-- -----------------------------------------------------
-- Table `amji`.`amji_statut`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_statut` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_statut` (
  `idamji_statut` INT NOT NULL ,
  `libelle` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`idamji_statut`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_user` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_user` (
  `idamji_user` INT NOT NULL AUTO_INCREMENT ,
  `pseudo` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `nom` VARCHAR(100) NOT NULL ,
  `prenom` VARCHAR(100) NOT NULL ,
  `adr` VARCHAR(100) NULL ,
  `tel` VARCHAR(100) NULL ,
  `etudiant` BOOLEAN NULL ,
  `ecole` VARCHAR(100) NULL ,
  `niveau` VARCHAR(100) NULL ,
  `salarie` BOOLEAN NULL ,
  `statut` VARCHAR(100) NULL ,
  `societe` VARCHAR(100) NULL ,
  `idamji_statut` INT NULL ,
  PRIMARY KEY (`idamji_user`) ,
  INDEX `fk_amji_user_amji_statut` (`idamji_statut` ASC) ,
  CONSTRAINT `fk_amji_user_amji_statut`
    FOREIGN KEY (`idamji_statut` )
    REFERENCES `amji`.`amji_statut` (`idamji_statut` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_type` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_type` (
  `idamji_type` INT NOT NULL AUTO_INCREMENT ,
  `libelle` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`idamji_type`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_priorite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_priorite` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_priorite` (
  `idamji_priorite` INT NOT NULL AUTO_INCREMENT ,
  `libelle` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`idamji_priorite`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_invitation` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_invitation` (
  `idamji_user` INT NOT NULL ,
  `idamji_invite` INT NOT NULL ,
  `message` TEXT NOT NULL ,
  PRIMARY KEY (`idamji_user`, `idamji_invite`) ,
  INDEX `fk_amji_user_has_amji_user_amji_user` (`idamji_user` ASC) ,
  INDEX `fk_amji_user_has_amji_user_amji_user1` (`idamji_invite` ASC) ,
  CONSTRAINT `fk_amji_user_has_amji_user_amji_user`
    FOREIGN KEY (`idamji_user` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_user_has_amji_user_amji_user1`
    FOREIGN KEY (`idamji_invite` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `amji`.`amji_invitation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_invitation` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_invitation` (
  `idamji_user` INT NOT NULL ,
  `idamji_invite` INT NOT NULL ,
  `message` TEXT NOT NULL ,
  PRIMARY KEY (`idamji_user`, `idamji_invite`) ,
  INDEX `fk_amji_user_has_amji_user_amji_user` (`idamji_user` ASC) ,
  INDEX `fk_amji_user_has_amji_user_amji_user1` (`idamji_invite` ASC) ,
  CONSTRAINT `fk_amji_user_has_amji_user_amji_user`
    FOREIGN KEY (`idamji_user` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_user_has_amji_user_amji_user1`
    FOREIGN KEY (`idamji_invite` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `amji`.`amji_file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_file` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_file` (
  `idamji_file` INT NOT NULL AUTO_INCREMENT ,
  `content` LONGBLOB NOT NULL ,
  PRIMARY KEY (`idamji_file`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_emoticones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_emoticones` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_emoticones` (
  `idamji_emoticones` INT NOT NULL AUTO_INCREMENT ,
  `racourci` VARCHAR(100) NOT NULL ,
  `image` VARCHAR(200) NOT NULL ,
  PRIMARY KEY (`idamji_emoticones`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_request`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_request` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_request` (
  `idamji_request` INT NOT NULL AUTO_INCREMENT ,
  `title` TEXT NOT NULL ,
  `content` TEXT NOT NULL ,
  `iduser` INT NOT NULL ,
  `idpriorite` INT NOT NULL ,
  `idtype` INT NOT NULL ,
  PRIMARY KEY (`idamji_request`) ,
  INDEX `fk_amji_request_amji_user` (`iduser` ASC) ,
  INDEX `fk_amji_request_amji_priorite` (`idpriorite` ASC) ,
  INDEX `fk_amji_request_amji_type` (`idtype` ASC) ,
  CONSTRAINT `fk_amji_request_amji_user`
    FOREIGN KEY (`iduser` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_request_amji_priorite`
    FOREIGN KEY (`idpriorite` )
    REFERENCES `amji`.`amji_priorite` (`idamji_priorite` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_request_amji_type`
    FOREIGN KEY (`idtype` )
    REFERENCES `amji`.`amji_type` (`idamji_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_response`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_response` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_response` (
  `idamji_response` INT NOT NULL AUTO_INCREMENT ,
  `content` TEXT NOT NULL ,
  `iduser` INT NOT NULL ,
  `idrequest` INT NOT NULL ,
  `idresponse` INT NULL ,
  PRIMARY KEY (`idamji_response`) ,
  INDEX `fk_amji_response_amji_user` (`iduser` ASC) ,
  INDEX `fk_amji_response_amji_request` (`idrequest` ASC) ,
  INDEX `fk_amji_response_amji_response` (`idresponse` ASC) ,
  CONSTRAINT `fk_amji_response_amji_user`
    FOREIGN KEY (`iduser` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_response_amji_request`
    FOREIGN KEY (`idrequest` )
    REFERENCES `amji`.`amji_request` (`idamji_request` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_response_amji_response`
    FOREIGN KEY (`idresponse` )
    REFERENCES `amji`.`amji_response` (`idamji_response` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`amji_subscribe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_subscribe` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_subscribe` (
  `idamji_user` INT NOT NULL ,
  `idamji_type` INT NOT NULL ,
  PRIMARY KEY (`idamji_user`, `idamji_type`) ,
  INDEX `fk_amji_user_has_amji_type_amji_user` (`idamji_user` ASC) ,
  INDEX `fk_amji_user_has_amji_type_amji_type` (`idamji_type` ASC) ,
  CONSTRAINT `fk_amji_user_has_amji_type_amji_user`
    FOREIGN KEY (`idamji_user` )
    REFERENCES `amji`.`amji_user` (`idamji_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_user_has_amji_type_amji_type`
    FOREIGN KEY (`idamji_type` )
    REFERENCES `amji`.`amji_type` (`idamji_type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `amji`.`amji_response_attachment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_response_attachment` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_response_attachment` (
  `idamji_response` INT NOT NULL ,
  `idamji_file` INT NOT NULL ,
  PRIMARY KEY (`idamji_response`, `idamji_file`) ,
  INDEX `fk_amji_response_has_amji_file_amji_response` (`idamji_response` ASC) ,
  INDEX `fk_amji_response_has_amji_file_amji_file` (`idamji_file` ASC) ,
  CONSTRAINT `fk_amji_response_has_amji_file_amji_response`
    FOREIGN KEY (`idamji_response` )
    REFERENCES `amji`.`amji_response` (`idamji_response` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_response_has_amji_file_amji_file`
    FOREIGN KEY (`idamji_file` )
    REFERENCES `amji`.`amji_file` (`idamji_file` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `amji`.`amji_request_attachment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`amji_request_attachment` ;

CREATE  TABLE IF NOT EXISTS `amji`.`amji_request_attachment` (
  `idamji_file` INT NOT NULL ,
  `idamji_request` INT NOT NULL ,
  PRIMARY KEY (`idamji_file`, `idamji_request`) ,
  INDEX `fk_amji_file_has_amji_request_amji_file` (`idamji_file` ASC) ,
  INDEX `fk_amji_file_has_amji_request_amji_request` (`idamji_request` ASC) ,
  CONSTRAINT `fk_amji_file_has_amji_request_amji_file`
    FOREIGN KEY (`idamji_file` )
    REFERENCES `amji`.`amji_file` (`idamji_file` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_amji_file_has_amji_request_amji_request`
    FOREIGN KEY (`idamji_request` )
    REFERENCES `amji`.`amji_request` (`idamji_request` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
