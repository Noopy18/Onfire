/* DROP DATABASE IF EXISTS ONFIRE_DB;
CREATE DATABASE ONFIRE_DB; */
USE ONFIRE_DB;

CREATE TABLE `utilizador` (
  `utilizador_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `profile_picture` VARCHAR(255),
  `name` VARCHAR(150) NOT NULL,
  `private_perfil` BOOLEAN NOT NULL DEFAULT '0',
  `fk_user` INT REFERENCES `user`(id) 
) ENGINE=InnoDB;

CREATE TABLE `category` (
  `category_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255),
  `color` VARCHAR(7) NOT NULL DEFAULT '#000000'
) ENGINE=InnoDB;
INSERT INTO `category` VALUES (1, 'Sport', 'A category for all sport related habits.', '#40826d');

CREATE TABLE `habit` (
  `habit_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255),
  `frequency` VARCHAR(255) NOT NULL,
  `final_date` DATE,
  `type` ENUM('boolean', 'int') NOT NULL,
  `created_at` DATE NOT NULL,
  `fk_utilizador` INT NOT NULL REFERENCES `utilizador`(utilizador_id),
  `fk_category` INT NOT NULL REFERENCES `category`(category_id)
) ENGINE=InnoDB;

CREATE TABLE `habit_completion` (
  `habit_completion_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `completed` BOOLEAN NOT NULL,
  `fk_habit` INT NOT NULL REFERENCES `habit`(habit_id)
) ENGINE=InnoDB;

CREATE TABLE `friends` (
  PRIMARY KEY (`sender`, `receiver`),
  `sender` INT NOT NULL  REFERENCES `utilizador`(utilizador_id),
  `receiver` INT NOT NULL REFERENCES `utilizador`(utilizador_id),
  `status` ENUM('rejeitado','aceite','pendente') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `weekly_challenge` (
  `weekly_challenge_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255),
  `start_date` DATE NOT NULL,
  `status` BOOLEAN NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `badge` (
  `badge_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `condition_type` ENUM('streak', 'habit_completions','habits_completed', 'wc_completions', 'wc_completed') NOT NULL,
  `condition_value` INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `weekly_challenge_utilizador` (
  `weekly_challenge_utilizador_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fk_utilizador` INT NOT NULL  REFERENCES `utilizador`(utilizador_id),
  `fk_weekly_challenge` INT NOT NULL  REFERENCES `weekly_challenge`(weekly_challenge_id)
) ENGINE=InnoDB;

CREATE TABLE `weekly_challenge_completion` (
  `weekly_challenge_completion_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `completed` BOOLEAN NOT NULL,
  `fk_weekly_challenge_utilizador` INT NOT NULL REFERENCES `weekly_challenge_utilizador`(weekly_challenge_utilizador_id)
) ENGINE=InnoDB;

CREATE TABLE `badge_utilizador` (
  PRIMARY KEY (`fk_utilizador`, `fk_badge`),
  `fk_utilizador` INT NOT NULL  REFERENCES `utilizador`(utilizador_id),
  `fk_badge` INT NOT NULL  REFERENCES `badge`(badge_id)
) ENGINE=InnoDB;

INSERT INTO `utilizador` VALUES (1, '', 'ADM', 1);
INSERT INTO `utilizador` VALUES (2, '', 'TECH', 2);