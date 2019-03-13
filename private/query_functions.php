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

function find_user_by_id($id)
{
    global $db;
    $query = "SELECT * FROM User WHERE user_id = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);
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
        $new_user['user_hashed_password'], 
        $new_user['user_email']);
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function edit_user($user, $id) {
    global $db;

    $errors = validate_edit_user($user);

    if(!empty($errors)) {
        return $errors;
    }

    $query = "UPDATE User SET user_name = ?, user_first = ?, user_last = ?,"; 
    $query .= "user_email = ? WHERE user_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssi", 
        $user['user_name'],
        $user['user_first'],
        $user['user_last'],
        $user['user_email'],
        $id);
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}
//select Session.Session_id, Session.session_title from Session
//	inner join User_Session on Session.session_id = User_Session.session_id where user_id = 2;
function find_sessions_by_user($user_id) {
    global $db;

    $query = "SELECT Session.session_id, Session.session_title, Session.session_description FROM Session ";
    $query .= "INNER JOIN User_Session on Session.session_id = User_Session.session_id ";
    $query .= "WHERE user_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $session_set = $stmt->get_result();

    $stmt->close();
    
    return $session_set;
}

// Returns an array with permission titles of user for session
function get_session_permissions($session_id, $user_id) {
    global $db;

    $query = "SELECT Session.session_id, session_title, User.user_id, permission_title from Permission ";
	$query .= "inner join User_Permission on Permission.permission_id = User_Permission.permission_id ";
    $query .= "inner join Session on User_Permission.session_id = Session.session_id ";
    $query .= "inner join User on User_Permission.user_id = User.user_id where Session.session_id = ? and User.user_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $session_id, $user_id);
    $stmt->execute();

    $permission_set = $stmt->get_result();

    $stmt->close();

    $permissions = [];

    while($perm = mysqli_fetch_assoc($permission_set)) {
        $permissions[] = $perm['permission_title'];
    }

    return $permissions;
}


/* Validation functions */

function validate_new_user($user) {
    $errors = [];
    
    if (is_empty($user['user_first']))
        $errors[] = "First name cannot be blank.";
    if (is_empty($user['user_last']))
        $errors[] = "Last name cannot be blank.";
    if (is_empty($user['user_name']))
        $errors[] = "Username cannot be blank.";
    if (is_empty($user['user_email']))
        $errors[] = "Email cannot be blank.";
    if (is_empty($user['user_password']))
        $errors[] = "Password cannot be blank.";

    if (has_length_greater_than($user['user_first'], MAX_LENGTH))
        $errors[] = "First name must be less than 256 characters.";
    if (has_length_greater_than($user['user_last'], MAX_LENGTH))
        $errors[] = "Last name must be less than 256 characters.";
    if (has_length_greater_than($user['user_name'], MAX_LENGTH))
        $errors[] = "Username must be less than 256 characters.";
    if (has_length_greater_than($user['user_email'], MAX_LENGTH))
        $errors[] = "Email must be less than 256 characters.";
    if (has_length_greater_than($user['user_password'], MAX_LENGTH))
        $errors[] = "Password must be less than 256 characters.";

    if (has_length_less_than($user['user_password'], 6))
        $errors[] = "Password must be at least 6 characters.";

    if (!has_valid_email_format($user['user_email']))
        $errors[] = "Email must be valid.";

    if (find_user_by_username($user['user_name']))
        $errors[] = "The username you chose is already in use.";

    return $errors;
}

function validate_edit_user($user) {
    $errors = [];
    
    if (is_empty($user['user_first']))
        $errors[] = "First name cannot be blank.";
    if (is_empty($user['user_last']))
        $errors[] = "Last name cannot be blank.";
    if (is_empty($user['user_name']))
        $errors[] = "Username cannot be blank.";
    if (is_empty($user['user_email']))
        $errors[] = "Email cannot be blank.";

    if (has_length_greater_than($user['user_first'], MAX_LENGTH))
        $errors[] = "First name must be less than 256 characters.";
    if (has_length_greater_than($user['user_last'], MAX_LENGTH))
        $errors[] = "Last name must be less than 256 characters.";
    if (has_length_greater_than($user['user_name'], MAX_LENGTH))
        $errors[] = "Username must be less than 256 characters.";
    if (has_length_greater_than($user['user_email'], MAX_LENGTH))
        $errors[] = "Email must be less than 256 characters.";

    if (!has_valid_email_format($user['user_email']))
        $errors[] = "Email must be valid.";

    $found_user = find_user_by_username($user['user_name']);
    if ($found_user && $found_user['user_name'] != $user['user_name'])
        $errors[] = "The username you chose is already in use.";

    return $errors;
}