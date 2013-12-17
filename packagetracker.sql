CREATE SCHEMA IF NOT EXISTS `packagetracker` DEFAULT CHARACTER SET latin1 ;
USE `packagetracker` ;

-- -----------------------------------------------------
-- Table `packagetracker`.`packages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `packagetracker`.`packages` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `product_name` VARCHAR(100) NOT NULL ,
  `status` ENUM('PROCESSING','SHIPPING','ARRIVED') NOT NULL ,
  `estimated_arrival_date` DATETIME NULL DEFAULT NULL ,
  `order_date` DATETIME NULL DEFAULT NULL ,
  `link` VARCHAR(256) NULL DEFAULT NULL ,
  `price` DOUBLE NULL DEFAULT NULL ,
  `tracking_number` VARCHAR(100) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `packagetracker`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `packagetracker`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `oauth_id` INT(11) NOT NULL ,
  `authentication_mode` ENUM('FACEBOOK','GOOGLE') NOT NULL ,
  `first_name` VARCHAR(50) NOT NULL ,
  `last_name` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `unique_oauth_id` (`oauth_id` ASC) ,
  UNIQUE INDEX `unique_authentication_mode` (`authentication_mode` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

USE `packagetracker` ;