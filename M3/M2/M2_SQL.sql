USE `db3188412`;
DROP TABLE IF EXISTS `MahlzeitBrauchtDeklaration`;
DROP TABLE IF EXISTS `FbGehoertZuFhAngehoerige`;
DROP TABLE IF EXISTS `BestellungEnthaeltMahlzeiten`;
DROP TABLE IF EXISTS `BenutzerBefreundetMitBenutzer`;
DROP TABLE IF EXISTS `MahlzeitenEnthaltenZutaten`;
DROP TABLE IF EXISTS `MahlzeitenHabenBilder`;
DROP TABLE IF EXISTS `Gaeste`;
DROP TABLE IF EXISTS `Fachbereich`;
DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Kommentare`;
DROP TABLE IF EXISTS `Studenten`;
DROP TABLE IF EXISTS `FH Angehoerige`;
DROP TABLE IF EXISTS `Bestellung`;
DROP TABLE IF EXISTS `Zutaten`
DROP TABLE IF EXISTS `Preise`;
DROP TABLE IF EXISTS `Mahlzeiten`;
DROP TABLE IF EXISTS `Deklarationen`;
DROP TABLE IF EXISTS `Kategorien`;
DROP TABLE IF EXISTS `Bilder`;
DROP TABLE IF EXISTS `Benutzer`;

CREATE TABLE `Benutzer`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    `E-Mail` VARCHAR(254) NOT NULL UNIQUE ,
    Bild mediumblob NOT NULL DEFAULT (0x00),
    Nutzername VARCHAR(50) NOT NULL UNIQUE ,
    Hash CHAR(60) NOT NULL  ,
    `Letzter Login` DATETIME DEFAULT NULL,
    `Anlege Datum` DATE NOT NULL DEFAULT CURRENT_DATE,
    Aktiv BOOL DEFAULT NULL,
    Vorname VARCHAR(50) NOT NULL,
    Nachname VARCHAR(50) NOT NULL,
    Geburtsdatum DATE DEFAULT NULL,
    `Alter` TINYINT UNSIGNED AS (YEAR(CURRENT_DATE()) - YEAR(Geburtsdatum) -
        (DATE_FORMAT(CURRENT_DATE(), '%m%d') <
         DATE_FORMAT(Geburtsdatum, '%m%d'))) VIRTUAL,
    PRIMARY KEY (Nummer),
    CONSTRAINT UN_Nutzername UNIQUE (`Nutzername`),
    CONSTRAINT UN_EMail UNIQUE (`E-Mail`)
);

CREATE TABLE `BenutzerBefreundetMitBenutzer`(
    BenutzerNummer1 INT UNSIGNED NOT NULL ,
    BenutzerNUmmer2 INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_BenutzerBefreundetMItBenutzer_1 FOREIGN KEY (BenutzerNummer1) REFERENCES Benutzer(Nummer),
    CONSTRAINT FK_BenutzerBefreundetMItBenutzer_2 FOREIGN KEY (BenutzerNummer2) REFERENCES Benutzer(Nummer)
    -- PRIMARY KEY (BenutzerNummer1, BenutzerNUmmer2)
);

CREATE TABLE `Gaeste`(
    Nummer INT UNSIGNED NOT NULL ,
    Grund VARCHAR(254) NOT NULL ,
    Ablaufdatum DATE DEFAULT (DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY)),
    CONSTRAINT FK_GaesteNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES Benutzer(Nummer) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (Nummer)
);

CREATE TABLE `FH Angehoerige`(
    Nummer INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_FhAngehoerigeNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES Benutzer(Nummer) ON DELETE CASCADE ON UPDATE CASCADE ,
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Mitarbeiter`(
    Nummer INT UNSIGNED,
    `Büro` VARCHAR(20) DEFAULT NULL,
    `Telefon` INT(20),
    CONSTRAINT FK_MitarbeiterNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES `FH Angehoerige`(Nummer) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Studenten`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    Studiengang VARCHAR(3) NOT NULL,
    Matrikelnummer INT(9) NOT NULL UNIQUE ,
    CONSTRAINT MatrikelNrEindeutig UNIQUE (Matrikelnummer),
    PRIMARY KEY (Nummer),
    CONSTRAINT UN_Matrikelnummer UNIQUE (Matrikelnummer),
    CONSTRAINT FK_StudentNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES `FH Angehoerige`(Nummer) ON DELETE CASCADE ON UPDATE CASCADE ,
    CONSTRAINT Ch_Values CHECK ( Studiengang='ET' OR Studiengang='INF' OR Studiengang='ISE' OR Studiengang='MCD' OR Studiengang='WI'),
    -- CONSTRAINT Ch_Values CHECK ( Studiengang IN ('ET','INF','ISE','MCD','WI')),
    CONSTRAINT CH_Value_Matrikelnummer CHECK (Matrikelnummer > 9999999)
);

CREATE TABLE `Fachbereich`(
    Website VARCHAR(254) NOT NULL,
    Name VARCHAR(254) NOT NULL,
    `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (ID)
);

