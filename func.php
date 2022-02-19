<?php
//paper functions file

use pinoox\app\com_pinoox_insurance\model\SettingsModel;

function setting($name = null, $theme = null)
{
    return SettingsModel::getData($name, $theme);
}
