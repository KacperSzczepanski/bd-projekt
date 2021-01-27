DROP TABLE ratetab;
DROP TABLE mist;
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
    email VARCHAR2(40) NOT NULL CHECK (email LIKE '%_@__%.__%'),
    descr LONG
);

CREATE TABLE publish_house (
    id NUMBER(6) DEFAULT seq_publ.nextval PRIMARY KEY,
    name VARCHAR2(50) NOT NULL,
    address VARCHAR2(100) NOT NULL,
    email VARCHAR2(40) NOT NULL CHECK (email LIKE '%_@__%.__%'),
    phone NUMBER(9),
    added_by VARCHAR2(15) NOT NULL REFERENCES users_tab
);

CREATE TABLE author (
    id NUMBER(6) DEFAULT seq_auth.nextval PRIMARY KEY,
    name VARCHAR2(100)
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
    name VARCHAR2(50) NOT NULL,
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

INSERT INTO class_levels VALUES (1, 'Szkola podstawowa 1');
INSERT INTO class_levels VALUES (2, 'Szkola podstawowa 2');
INSERT INTO class_levels VALUES (3, 'Szkola podstawowa 3');
INSERT INTO class_levels VALUES (4, 'Szkola podstawowa 4');
INSERT INTO class_levels VALUES (5, 'Szkola podstawowa 5');
INSERT INTO class_levels VALUES (6, 'Szkola podstawowa 6');
INSERT INTO class_levels VALUES (7, 'Szkola podstawowa 7');
INSERT INTO class_levels VALUES (8, 'Szkola podstawowa 8');
INSERT INTO class_levels VALUES (9, 'Liceum 1');
INSERT INTO class_levels VALUES (10, 'Liceum 2');
INSERT INTO class_levels VALUES (11, 'Liceum 3');
INSERT INTO class_levels VALUES (12, 'Liceum 4');
INSERT INTO class_levels VALUES (13, 'Technikum 1');
INSERT INTO class_levels VALUES (14, 'Technikum 2');
INSERT INTO class_levels VALUES (15, 'Technikum 3');
INSERT INTO class_levels VALUES (16, 'Technikum 4');
INSERT INTO class_levels VALUES (17, 'Technikum 5');
INSERT INTO class_levels VALUES (18, 'Szkola zawodowa 1');
INSERT INTO class_levels VALUES (19, 'Szkola zawodowa 2');
INSERT INTO class_levels VALUES (20, 'Szkola zawodowa 3');

--dane

INSERT INTO users_tab VALUES ('admin', '$2y$10$/2x4WPlghOUi8WKJFksGYes0Xkl6YgyIcGwACV6FzF.5Lt/uZOrP.', 'Jeff', 'email@testowy.sql', 'konto testowe');

INSERT INTO publish_house VALUES (10, 'Oficyna Edukacyjna * Krzysztof Pazdro', 'ul. Koscianska 4, 01-695 Warszawa', 'handlowy@pazdro.com.pl', 225608116, 'admin');
INSERT INTO publish_house VALUES (11, 'WSiP Wydawnictwo Szkolne i Pedagogiczne', 'al. Jerozolimskie 96, 02-017 Warszawa', 'wsip@wsip.com.pl', 801220555, 'admin');
INSERT INTO publish_house VALUES (12, 'Nowa Era', 'al. Jerozolimskie 146d, 02-305 Warszawa', 'nowaera@nowaera.pl', 801881010, 'admin');

INSERT INTO author VALUES (10, 'Opracowanie Zbiorowe');

INSERT INTO author VALUES (11, 'Kurczab Marcin');
INSERT INTO author VALUES (12, 'Kurczab Elzbieta');
INSERT INTO author VALUES (13, 'Swida Elzbieta');

INSERT INTO author VALUES (14, 'Braun Marcin');
INSERT INTO author VALUES (15, 'Byczuk Agnieszka');
INSERT INTO author VALUES (16, 'Byczuk Krzysztof');
INSERT INTO author VALUES (17, 'Wojtowicz Elzbieta');

INSERT INTO author VALUES (18, 'Davies Paul A.');
INSERT INTO author VALUES (19, 'Lambert Viv');

INSERT INTO author VALUES (20, 'Gromek Ewa');
INSERT INTO author VALUES (21, 'Klos Ewa');
INSERT INTO author VALUES (22, 'Kofta Wawrzyniec');
INSERT INTO author VALUES (23, 'Laskowska Ewa');
INSERT INTO author VALUES (24, 'Melson Andrzej');

INSERT INTO author VALUES (25, 'Knopik Justyna');
INSERT INTO author VALUES (26, 'Kucharska Maria');
INSERT INTO author VALUES (27, 'Przybyl Ryszard');
INSERT INTO author VALUES (28, 'Skomoroko Kamila');
INSERT INTO author VALUES (29, 'Witek-Nowakowska Alina');

INSERT INTO author VALUES (30, 'Guzik Marek');
INSERT INTO author VALUES (31, 'Kozik Ryszard');
INSERT INTO author VALUES (32, 'Zamachowski Wladyslaw');


INSERT INTO books VALUES (10, 'Matematyka 3', 1, 2, 3, 11, 10, 'admin');
INSERT INTO auth_book VALUES (11, 10);
INSERT INTO auth_book VALUES (12, 10);
INSERT INTO auth_book VALUES (13, 10);

INSERT INTO books VALUES (11, 'Matematyka 3', 1, 2, 1, 11, 10, 'admin');
INSERT INTO auth_book VALUES (11, 11);
INSERT INTO auth_book VALUES (12, 11);
INSERT INTO auth_book VALUES (13, 11);

INSERT INTO books VALUES (12, 'Repetytorium matura', 3, 1, 5, 12, 11, 'admin');
INSERT INTO auth_book VALUES (10, 12);

INSERT INTO books VALUES (13, 'Zrozumiec fizyke 1', 2, 2, 1, 9, 12, 'admin');
INSERT INTO books VALUES (14, 'Zrozumiec fizyke 1', 2, 2, 1, 13, 12, 'admin');
INSERT INTO auth_book VALUES (14, 13);
INSERT INTO auth_book VALUES (15, 13);
INSERT INTO auth_book VALUES (16, 13);
INSERT INTO auth_book VALUES (17, 13);
INSERT INTO auth_book VALUES (14, 14);
INSERT INTO auth_book VALUES (15, 14);
INSERT INTO auth_book VALUES (16, 14);
INSERT INTO auth_book VALUES (17, 14);

INSERT INTO books VALUES (15, 'Przyroda 4', 8, 1, 1, 4, 11, 'admin');
INSERT INTO auth_book VALUES (20, 15);
INSERT INTO auth_book VALUES (21, 15);
INSERT INTO auth_book VALUES (22, 15);
INSERT INTO auth_book VALUES (23, 15);
INSERT INTO auth_book VALUES (24, 15);

INSERT INTO books VALUES (16, 'Planeta Nowa', 10, 1, 2, 7, 12, 'admin');
INSERT INTO auth_book VALUES (25, 16);
INSERT INTO auth_book VALUES (26, 16);
INSERT INTO auth_book VALUES (27, 16);
INSERT INTO auth_book VALUES (28, 16);
INSERT INTO auth_book VALUES (29, 16);

INSERT INTO books VALUES (17, 'Biologia na czasie 2', 6, 2, 1, 10, 10, 12, 'admin');
INSERT INTO books VALUES (18, 'Biologia na czasie 2', 6, 2, 1, 10, 14, 12, 'admin');
INSERT INTO auth_book VALUES (30, 17);
INSERT INTO auth_book VALUES (31, 17);
INSERT INTO auth_book VALUES (32, 17);
INSERT INTO auth_book VALUES (30, 18);
INSERT INTO auth_book VALUES (31, 18);
INSERT INTO auth_book VALUES (32, 18);

COMMIT;
