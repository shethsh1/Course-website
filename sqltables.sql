
use a3;
drop table if exists grades;
drop table if exists feedback;
drop table if exists users;


CREATE TABLE users (
  username varchar(36) NOT NULL,
  password varchar(36) DEFAULT NULL,
  role varchar(36) DEFAULT NULL,
  PRIMARY KEY (username)
); 



CREATE TABLE grades (
  username varchar(256) NOT NULL,
  assignmentName varchar(256) NOT NULL,
  assignmentWeight float DEFAULT NULL,
  mark float DEFAULT NULL,
  remark boolean,
  description TEXT DEFAULT NULL,
  remarkTA varchar(256) DEFAULT NULL,
  foreign key(username) references users(username)
);


CREATE TABLE feedback (
  username varchar(36) DEFAULT NULL,
  messageOne TEXT DEFAULT NULL,
  messageTwo TEXT DEFAULT NULL,
  messageThree TEXT DEFAULT NULL,
  messageFour TEXT DEFAULT NULL,
  messageFive TEXT DEFAULT NULL,
  messageSix TEXT DEFAULT NULL,
  foreign key(username) references users(username)
  
);


insert into users VALUES
("bob", "bob", "student"),
("abbas", "abbas", "instructor");

insert into grades VALUES
("bob", "a1", 10, 50, FALSE, NULL, NULL),
("bob", "midterm", 10, 50, FALSE, NULL, NULL),
("bob", "final", 10, 50, FALSE, NULL, NULL);





