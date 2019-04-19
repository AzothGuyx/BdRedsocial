-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema redes_sociales
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema redes_sociales
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `redes_sociales` DEFAULT CHARACTER SET utf8 ;
USE `redes_sociales` ;

-- -----------------------------------------------------
-- Table `redes_sociales`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `redes_sociales`.`usuario` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) CHARACTER SET 'big5' NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `ultimo_ingreso` DATETIME NULL,
  `clave` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `redes_sociales`.`evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `redes_sociales`.`evento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dsevento` VARCHAR(500) NOT NULL,
  `feevento` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `redes_sociales`.`agenda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `redes_sociales`.`agenda` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `evento_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`, `evento_id`, `usuario_id`),
  INDEX `fk_agenda_evento1_idx` (`evento_id` ASC),
  INDEX `fk_agenda_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_agenda_evento1`
    FOREIGN KEY (`evento_id`)
    REFERENCES `redes_sociales`.`evento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_agenda_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `redes_sociales`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `redes_sociales`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `redes_sociales`.`categoria` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(100) NOT NULL,
  `principal` INT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`id`, `usuario_id`),
  INDEX `fk_categoria_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_categoria_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `redes_sociales`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `redes_sociales`.`publicacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `redes_sociales`.`publicacion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `dspublicacion` VARCHAR(500) NOT NULL,
  `usuario_id` INT NOT NULL,
  `categoria_id` INT NOT NULL,
  PRIMARY KEY (`id`, `usuario_id`, `categoria_id`),
  INDEX `fk_publicacion_usuario1_idx` (`usuario_id` ASC),
  INDEX `fk_publicacion_categoria1_idx` (`categoria_id` ASC),
  CONSTRAINT `fk_publicacion_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `redes_sociales`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacion_categoria1`
    FOREIGN KEY (`categoria_id`)
    REFERENCES `redes_sociales`.`categoria` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = INNODB;


-- -----------------------------------------------------
-- Table `redes_sociales`.`likes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `redes_sociales`.`likes` (
  `numLikes` INT NOT NULL DEFAULT 0,
  `publicacion_id` INT NOT NULL,
  PRIMARY KEY (`publicacion_id`),
  CONSTRAINT `fk_likes_publicacion1`
    FOREIGN KEY (`publicacion_id`)
    REFERENCES `redes_sociales`.`publicacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = INNODB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
