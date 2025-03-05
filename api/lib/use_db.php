<?php
include "config.php";

function get_pdo()

{

    $config = get_db_config();
    $conn = new PDO($config->dsn, $config->username, $config->password, $config->options);
    return $conn;
}

function array_to_pdo_params($array)
{
    $temp = array();
    foreach (array_keys($array) as $name) {
        $temp[] = "$name = ?";
    }
    return implode(', ', $temp);
}


function sanitizeInput($input)
{
    // Return null if the input is null
    if ($input === null) {
        return null;
    }

    // Replace non-printing characters and line breaks with a space
    $input = preg_replace('/[\x00-\x1F\x7F]/', ' ', $input);

    // Pattern to match characters that are NOT allowed
    $disallowedPattern = '/[^a-zA-Z0-9&@()\/_.`,\'"\\-:;\\[\\]{}|\\+=!#$%^*<>~?]+/';

    // Replace disallowed characters with a space and then trim whitespace
    return trim(preg_replace($disallowedPattern, ' ', $input));
}
