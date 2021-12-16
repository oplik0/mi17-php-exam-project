<?php

preg_match('{/class/([a-z]+)}iu', $_SERVER['REQUEST_URI'], $matches);
$className = $matches[1];


$classReflection = new ReflectionClass($className);

function createInputs(ReflectionClass $classReflection): void
{
    $classProperties = $classReflection->getConstructor()->getParameters();
    $className = $classReflection->getName();
    echo "<fieldset name=\"$className\">";
    foreach ($classProperties as $property) {
        $propertyName = $property->getName();
        $propertyType = $property->getType();

        switch ((string) $propertyType) {
            case 'int':
                $input = "<input type=\"number\" id=\"$propertyName\" name=\"$propertyName\" placeholder=\"$propertyName\">";
                break;
            case 'string':
            case 'string|array':
                $input = "<input type=\"text\" id=\"$propertyName\" name=\"$propertyName\" placeholder=\"$propertyName\">";
                break;
            default:
                try {
                    $typeClass = new ReflectionClass((string)$propertyType);
                    if ($typeClass->isSubclassOf('Software')) {
                        echo "<label for=\"$propertyType\">$propertyName</label>";
                        createInputs($typeClass);
                        continue 2;
                    }
                } catch (Exception $e) {
                }
                $input = "<input type=\"text\" id=\"$propertyName\" name=\"$propertyName\" placeholder=\"$propertyName\">";
        }
        echo <<<EOD
            <div class="classInput">
                <label for="$propertyName">$propertyName</label>
                $input
            </div>
            EOD;
    }
    echo "</fieldset>";
}

?>
<h1>Create new <?= $className ?></h1>
<form action="/index.php" method="post">
    <input type="hidden" name="className" value="<?= $className ?>">
    <?php createInputs($classReflection); ?>
    <input type="submit" name="createClass" value="Create">
</form>