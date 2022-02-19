<?php

const api_v1 = 'api/panel/v1/';

return [
    'module' => [
        'panel' => false,
        'panel/dashboard' => false,
        'panel/user' => false,
        'panel/group' => false,
        'panel/permission' => false,
        'panel/quiz' => false,
        'panel/quiz/add' => false,
        'panel/quiz/edit' => false,
        'panel/quiz/delete' => false,
        'panel/quiz/search' => false,
        'panel/category' => false,
        'panel/templates' => false,
        'panel/profile' => false,
        'panel/setting' => false,
    ],
    'option' => [
        'all_quiz' => false,
        'manage_quiz' => false,
    ],
    'api' => [
        api_v1 => true,
        api_v1 . 'dashboard' => false,
        api_v1 . 'user' => false,
        api_v1 . 'group' => false,
        api_v1 . 'permission' => false,
        api_v1 . 'quiz' => false,
        api_v1 . 'quiz/save' => false,
        api_v1 . 'quiz/delete' => false,
        api_v1 . 'category' => false,
        api_v1 . 'template' => false,
        api_v1 . 'profile' => false,
        api_v1 . 'setting' => false,
    ],
];