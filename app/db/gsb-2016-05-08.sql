-- MySQL Workbench Synchronization
-- Generated: 2016-05-08 10:40
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Melanie

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER SCHEMA `gsb`  DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_general_ci ;

ALTER TABLE `gsb`.`bilan`
DROP COLUMN `motif`,
ADD COLUMN `motif_id` INT(11) NOT NULL COMMENT '' AFTER `praticien_numero`,
ADD INDEX `fk_bilan_motif1_idx` (`motif_id` ASC)  COMMENT '';

CREATE TABLE IF NOT EXISTS `gsb`.`motif` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `libelle` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;

ALTER TABLE `gsb`.`bilan`
ADD CONSTRAINT `fk_bilan_motif1`
FOREIGN KEY (`motif_id`)
REFERENCES `gsb`.`motif` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

INSERT INTO `gsb`.`motif` (`id`, `libelle`) VALUES
  (NULL, 'Rendez-vous périodique'),
  (NULL, 'Nouveautés'),
  (NULL, 'Remontage'),
  (NULL, 'Demande d''informations'),
  (NULL, 'Autre');


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
