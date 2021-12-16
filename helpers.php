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
function mapToSQL($value, string $key): string
{
    switch (gettype($value)) {
        case 'string':
            return "`$key` varchar(255)";
        case 'integer':
            return "`$key` int";
        case 'boolean':
            return "`$key` bit(1)";
        case 'array':
            return "`$key` text";
        case 'double':
            return "`$key` double";
        default:
            // default is *some* attempt at foreign key
            return "`$key` int unsigned";
    }
}

function sqlTypes($x)
{
    switch (gettype($x)) {
        case 'integer':
            return 'i';
        case 'double':
            return 'd';
        default;
            return 's';
    }
}