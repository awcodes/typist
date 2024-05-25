<?php

namespace Awcodes\Typist\Enums;

enum ContentType: string
{
    case Html = 'html';
    case Json = 'json';
    case Text = 'text';
    case Markdown = 'markdown';
}
