<?php
    $filename = dirname(__FILE__) . '/russian-UTF8.php';
    $contents = file_get_contents($filename);
    $contents = mb_convert_encoding($contents, 'windows-1251', 'UTF-8');
    eval('?>' . $contents);
    $modx_lang_attribute = 'ru'; // Manager HTML/XML Language Attribute see http://en.wikipedia.org/wiki/ISO_639-1
    $modx_manager_charset = 'windows-1251';
    setlocale (LC_ALL, 'ru_RU.CP1251');
?>