<h2>Database</h2>
DROP TABLE IF EXISTS `db_site`.`header_slider_images`;<br>       
CREATE DATABASE IF NOT EXISTS `db_site` CHARACTER SET utf8 COLLATE utf8_spanish_ci;<br>
CREATE TABLE IF NOT EXISTS `db_site`.`header_slider_images` (<br>
   `id` INT NOT NULL AUTO_INCREMENT,<br>
   `image` VARCHAR(45) NOT NULL,<br>
   `position` INT NOT NULL,<br>

   PRIMARY KEY (`id`),<br>
   INDEX (`position`)<br>
) ENGINE=innodb;
