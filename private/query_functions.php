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

function find_users_by_session($session_id) {
    global $db;
    $query = "SELECT User.user_id, User.user_first, User.user_last FROM User
    INNER JOIN User_Session ON User_Session.user_id = User.user_id
    WHERE User_Session.session_id = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $stmt->execute();

    $user_set = $stmt->get_result();

    $stmt->close();
    
    return $user_set;
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

// sql to update user
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

function has_permission ($session_id, $user_id, $required) {
    global $db;

    $query = "SELECT Permission.permission_title FROM User
	INNER JOIN User_Permission ON User_Permission.user_id = User.user_id
    INNER JOIN User_Session ON User_Session.user_id = User.user_id
    INNER JOIN Permission ON Permission.permission_id = User_Permission.permission_id
    WHERE User_Session.session_id = ? AND User.user_id = ? GROUP BY Permission.permission_title;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $session_id, $user_id);
    $stmt->execute();

    $permission_set = $stmt->get_result();


    while($perm = mysqli_fetch_assoc($permission_set)) {
        if ($perm['permission_title'] == $required)
            return true;
    }

    return false;
}

function find_leader_data($session_id) {

    global $db;

    $query = "SELECT User.user_id, User.user_first, Rank.rank_title, Image.image_path FROM User INNER JOIN
    (SELECT User_Rank.user_id, max(Rank.rank_level) AS Maxrank FROM Rank
    INNER JOIN User_Rank ON User_Rank.rank_id = Rank.rank_id
    INNER JOIN User_Session ON User_Session.user_id = User_Rank.user_id
    WHERE User_Session.session_id = ? AND Rank.session_id = ?
    GROUP BY user_id) Maxrank ON User.user_id = Maxrank.user_id
    INNER JOIN User_Rank ON User.user_id = User_Rank.user_id
    INNER JOIN Rank ON User_Rank.rank_id = Rank.rank_id
    INNER JOIN Image ON Rank.image_id = Image.image_id
    WHERE Rank.rank_level = Maxrank.Maxrank ORDER BY Maxrank.Maxrank DESC;";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $session_id, $session_id);
    $stmt->execute();

    $leader_set = $stmt->get_result();

    $stmt->close();

    return $leader_set;
}

function find_rank_data($session_id) {
    global $db;

    $query = "SELECT Rank.rank_id, Rank.rank_title, Rank.rank_description, Image.image_path FROM Rank 
    INNER JOIN Image ON Rank.image_id = Image.image_id
    WHERE Rank.session_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $session_id);
    $stmt->execute();

    $rank_set = $stmt->get_result();

    $stmt->close();

    return $rank_set;
}

function find_user_badges($user_id, $rank_id) {
    global $db;

    $query = "SELECT Badge.badge_id, Badge.badge_title, Badge.badge_required, Image.image_path, 'false' as badge_earned FROM Badge
	INNER JOIN Image ON Badge.image_id = Image.image_id
    WHERE Badge.rank_id = ? AND Badge.badge_id NOT IN (SELECT badge_id FROM User_Badge WHERE user_id = ?)
    UNION ALL
    SELECT Badge.badge_id, Badge.badge_title, Badge.badge_required, Image.image_path, 'true' as badge_earned FROM Badge
    INNER JOIN Image ON Badge.image_id = Image.image_id
    INNER JOIN User_Badge ON Badge.badge_id = User_Badge.badge_id
    WHERE User_Badge.user_id = ? AND Badge.rank_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("iiii", $rank_id, $user_id, $user_id, $rank_id);
    $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return $badge_set;
}

function find_profile_badges($session_id, $user_id) {
    global $db;
    
    $query = "SELECT Badge.badge_id, Badge.badge_title, Image.image_path, Image.image_name FROM Badge
	INNER JOIN Image ON Badge.image_id = Image.image_id
    INNER JOIN User_Badge ON Badge.badge_id = User_Badge.badge_id
    INNER JOIN User ON User_Badge.user_id = User.user_id
    INNER JOIN User_Session ON User.user_id = User_Session.user_id
    WHERE User.user_id = ? AND User_Session.session_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $session_id);
    $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return $badge_set;
}

