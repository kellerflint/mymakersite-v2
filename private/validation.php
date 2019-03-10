<?php 

// returns true if is not empty
function has_value($value)
{
    return isset($value) && trim($value) != '';
}

?>