<?php
/**
 * sagarpatel
 * Date: 03-Apr-15
 * Time: 4:08 PM
 */

function cleanString($str)
{
    return filter_var((string)$str,FILTER_SANITIZE_SPECIAL_CHARS);
}