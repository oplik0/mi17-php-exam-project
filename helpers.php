<?php

/**
 * Some useful function
 * @author @oplik0
 * @version 0.1
 * @package php-exam
 */

function createTable(array $array): string
{
    $table = "<table><tr>";
    foreach (array_keys($array[0]) as $key) {
        $table .= "<th>$key</th>";
    }
    $table .= "</tr>";
    foreach ($array as $row) {
        $table .= "<tr>";
        foreach ($row as $cell) {
            $table .= "<td>$cell</td>";
        }
        $table .= "</tr>";
    }
    $table .= "</table>";
    return $table;
}

function isSupportedClass($classname)
{
    try {
        $class = new ReflectionClass($classname);
    } catch (Exception $e) {
        return false;
    }

    return $classname === "Software" || $class->isSubclassOf('Software');
}

function require_software_classess()
{
    foreach (glob(__DIR__ . "/classes/Software/*") as $filename) {
        require_once($filename);
    }
}