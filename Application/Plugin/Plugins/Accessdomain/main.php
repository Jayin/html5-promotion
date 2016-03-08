<?php
/**
 * 默认:
 * {
 * "domains": [
 *
 * ]
 * }
 */


$data_json = file_get_contents('__resource/Accessdomain/data.json');

$data = json_decode($data_json, true);
if ($data && count($data['domains']) > 0) {
    $pass = false;
    foreach ($data['domains'] as $index => $domain) {
        if (strpos($_SERVER['HTTP_HOST'], $domain) !== false) {
            $pass = true;
            break;
        }
    }
    if (!$pass) {
        include('__resource/Accessdomain/index.html');
        exit();
    }
}

?>