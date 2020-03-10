USE frlg18;

SET NAMES utf8;

DROP TABLE IF EXISTS questions;
CREATE TABLE questions (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(80) NOT NULL,
    `author` VARCHAR(80) NOT NULL,
    `question` VARCHAR(3000) NOT NULL,
    `created` DATETIME,
    `tags` VARCHAR(1000) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
