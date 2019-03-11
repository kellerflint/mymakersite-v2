<?php

function find_user_by_username($username)
{
    global $db;
    $query = "SELECT * FROM User WHERE user_name = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $user_set = $stmt->get_result();

    $stmt->close();
    
    return mysqli_fetch_assoc($user_set);
}

function add_new_user($user_name, $user_first, $user_last, $user_password, $user_email) 
{
    global $db;

    $query = "INSERT INTO User Values (default, ?, ?, ?, ?, ?, now())";

    $stmt = $db->prepare($query);
    $stmt->bind_param("sssss", $user_name, $user_first, $user_last, $user_password, $user_email);
    $stmt->execute();
    // returns false or true or errors or something if fails. Remember, validation should be taking care of this.
}