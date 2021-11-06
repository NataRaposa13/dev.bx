CREATE TABLE language
(
    ID char(2) not null,
    NAME varchar(256) not null,

    PRIMARY KEY (ID)
);

CREATE TABLE movie_title
(
    MOVIE_ID int not null,
    LANGUAGE_ID char(2) not null,
    TITLE varchar(500) not null,

    PRIMARY KEY (MOVIE_ID, LANGUAGE_ID),
    FOREIGN KEY FK_MT_MOVIE (MOVIE_ID)
        REFERENCES movie(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    FOREIGN KEY FK_MT_LANGUAGE (LANGUAGE_ID)
        REFERENCES language(ID)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);