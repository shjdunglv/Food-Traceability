<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('filterOnly')) {
    function filterOnly($key, $data)
    {

        $filtered = array_filter(
            $data,
            function ($key_) use ($key) {
                return in_array($key_, $key);
            },
            ARRAY_FILTER_USE_KEY
        );
        return $filtered;
    }
}
