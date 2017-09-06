DELIMITER $$

CREATE PROCEDURE `insert_cd_with_songs` (

	IN cdTitle VARCHAR(50),
	IN cdDescription TEXT,
	IN imageName VARCHAR(100),
	IN cdPrice DECIMAL(10,2),
	IN releaseDate DATE,
	IN totalSongs INT(11),

	IN songs TEXT
)

DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
		ROLLBACK;
END;

DECLARE EXIT HANDLER FOR SQLWARNING
BEGIN   
		ROLLBACK;
END;
    
START TRANSACTION;

	INSERT INTO cd(cd_title, description, image_name, price, release_date, total_songs)
	VALUES(cdTitle, cdDescription, imageName, cdPrice, releaseDate, totalSongs);

	INSERT INTO song(clip_name, song_number, song_title)
	VALUES(clipName, songNumber, songTitle);


COMMIT;    
END $$

DELIMITER ;