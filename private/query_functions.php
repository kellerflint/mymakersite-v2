<?php

function find_all_users()
{
    global $db;
    $sql = "SELECT * FROM User";
    $user_set = mysqli_query($db, $sql);
    return $user_set;
}

// Returns data set from highest rank (currently returns all rows ordered by badge level cause I'm bad at SQL)
// As opposed to something like find_all_user_ranks() which would return the full set (i.e. what it does now... kill me)
function find_user_rank($user_id)
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
    $rank = mysqli_fetch_assoc($rank_set);
    return $rank;
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