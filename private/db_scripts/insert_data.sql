/* source /var/www/html/mymakersite.com/private/db_scripts/insert_data.sql */

/* Hashed password is adminpass */
insert into User values (default, 'SYSTEM', 'SYSTEM', 'SYSTEM', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'kflint0068@gmail.com', now());

insert into User values (default, 'kellerflint', 'Keller', 'Flint', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'system@gmail.com', now());

insert into User values (default, 'testuser1', 'TestA', 'UserA', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'something@gmail.com', now());

insert into User values (default, 'testuser2', 'TestB', 'UserB', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'nothing@gmail.com', now());

set @system = (select user_id from User where user_name = 'SYSTEM');
set @keller = (select user_id from User where user_name = 'kellerflint');
set @testuser1 = (select user_id from User where user_name = 'testuser1');
set @testuser2 = (select user_id from User where user_name = 'testuser2');

insert into Session values (default, 'Session 1', 'Session 1 Descript');
insert into Session values (default, 'Session 2', 'Session 2 Descript');

set @session1 = (select session_id from Session where session_title = 'Session 1');
set @session2 = (select session_id from Session where session_title = 'Session 2');

insert into User_Session values (@keller, @session1, now());
insert into User_Session values (@keller, @session2, now());

insert into User_Session values (@testuser1, @session1, now());
insert into User_Session values (@testuser2, @session1, now());

insert into Permission values (default, 'viewer', 'Can view the session. Has a private profile in the session.');
insert into Permission values (default, 'user', 'Is visible in the session. Has a public profile in the session.');
insert into Permission values (default, 'grader', 'Can give badges and ranks to any user in a session. Can remove badges and ranks from any use in a session.');
insert into Permission values (default, 'manager', 'Can invite users to a session. Can remove users from a session except managers, admins and the owner (unless they are also admins or the owner). Can grant and revoke any permission other than manager, admin and promoter.');
insert into Permission values (default, 'admin', 'Can add, edit and delete badges and ranks in a session. Can grant and revoke any permission (other than owner).');
insert into Permission values (default, 'owner', 'Can delete, edit or duplicate a session. Can grant and revoke any permission.');

insert into User_Permission values (@keller, @session1, 1, now());
insert into User_Permission values (@keller, @session1, 2, now());
insert into User_Permission values (@keller, @session1, 3, now());
insert into User_Permission values (@keller, @session1, 4, now());
insert into User_Permission values (@keller, @session1, 5, now());
insert into User_Permission values (@keller, @session1, 6, now());

insert into User_Permission values (@keller, @session2, 1, now());
insert into User_Permission values (@keller, @session2, 2, now());
insert into User_Permission values (@keller, @session2, 3, now());
insert into User_Permission values (@keller, @session2, 4, now());
insert into User_Permission values (@keller, @session2, 5, now());
insert into User_Permission values (@keller, @session2, 6, now());

insert into User_Permission values (@testuser1, @session1, 1, now());
insert into User_Permission values (@testuser1, @session1, 2, now());

insert into User_Permission values (@testuser2, @session1, 1, now());
insert into User_Permission values (@testuser2, @session1, 2, now());

insert into Image values (default, 'unranked', '/mymakersite.com/public_html/style/img/rank/unranked.png');
insert into Image values (default, 'novice', '/mymakersite.com/public_html/style/img/rank/novice.png');
insert into Image values (default, 'apprentice', '/mymakersite.com/public_html/style/img/rank/apprentice.png');
insert into Image values (default, 'adept', '/mymakersite.com/public_html/style/img/rank/adept.png');
insert into Image values (default, 'expert', '/mymakersite.com/public_html/style/img/rank/expert.png');
insert into Image values (default, 'master', '/mymakersite.com/public_html/style/img/rank/master.png');
insert into Image values (default, 'badge_default', '/mymakersite.com/public_html/style/img/badge/default.png');

set @unranked_img = (select image_id from Image where image_name = 'unranked');
set @novice_img = (select image_id from Image where image_name = 'novice');
set @apprentice_img = (select image_id from Image where image_name = 'apprentice');
set @adept_img = (select image_id from Image where image_name = 'adept');
set @expert_img = (select image_id from Image where image_name = 'expert');
set @master_img = (select image_id from Image where image_name = 'master');

insert into Rank values (default, @session1, 'Unranked', 0, "TODO", @unranked_img);
insert into Rank values (default, @session1, 'Novice', 1, "TODO", @novice_img);
insert into Rank values (default, @session1, 'Apprentice', 2, "TODO", @apprentice_img);
insert into Rank values (default, @session2, 'Adept', 3, "TODO", @adept_img);
insert into Rank values (default, @session2, 'Expert', 4, "TODO", @expert_img);
insert into Rank values (default, @session2, 'Master', 5, "TODO", @master_img);

set @unranked = (select rank_id from Rank where rank_title = 'Unranked');
set @novice = (select rank_id from Rank where rank_title = 'Novice');
set @apprentice = (select rank_id from Rank where rank_title = 'Apprentice');
set @adept = (select rank_id from Rank where rank_title = 'Adept');
set @expert = (select rank_id from Rank where rank_title = 'Expert');
set @master = (select rank_id from Rank where rank_title = 'Master');

insert into User_Rank values (@keller, @unranked, now(), @system);
insert into User_Rank values (@keller, @novice, now(), @system);
insert into User_Rank values (@keller, @apprentice, now(), @system);
insert into User_Rank values (@keller, @adept, now(), @system);
insert into User_Rank values (@keller, @expert, now(), @system);
insert into User_Rank values (@keller, @master, now(), @system);

insert into User_Rank values (@testuser1, @unranked, now(), @system);
insert into User_Rank values (@testuser1, @novice, now(), @system);

insert into User_Rank values (@testuser2, @unranked, now(), @system);

/* Novice Badges */
insert into Badge values (default, 'Animate from Scratch', @novice, 'true', 'novice badge 1', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '7');

insert into Badge values (default, 'Musical Storyteller', @novice, 'false', 'novice badge 2', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '7');

insert into Badge values (default, 'My First Game', @novice, 'true', 'novice badge 3', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '7');

/* Apprentice Badges */

insert into Badge values (default, 'Move to the Code', @apprentice, 'true', 'apprentice badge 1', 
'https://codeclubprojects.org/en-GB/scratch/lost-in-space/', '7');

insert into Badge values (default, 'Who You Gonna Call', @apprentice, 'true', 'apprentice badge 2', 
'https://codeclubprojects.org/en-GB/scratch/ghostbusters/', '7');

insert into Badge values (default, 'Talk to the Bot', @apprentice, 'true', 'apprentice badge 3', 
'https://codeclubprojects.org/en-GB/scratch/chatbot/', '7');

insert into Badge values (default, 'Artistic License', @apprentice, 'true', 'apprentice badge 4', 
'https://codeclubprojects.org/en-GB/scratch/paint-box/', '7');

insert into Badge values (default, 'Whatever Floats Your Boat', @expert, 'true', 'apprentice badge 5', 
'https://codeclubprojects.org/en-GB/scratch/boat-race/', '7');

/* Adept Badges */

/* Expert Badges */

/* Master Badges */

set @novice_badge1 = (select badge_id from Badge where badge_title = "Animate from Scratch");

insert into User_Badge values (@keller, @novice_badge1, 1, now(), @SYSTEM);