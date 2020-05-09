CREATE DEFINER=`root`@`localhost` PROCEDURE `valida_entrada_album`(OUT entrada INT, usuario VARCHAR(150), album INT)
BEGIN
        DECLARE tAlbum, ids, salida, idAl, bandera INT;
        DECLARE curTipoAlbum CURSOR FOR SELECT tipo FROM Album WHERE id_album = album;
        DECLARE curValidaEntrada CURSOR FOR SELECT id_album FROM Suscripciones WHERE username = usuario;  
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET salida = 1;
        SET salida = 0;
        SET entrada = 0;
        SET bandera = 0;
        

        OPEN curTipoAlbum;
            FETCH curTipoAlbum INTO tAlbum;
        CLOSE curTipoAlbum;
        IF tAlbum = 1 THEN 
            OPEN curValidaEntrada;
                curV: REPEAT
                    FETCH curValidaEntrada INTO ids;
                    IF salida = 1 THEN
                        LEAVE curV;
                    END IF;
                    IF ids = album THEN
                        SET bandera = 1;
                    END IF;
                    UNTIL salida = 1
                END REPEAT curV;
            CLOSE curValidaEntrada;
            IF bandera != 1 THEN
				SET entrada = 1;
			end if;
        END IF;
    END