function find_badge_by_id($badge_id) {
    global $db;
    
    $query = "SELECT Badge.badge_id, Badge.badge_title, Badge.badge_description, Badge.badge_link, 
    Badge.badge_required, Rank.rank_title FROM Badge 
    INNER JOIN Rank on Badge.rank_id = Rank.rank_id WHERE badge_id = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $badge_id);
    $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();
    
    return mysqli_fetch_assoc($badge_set);
}

function find_badge_session_by_id($badge_id) {
    global $db;

    $query = "SELECT Rank.session_id FROM Rank
    INNER JOIN Badge ON Badge.rank_id = Rank.rank_id
    WHERE Badge.badge_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $badge_id);
    $stmt->execute();

    $badge_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($badge_set);
}

function edit_badge($badge) {
    global $db;

    $errors = validate_edit_badge($badge);

    if(!empty($errors)) {
        return $errors;
    }

    $query = "UPDATE Badge SET badge_title = ?, rank_id = ?, badge_required = ?, 
    badge_description = ?, badge_link = ? WHERE badge_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param('sisssi', $badge['badge_title'], $badge['rank_id'], 
    $badge['badge_required'], $badge['badge_description'], $badge['badge_link'], $badge['badge_id']);
    
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function create_badge($badge) {
    global $db;

    $errors = validate_edit_badge($badge);

    if(!empty($errors)) {
        return $errors;
    }

    $query = "INSERT INTO Badge VALUES (default, ?, ?, ?, ?, ?, 7)";

    $stmt = $db->prepare($query);

    $stmt->bind_param('sisss', $badge['badge_title'], $badge['rank_id'], 
    $badge['badge_required'], $badge['badge_description'], $badge['badge_link']);
    
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function delete_badge($badge_id) {
    global $db;
    
    $query = "DELETE FROM User_Badge WHERE Badge_id = ?";

    $stmt = $db->prepare($query);

    $stmt->bind_param('i', $badge_id);
    
    $result = $stmt->execute();

    $query = "DELETE FROM Badge WHERE Badge_id = ?";

    $stmt = $db->prepare($query);

    $stmt->bind_param('i', $badge_id);
    
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function give_user_badge($user_id, $badge_id, $giver_id) {
    global $db;

    $query = "INSERT INTO User_Badge VALUES (?, ?, 0, now(), ?)";

    $stmt = $db->prepare($query);

    $stmt->bind_param('iii', $user_id, $badge_id, $giver_id);
    
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function remove_user_badge($user_id, $badge_id) {
    global $db;

    $query = "DELETE FROM User_Badge WHERE user_id = ? AND badge_id = ?";

    $stmt = $db->prepare($query);

    $stmt->bind_param('ii', $user_id, $badge_id);
    
    $result = $stmt->execute();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function find_rank_by_user($session_id, $user_id) {
    global $db;

    $query = "SELECT Rank.rank_title, Image.image_path FROM Rank
    INNER JOIN Image ON Image.image_id = Rank.image_id
    INNER JOIN User_Rank ON Rank.rank_id = User_Rank.rank_id
    WHERE Rank.session_id = ? AND User_Rank.user_id = ? ORDER BY Rank.rank_level DESC";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $session_id, $user_id);
    $stmt->execute();

    $rank_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($rank_set);
}

function give_user_rank($user_id, $rank_id,  $giver_id) {
    global $db;

    $query = "INSERT INTO User_Rank VALUES (?, ?, now(), ?)";

    $stmt = $db->prepare($query);

    $stmt->bind_param('iii', $user_id, $rank_id, $giver_id);
    
    $result = $stmt->execute();

    $stmt->close();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function remove_user_rank($user_id, $rank_id) {
    global $db;

    $query = "DELETE FROM User_Rank WHERE user_id = ? AND rank_id = ?";

    $stmt = $db->prepare($query);

    $stmt->bind_param('ii', $user_id, $rank_id);
    
    $result = $stmt->execute();

    $stmt->close();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

function update_permissions($permission_array, $user_id, $session_id, $giver_id) {
    global $db;

    $result = false;
    
    for ($i = 0; $i < sizeof($permission_array); $i++) {
        $permission_id = ($i + 1);
        if ($permission_array[$i] == "true") {
            $query = "INSERT INTO User_Permission VALUES(?,?,?, now(), ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('iiii', $user_id, $session_id, $permission_id, $giver_id);
            $result = $stmt->execute();
            $stmt->close();
        } else {
            $query = "DELETE FROM User_Permission WHERE user_id = ? AND session_id = ? AND permission_id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('iii', $user_id, $session_id, $permission_id);
            $result = $stmt->execute();
            $stmt->close();
        }
    }
    
    if ($result) {
        return true;
    } else {
        return false;
    }
}

// Returns set of users not in session by a search
// TODO running this query in workbench returns as expected but in php producing duplicate search results
function find_users_like($session_id, $user_search) {
    global $db;
    
    $search = '%';
    $search .= $user_search;
    $search .= '%';

    $query = "SELECT DISTINCT User.user_id, User.user_name FROM User 
    WHERE User.user_id NOT IN (SELECT user_id FROM User_Session WHERE session_id = ?) 
    AND User.user_name LIKE ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $session_id, $search);
    $stmt->execute();

    $user_set = $stmt->get_result();

    $stmt->close();

    return $user_set;
}

function add_user_session($session_id, $user_id) {
    global $db;

    $query = "INSERT INTO User_Session VALUES (?, ?, now())";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $session_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    if ($result) {
        $default_permissions = ['true', 'true', 'false', 'false', 'false', 'false'];
        update_permissions($default_permissions, $user_id, $session_id, 1);
        return true;
    } else {
        return false;
    }
}

function remove_user_session($session_id, $user_id) {
    global $db;

    $query = "DELETE FROM User_Session WHERE user_id = ? AND session_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $user_id, $session_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();
    
    if ($result) {
        $no_permissions = ['false', 'false', 'false', 'false', 'false', 'false'];
        update_permissions($default_permissions, $user_id, $session_id, 1);
        return true;
    } else {
        return false;
    }
}

function find_profile_styles($session_id, $user_id) {
    global $db;

    $query = "SELECT Style.style_id, Style.style_title, Style.style_css_url FROM Style
	INNER JOIN Profile ON Profile.style_id = Style.style_id
    WHERE Profile.session_id = ? AND Profile.user_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $session_id, $user_id);
    $stmt->execute();

    $style_set = $stmt->get_result();

    $stmt->close();

    return $style_set;
}

function find_profile_style($session_id, $user_id) {
    global $db;

    $query = "SELECT Profile.style_id, Style.style_css_url FROM Profile
	INNER JOIN Style ON Style.style_id = Profile.style_id
    WHERE Profile.session_id = ? AND Profile.user_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $session_id, $user_id);
    $stmt->execute();

    $style_set = $stmt->get_result();

    $stmt->close();

    return mysqli_fetch_assoc($style_set);
}

function set_profile_style($session_id, $user_id, $style_id) {
    $query = "UPDATE Profile SET style_id = ? WHERE session_id = ? AND user_id = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param("iii", $style_id, $session_id, $user_id);
    $stmt->execute();

    $result = $stmt->get_result();

    $stmt->close();

    if ($result) {
        return true;
    } else {
        return false;
    }
}

/* Validation functions */

// at least check if owner is being deleted
function validate_user_deletion() {
    
}

function validate_edit_badge($badge) {
    $errors = [];
    return $errors;
}

function validate_create_badge($badge) {
    $errors = [];
    return $errors;
}

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