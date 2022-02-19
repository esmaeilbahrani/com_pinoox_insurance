<?php
//pinoox config file, generated at "2021-11-05 20:47"

return array(
    'nodes' =>
        array(
            0 => 'panel/dashboard',
            1 => 'panel/user',
            2 => 'panel/permission',
            3 => 'panel/quiz/add',
            4 => 'panel/quiz/edit',
            5 => 'panel/quiz/delete',
            6 => 'panel/quiz/search',
            7 => 'all_quiz',
            8 => 'manage_quiz',
            9 => 'panel/category',
            10 => 'panel/templates',
            11 => 'panel/profile',
            12 => 'panel/setting',
        ),
    'branches' =>
        array(
            0 =>
                array(
                    'id' => 'panel',
                    'type' => 'module',
                    'status' => 2,
                ),
            1 =>
                array(
                    'id' => 'panel/dashboard',
                    'api' => 'api/panel/v1/dashboard',
                    'status' => 2,
                ),
            2 =>
                array(
                    'id' => 'panel/user',
                    'api' => 'api/panel/v1/user',
                    'status' => 2,
                ),
            3 =>
                array(
                    'id' => 'panel/group',
                    'api' => 'api/panel/v1/group',
                    'status' => 2,
                ),
            4 =>
                array(
                    'id' => 'panel/permission',
                    'api' => 'api/panel/v1/permission',
                    'status' => 2,
                ),
            5 =>
                array(
                    'id' => 'panel/quiz',
                    'api' => 'api/panel/v1/quiz',
                    'status' => 2,
                ),
            6 =>
                array(
                    'id' => 'panel/quiz/add',
                    'api' => 'api/panel/v1/quiz/save',
                    'status' => 2,
                ),
            7 =>
                array(
                    'id' => 'panel/quiz/edit',
                    'api' => 'api/panel/v1/quiz/save',
                    'status' => 2,
                ),
            8 =>
                array(
                    'id' => 'panel/quiz/delete',
                    'api' => 'api/panel/v1/quiz/delete',
                    'status' => 2,
                ),
            9 =>
                array(
                    'id' => 'panel/quiz/search',
                    'status' => 2,
                ),
            10 =>
                array(
                    'id' => 'all_quiz',
                    'type' => 'option',
                    'status' => 2,
                ),
            11 =>
                array(
                    'id' => 'manage_quiz',
                    'type' => 'option',
                    'status' => 2,
                ),
            12 =>
                array(
                    'id' => 'panel/category',
                    'api' => 'api/panel/v1/category',
                    'status' => 2,
                ),
            13 =>
                array(
                    'id' => 'panel/templates',
                    'api' => 'api/panel/v1/template',
                    'status' => 2,
                ),
            14 =>
                array(
                    'id' => 'panel/profile',
                    'api' => 'api/panel/v1/profile',
                    'status' => 2,
                ),
            15 =>
                array(
                    'id' => 'panel/setting',
                    'api' => 'api/panel/v1/setting',
                    'status' => 2,
                ),
        ),
);

//end of config