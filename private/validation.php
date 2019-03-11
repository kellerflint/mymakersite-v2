<?php 

define('MAX_LENGTH', 255);

// returns true if value is empty
function is_empty($value)
{
    return !isset($value) || trim($value) === '';
}

// returns true if length is greater than min
function has_length_greater_than($value, $min) {
    $length = strlen($value);
    return $length > $min;
}

// returns true if length is less than max
function has_length_less_than($value, $max) {
    $length = strlen($value);
    return $length < $max;
}

function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
}

function has_valid_email_format($value) {
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1;
}

// why in the hell would I define this function when in_array exists? Just keeping it so I remember that in_array exists
/* function has_inclusion_of($value, $set) {
    return in_array($value, $set);
} */

?>