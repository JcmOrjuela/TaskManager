<?php

/**
 * @author Juan Camilo Moyano Orjuela 
 * @description Conviente un arreglo en una cadena compatible con sql
 * @param Array $array
 * @return String
 */
function array_sql_filter(&$array): String
{
    $filters = [];
    foreach ($array as $key => $value) {
        if (is_array($value) && is_string($key)) {
            return array_sql_filter($value);
        } else {
            if (is_array($value)) {
                $values = "'" . implode("','", $value);
                $filters[] = "$key in ($values)";
            } else {
                $filters[] = "$key = '$value'";
            }
        }
    }

    return implode(" AND ", $filters);
}
