#1. Вывести список фильмов, в которых снимались одновременно Арнольд Шварценеггер и Линда Хэмилтон
SELECT m.ID,
       mt.TITLE,
       d.NAME
FROM movie m
         INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID
         INNER JOIN director d on d.ID = m.DIRECTOR_ID
WHERE mt.LANGUAGE_ID = 'ru'
  AND m.ID IN (SELECT MOVIE_ID FROM movie_actor WHERE ACTOR_ID = 1)
  AND m.ID IN (SELECT MOVIE_ID FROM movie_actor WHERE ACTOR_ID = 3);

#2. Вывести список названий фильмов на англйском языке с "откатом" на русский, в случае если название на английском не задано
SELECT MOVIE_ID, TITLE FROM movie_title
WHERE LANGUAGE_ID in ('en','ru') GROUP BY MOVIE_ID;

#3. Вывести самый длительный фильм Джеймса Кэмерона
SELECT m.ID,
       mt.TITLE,
       LENGTH
FROM movie m
         INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID
WHERE mt.LANGUAGE_ID = 'ru'
  AND DIRECTOR_ID = 1
  AND LENGTH in (SELECT MAX(LENGTH) FROM movie);

#4. Вывести список фильмов с названием, сокращённым до 10 символов. Если название короче 10 символов – оставляем как есть.
#   Если длиннее – сокращаем до 10 символов и добавляем многоточие
SELECT ID,
       IF(CHAR_LENGTH(TITLE) > 10, CONCAT(LEFT(TITLE, 10), '...'), TITLE) as TITLE
FROM movie
         INNER JOIN movie_title on ID = MOVIE_ID;

#5. Вывести количество фильмов, в которых снимался каждый актёр
SELECT NAME,
       (SELECT COUNT(MOVIE_ID) FROM movie_actor WHERE ID = ACTOR_ID) as NUMBER_OF_FILMS
FROM actor;

SELECT NAME,
       COUNT(MOVIE_ID) as NUMBER_OF_FILMS
FROM actor
         INNER JOIN movie_actor on ID = ACTOR_ID
GROUP BY 1;

#6. Вывести жанры, в которых никогда не снимался Арнольд Шварценеггер
SELECT g.ID, g.NAME
FROM genre g
WHERE g.NAME NOT IN (SELECT DISTINCT g.NAME
                     FROM genre g
                            INNER JOIN movie_genre mg on g.ID = mg.GENRE_ID
                            INNER JOIN movie m on mg.MOVIE_ID = m.ID
                     WHERE m.ID IN (SELECT MOVIE_ID FROM movie_actor WHERE ACTOR_ID = 1));

#7. Вывести список фильмов, у которых больше 3-х жанров
SELECT m.ID,
       mt.TITLE
FROM movie m
         INNER JOIN movie_title mt on m.ID = mt.MOVIE_ID
WHERE mt.LANGUAGE_ID = 'ru'
  AND (SELECT count(MOVIE_ID) FROM movie_genre mg WHERE m.ID = mg.MOVIE_ID) > 3;

#8. Вывести самый популярный жанр для каждого актёра Формат вывода: Имя актёра, Жанр, в котором у актёра больше всего фильмов.
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
