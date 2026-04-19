CREATE DATABASE hashbrownDB;
USE hashbrownDB;
CREATE TABLE secureusers(
    username varchar(40) not null primary key,
    password varchar(512) not null,
    password_salt char(16) not null unique,
    picture varchar(40),
    login_count smallint default 0
);