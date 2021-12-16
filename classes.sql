CREATE TABLE IF NOT EXISTS `classes` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `imgSrc` varchar(255) NOT NULL,
    `title` varchar(255) NOT NULL,
    `level` int unsigned NOT NULL,
    `parentId` int unsigned NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
INSERT IGNORE INTO `classes` (
        `id`,
        `name`,
        `imgSrc`,
        `title`,
        `level`,
        `parentId`
    )
VALUES (
        1,
        'Software',
        '/static/images/api_black_24dp.svg',
        'Software',
        1,
        0
    ),
    (
        2,
        'Application',
        '/static/images/widgets_black_24dp.svg',
        'Application',
        2,
        1
    ),
    (
        3,
        'Library',
        '/static/images/library_books_black_24dp.svg',
        'Library',
        2,
        1
    ),
    (
        4,
        'OS',
        '/static/images/devices_black_24dp.svg',
        'Operating System',
        2,
        1
    ),
    (
        5,
        'GameEngineLibrary',
        '/static/images/games_black_24dp.svg',
        'Game Engine Library',
        3,
        3
    ),
    (
        6,
        'CryptographicLibrary',
        '/static/images/enhanced_encryption_black_24dp.svg',
        'Cryptographic Library',
        3,
        3
    ),
    (
        7,
        'GameApplication',
        '/static/images/sports_esports_black_24dp.svg',
        'Game Application',
        3,
        2
    ),
    (
        8,
        'IDEApplication',
        '/static/images/code_black_24dp.svg',
        'IDE Application',
        3,
        2
    );