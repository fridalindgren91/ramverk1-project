USE dbwebb;

SET NAMES utf8;

DROP TABLE IF EXISTS answers;
CREATE TABLE answers (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `answer` VARCHAR(3000) NOT NULL,
    `author` VARCHAR(80) NOT NULL,
    `questionID` INT NOT NULL,
    `created` DATETIME,
    FOREIGN KEY (questionID) REFERENCES questions(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
