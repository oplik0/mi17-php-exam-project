CREATE TABLE IF NOT EXISTS `classes` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `imgSrc` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    `level` int unsigned NOT NULL,
    `parentId` int unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;