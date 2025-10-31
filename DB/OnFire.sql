DROP DATABASE IF EXISTS ONFIRE_DB;
CREATE DATABASE ONFIRE_DB;
USE ONFIRE_DB;

CREATE TABLE `utilizador` (
  `utilizador_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL /* , */
  /* `fk_user` INT REFERENCES `user`(id) */
) ENGINE=InnoDB;

CREATE TABLE `category` (
  `category_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `color` VARCHAR(255) NOT NULL,
  `fk_utilizador` INT NOT NULL REFERENCES `utilizador`(utilizador_id)
) ENGINE=InnoDB;

CREATE TABLE `settings` (
  `settings_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `time_format` VARCHAR(255) NOT NULL,
  `dark_theme` BOOLEAN NOT NULL,
  `fk_utilizador_id` INT NOT NULL REFERENCES `utilizador`(utilizador_id)
) ENGINE=InnoDB;

CREATE TABLE `friend_invite` (
  `friend_invite_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sender` INT NOT NULL  REFERENCES `utilizador`(utilizador_id),
  `receiver` INT NOT NULL REFERENCES `utilizador`(utilizador_id),
  `rejected` BOOLEAN NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `friends` (
  `friends_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user1` INT NOT NULL REFERENCES `utilizador`(utilizador_id),
  `user2` INT NOT NULL REFERENCES `utilizador`(utilizador_id)
) ENGINE=InnoDB;

CREATE TABLE `weekly_challenge` (
  `weekly_challenge_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `duration` INT NOT NULL,
  `status` BOOLEAN NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `weekly_challenge_utilizador` (
  `weekly_challenge_utilizador_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fk_utilizador` INT NOT NULL  REFERENCES `utilizador`(utilizador_id),
  `fk_weekly_challenge` INT NOT NULL  REFERENCES `weekly_challenge`(weekly_challenge_id)
) ENGINE=InnoDB;

CREATE TABLE `badge` (
  `badge_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE `badge_utilizador` (
  `badge_utilizador_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `fk_utilizador` INT NOT NULL  REFERENCES `utilizador`(utilizador_id),
  `fk_badge` INT NOT NULL  REFERENCES `badge`(badge_id)
) ENGINE=InnoDB;

CREATE TABLE `habit` (
  `habit_id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `frequency` VARCHAR(255) NOT NULL,
  `streak` INT NOT NULL,
  `fk_utilizador` INT NOT NULL REFERENCES `utilizador`(utilizador_id),
  `fk_category` INT REFERENCES `category`(category_id)
) ENGINE=InnoDB;