CREATE TABLE `FbGehoertZuFhAngehoerige`(
    ID INT UNSIGNED NOT NULL ,
    Nummer INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_FbGehoertZuFhAngehoerige_Fachbereich FOREIGN KEY (ID) REFERENCES Fachbereich(ID),
    CONSTRAINT FK_FbGehoertZuFhAngehoerige_FhAngehoerige FOREIGN KEY (Nummer) REFERENCES `FH Angehoerige`(Nummer)
);

CREATE TABLE `Bilder`(
    ID INT UNSIGNED AUTO_INCREMENT,
    `Alt-Text` VARCHAR(254) NOT NULL ,
    Titel VARCHAR(50) NOT NULL ,
    Binärdaten mediumblob,
    PRIMARY KEY (ID)
);

CREATE TABLE `Kategorien`(
    ID INT UNSIGNED AUTO_INCREMENT NOT NULL ,
    Bezeichnung VARCHAR(254),
    hatKategorie INT UNSIGNED,
    hatBilder INT UNSIGNED,
    PRIMARY KEY (ID),
    CONSTRAINT FK_KategorienHatKategorien FOREIGN KEY (hatKategorie) REFERENCES Kategorien(ID) ON DELETE SET NULL,
    CONSTRAINT FK_KategorienHatBilder FOREIGN KEY (hatBilder) REFERENCES Bilder(ID) ON DELETE SET NULL
);

CREATE TABLE `Mahlzeiten`(
    ID INT UNSIGNED AUTO_INCREMENT,
    Name Varchar(255) NOT NULL,
    Beschreibung TEXT(1000) CHARACTER SET UTF8 NOT NULL,
    Vorrat INT(3) UNSIGNED DEFAULT 0,
    `Verfügbar` BOOL AS (Vorrat > 0) VIRTUAL,
    inKategorie INT UNSIGNED NOT NULL,
    PRIMARY KEY (ID)
    -- CONSTRAINT FK_MahlzeitenInKategorien FOREIGN KEY (inKategorie) REFERENCES Kategorien(ID)
);

CREATE TABLE `Deklarationen`(
    Zeichen VARCHAR(2) NOT NULL ,
    Beschriftung VARCHAR(32) NOT NULL ,
    PRIMARY KEY (Zeichen)
);

