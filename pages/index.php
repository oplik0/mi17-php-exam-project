<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaliczenie</title>
</head>

<body>
    <?php
    require_once(__DIR__ . "/../db.php");
    require_once(__DIR__ . '/../classes/ClassDisplay.php');

    $db = connectToDatabase();
    $classes = $db->query("SELECT `id`, `name`, `imgSrc`, `title`, `level`, `parentId` FROM `classes`");
    $classArray = $classes->fetch_all(MYSQLI_ASSOC);
    if (count($classArray) == 0) {
        throw new LengthException("No classes found!");
    }
    echo createTable($classArray);

    array_multisort(array_column($classArray, 'level'), SORT_ASC, $classArray);
    $classDisplays = array();
    foreach ($classArray as $class) {
        $classDisplays[$class['id']] = new ClassDisplay($class['id'], $class['name'], $class['imgSrc'], $class['title'], $class['level'], $class['parentId']);
        if ($class['parentId'] != 0) {
            $classDisplays[$class['parentId']]->addChild($classDisplays[$class['id']]);
        }
    }
    echo $classDisplays[1]->toHTML();
    ?>
</body>

</html>