<?php

namespace app\services;

function rename_key(array &$arr, string $old_key, string $new_key)
{
    $arr[$new_key] = $arr[$old_key];
    unset($arr[$old_key]);
}
