<?php require_once '../../private/initialize.php'; ?>

<?php $page_title = 'Add User'; ?>

<?php include_once SHARED_PATH . '/default_header.php'; ?>

<?php
if (request_is_post()) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    echo $username . '<br>';
    echo has_value($username) . '<br>';

    if (has_value($username) &&
        has_value($firstname) &&
        has_value($lastname) &&
        has_value($password)) {
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
            $rank = find_rank('Unranked');
            confirm_result($rank);

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

        } else {
            echo '<br>Insert failed: ' . mysqli_error($db);
            db_disconnect($db);
            exit;
        }
    } else {
        echo 'Error: All fields for user are required and must not be empty.';
    }

} else { ?>

<div class="content">

    <form action="add_user.php" method="POST">
        <label for='firstname'>First Name: </label>
        <input type="text" name="firstname" id="firstname">
        <br>
        <label for='lastname'>Last Name: </label>
        <input type="text" name="lastname" id="lastname">
        <br>
        <label for='username'>Username: </label>
        <input type="text" name="username" id="username">
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

<script src="../../private/scripts/autofill_uname.js"></script>
<?php include_once SHARED_PATH . '/default_footer.php'; ?>

<?php 
} ?>