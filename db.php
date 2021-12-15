<?php

function connectToDatabase(): mysqli
{
    if (getenv("CODESPACES") === "true") {
        $config = parse_ini_file("config-codespaces.ini");
    } else {
        $config = parse_ini_file("config.ini");
    }
    try {
        $db = new mysqli($config["db_url"], $config["db_username"], $config["db_password"], $config["db_name"]);
    } catch (Exception $e) {
        http_response_code(500);
        throw new Exception("Could not connect to database!");
    }
    return $db;
}