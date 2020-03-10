USE frlg18;

SET NAMES utf8;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(80) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `description` VARCHAR(1000) DEFAULT "Beskrivning om mig",
    `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
