<?php

$defaultIncludes = [];
$composerAutoload = getcwd() . DIRECTORY_SEPARATOR . '/vendor/autoload.php';

if (is_file($composerAutoload)) {
    $defaultIncludes[] = $composerAutoload;
}

return [
    'defaultIncludes' => $defaultIncludes,
];
