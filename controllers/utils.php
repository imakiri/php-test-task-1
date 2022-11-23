<?php

namespace app\controllers;

function rearrange(string $key, array $in): array
{
    $out = [];
    foreach ($in as $element) {
        $kv = $element[$key];
        unset($element[$key]);;
        $out[$kv] = $element;
    }
    return $out;
}