DROP TABLE IF EXISTS `db_site`.`header_slider_images`;          

CREATE DATABASE IF NOT EXISTS `db_site` CHARACTER SET utf8 COLLATE utf8_spanish_ci;

CREATE TABLE IF NOT EXISTS `db_site`.`header_slider_images` (
   `id` INT NOT NULL AUTO_INCREMENT,
   `image` VARCHAR(45) NOT NULL,
   `position` INT NOT NULL,
 
   PRIMARY KEY (`id`),
   INDEX (`position`)
) ENGINE=innodb;