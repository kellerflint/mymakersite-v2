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