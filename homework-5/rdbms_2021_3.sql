# 1. Вывести список фильмов, в которых снимались одновременно Арнольд Шварценеггер и Линда Хэмилтон
#    Формат: ID фильма, Название на русском языке, Имя режиссёра.

# 1.1 подзапросы
SELECT m.ID, mt.TITLE, d.NAME
FROM movie m
         INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID
         INNER JOIN director d on d.ID = m.DIRECTOR_ID
WHERE mt.LANGUAGE_ID = 'ru'
  AND m.ID IN (SELECT MOVIE_ID FROM movie_actor WHERE ACTOR_ID = 1)
  AND m.ID IN (SELECT MOVIE_ID FROM movie_actor WHERE ACTOR_ID = 3);

# 1.2 подсчёт количества актёров
SELECT m.ID, mt.TITLE, d.NAME
FROM movie m
         LEFT JOIN movie_title mt on m.ID = mt.MOVIE_ID AND mt.LANGUAGE_ID = 'ru'
         INNER JOIN director d on m.DIRECTOR_ID = d.ID
         INNER JOIN movie_actor ma1 on m.ID = ma1.MOVIE_ID
WHERE ma1.ACTOR_ID in (1, 3)
GROUP BY 1, 2, 3
HAVING COUNT(DISTINCT ma1.ACTOR_ID) = 2;

# 2. Вывести список названий фильмов на англйском языке с "откатом" на русский, в случае если название на английском не задано
#    Формат: ID фильма, Название.

# 2.1 два джойна на одну таблицу
SELECT m.ID,
       IFNULL(mt_en.TITLE, mt_ru.TITLE) TITLE
FROM movie m
         LEFT JOIN movie_title mt_en on m.ID = mt_en.MOVIE_ID AND mt_en.LANGUAGE_ID = 'en'
         LEFT JOIN movie_title mt_ru on m.ID = mt_ru.MOVIE_ID AND mt_ru.LANGUAGE_ID = 'ru'
ORDER BY ID;

# 2.2 подзапрос
SELECT m.ID,
       IFNULL(mt_en.TITLE, (SELECT TITLE FROM movie_title WHERE MOVIE_ID = m.ID AND LANGUAGE_ID = 'ru')) TITLE
FROM movie m
         LEFT JOIN movie_title mt_en on m.ID = mt_en.MOVIE_ID AND mt_en.LANGUAGE_ID = 'en'
ORDER BY ID;

# 3. Вывести самый длительный фильм Джеймса Кэмерона
#    Формат: ID фильма, Название на русском языке, Длительность.

SELECT m.ID, mt.TITLE, LENGTH
FROM movie m
         INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID
WHERE mt.LANGUAGE_ID = 'ru'
  AND DIRECTOR_ID = 1
  AND LENGTH in (SELECT MAX(LENGTH) FROM movie);

# без использования подзапросов
SELECT ID, mt.TITLE, LENGTH
FROM movie
         LEFT JOIN movie_title mt on movie.ID = mt.MOVIE_ID AND mt.LANGUAGE_ID = 'ru'
WHERE DIRECTOR_ID = 1
ORDER BY LENGTH DESC
    LIMIT 1;

# 4. Вывести список фильмов с названием, сокращённым до 10 символов. Если название короче 10 символов – оставляем как есть.
#    Если длиннее – сокращаем до 10 символов и добавляем многоточие
#    Формат: ID фильма, сокращённое название

SELECT ID,
       IF(CHAR_LENGTH(TITLE) > 10, CONCAT(LEFT(TITLE, 10), '...'), TITLE) as TITLE
FROM movie
         INNER JOIN movie_title on ID = MOVIE_ID;

# 4.1
SELECT ID,
       IF(CHAR_LENGTH(mt.TITLE) < 10, mt.TITLE, CONCAT(LEFT(mt.TITLE, 9), '...')) SHORT_TITLE
FROM movie m
         LEFT JOIN movie_title mt on m.ID = mt.MOVIE_ID AND LANGUAGE_ID = 'ru'
ORDER BY ID;

# 4.2 Интересное решение с INSERT
SELECT m.ID, INSERT(LEFT(mt.TITLE, 10), 11, 3, '...') AS ABBREVIATED_NAME
FROM movie m
    INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID;

# 5. Вывести количество фильмов, в которых снимался каждый актёр
#    Формат: Имя актёра, Количество фильмов актёра.

SELECT NAME,
       (SELECT COUNT(MOVIE_ID) FROM movie_actor WHERE ID = ACTOR_ID) as NUMBER_OF_FILMS
FROM actor;

SELECT NAME,
       COUNT(MOVIE_ID) as NUMBER_OF_FILMS
FROM actor
         INNER JOIN movie_actor on ID = ACTOR_ID
GROUP BY 1;

# 5.1
SELECT a.NAME,
       COUNT(ma.MOVIE_ID) MOVIE_COUNT
FROM actor a
         LEFT JOIN movie_actor ma on a.ID = ma.ACTOR_ID
GROUP BY a.NAME;

# 6. Вывести жанры, в которых никогда не снимался Арнольд Шварценеггер
#    Формат: ID жанра, название

SELECT g.ID, g.NAME
FROM genre g
WHERE g.NAME NOT IN (SELECT DISTINCT g.NAME
                     FROM genre g
                            INNER JOIN movie_genre mg on g.ID = mg.GENRE_ID
                            INNER JOIN movie m on mg.MOVIE_ID = m.ID
                     WHERE m.ID IN (SELECT MOVIE_ID FROM movie_actor WHERE ACTOR_ID = 1));

