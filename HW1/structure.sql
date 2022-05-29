mysql -u root -p
CREATE database hw1;
use hw1;

CREATE TABLE Users(
    username varchar(20) PRIMARY KEY,
    name varchar(20) not null,
    surname varchar(20) not null,
    email varchar(20) not null unique,
    password varchar(20) not null,
    nfavorite integer default 0,
    nrec_written integer default 0,
    pro_gif varchar(255) default null
) engine=InnoDB;

CREATE TABLE Recipe(
    id integer primary key auto_increment,
    username varchar(20) not null,
    title varchar(20) not null,
    text varchar(255),
    image varchar(255),
    nlikes integer default 0,
    ncomments integer default 0,
    index ind_user(username),
    foreign key(username) references users(username) on delete cascade on update cascade
) engine=InnoDB;

CREATE TABLE Ingredients(
    name varchar(50) not null,
    recipe integer not null,
    primary key(name,recipe),
    index ind_rec(recipe),
    foreign key(recipe) references recipe(id) on delete cascade on update cascade
) engine=InnoDB;

CREATE TABLE likeRecipe (
    username varchar(20) not null,
    recipe integer not null,
    primary key(username,recipe),
    index ind_user(username),
    index ind_rec(recipe),
    foreign key(username) references users(username) on delete cascade on update cascade,
    foreign key(recipe) references recipe(id) on delete cascade on update cascade
) engine=InnoDB;

CREATE TABLE favoriteRecipe (
    username varchar(20) not null,
    recipe integer not null,
    primary key(username,recipe),
    index ind_user(username),
    index ind_rec(recipe),
    foreign key(username) references users(username) on delete cascade on update cascade,
    foreign key(recipe) references recipe(id) on delete cascade on update cascade
) engine=InnoDB;

CREATE TABLE comment (
    id integer primary key auto_increment,
    username varchar(20) not null,
    recipe integer not null,
    text varchar(255),
    index ind_user(username),
    index ind_rec(recipe),
    foreign key(username) references users(username) on delete cascade on update cascade,
    foreign key(recipe) references recipe(id) on delete cascade on update cascade
) Engine = InnoDB;



/* TRIGGERS */

CREATE TRIGGER Add_Recipe
AFTER INSERT ON Recipe
FOR EACH ROW
UPDATE Users
SET nrec_written = nrec_written + 1
WHERE username = NEW.username;

CREATE TRIGGER Delete_Recipe
AFTER DELETE ON Recipe
FOR EACH ROW
UPDATE Users
SET nrec_written = nrec_written - 1
WHERE username = OLD.username;


CREATE TRIGGER Add_Favorite
AFTER INSERT ON favoriteRecipe
FOR EACH ROW
UPDATE Users
SET nfavorite = nfavorite + 1
WHERE username = NEW.username;

CREATE TRIGGER Remove_Favorite
AFTER DELETE ON favoriteRecipe
FOR EACH ROW
UPDATE Users
SET nfavorite = nfavorite - 1
WHERE username = OLD.username;


CREATE TRIGGER Add_like
AFTER INSERT ON likeRecipe
FOR EACH ROW
UPDATE Recipe
SET nlikes = nlikes + 1
WHERE id = NEW.recipe;

CREATE TRIGGER Remove_like
AFTER DELETE ON likeRecipe
FOR EACH ROW
UPDATE Recipe
SET nlikes = nlikes - 1
WHERE id = OLD.recipe;


CREATE TRIGGER Add_comment
AFTER INSERT ON comment
FOR EACH ROW
UPDATE Recipe
SET ncomments = ncomments + 1
WHERE id = NEW.recipe;

CREATE TRIGGER Remove_comment
AFTER DELETE ON comment
FOR EACH ROW
UPDATE Recipe
SET ncomments = ncomments - 1
WHERE id = OLD.recipe;