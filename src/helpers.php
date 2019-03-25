<?php

/**
 * Global helpers file with misc functions
 *
 * @author: Pham Cong Toan
 * @date: 2018-08-15 10:46:19
 */


if (!function_exists('substitute')) {
    function substitute($template, $data) {
        $placeholders = array_keys($data);
        foreach ($placeholders as &$placeholder) {
            $placeholder = "{{{$placeholder}}}";
        }
        return str_replace($placeholders, array_values($data), $template);
    }
}
