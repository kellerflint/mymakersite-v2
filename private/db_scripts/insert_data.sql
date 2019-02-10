/* source /var/www/html/mymakersite.com/private/db_scripts/insert_data.sql */

insert into User values (default, 'kellerflint', 'Keller', 'Flint', 'adminpass', 'admin', now());

insert into Image values (default, 'unranked', '/mymakersite.com/public/style/img/rank/unranked.png');
insert into Image values (default, 'novice', '/mymakersite.com/public/style/img/rank/novice.png');
insert into Image values (default, 'apprentice', '/mymakersite.com/public/style/img/rank/apprentice.png');
insert into Image values (default, 'adept', '/mymakersite.com/public/style/img/rank/adept.png');
insert into Image values (default, 'expert', '/mymakersite.com/public/style/img/rank/expert.png');
insert into Image values (default, 'master', '/mymakersite.com/public/style/img/rank/master.png');

set @unranked_img = (select image_id from Image where image_name = 'unranked');
set @novice_img = (select image_id from Image where image_name = 'novice');
set @apprentice_img = (select image_id from Image where image_name = 'apprentice');
set @adept_img = (select image_id from Image where image_name = 'adept');
set @expert_img = (select image_id from Image where image_name = 'expert');
set @master_img = (select image_id from Image where image_name = 'master');

insert into Subject values (default, 'Scratch', '1');
insert into Subject values (default, 'Gamemaker', '1');

set @scratch = (select subject_id from Subject where subject_title = 'Scratch');

insert into Rank values (default, @scratch, 'Unranked', 0, @unranked_img);
insert into Rank values (default, @scratch, 'Novice', 1, @novice_img);
insert into Rank values (default, @scratch, 'Apprentice', 2, @apprentice_img);
insert into Rank values (default, @scratch, 'Adept', 3, @adept_img);
insert into Rank values (default, @scratch, 'Expert', 4, @expert_img);
insert into Rank values (default, @scratch, 'Master', 5, @master_img);

set @unranked = (select rank_id from Rank where rank_title = 'Unranked');
set @novice = (select rank_id from Rank where rank_title = 'Novice');
set @apprentice = (select rank_id from Rank where rank_title = 'Apprentice');
set @adept = (select rank_id from Rank where rank_title = 'Adept');
set @expert = (select rank_id from Rank where rank_title = 'Expert');
set @master = (select rank_id from Rank where rank_title = 'Master');

set @keller = (select user_id from User where user_name = 'kellerflint');
insert into User_Rank values (@keller, @adept, now());

/* Novice Badges */

insert into Badge values (default, 'Animate from Scratch', @novice, 'novice badge 1', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '1');

insert into Badge values (default, 'Musical Storyteller', @novice, 'novice badge 2', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '1');

insert into Badge values (default, 'My First Game', @novice, 'novice badge 3', 
'https://resources.scratch.mit.edu/www/cards/en/scratch-cards-all.pdf', '1');

/* Apprentice Badges */

insert into Badge values (default, 'Move to the Code', @apprentice, 'apprentice badge 1', 
'https://codeclubprojects.org/en-GB/scratch/lost-in-space/', '1');

insert into Badge values (default, 'Who You Gonna Call', @apprentice, 'apprentice badge 2', 
'https://codeclubprojects.org/en-GB/scratch/ghostbusters/', '1');

insert into Badge values (default, 'Talk to the Bot', @apprentice, 'apprentice badge 3', 
'https://codeclubprojects.org/en-GB/scratch/chatbot/', '1');

insert into Badge values (default, 'Artistic License', @apprentice, 'apprentice badge 4', 
'https://codeclubprojects.org/en-GB/scratch/paint-box/', '1');

insert into Badge values (default, 'Whatever Floats Your Boat', @apprentice, 'apprentice badge 5', 
'https://codeclubprojects.org/en-GB/scratch/boat-race/', '1');

/* Adept Badges */

/* Expert Badges */

/* Master Badges */