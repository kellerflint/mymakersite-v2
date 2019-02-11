<?php

function find_all_users()
{
    global $db;
    $sql = "SELECT * FROM User";
    $user_set = mysqli_query($db, $sql);
    return $user_set;
}

// Returns assoc for user identified by their user_name
function find_user($username)
{
    global $db;
    $sql = "SELECT * from User where user_name = '" . $username . "';";
    $user_set = mysqli_query($db, $sql);
    $user = mysqli_fetch_assoc($user_set);
    return $user;
}

// Returns assoc for user identified by their rank_title
function find_rank($rank)
{
    global $db;
    $sql = "SELECT * from Rank where rank_title = '" . $rank . "';";
    $rank_set = mysqli_query($db, $sql);
    $rank = mysqli_fetch_assoc($rank_set);
    return $rank;
}

// returns all ranks the user has ordered by the rank level (descending)
function find_user_ranks($user_id)
{
    /*
    SELECT User_Rank.user_id, User_Rank.rank_id, Rank.rank_level, Rank.rank_title, Rank.image_id
    FROM User_Rank
    INNER JOIN Rank ON User_Rank.rank_id=Rank.rank_id
    where User_Rank.user_id = 1 ORDER BY Rank.rank_level DESC;
     */
    global $db;
    $sql = "SELECT User_Rank.user_id, User_Rank.rank_id, Rank.rank_level, Rank.rank_title, Rank.image_id ";
    $sql .= "FROM User_Rank INNER JOIN Rank ON User_Rank.rank_id=Rank.rank_id ";
    $sql .= "where User_Rank.user_id = ";
    $sql .= $user_id;
    $sql .= " ORDER BY Rank.rank_level DESC";
    $rank_set = mysqli_query($db, $sql);
    return $rank_set;
}

// Given image_id return image assoc
function find_image($image_id)
{
    global $db;
    $sql = "SELECT * FROM Image where image_id = ";
    $sql .= $image_id;
    $image_set = mysqli_query($db, $sql);
    $image = mysqli_fetch_assoc($image_set);
    return $image;
}

// Returns all ranks
function find_all_ranks()
{
    global $db;
    $sql = "SELECT * FROM Rank";
    $rank_set = mysqli_query($db, $sql);
    return $rank_set;
}

// Returns table of all badges a user has for a given rank
function find_user_badges($user_id, $rank_id)
{
    global $db;
    $sql = "SELECT
        User_Badge . user_id,
        User_Badge . badge_id,
        Badge . rank_id,
        Badge . badge_title,
        Badge . badge_required
        FROM
        User_Badge
        INNER JOIN Badge ON User_Badge . badge_id = Badge . badge_id
        where
        user_id = " . $user_id . " and rank_id = " . $rank_id . ";";
    $badge_set = mysqli_query($db, $sql);
    return $badge_set;
}

// Returns all required badges for given rank_id
function find_badges_for_rank($rank_id)
{
    global $db;
    $sql = "SELECT * FROM Badge WHERE rank_id = " . $rank_id . " AND badge_required = 'true';";
    $badge_set = mysqli_query($db, $sql);
    return $badge_set;
}

// Returns assoc for user identified by their badge_title
function find_badge($badge)
{
    global $db;
    $sql = "SELECT * from Badge where badge_title = '" . $badge . "';";
    $badge_set = mysqli_query($db, $sql);
    $badge = mysqli_fetch_assoc($badge_set);
    return $badge;
}