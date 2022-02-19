<?php

return array(
    'package-name' => 'com_pinoox_insurance',
    'name' => 'insurance',
    'description' => 'insurance CRM',
    'version-code' => 14,
    'version-name' => '1.0.0',
    'developer' => 'pinoox',
    'enable' => true,
    'theme' => 'landing',
    'theme-panel' => 'papyrus',
    'lang' => 'fa',
    'service' => [
        'user',
        'permission',
        'schedule',
    ],
    'loader' => [
        '@func' => 'func.php',
    ]
);

//end of app