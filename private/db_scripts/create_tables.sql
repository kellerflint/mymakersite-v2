/* source /var/www/html/mymakersite.com/private/db_scripts/create_tables.sql */

CREATE TABLE User
(
    user_id int NOT NULL AUTO_INCREMENT,
    user_name varchar(50) NOT NULL UNIQUE,
    user_first varchar(50) NOT NULL,
    user_last varchar(50) NOT NULL,
    user_password varchar(50) NOT NULL,
    user_role varchar(50) NOT NULL,
    user_join_date datetime NOT NULL,

    PRIMARY KEY (user_id)
);

CREATE TABLE Image
(
    image_id int NOT NULL AUTO_INCREMENT,
    image_name varchar(50) NOT NULL,
    image_path varchar(200) NOT NULL,

    PRIMARY KEY (image_id)
);

CREATE TABLE Subject
(
    subject_id int NOT NULL AUTO_INCREMENT,
    subject_title varchar(50) NOT NULL,
    image_id int,

    PRIMARY KEY (subject_id),
    FOREIGN KEY (image_id) REFERENCES Image (image_id) ON UPDATE CASCADE
);


CREATE TABLE Rank
(
    rank_id int NOT NULL AUTO_INCREMENT,
    subject_id int,
    rank_title varchar(50) NOT NULL,
    rank_level int NOT NULL,
    image_id int,

    PRIMARY KEY (rank_id),
    FOREIGN KEY (subject_id) REFERENCES Subject (subject_id) ON UPDATE CASCADE,
    FOREIGN KEY (image_id) REFERENCES Image (image_id) ON UPDATE CASCADE
);

CREATE TABLE Badge
(
    badge_id int NOT NULL AUTO_INCREMENT,
    badge_title varchar(50) NOT NULL,
    rank_id int,
    badge_required varchar(5) NOT NULL,
    badge_description varchar(500),
    badge_link varchar(200),
    image_id int,

    PRIMARY KEY (badge_id),
    FOREIGN KEY (rank_id) REFERENCES Rank (rank_id) ON UPDATE CASCADE,
    FOREIGN KEY (image_id) REFERENCES Image (image_id) ON UPDATE CASCADE

);

CREATE TABLE User_Badge
(
    user_id int,
    badge_id int,
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