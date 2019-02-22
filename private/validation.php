<?php 

function has_value($value)
{
    return isset($value) && trim($value) != '';
}

?>