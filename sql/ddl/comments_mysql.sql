USE dbwebb;

SET NAMES utf8;

DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `comment` VARCHAR(3000) NOT NULL,
    `author` VARCHAR(80) NOT NULL,
    `questionID` INT,
    `answerID` INT,
    `created` DATETIME,
    FOREIGN KEY (questionID) REFERENCES questions(id),
    FOREIGN KEY (answerID) REFERENCES answers(id)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
