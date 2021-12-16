    <?php

    use MyCLabs\Enum\Enum;

    require_once(__DIR__ . "/../db.php");
    require_once(__DIR__ . '/../classes/ClassDisplay.php');

    $db = connectToDatabase();

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["imageUpload"]) && isset($_POST["classId"])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($_FILES['classImage']['tmp_name']);
        $allowedMime = array('image/png', 'image/svg', 'image/jpeg', 'image/gif', 'image/avif', 'image/jxl', 'image/svg+xml');
        if (!in_array($_FILES['classImage']['type'], $allowedMime) && !in_array($realMime, $allowedMime)) {
            echo "<h1>Filetype not allowed</h1>";
        } else if ($_FILES['classImage']['size'] > 10000000) {
            echo "<h1>File is too big</h1>";
        } else if ($_FILES['classImage']['error'] > 0) {
            echo "<h1>Error: " . $_FILES['classImage']['error'] . "</h1>";
        } else {


            $fileTempName = $_FILES['classImage']['tmp_name'];
            $filename = __DIR__ . "/../static/images/" . basename(md5_file($fileTempName) . '_' . $_FILES["classImage"]['name']);
            if (!move_uploaded_file($fileTempName, $filename)) {
                echo "<h1>Error uploading file</h1>";
            } else {
                $filepath = str_replace(__DIR__ . "/..", "", $filename);
                $statement = $db->prepare('UPDATE classes SET imgSrc = ? WHERE id = ?');
                $statement->bind_param('si', $filepath, $_POST["classId"]);
                $statement->execute();
            }
        }
    }

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

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["createClass"])) {
        if (isset($_POST["className"]) && isSupportedClass($_POST["className"])) {
            function formToClass($className)
            {
                $classReflection = new ReflectionClass($className);
                $classProperties = $classReflection->getConstructor()->getParameters();
                $constructionParams = array();
                foreach ($classProperties as $property) {
                    if (isset($_POST[$property->name])) {
                        $propertyType = $property->getType();
                        if (in_array((string)$propertyType, array('int', 'string'))) {
                            $constructionParams[$property->name] = $_POST[$property->name];
                        } else if (in_array((string)$propertyType, array('string|array', 'array'))) {
                            $constructionParams[$property->name] = explode(', ', $_POST[$property->name]);
                        } else {
                            try {
                                $typeClass = new ReflectionClass((string)$propertyType);
                                if ($typeClass->isSubclassOf('Software')) {
                                    $constructionParams[$property->name] = formToClass((string)$propertyType);
                                }
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
                $newObject = $classReflection->newInstanceArgs($constructionParams);
                return $newObject;
            }
            $class = formToClass($_POST["className"]);
            if ($class->serializeToSQL($db)) {
                echo "<script>alert('Obiekt " . $class . " został zapisany');</script>";
            }
        }
    }
    $db->close();
    ?>