CREATE TABLE `MahlzeitBrauchtDeklaration`(
    ID INT UNSIGNED NOT NULL ,
    Zeichen VARCHAR(2) NOT NULL ,
    CONSTRAINT FK_MahlzeitBrauchtDejklaration_Mahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE ON UPDATE CASCADE ,
    CONSTRAINT FK_MahlzeitBrauchtDejklaration_Deklarationen FOREIGN KEY (Zeichen) REFERENCES Deklarationen(Zeichen) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `Kommentare`(
    `ID` INT UNSIGNED AUTO_INCREMENT,
    Bemerkung VARCHAR(254) DEFAULT NULL,
    Bewertung INT (1),
    GeschriebenVon INT UNSIGNED ,
    GehörtZu INT UNSIGNED ,
    PRIMARY KEY (ID),
    CONSTRAINT FK_KommentareGeschriebenVonStudenten FOREIGN KEY (GeschriebenVon) REFERENCES Studenten(Nummer) ON DELETE SET NULL ,
    CONSTRAINT FK_KommentareZuMahlzeiten FOREIGN KEY (GehörtZu) REFERENCES Mahlzeiten(ID) ON DELETE SET NULL
);

CREATE TABLE `Bestellung`(
    Abholzeitpunkt DATETIME DEFAULT NULL,
    Bestellzeitpunkt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Nummer INT UNSIGNED AUTO_INCREMENT,
    Endpreis DECIMAL(6,2) DEFAULT 0,
    BenutzerNr INT UNSIGNED ,
    CONSTRAINT FK_BestellungBenutzer FOREIGN KEY (BenutzerNr) REFERENCES Benutzer(Nummer)ON DELETE SET NULL,
    CONSTRAINT CH_Abholzeitpunkt CHECK ( Abholzeitpunkt is NULL OR Abholzeitpunkt > Bestellzeitpunkt),
    PRIMARY KEY (Nummer)

);

CREATE TABLE `BestellungEnthaeltMahlzeiten`(

    Nummer INT UNSIGNED NOT NULL ,
    ID INT UNSIGNED NOT NULL ,
    Anzahl INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_BestellungEnthaeltMahlzeiten_Bestellung FOREIGN KEY (Nummer) REFERENCES Bestellung(Nummer) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_BestellungEnthaeltMahlzeiten_Mahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE ON UPDATE CASCADE
);


CREATE TABLE `Preise` (
    Jahr YEAR NOT NULL,
    Gastpreis DECIMAL(4,2) UNSIGNED NOT NULL ,
    Studentpreis DECIMAL(4,2) UNSIGNED DEFAULT NULL,
    `MA-Preis` DECIMAL(4,2) UNSIGNED DEFAULT NULL,
    MahlzeitID INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_IDVonMahlzeiten FOREIGN KEY (MahlzeitID) REFERENCES Mahlzeiten(ID),
    CONSTRAINT CH_Preis CHECK ( Studentpreis < `MA-Preis` ),
    CONSTRAINT PK_Key PRIMARY KEY (Jahr, MahlzeitID)

);

CREATE TABLE `Zutaten` (
    ID INT(5) zerofill,
    Name VARCHAR(50) NOT NULL ,
    Bio BOOL DEFAULT FALSE,
    Vegetarisch BOOL DEFAULT FALSE,
    Vegan BOOL DEFAULT FALSE,
    Glutenfrei BOOL DEFAULT FALSE,
    PRIMARY KEY (ID)
    -- CONSTRAINT CH_stellenVonZahlID CHECK ( ID > 9999 )
    -- CONSTRAINT CH_ValueBIO CHECK ( Bio = '0' OR Bio = '1' ),
    -- CONSTRAINT CH_ValueVegetarisch CHECK ( Vegetarisch = '0' OR Vegetarisch = '1' ),
    -- CONSTRAINT CH_ValueVegan CHECK ( Vegan = '0' OR Vegan = '1' ),
    -- CONSTRAINT CH_ValueGlutenfrei CHECK ( Glutenfrei = '0' OR Glutenfrei = '1' )
);

CREATE TABLE `MahlzeitenEnthaltenZutaten`(
    ID_M INT UNSIGNED NOT NULL ,
    ID_Z INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_MahlzeitenEnthaltenZutaten_Mahlzeiten FOREIGN KEY (ID_M) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_MahlzeitenEnthaltenZutaten_Zutaten FOREIGN KEY (ID_Z) REFERENCES Zutaten(ID) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `MahlzeitenHabenBilder`(
    ID_M INT UNSIGNED NOT NULL ,
    ID_B INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_MahlzeitenHabenBilder_Mahlzeiten FOREIGN KEY (ID_M) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FK_MahlzeitenHabenBilder_Bilder FOREIGN KEY (ID_B) REFERENCES Bilder(ID) ON DELETE CASCADE ON UPDATE CASCADE
);


-- Aufgabe 2.3 - Kaskaden

INSERT INTO Benutzer(`E-Mail`, Bild, Nutzername, `Anlege Datum`, Aktiv, Vorname, Nachname, Geburtsdatum, `Letzter Login`, Hash) VALUES ('test1.test1@fh-aachen.com', 0, 'ts1111s', CURRENT_DATE, 0, 'vtest1', 'ntest1', '2001-01-01', NOW(), 11111);
INSERT INTO Benutzer(`E-Mail`, Bild, Nutzername, `Anlege Datum`, Aktiv, Vorname, Nachname, Geburtsdatum, `Letzter Login`, Hash) VALUES ('test2.test2@fh-aachen.com', 0, 'ts2222s', CURRENT_DATE, 0, 'vtest2', 'ntest2', '2002-02-02', NOW(), 222222222);
INSERT INTO Benutzer(`E-Mail`, Bild, Nutzername, `Anlege Datum`, Aktiv, Vorname, Nachname, Geburtsdatum, `Letzter Login`, Hash) VALUES ('test3.test3@fh-aachen.com', 0, 'ts3333s', CURRENT_DATE, 0, 'test3', 'ntest3', '2003-03-03', NOW(), 3333333);
INSERT INTO Benutzer(`E-Mail`, Bild, Nutzername, `Anlege Datum`, Aktiv, Vorname, Nachname, Geburtsdatum, `Letzter Login`, Hash) VALUES ('test4.test4@fh-aachen.com', 0, 'ts4444s', CURRENT_DATE, 0, 'test4', 'ntest4', '2004-04-04', NOW(), 44444444);

INSERT INTO `FH Angehoerige`(Nummer) VALUE ((SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts1111s'));
-- INSERT INTO `FH Angehoerige`(Nummer) VALUE ((SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts2222s'));
INSERT INTO `FH Angehoerige`(Nummer) VALUE ((SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts3333s'));
INSERT INTO `FH Angehoerige`(Nummer) VALUE ((SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts4444s'));

INSERT INTO Studenten(Matrikelnummer, Studiengang, Nummer) VALUES (12345678, 'INF', (SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts1111s'));
INSERT INTO Studenten(Matrikelnummer, Studiengang, Nummer) VALUES (123456789, 'WI', (SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts4444s'));

INSERT INTO Mitarbeiter(`Büro`, Telefon, Nummer) VALUES ('G203', '181099', (SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts3333s'));
INSERT INTO Gaeste (Nummer, Grund) VALUES ((SELECT Nummer FROM Benutzer WHERE Nutzername = 'ts2222s'), 'Ist Dumm') ;

SELECT * FROM Benutzer;
SELECT * FROM `FH Angehoerige`;
SELECT * FROM Studenten;
SELECT * FROM Mitarbeiter;
SELECT * FROM Gaeste;

-- DELETE FROM Benutzer WHERE Nummer = 1;
-- DELETE FROM Benutzer WHERE Nummer = 2;
-- DELETE FROM Benutzer WHERE Nummer = 3;
-- DELETE FROM Benutzer WHERE Nummer = 4;

-- Weitere Business Rules
-- 1.
ALTER TABLE Preise DROP CONSTRAINT FK_IDVonMahlzeiten;
ALTER TABLE Preise ADD CONSTRAINT FK_IDVonMahlzeiten FOREIGN KEY (MahlzeitID) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE;

ALTER TABLE MahlzeitenEnthaltenZutaten DROP CONSTRAINT FK_MahlzeitenEnthaltenZutaten_Mahlzeiten;
ALTER TABLE MahlzeitenEnthaltenZutaten ADD CONSTRAINT FK_MahlzeitenEnthaltenZutaten_Mahlzeiten FOREIGN KEY (ID_M) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE Kommentare DROP CONSTRAINT FK_KommentareZuMahlzeiten;
ALTER TABLE Kommentare ADD CONSTRAINT FK_KommentareZuMahlzeiten  FOREIGN KEY (GehörtZu) REFERENCES Mahlzeiten(ID) ON DELETE CASCADE ON UPDATE CASCADE;

-- 2.
ALTER TABLE Kategorien DROP CONSTRAINT FK_KategorienHatKategorien;
ALTER TABLE Kategorien ADD CONSTRAINT FOREIGN KEY (hatKategorie) REFERENCES Kategorien(ID) ON DELETE SET NULL;

-- 3.
ALTER TABLE Kategorien DROP CONSTRAINT FK_KategorienHatBilder;
ALTER TABLE Kategorien ADD CONSTRAINT FOREIGN KEY (hatBilder) REFERENCES Bilder(ID) ON DELETE SET NULL;

INSERT INTO db3188412.Zutaten (ID, Name, Bio, Vegetarisch, Vegan, Glutenfrei) SELECT * FROM public.zutaten;

INSERT INTO Kategorien(Bezeichnung)
	VALUES ('Klassiker');

INSERT INTO Kategorien(Bezeichnung)
	VALUES ('Salat');

INSERT INTO Mahlzeiten(`Name`, inKategorie, Vorrat, Beschreibung)
	VALUES ('Falafel', 1, 20, 'Teigtasche mit Falafel aus Kichererbsen und Sesam, dazu passt hervorragend der <a href="http://localhost/DBWT/M2/Detail.php?id=5">Krautsalat</a>');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `Studentpreis`, `MA-Preis`)
	VALUES (1, 2018, '2.90', '2.50', '2.70');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `Studentpreis`, `MA-Preis`)
	VALUES (1, 2019, '3.00', '2.50', '2.70');

INSERT INTO Mahlzeiten(`Name`, inKategorie, Vorrat, Beschreibung)
	VALUES ('Schnitzel',(SELECT ID FROM Kategorien WHERE Bezeichnung = 'Klassiker'), 6, 'Mit schmackiger Champignon Rahmsoße');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `MA-Preis`, Studentpreis )
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 2018, '3.90', '3.60', '3.40');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `MA-Preis`, Studentpreis)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 2019, '4.00', '3.60', '3.40');
-- INSERT INTO Mahlzeitzutaten(MahlzeitID, ZutatID)
-- VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 10002);
-- INSERT INTO Mahlzeitzutaten(MahlzeitID, ZutatID)
-- VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 10007);
-- INSERT INTO Mahlzeitzutaten(MahlzeitID, ZutatID)
-- VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 10010);
INSERT INTO Kommentare(GehörtZu, Bewertung)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 5);
INSERT INTO Kommentare(GehörtZu, Bewertung)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 5);
INSERT INTO Kommentare(GehörtZu, Bewertung)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 4);
INSERT INTO Kommentare(GehörtZu, Bewertung)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Schnitzel'), 1);

INSERT INTO Mahlzeiten(`Name`, inKategorie, Vorrat, Beschreibung)
	VALUES ('Currywurst', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'Klassiker'), 0, 'Geht eigentlich immer ;D');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `MA-Preis`, Studentpreis)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Currywurst'), 2018, '3.50', '3.40', '3.30');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `MA-Preis`,Studentpreis)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Currywurst'), 2019, '3.70', '3.40', '3.30');

