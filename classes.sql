CREATE TABLE IF NOT EXISTS `classes` (
    `id` unsigned int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `imgSrc` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    `level` unsigned int NOT NULL,
    `parentId` unsigned int NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;