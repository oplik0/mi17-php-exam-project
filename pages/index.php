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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["className"]) && isSupportedClass($_POST["className"])) {
            function formToClass($className)
            {
                $classReflection = new ReflectionClass($className);
                $classProperties = $classReflection->getConstructor()->getParameters();
                foreach ($classProperties as $property) {
                    if (isset($_POST[$property->name])) {
                        $propertyType = $property->getType();
                        if (in_array((string)$propertyType, array('int', 'string'))) {
                            $classProperties[$property->name] = $_POST[$property->name];
                        } else if (in_array((string)$propertyType, array('string|array', 'array'))) {
                            $classProperties[$property->name] = explode(', ', $_POST[$property->name]);
                        } else {
                            try {
                                $typeClass = new ReflectionClass((string)$propertyType);
                                if ($typeClass->isSubclassOf('Software')) {
                                    $classProperties[$property->name] = formToClass((string)$propertyType);
                                }
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
            }
        }
    }
    ?>