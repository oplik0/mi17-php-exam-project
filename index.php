<?php

/**
 * A very basic applicaiton-specific router
 * @author @oplik0
 * @version 0.1
 * @package php-exam
 */
require_once(__DIR__ . '/helpers.php');


$uri = $_SERVER['REQUEST_URI'];


require_software_classess();

function render_template(string $page, string $title, array|string $additionalHeadElements = array())
{
    $headContents = implode("\n", array_merge(array(
        '<meta charset="UTF-8">',
        '<meta http-equiv="X-UA-Compatible" content="IE=edge">',
        '<meta name="viewport" content="width=device-width, initial-scale=1.0">',
        '<title>' . $title . '</title>',
        '<meta name="author" content="Jakub Blźniuk">',
        '<link rel="stylesheet" href="/static/style.css">'
    ), $additionalHeadElements));
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <?= $headContents ?>
</head>

<body>
    <?php require_once(__DIR__ . '/pages/' . $page . '.php'); ?>
</body>

</html>
<?php
}


switch ($uri) {
        /**
     * Basic routes
     */
    case '':
    case 'index.php':
    case 'index.html':
    case '/':
        render_template('index', 'Klasy');
        break;
    default:
        /**
         * More advanced resolution, then 404 if none are found
         */
        preg_match('{/class/([a-z])}iu', $uri, $matches);
        if (isSupportedClass($matches[1])) {
            render_template('classInput', $matches[1]);
        } else {
            render_template('404', 'Błąd 404');
        }
}