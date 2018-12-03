SELECT *
FROM game_genre
JOIN genres on game_genre.genreid = genres.genreid
WHERE gameid = :gameid