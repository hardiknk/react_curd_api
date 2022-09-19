<?php

function getUniqueString($table, $length = NULL)
{
    $length = $length ?? 8;
    $field = 'custom_id';

    $string = \Illuminate\Support\Str::random($length);
    $found = \Illuminate\Support\Facades\DB::table($table)->where([$field => $string])->first();
    if ($found) {
        return getUniqueString($table, $field, $length);
    } else {
        return $string;
    }
}