INSERT INTO Mahlzeiten(`Name`, inKategorie, Vorrat, Beschreibung)
	VALUES ('Spiegelei', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'Klassiker'), 40, 'Ein Spieglei? Etwas dürftig, oder?');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `MA-Preis`, Studentpreis)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Spiegelei'), 2018, '2.20', '1.80', '1.40');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `MA-Preis`, Studentpreis)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Spiegelei'), 2019, '2.50', '1.80', '1.40');

INSERT INTO Mahlzeiten(`Name`, inKategorie, Vorrat, Beschreibung)
	VALUES ('Krautsalat', (SELECT ID FROM Kategorien WHERE Bezeichnung = 'Salat'), 25, 'Der einzige essbare Salat auf der Welt...');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `Studentpreis`, `MA-Preis`)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Krautsalat'), 2018, '1.50', '1.10', '1.20');
INSERT INTO Preise(MahlzeitID, Jahr, Gastpreis, `Studentpreis`, `MA-Preis`)
	VALUES ((SELECT ID FROM Mahlzeiten WHERE `Name` = 'Krautsalat'), 2019, '1.90', '1.10', '1.30');

-- Kann erst nach Hochladen der Bilder Ausgeführt werden. --

-- INSERT INTO MahlzeitenHabenBilder(ID_M, ID_B) VALUES ((SELECT M.ID FROM Mahlzeiten M WHERE M.Name = 'Schnitzel'),(SELECT B.ID FROM Bilder B WHERE B.Titel = 'Schnitzel'));
-- INSERT INTO MahlzeitenHabenBilder(ID_M, ID_B) VALUES ((SELECT M.ID FROM Mahlzeiten M WHERE M.Name = 'Spiegelei'),(SELECT B.ID FROM Bilder B WHERE B.Titel = 'Spiegelei'));
-- INSERT INTO MahlzeitenHabenBilder(ID_M, ID_B) VALUES ((SELECT M.ID FROM Mahlzeiten M WHERE M.Name = 'Falafel'),(SELECT B.ID FROM Bilder B WHERE B.Titel = 'Falafel'));
-- INSERT INTO MahlzeitenHabenBilder(ID_M, ID_B) VALUES ((SELECT M.ID FROM Mahlzeiten M WHERE M.Name = 'Krautsalat'),(SELECT B.ID FROM Bilder B WHERE B.Titel = 'Krautsalat'));
-- INSERT INTO MahlzeitenHabenBilder(ID_M, ID_B) VALUES ((SELECT M.ID FROM Mahlzeiten M WHERE M.Name = 'Currywurst'),(SELECT B.ID FROM Bilder B WHERE B.Titel = 'Currywurst'));


create view Nutzerrollen AS select B.Nummer, IF(B.Nummer = G.Nummer, 'Gast' ,IF(B.Nummer = M.Nummer, 'Mitarbeiter',
    IF(B.Nummer = S.Nummer, 'Student', NULL))) AS Rolle From Benutzer B
        left Join Gaeste G on B.Nummer = G.Nummer
        left join `FH Angehoerige` `F A` on B.Nummer = `F A`.Nummer
        left join Mitarbeiter M on `F A`.Nummer = M.Nummer
        left join Studenten S on `F A`.Nummer = S.Nummer ;



