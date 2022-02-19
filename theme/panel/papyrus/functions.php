<?php

use pinoox\component\HelperString;

function setting_json($key)
{
    return HelperString::encodeJson(setting($key), true);
}
