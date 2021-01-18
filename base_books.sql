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
DROP TABLE users_tab;
DROP TABLE publish_house;




CREATE TABLE publish_house (
    id NUMBER(6) PRIMARY KEY,
    name VARCHAR2(30) NOT NULL,
    addres VARCHAR2(40) NOT NULL,
    email VARCHAR2(30) NOT NULL CHECK (email LIKE '%_@__%.__%'),
    phone NUMBER(9)
);

CREATE TABLE users_tab (
    login VARCHAR2(15) PRIMARY KEY,
    pwd VARCHAR2(255) NOT NULL,
    name VARCHAR2(30),
    email VARCHAR2(30) NOT NULL CHECK (email LIKE '%_@__%.__%'),
    descr LONG
);

CREATE TABLE author (
    id NUMBER(6) PRIMARY KEY,
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
    id NUMBER(10) PRIMARY KEY,
    name VARCHAR2(30) NOT NULL,
    subj NUMBER(3) NOT NULL REFERENCES subject,
    lev NUMBER(2) REFERENCES levels,
    type NUMBER(2) NOT NULL REFERENCES book_types,
    class NUMBER(2) REFERENCES class_levels,
    pub NUMBER(6) NOT NULL REFERENCES publish_house
);

CREATE TABLE auth_book (
    id_au NUMBER(6) NOT NULL,
    id_book NUMBER(10) NOT NULL,
    CONSTRAINT id PRIMARY KEY (id_au, id_book)
);

CREATE TABLE bookedition (
    book NUMBER(10) NOT NULL,
    yer NUMBER(4) NOT NULL,
    CONSTRAINT id_boed PRIMARY KEY (book, yer)
);

CREATE TABLE mist (
    id NUMBER(10) PRIMARY KEY,
    book NUMBER(10) NOT NULL,
    yr NUMBER(4) NOT NULL,
    page NUMBER(3),
    descr LONG,
    CONSTRAINT edit FOREIGN KEY (book, yr) REFERENCES bookedition
);

CREATE TABLE ratetab (
    id NUMBER(10) PRIMARY KEY,
    ratetype NUMBER(1) NOT NULL, --1 - ocena, 2- poz. trud.
    val NUMBER(2) NOT NULL CHECK (val >= 0 AND val <= 10),
    book NUMBER(10) NOT NULL REFERENCES books,
    userlog VARCHAR2(15) NOT NULL REFERENCES users_tab,
    descr LONG,
    CONSTRAINT usbo UNIQUE (book, userlog, ratetype)
);
