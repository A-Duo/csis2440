CREATE DATABASE insecureDB;
USE insecureDB;
CREATE TABLE account(
    username varchar(40) not null primary key,
    password varchar(40) not null
);
INSERT INTO account (username, password) VALUES 
    ('chuck', 'roast'), 
    ('dog', 'house'), 
    ('car', 'toons'), 
    ('bob', 'ross');