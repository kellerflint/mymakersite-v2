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

function add_new_user($new_user) 
{
    global $db;

    $errors = validate_new_user($new_user);

    if(!empty($errors)) {
        return $errors;
    }

    $query = "INSERT INTO User Values (default, ?, ?, ?, ?, ?, now())";

    $stmt = $db->prepare($query);
    $stmt->bind_param("sssss", 
        $new_user['user_name'], 
        $new_user['user_first'], 
        $new_user['user_last'], 
        $new_user['password'], 
        $new_user['user_email']);
    $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function validate_new_user($new_user) {
    $errors = [];
    
    if (is_empty($new_user['user_first']))
        $errors[] = "First name cannot be blank.";
    if (is_empty($new_user['user_last']))
        $errors[] = "Last name cannot be blank.";
    if (is_empty($new_user['user_name']))
        $errors[] = "Username cannot be blank.";
    if (is_empty($new_user['user_email']))
        $errors[] = "Email cannot be blank.";
    if (is_empty($new_user['password']))
        $errors[] = "Password cannot be blank.";

    return $errors;
}