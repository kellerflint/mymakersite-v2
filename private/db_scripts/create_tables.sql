/* source /var/www/html/mymakersite.com/private/db_scripts/create_tables.sql */

CREATE TABLE Image
(
    image_id int NOT NULL AUTO_INCREMENT,
    image_name varchar(255) NOT NULL UNIQUE,
    image_path varchar(255) NOT NULL,

    PRIMARY KEY (image_id)
);

CREATE TABLE User
(
    user_id int NOT NULL AUTO_INCREMENT,
    user_name varchar(255) NOT NULL UNIQUE,
    user_first varchar(255) NOT NULL,
    user_last varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    user_email varchar(255) NOT NULL UNIQUE,
    user_join_date datetime NOT NULL,

    PRIMARY KEY (user_id)
);

CREATE TABLE Session
(
    session_id int NOT NULL AUTO_INCREMENT,
    session_title varchar(255) NOT NULL,
    session_description varchar(5000),

    PRIMARY KEY (session_id)
);

CREATE TABLE User_Session 
(
    user_id int,
    session_id int,
    session_join_date datetime NOT NULL,

    PRIMARY KEY (user_id, session_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE
);

CREATE TABLE Permission 
(
    permission_id int NOT NULL AUTO_INCREMENT,
    permission_title varchar(255) NOT NULL,
    permission_description varchar(5000) NOT NULL,

    PRIMARY KEY (permission_id)
);

CREATE TABLE User_Permission
(
    user_id int,
    session_id int,
    permission_id int,
    user_permission_date datetime NOT NULL,
    user_permission_granter int NOT NULL,

    PRIMARY KEY (user_id, session_id, permission_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (user_permission_granter) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES Permission (permission_id) ON UPDATE CASCADE


);

CREATE TABLE Rank
(
    rank_id int NOT NULL AUTO_INCREMENT,
    session_id int NOT NULL,
    rank_title varchar(255) NOT NULL,
    rank_level int NOT NULL,
    rank_description varchar(5000),
    image_id int,

    PRIMARY KEY (rank_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (image_id) REFERENCES Image (image_id) ON UPDATE CASCADE
);

CREATE TABLE Badge
(
    badge_id int NOT NULL AUTO_INCREMENT,
    badge_title varchar(255) NOT NULL,
    rank_id int NOT NULL,
    badge_required varchar(5) NOT NULL,
    badge_description varchar(5000),
    badge_link varchar(255),
    image_id int,

    PRIMARY KEY (badge_id),
    FOREIGN KEY (rank_id) REFERENCES Rank (rank_id) ON UPDATE CASCADE,
    FOREIGN KEY (image_id) REFERENCES Image (image_id) ON UPDATE CASCADE

);

CREATE TABLE User_Badge
(
    user_id int,
    badge_id int,
    user_badge_priority int NOT NULL,
    user_badge_date datetime NOT NULL,
    user_badge_giver int NOT NULL,

    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE,
    FOREIGN KEY (user_badge_giver) REFERENCES User (user_id) ON UPDATE CASCADE
);

CREATE TABLE User_Rank
(
    user_id int,
    rank_id int,
    user_rank_date datetime NOT NULL,
    user_rank_giver int  NOT NULL,

    PRIMARY KEY (user_id, rank_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (rank_id) REFERENCES Rank (rank_id) ON UPDATE CASCADE,
    FOREIGN KEY (user_rank_giver) REFERENCES User (user_id) ON UPDATE CASCADE
);

CREATE TABLE Style
(
    style_id int NOT NULL AUTO_INCREMENT,
    style_title varchar(255) NOT NULL,
    style_css_url varchar(255) NOT NULL,
    session_id int NOT NULL,
    badge_id int,

    PRIMARY KEY (style_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE
);

CREATE TABLE Profile
(
    user_id int,
    session_id int,
    style_id int,   

    PRIMARY KEY (user_id, session_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (style_id) REFERENCES Style (style_id) ON UPDATE CASCADE
);

/* Not sure if I'm gonna keep these. But I want some type of optional customizable static page for a session. 
Just upload html maybe?*/
/*
CREATE TABLE Page_Item
(
    page_item_id int,
    page_item_title varchar(255) NOT NULL,
    page_item_code varchar(255) NOT NULL,

    PRIMARY KEY (page_item_id)
);

CREATE TABLE Custom_Page
(
    custom_page_id int,
    session_id int NOT NULL,
    custom_page_title varchar(255) NOT NULL,
    style_id int,

    PRIMARY KEY (custom_page_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (style_id) REFERENCES Style (style_id) ON UPDATE CASCADE
);

CREATE TABLE Custom_Page_Item
(
    custom_page_id int,
    page_item_id int,
    page_item_priority int,
    page_item_content varchar(5000),

    PRIMARY KEY (custom_page_id, page_item_id, page_item_priority),
    FOREIGN KEY (custom_page_id) REFERENCES Custom_Page (custom_page_id) ON UPDATE CASCADE,
    FOREIGN KEY (page_item_id) REFERENCES Page_Item (page_item_id) ON UPDATE CASCADE
);

*/