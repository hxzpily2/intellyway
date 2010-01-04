SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `amji` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `amji`;

-- -----------------------------------------------------
-- Table `amji`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`user` ;

CREATE  TABLE IF NOT EXISTS `amji`.`user` (
  `email` VARCHAR(100) NOT NULL ,
  `nom` VARCHAR(45) NOT NULL ,
  `prenom` VARCHAR(45) NOT NULL ,
  `pseudo` VARCHAR(45) NOT NULL ,
  `adr` VARCHAR(45) NULL ,
  `tel` VARCHAR(45) NULL ,
  `etudiant` BOOLEAN NULL ,
  `salarie` BOOLEAN NULL ,
  `statut` VARCHAR(45) NULL ,
  `entreprise` VARCHAR(45) NULL ,
  `niveauetude` VARCHAR(45) NULL ,
  `ecole` VARCHAR(45) NULL ,
  `iduser` INT NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`iduser`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`type` ;

CREATE  TABLE IF NOT EXISTS `amji`.`type` (
  `idtype` INT NOT NULL AUTO_INCREMENT ,
  `libelle` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idtype`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`priorite`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`priorite` ;

CREATE  TABLE IF NOT EXISTS `amji`.`priorite` (
  `idpriorite` INT NOT NULL AUTO_INCREMENT ,
  `libelle` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idpriorite`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`request`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`request` ;

CREATE  TABLE IF NOT EXISTS `amji`.`request` (
  `idrequest` INT NOT NULL ,
  `content` TEXT NOT NULL ,
  `user` INT NOT NULL ,
  `priorite` INT NOT NULL ,
  `type` INT NOT NULL ,
  `title` TEXT NOT NULL ,
  PRIMARY KEY (`idrequest`) ,
  CONSTRAINT `fk_request_user`
    FOREIGN KEY (`user` )
    REFERENCES `amji`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_request_priorite`
    FOREIGN KEY (`priorite` )
    REFERENCES `amji`.`priorite` (`idpriorite` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_request_type`
    FOREIGN KEY (`type` )
    REFERENCES `amji`.`type` (`idtype` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_request_user` ON `amji`.`request` (`user` ASC) ;

CREATE INDEX `fk_request_priorite` ON `amji`.`request` (`priorite` ASC) ;

CREATE INDEX `fk_request_type` ON `amji`.`request` (`type` ASC) ;


-- -----------------------------------------------------
-- Table `amji`.`requestusers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`requestusers` ;

CREATE  TABLE IF NOT EXISTS `amji`.`requestusers` (
  `request` INT NOT NULL ,
  `user` INT NOT NULL ,
  `readed` BOOLEAN NOT NULL ,
  PRIMARY KEY (`request`, `user`) ,
  CONSTRAINT `fk_request_has_user_request`
    FOREIGN KEY (`request` )
    REFERENCES `amji`.`request` (`idrequest` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_request_has_user_user`
    FOREIGN KEY (`user` )
    REFERENCES `amji`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE INDEX `fk_request_has_user_request` ON `amji`.`requestusers` (`request` ASC) ;

CREATE INDEX `fk_request_has_user_user` ON `amji`.`requestusers` (`user` ASC) ;


-- -----------------------------------------------------
-- Table `amji`.`subscribe`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`subscribe` ;

CREATE  TABLE IF NOT EXISTS `amji`.`subscribe` (
  `user` INT NOT NULL ,
  `type` INT NOT NULL ,
  `dateinscr` DATETIME NOT NULL ,
  PRIMARY KEY (`user`, `type`) ,
  CONSTRAINT `fk_user_has_type_user`
    FOREIGN KEY (`user` )
    REFERENCES `amji`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_type_type`
    FOREIGN KEY (`type` )
    REFERENCES `amji`.`type` (`idtype` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE INDEX `fk_user_has_type_user` ON `amji`.`subscribe` (`user` ASC) ;

CREATE INDEX `fk_user_has_type_type` ON `amji`.`subscribe` (`type` ASC) ;


-- -----------------------------------------------------
-- Table `amji`.`emoticones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`emoticones` ;

CREATE  TABLE IF NOT EXISTS `amji`.`emoticones` (
  `idemoticones` INT NOT NULL AUTO_INCREMENT ,
  `racourci` VARCHAR(45) NOT NULL ,
  `image` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`idemoticones`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `amji`.`response`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`response` ;

CREATE  TABLE IF NOT EXISTS `amji`.`response` (
  `idresponse` INT NOT NULL AUTO_INCREMENT ,
  `content` TEXT NOT NULL ,
  `user` INT NOT NULL ,
  `request` INT NOT NULL ,
  `response` INT NOT NULL ,
  PRIMARY KEY (`idresponse`) ,
  CONSTRAINT `fk_response_user`
    FOREIGN KEY (`user` )
    REFERENCES `amji`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_response_request`
    FOREIGN KEY (`request` )
    REFERENCES `amji`.`request` (`idrequest` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_response_response`
    FOREIGN KEY (`response` )
    REFERENCES `amji`.`response` (`idresponse` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_response_user` ON `amji`.`response` (`user` ASC) ;

CREATE INDEX `fk_response_request` ON `amji`.`response` (`request` ASC) ;

CREATE INDEX `fk_response_response` ON `amji`.`response` (`response` ASC) ;


-- -----------------------------------------------------
-- Table `amji`.`contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `amji`.`contacts` ;

CREATE  TABLE IF NOT EXISTS `amji`.`contacts` (
  `user` INT NOT NULL ,
  `contact` INT NOT NULL ,
  PRIMARY KEY (`user`, `contact`) ,
  CONSTRAINT `fk_user_has_user_user`
    FOREIGN KEY (`user` )
    REFERENCES `amji`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_user_user1`
    FOREIGN KEY (`contact` )
    REFERENCES `amji`.`user` (`iduser` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE INDEX `fk_user_has_user_user` ON `amji`.`contacts` (`user` ASC) ;

CREATE INDEX `fk_user_has_user_user1` ON `amji`.`contacts` (`contact` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
