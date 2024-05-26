<?php

use Awcodes\Typist\Support\Converter;

if (! function_exists('typist')) {
    function typist(string | array | stdClass | null $content): Converter
    {
        return new Converter($content);
    }
}
