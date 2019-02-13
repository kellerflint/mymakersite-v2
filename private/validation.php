<?php 

function has_value($value)
{
    return !isset($value) || trim($value) === '';
}

function has_length_less_than($value, $max)
{
    $length = strlen($value);
    return $length < $max;
}

?>