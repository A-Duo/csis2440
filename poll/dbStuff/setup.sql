create database pollDB;
use pollDB;

create table answers (
    id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    message varchar(100) NOT NULL, 
    count int unsigned default 0
);
INSERT INTO answers (message) VALUES 
    ('Pineapple'), 
    ('Mushroom'), 
    ('Meatball'), 
    ('Pepperoni'),
    ("I'm too weak for pizza :(");

create table submissions (
    ssid varchar(40) not null primary key,
    choice int unsigned not null
);


DELIMITER //
CREATE TRIGGER tr_submission_added AFTER INSERT ON submissions
FOR EACH ROW
BEGIN
    UPDATE answers SET count = count + 1 WHERE id=NEW.choice;
END; //
DELIMITER ;

DELIMITER //
CREATE TRIGGER tr_submission_choice_changed AFTER UPDATE ON submissions
FOR EACH ROW
BEGIN
    IF OLD.choice <> NEW.choice THEN
    	UPDATE answers SET count = count - 1 WHERE id=OLD.choice;
		UPDATE answers SET count = count + 1 WHERE id=NEW.choice;
    END IF;
END; //
DELIMITER ;

DELIMITER //
CREATE TRIGGER tr_submission_deleted AFTER DELETE ON submissions
FOR EACH ROW
BEGIN
    UPDATE answers SET count = count - 1 WHERE id=OLD.choice;
END; //
DELIMITER ;