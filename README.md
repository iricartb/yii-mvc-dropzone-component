<h1>Yii Widget</h1>
Yii component that allows to interact with the user through a widget to drag and drop elements in a stipulated area, makes use of the MVC pattern and interacts with the database by making internal calls about the models that, through inheritance, implement a certain interface.
<h2>Database</h2>
DROP TABLE IF EXISTS `db_site`.`header_slider_images`;<br><br>     
CREATE DATABASE IF NOT EXISTS `db_site` CHARACTER SET utf8 COLLATE utf8_spanish_ci;<br><br>
CREATE TABLE IF NOT EXISTS `db_site`.`header_slider_images` (<br>
   `id` INT NOT NULL AUTO_INCREMENT,<br>
   `image` VARCHAR(45) NOT NULL,<br>
   `position` INT NOT NULL,<br>

   PRIMARY KEY (`id`),<br>
   INDEX (`position`)<br>
) ENGINE=innodb;
