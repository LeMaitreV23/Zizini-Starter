<?php

if (! function_exists('mb_split')) {
    function mb_split(string $pattern, string $string, int $limit = -1): array|false
    {
        $delimiter = '~';
        $escaped = str_replace($delimiter, '\\'.$delimiter, $pattern);
        $regex = $delimiter.$escaped.$delimiter.'u';

        return preg_split($regex, $string, $limit);
    }
}
