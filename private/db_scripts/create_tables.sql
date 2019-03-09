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
    user_email varchar(255) NOT NULL,
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
    user_access_level int NOT NULL,
    session_join_date datetime NOT NULL,

    PRIMARY KEY (user_id, session_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE
);

CREATE TABLE Rank
(
    rank_id int NOT NULL AUTO_INCREMENT,
    session_id int,
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
    session_id int,
    badge_title varchar(255) NOT NULL,
    rank_id int,
    badge_required varchar(5) NOT NULL,
    badge_description varchar(500),
    badge_link varchar(255),
    image_id int,

    PRIMARY KEY (badge_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (rank_id) REFERENCES Rank (rank_id) ON UPDATE CASCADE,
    FOREIGN KEY (image_id) REFERENCES Image (image_id) ON UPDATE CASCADE

);

CREATE TABLE User_Badge
(
    user_id int,
    badge_id int,
    user_badge_priority int NOT NULL,
    user_badge_date datetime NOT NULL,

    PRIMARY KEY (user_id, badge_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE
);

CREATE TABLE User_Rank
(
    user_id int,
    rank_id int,
    user_rank_date datetime NOT NULL,

    PRIMARY KEY (user_id, rank_id),
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (rank_id) REFERENCES Rank (rank_id) ON UPDATE CASCADE
);

CREATE TABLE Style
(
    style_id int,
    style_title varchar(255) UNIQUE,
    style_css varchar(5000),
    session_id int,
    rank_id int,
    badge_id int,

    PRIMARY KEY (style_id),
    FOREIGN KEY (rank_id) REFERENCES Rank (rank_id) ON UPDATE CASCADE,
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (badge_id) REFERENCES Badge (badge_id) ON UPDATE CASCADE
);

CREATE TABLE Profile
(
    session_id int,
    user_id int,
    style_id int,
    profile_css varchar(5000),

    PRIMARY KEY (session_id, user_id),
    FOREIGN KEY (session_id) REFERENCES Session (session_id) ON UPDATE CASCADE,
    FOREIGN KEY (user_id) REFERENCES User (user_id) ON UPDATE CASCADE,
    FOREIGN KEY (style_id) REFERENCES Style (style_id) ON UPDATE CASCADE
);