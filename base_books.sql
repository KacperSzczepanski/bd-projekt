DROP TABLE ratetab;
DROP TABLE mist;
DROP TABLE bookedition;
DROP TABLE auth_book;
DROP TABLE books;
DROP TABLE class_levels;
DROP TABLE levels;
DROP TABLE book_types;
DROP TABLE subject;
DROP TABLE author;
DROP TABLE publish_house;
DROP TABLE users_tab;
DROP SEQUENCE seq_books;
DROP SEQUENCE seq_publ;
DROP SEQUENCE seq_rate;
DROP SEQUENCE seq_mist;
DROP SEQUENCE seq_auth;

CREATE SEQUENCE seq_books START WITH 10 INCREMENT BY 1;
CREATE SEQUENCE seq_publ START WITH 10 INCREMENT BY 1;
CREATE SEQUENCE seq_rate START WITH 10 INCREMENT BY 1;
CREATE SEQUENCE seq_mist START WITH 10 INCREMENT BY 1;
CREATE SEQUENCE seq_auth START WITH 10 INCREMENT BY 1;



CREATE TABLE users_tab (
    login VARCHAR2(15) PRIMARY KEY,
    pwd VARCHAR2(255) NOT NULL,
    name VARCHAR2(30),
    email VARCHAR2(30) NOT NULL CHECK (email LIKE '%_@__%.__%'),
    descr LONG
);

CREATE TABLE publish_house (
    id NUMBER(6) DEFAULT seq_publ.nextval PRIMARY KEY,
    name VARCHAR2(30) NOT NULL,
    address VARCHAR2(40) NOT NULL,
    email VARCHAR2(30) NOT NULL CHECK (email LIKE '%_@__%.__%'),
    phone NUMBER(9),
    added_by VARCHAR2(15) NOT NULL REFERENCES users_tab
);

CREATE TABLE author (
    id NUMBER(6) DEFAULT seq_auth.nextval PRIMARY KEY,
    name VARCHAR2(30)
);

CREATE TABLE subject (
    id NUMBER(3) PRIMARY KEY,
    name VARCHAR2(30) NOT NULL
);

CREATE TABLE book_types (
    id NUMBER(2) PRIMARY KEY,
    btype VARCHAR2(20) NOT NULL UNIQUE
);

CREATE TABLE levels (
    id NUMBER(2) PRIMARY KEY,
    name VARCHAR2(30) NOT NULL UNIQUE
);

CREATE TABLE class_levels (
    id NUMBER(2) PRIMARY KEY,
    name VARCHAR(30)
);

CREATE TABLE books (
    id NUMBER(10) DEFAULT seq_books.nextval PRIMARY KEY,
    name VARCHAR2(30) NOT NULL,
    subj NUMBER(3) NOT NULL REFERENCES subject,
    lev NUMBER(2) REFERENCES levels,
    type NUMBER(2) NOT NULL REFERENCES book_types,
    class NUMBER(2) REFERENCES class_levels,
    pub NUMBER(6) NOT NULL REFERENCES publish_house,
    added_by VARCHAR2(15) NOT NULL REFERENCES users_tab
);

CREATE TABLE auth_book (
    id_au NUMBER(6) NOT NULL,
    id_book NUMBER(10) NOT NULL,
    CONSTRAINT id PRIMARY KEY (id_au, id_book)
);

CREATE TABLE mist (
    id NUMBER(10) DEFAULT seq_mist.nextval PRIMARY KEY,
    book NUMBER(10) NOT NULL REFERENCES books,
    yr NUMBER(4) NOT NULL,
    page NUMBER(3),
    descr LONG,
    auth VARCHAR2(15) REFERENCES users_tab
);

CREATE TABLE ratetab (
    id NUMBER(10) DEFAULT seq_mist.nextval PRIMARY KEY,
    rateval NUMBER(2) CHECK ((rateval >= 0 AND rateval <= 10) OR rateval IS NULL),
    difficval NUMBER(2) CHECK ((difficval >= 0 AND difficval <= 10) OR difficval IS NULL),
    book NUMBER(10) NOT NULL REFERENCES books,
    userlog VARCHAR2(15) NOT NULL REFERENCES users_tab,
    descr LONG,
    CONSTRAINT usbo UNIQUE (book, userlog),
    CONSTRAINT col CHECK (rateval IS NOT NULL OR difficval IS NOT NULL)
);

INSERT INTO subject VALUES (1, 'Matematyka');
INSERT INTO subject VALUES (2, 'Fizyka');
INSERT INTO subject VALUES (3, 'j. polski');
INSERT INTO subject VALUES (4, 'j.angielski');
INSERT INTO subject VALUES (5, 'Chemia');
INSERT INTO subject VALUES (6, 'Biologia');
INSERT INTO subject VALUES (7, 'j. hiszpanski');
INSERT INTO subject VALUES (8, 'Przyroda');
INSERT INTO subject VALUES (9, 'Religia');
INSERT INTO subject VALUES (10, 'Geografia');

INSERT INTO book_types VALUES (1, 'Podrecznik');
INSERT INTO book_types VALUES (2, 'Cwiczenia');
INSERT INTO book_types VALUES (3, 'Zbior zadan');
INSERT INTO book_types VALUES (4, 'Zadania konkursowe');
INSERT INTO book_types VALUES (5, 'Repetytorium');

INSERT INTO levels VALUES (1, 'Zakres podstawowy');
INSERT INTO levels VALUES (2, 'Zakres rozszerzony');

INSERT INTO class_levels VALUES (1, '1 SP');
INSERT INTO class_levels VALUES (2, '2 SP');
INSERT INTO class_levels VALUES (3, '3 SP');
INSERT INTO class_levels VALUES (4, '4 SP');
INSERT INTO class_levels VALUES (5, '5 SP');
INSERT INTO class_levels VALUES (6, '6 SP');
INSERT INTO class_levels VALUES (7, '7 SP');
INSERT INTO class_levels VALUES (8, '8 SP');
INSERT INTO class_levels VALUES (9, '1 LO');
INSERT INTO class_levels VALUES (10, '2 LO');
INSERT INTO class_levels VALUES (11, '3 LO');
INSERT INTO class_levels VALUES (12, '4 LO');
INSERT INTO class_levels VALUES (13, '1 TE');
INSERT INTO class_levels VALUES (14, '2 TE');
INSERT INTO class_levels VALUES (15, '3 TE');
INSERT INTO class_levels VALUES (16, '4 TE');
INSERT INTO class_levels VALUES (17, '5 TE');
INSERT INTO class_levels VALUES (18, '1 SZ');
INSERT INTO class_levels VALUES (19, '2 SZ');
INSERT INTO class_levels VALUES (20, '3 SZ');
COMMIT;
