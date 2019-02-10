 <div id="user-box">
     <h2>Users</h2>
     <?php 
    $user_set = find_all_users();
    confirm_result($user_set);
    while ($user = mysqli_fetch_assoc($user_set)) {
        $ranks_set = find_user_ranks($user['user_id']);
        confirm_result($ranks_set);
        $rank = mysqli_fetch_assoc($ranks_set);
        ?>

     <div
         class="user-item <?php if ($user_count % 2 == 0) echo 'even';
                            else echo 'odd'; ?>">
         <p>
             <?php echo '|' . $user['user_name'] . '| ' . $user['user_first'] . ' ' . $user['user_last'] . ': ' . $rank['rank_title']; ?>
         </p>
     </div>

     <?php
    $user_count++;
} ?>

 </div>

 <div id="form-box">
     <form action="give_rank.php" method="POST">
         <input type="text">
         <button name="submit">Check Prerequisites</button>
     </form>
 </div>

 <div id="rank-box">
     <h2>Ranks</h2>
     <?php 
    $rank_set = find_all_ranks();
    confirm_result($rank_set);
    $rank_count = 0;
    while ($rank = mysqli_fetch_assoc($rank_set)) { ?>

     <div
         class="user-item <?php if ($rank_count % 2 == 0) echo 'even';
                            else echo 'odd'; ?>">
         <p>
             <?php echo $rank['rank_title']; ?>
         </p>
     </div>

     <?php
    $rank_count++;
} ?>

 </div>