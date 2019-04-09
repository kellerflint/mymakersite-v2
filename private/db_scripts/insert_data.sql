/* source /var/www/html/mymakersite.com/private/db_scripts/insert_data.sql */

/* Hashed password is adminpass */

/* WITHOUT EMAIL TEST USERS*/
insert into User values (default, 'SYSTEM', 'SYSTEM', 'SYSTEM', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', now());

insert into User values (default, 'kellerflint', 'Keller', 'Flint', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', now());

insert into User values (default, 'testuser1', 'TestA', 'UserA', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', now());

insert into User values (default, 'testuser2', 'TestB', 'UserB', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', now());

/* WITH EMAIL TEST USERS
insert into User values (default, 'SYSTEM', 'SYSTEM', 'SYSTEM', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'kflint0068@gmail.com', now());

insert into User values (default, 'kellerflint', 'Keller', 'Flint', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'system@gmail.com', now());

insert into User values (default, 'testuser1', 'TestA', 'UserA', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'something@gmail.com', now());

insert into User values (default, 'testuser2', 'TestB', 'UserB', 
'$2y$10$jM8vtCbP3ml.x5OlvkhkpObt7M0agzz4AVwB7s0vMkN1E9N8Qp89G', 'nothing@gmail.com', now());
*/

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

insert into User_Permission values (@testuser1, @session1, 1, now(), @SYSTEM);
insert into User_Permission values (@testuser1, @session1, 2, now(), @SYSTEM);

insert into User_Permission values (@testuser2, @session1, 1, now(), @SYSTEM);
insert into User_Permission values (@testuser2, @session1, 2, now(), @SYSTEM);

insert into Image values (default, 'unranked', '/mymakersite.com/public_html/style/img/rank/unranked.png');
insert into Image values (default, 'bronze', '/mymakersite.com/public_html/style/img/rank/bronze.png');
insert into Image values (default, 'silver', '/mymakersite.com/public_html/style/img/rank/silver.png');
insert into Image values (default, 'gold', '/mymakersite.com/public_html/style/img/rank/gold.png');
insert into Image values (default, 'expert', '/mymakersite.com/public_html/style/img/rank/expert.png');
insert into Image values (default, 'master', '/mymakersite.com/public_html/style/img/rank/master.png');
insert into Image values (default, 'badge_default', '/mymakersite.com/public_html/style/img/badge/default.png');

set @unranked_img = (select image_id from Image where image_name = 'unranked');
set @novice_img = (select image_id from Image where image_name = 'bronze');
set @apprentice_img = (select image_id from Image where image_name = 'silver');
set @adept_img = (select image_id from Image where image_name = 'gold');
set @expert_img = (select image_id from Image where image_name = 'expert');
set @master_img = (select image_id from Image where image_name = 'master');

insert into Rank values (default, @session1, 'Unranked', 0, "TODO", @unranked_img);
insert into Rank values (default, @session1, 'Bronze', 1, "TODO", @novice_img);
insert into Rank values (default, @session1, 'Silver', 2, "TODO", @apprentice_img);
insert into Rank values (default, @session2, 'Gold', 3, "TODO", @adept_img);
insert into Rank values (default, @session2, 'Expert', 4, "TODO", @expert_img);
insert into Rank values (default, @session2, 'Master', 5, "TODO", @master_img);

set @unranked = (select rank_id from Rank where rank_title = 'Unranked');
set @bronze = (select rank_id from Rank where rank_title = 'Bronze');
set @silver = (select rank_id from Rank where rank_title = 'Silver');
set @gold = (select rank_id from Rank where rank_title = 'Gold');
set @expert = (select rank_id from Rank where rank_title = 'Expert');
set @master = (select rank_id from Rank where rank_title = 'Master');

insert into User_Rank values (@keller, @unranked, now(), @system);
insert into User_Rank values (@keller, @bronze, now(), @system);
insert into User_Rank values (@keller, @silver, now(), @system);
insert into User_Rank values (@keller, @gold, now(), @system);
insert into User_Rank values (@keller, @expert, now(), @system);
insert into User_Rank values (@keller, @master, now(), @system);

insert into User_Rank values (@testuser1, @unranked, now(), @system);
insert into User_Rank values (@testuser1, @bronze, now(), @system);

insert into User_Rank values (@testuser2, @unranked, now(), @system);

/* bronze Badges */
insert into Badge values (default, 'Animate from Scratch', @bronze, 'true', 'bronze badge 1', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '7');

insert into Badge values (default, 'Musical Storyteller', @bronze, 'false', 'bronze badge 2', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '7');

insert into Badge values (default, 'My First Game', @bronze, 'true', 'bronze badge 3', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '7');

/* silver Badges */

insert into Badge values (default, 'Move to the Code', @silver, 'true', 'silver badge 1', 
'https://codeclubprojects.org/en-GB/scratch/lost-in-space/', '7');

insert into Badge values (default, 'Who You Gonna Call', @silver, 'true', 'silver badge 2', 
'https://codeclubprojects.org/en-GB/scratch/ghostbusters/', '7');

insert into Badge values (default, 'Talk to the Bot', @silver, 'true', 'silver badge 3', 
'https://codeclubprojects.org/en-GB/scratch/chatbot/', '7');

insert into Badge values (default, 'Artistic License', @silver, 'true', 'silver badge 4', 
'https://codeclubprojects.org/en-GB/scratch/paint-box/', '7');

insert into Badge values (default, 'Whatever Floats Your Boat', @expert, 'true', 'silver badge 5', 
'https://codeclubprojects.org/en-GB/scratch/boat-race/', '7');

/* gold Badges */

/* Expert Badges */

/* Master Badges */

set @novice_badge1 = (select badge_id from Badge where badge_title = "Animate from Scratch");

insert into User_Badge values (@keller, @novice_badge1, 1, now(), @SYSTEM);

/* Styles */
insert into Style values (default, 'classic', '_template.css', @session1, NULL);
insert into Style values (default, 'blackout', 'blackout.css', @session1, NULL);
insert into Style values (default, 'sunset', 'sunset.css', @session1, NULL);
insert into Style values (default, 'rainbow', 'rainbow.css', @session1, NULL);
insert into Style values (default, 'dark rainbow', 'dark_rainbow.css', @session1, NULL);

insert into Profile values (@keller, @session1, NULL);