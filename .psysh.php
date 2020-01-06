<?php

$defaultIncludes = [];
$composerAutoload = getcwd() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (is_file($composerAutoload)) {
    $defaultIncludes[] = $composerAutoload;
}

return [
    'defaultIncludes' => $defaultIncludes,
];
