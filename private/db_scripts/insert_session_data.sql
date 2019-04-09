/* source /var/www/html/mymakersite.com/private/db_scripts/insert_data.sql */

/* Hashed password is adminpass */

/* WITHOUT EMAIL TEST USERS*/
insert into User values (default, 'SYSTEM', 'SYSTEM', 'SYSTEM', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', now());

insert into User values (default, 'kellerflint', 'Keller', 'Flint', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', now());

set @system = (select user_id from User where user_name = 'SYSTEM');
set @keller = (select user_id from User where user_name = 'kellerflint');

insert into Session values (default, 'Auburn Gamemaker Junior', 'This is the session for the Gamemaker Junior makerspaces run in Auburn.');
insert into Session values (default, 'White River Game Design', 'This is the session for the White River Game Design afterschool program.');

set @session1 = (select session_id from Session where session_title = 'Auburn Gamemaker Junior');
set @session2 = (select session_id from Session where session_title = 'White River Game Design');

insert into User_Session values (@keller, @session1, now());
insert into User_Session values (@keller, @session2, now());

insert into Permission values (default, 'viewer', 'Can view the session. Has a private profile in the session.');
insert into Permission values (default, 'user', 'Is visible in the session. Has a public profile in the session.');
insert into Permission values (default, 'grader', 'Can give badges and ranks to any user in a session. Can remove badges and ranks from any use in a session.');
insert into Permission values (default, 'manager', 'Can invite users to a session. Can remove users from a session except managers, admins and the owner (unless they are also admins or the owner). Can grant and revoke any permission other than manager, admin and promoter.');
insert into Permission values (default, 'admin', 'Can add, edit and delete badges and ranks in a session. Can grant and revoke any permission (other than owner).');
insert into Permission values (default, 'owner', 'Can delete, edit or duplicate a session. Can grant and revoke any permission.');

insert into User_Permission values (@keller, @session1, 1, now(), @SYSTEM);
insert into User_Permission values (@keller, @session1, 2, now(), @SYSTEM);
insert into User_Permission values (@keller, @session1, 3, now(), @SYSTEM);
insert into User_Permission values (@keller, @session1, 4, now(), @SYSTEM);
insert into User_Permission values (@keller, @session1, 5, now(), @SYSTEM);
insert into User_Permission values (@keller, @session1, 6, now(), @SYSTEM);

insert into User_Permission values (@keller, @session2, 1, now(), @SYSTEM);
insert into User_Permission values (@keller, @session2, 2, now(), @SYSTEM);
insert into User_Permission values (@keller, @session2, 3, now(), @SYSTEM);
insert into User_Permission values (@keller, @session2, 4, now(), @SYSTEM);
insert into User_Permission values (@keller, @session2, 5, now(), @SYSTEM);
insert into User_Permission values (@keller, @session2, 6, now(), @SYSTEM);

insert into Image values (default, 'unranked', '/style/img/rank/unranked.png');
insert into Image values (default, 'bronze', '/style/img/rank/bronze.png');
insert into Image values (default, 'silver', '/style/img/rank/silver.png');
insert into Image values (default, 'gold', '/style/img/rank/gold.png');
insert into Image values (default, 'expert', '/style/img/rank/expert.png');
insert into Image values (default, 'master', '/style/img/rank/master.png');
insert into Image values (default, 'badge_default', '/style/img/badge/default.png');

set @unranked_img = (select image_id from Image where image_name = 'unranked');
set @novice_img = (select image_id from Image where image_name = 'bronze');
set @apprentice_img = (select image_id from Image where image_name = 'silver');
set @adept_img = (select image_id from Image where image_name = 'gold');
set @expert_img = (select image_id from Image where image_name = 'expert');
set @master_img = (select image_id from Image where image_name = 'master');

insert into Rank values (default, @session1, 'Unranked', 0, "You are new to the makerspace and learning the basics of Scratch coding.", @unranked_img);
insert into Rank values (default, @session1, 'Bronze', 1, "You know how to do the basics in Scratch. You can make simple games and animations on your own.", @novice_img);
insert into Rank values (default, @session1, 'Silver', 2, "You understand how to use most blocks in scratch and how to apply them to make games on your own.", @apprentice_img);
insert into Rank values (default, @session2, 'Gold', 3, "You understand all of the blocks in scratch and can use them to create good games on your own.", @adept_img);
insert into Rank values (default, @session2, 'Expert', 4, "You have great practical understanding of how coding and block interactions work and you can create any type of game you can image on your own.", @expert_img);
insert into Rank values (default, @session2, 'Master', 5, "Good luck!", @master_img);

set @unranked = (select rank_id from Rank where rank_title = 'Unranked');
set @bronze = (select rank_id from Rank where rank_title = 'Bronze');
set @silver = (select rank_id from Rank where rank_title = 'Silver');
set @gold = (select rank_id from Rank where rank_title = 'Gold');
set @expert = (select rank_id from Rank where rank_title = 'Expert');
set @master = (select rank_id from Rank where rank_title = 'Master');

/* Styles */
insert into Style values (default, 'classic', '_template.css', @session1, NULL);
insert into Style values (default, 'blackout', 'blackout.css', @session1, NULL);
insert into Style values (default, 'sunset', 'sunset.css', @session1, NULL);
insert into Style values (default, 'rainbow', 'rainbow.css', @session1, NULL);
insert into Style values (default, 'dark rainbow', 'dark_rainbow.css', @session1, NULL);

insert into Profile values (@keller, @session1, NULL);