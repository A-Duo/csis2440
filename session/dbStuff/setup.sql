CREATE DATABASE sessionDB;
USE sessionDB;
CREATE TABLE account(
    username varchar(40) not null primary key,
    password varchar(40) not null,
    picture varchar(40) not null
);
INSERT INTO account (username, password, picture) VALUES 
    ('chuck', 'roast', 'chuck.webp'), 
    ('dog', 'house', 'doghouse.webp'), 
    ('car', 'toons', 'cartoon.webp'), 
    ('bob', 'ross', 'bobross.jpg');