# 6.1 подзапрос
SELECT *
FROM genre
WHERE ID NOT IN (
    SELECT mg.GENRE_ID
    FROM movie_actor ma
             INNER JOIN movie_genre mg on ma.MOVIE_ID = mg.MOVIE_ID
    WHERE ma.ACTOR_ID = 1);

# 6.2 подсчет количества
SELECT g.ID, g.NAME
FROM genre g
         INNER JOIN movie_genre mg on g.ID = mg.GENRE_ID
         LEFT JOIN movie_actor ma on mg.MOVIE_ID = ma.MOVIE_ID AND ma.ACTOR_ID = 1
GROUP BY 1
HAVING COUNT(ma.MOVIE_ID) = 0;

# 6.3 (решение от Игоря Константинова) и Василия Кулагина
SELECT g.ID, g.NAME
FROM movie_actor ma
         INNER JOIN movie_genre mg on ma.MOVIE_ID = mg.MOVIE_ID AND ma.ACTOR_ID = 1
         RIGHT JOIN genre g on g.ID = mg.GENRE_ID
WHERE ma.ACTOR_ID IS NULL;

# 7. Вывести список фильмов, у которых больше 3-х жанров
#    Формат: ID фильма, название на русском языке

SELECT m.ID,
       mt.TITLE
FROM movie m
         INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID
WHERE mt.LANGUAGE_ID = 'ru'
  AND (SELECT count(MOVIE_ID) FROM movie_genre mg WHERE m.ID = mg.MOVIE_ID) > 3;

# 7.1 без подзапроса
SELECT movie.ID, mt.TITLE
FROM movie
         LEFT JOIN movie_title mt on movie.ID = mt.MOVIE_ID AND LANGUAGE_ID = 'ru'
         INNER JOIN movie_genre mg on movie.ID = mg.MOVIE_ID
GROUP BY 1
HAVING COUNT(mg.GENRE_ID) > 3;

# 8. Вывести самый популярный жанр для каждого актёра Формат вывода: Имя актёра, Жанр, в котором у актёра больше всего фильмов.
#    Формат вывода: Имя актёра, Жанр, в котором у актёра больше всего фильмов.

SELECT a.NAME,
       g.NAME
FROM actor a
         INNER JOIN movie_actor ma on a.ID = ma.ACTOR_ID
         INNER JOIN movie m on ma.MOVIE_ID = m.ID
         INNER JOIN movie_genre mg on m.ID = mg.MOVIE_ID
         INNER JOIN genre g on mg.GENRE_ID = g.ID
WHERE g.NAME = (SELECT g2.NAME
                FROM actor a2
                        INNER JOIN movie_actor ma2 on a2.ID = ma2.ACTOR_ID
                        INNER JOIN movie m2 on ma2.MOVIE_ID = m2.ID
                        INNER JOIN movie_genre mg2 on m2.ID = mg2.MOVIE_ID
                        INNER JOIN genre g2 on mg2.GENRE_ID = g2.ID
                WHERE ma2.ACTOR_ID = a.ID
                GROUP BY g2.NAME
                ORDER BY COUNT(1) desc LIMIT 1)
GROUP BY a.NAME, g.NAME;

SELECT a.NAME,
       g.NAME,
       COUNT(g.NAME) cnt
FROM actor a
         INNER JOIN movie_actor ma on a.ID = ma.ACTOR_ID
         INNER JOIN movie m on ma.MOVIE_ID = m.ID
         INNER JOIN movie_genre mg on m.ID = mg.MOVIE_ID
         INNER JOIN genre g on mg.GENRE_ID = g.ID
GROUP BY 1, 2
ORDER BY 1, 3 DESC;

SELECT a.NAME,
       g.NAME,
       COUNT(g.NAME)
FROM actor a
         INNER JOIN movie_actor ma on a.ID = ma.ACTOR_ID
         INNER JOIN movie m on ma.MOVIE_ID = m.ID
         INNER JOIN movie_genre mg on m.ID = mg.MOVIE_ID
         INNER JOIN genre g on mg.GENRE_ID = g.ID
GROUP BY 1, 2
HAVING COUNT(g.NAME) = (SELECT COUNT(g2.NAME)
                         FROM actor a2
                                  INNER JOIN movie_actor ma2 on a2.ID = ma2.ACTOR_ID
                                  INNER JOIN movie m2 on ma2.MOVIE_ID = m2.ID
                                  INNER JOIN movie_genre mg2 on m2.ID = mg2.MOVIE_ID
                                  INNER JOIN genre g2 on mg2.GENRE_ID = g2.ID
                         GROUP BY a2.NAME, g2.NAME
                         ORDER BY COUNT(g2.NAME) DESC LIMIT 1);

# 8.1
SELECT a.NAME,
       (SELECT g.NAME
        FROM movie_actor ma
                 INNER JOIN movie_genre mg on ma.MOVIE_ID = mg.MOVIE_ID
                 INNER JOIN genre g on mg.GENRE_ID = g.ID
        WHERE ma.ACTOR_ID = a.ID
        GROUP BY 1
        ORDER BY COUNT(DISTINCT mg.MOVIE_ID) DESC
           LIMIT 1) AS MOST_POPULAR_GENRE
FROM actor a;
