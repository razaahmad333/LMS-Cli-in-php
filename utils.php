<?php

function generateID($length = 4, $alphanumeric = false)
{
    $characters  = "";
    $id = [];

    if ($alphanumeric) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    } else {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }

    $max = strlen($characters)  - 1;
    for ($i = 0; $i < $length; $i++) {
        $id[] = $characters[random_int(0, $max)];
    }

    return implode("", $id);
}
