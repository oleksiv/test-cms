<?php

namespace App\Helpers;

class StringHelper {
    /**
     * @param $value
     * @return string
     */
    public static function hyphenCase($value): string
    {
        // Replace unwanted subsets of characters
        $value = preg_replace('/([^0-9a-zA-Z])+/u', '-', $value);
        // Remove hyphens from right
        $value = preg_replace('/(-)+$/u', '', $value);
        // Remove hyphens from left
        $value = preg_replace('/^(-)+/u', '', $value);
        // lowercase
        $value = mb_strtolower($value, 'UTF-8');
        // Return string
        return $value;
    }
}