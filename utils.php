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


function loadDB($db)
{
    if (!file_exists($db)) {
        file_put_contents($db, json_encode([]));
    }
    return json_decode(file_get_contents($db), true);
}

function saveToDB($db, $list)
{
    file_put_contents($db, json_encode($list, JSON_PRETTY_PRINT));
}

function formatTime($timestamp)
{
    $datetime = (new DateTime())->setTimestamp($timestamp);
    $datetime->setTimezone(new DateTimeZone('Asia/Kolkata'));
    return $datetime->format('d/m/y H:i:s a');
}
