<?php require_once '../../private/initialize.php'; ?>

<?php $page_title = 'Add User' ?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php
if (request_is_post()) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO User VALUES (default, ";
    $sql .= "'" . hsc($username) . "', ";
    $sql .= "'" . hsc($firstname) . "', ";
    $sql .= "'" . hsc($lastname) . "', ";
    $sql .= "'" . hsc($password) . "', ";
    $sql .= "'" . $role . "', ";
    $sql .= "now());";

    $result = mysqli_query($db, $sql);

    if ($result) {
        $new_id = mysqli_insert_id($db);
        echo 'New user created with id ' . $new_id;

        // add unranked as default rank
        $sql = "SELECT rank_id FROM Rank where rank_title = 'unranked'";

        $result_set = mysqli_query($db, $sql);
        confirm_result($result_set);
        $rank = mysqli_fetch_assoc($result_set);

        echo "<br>" . $sql . "<br>";

        $sql = "INSERT INTO User_Rank VALUES('";
        $sql .= $new_id . "',  '";
        $sql .= $rank['rank_id'] . "', ";
        $sql .= "now());";

        echo "<br>" . $sql . "<br>";

        $rank_result = mysqli_query($db, $sql);

        if ($rank_result) {
            echo "Default rank assigned to user " . "";
        } else {
            echo "Default rank insert failed: " . mysqli_error($db);
        }

        echo 'Redirecting in 5 seconds... ';

        //sleep(5);
        // TODO Should redirect to user profile page once implemented
        //redirect_to('student/index.php');



    } else {
        echo '<br>Insert failed: ' . mysqli_error($db);
        db_disconnect($db);
        exit;
    }


} else { ?>

<div class="content">

    <form action="add_user.php" method="POST">
        <label for='username'>Username: </label>
        <input type="text" name="username" id="username">
        <br>
        <label for='firstname'>First Name: </label>
        <input type="text" name="firstname" id="firstname">
        <br>
        <label for='lastname'>Last Name: </label>
        <input type="text" name="lastname" id="lastname">
        <br>
        <label for='password'>Password: </label>
        <input type="text" name="password" id="password">
        <br>
        <label for='role'>Role: </label>
        <select name="role" id="role">
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
            <option value="admin">Admin</option>
        </select>
        <br>
        <button name="submit">Add User</button>
    </form>

</div>


<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php 
} ?>