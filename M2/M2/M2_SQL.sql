USE `db3188412`;
DROP TABLE IF EXISTS `Benutzer`;
DROP TABLE IF EXISTS `Gäste`;
DROP TABLE IF EXISTS `FH Angehörige`;
DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Studenten`;
DROP TABLE IF EXISTS `Fachbereich`;
DROP TABLE IF EXISTS `Bestellung`;
DROP TABLE IF EXISTS `Deklarationen`;
DROP TABLE IF EXISTS `Kommentare`;
DROP TABLE IF EXISTS `Zutaten`;
DROP TABLE IF EXISTS `Bilder`;
DROP TABLE IF EXISTS `Kategorien`;
DROP TABLE IF EXISTS `Preise`;
DROP TABLE IF EXISTS `Mahlzeiten`;

CREATE TABLE `Benutzer`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    `E-Mail` VARCHAR(254) NOT NULL,
    Bild VARBINARY(1000),
    Nutzername VARCHAR(50) NOT NULL,
    Hash VARCHAR(60),
    `Letzter Login` DATETIME,
    `Anlege Datum` DATE NOT NULL,
    Aktiv BOOL,
    Vorname VARCHAR(50) NOT NULL,
    Nachname VARCHAR(50) NOT NULL,
    Geburtsdatum DATE NOT NULL,
    `Alter` INT unsigned,
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Gäste`(
    Grund VARCHAR(254),
    Ablaufdatum DATETIME

);

CREATE TABLE `Mitarbeiter`(
    `Büro` VARCHAR(20),
    `Telefon` INT(20)
);

CREATE TABLE `Studenten`(
    Studiengang VARCHAR(3) NOT NULL,
    Matrikelnummer INT(9) NOT NULL,
    CONSTRAINT MatrikelNrEindeutig UNIQUE (Matrikelnummer)
);

CREATE TABLE `Fachbereich`(
    Website VARCHAR(100),
    Name VARCHAR(100) NOT NULL,
    `ID` INT AUTO_INCREMENT,
    PRIMARY KEY (ID)
);

CREATE TABLE `Kommentare`(
    `ID` INT AUTO_INCREMENT,
    Bemerkung VARCHAR(254),
    Bewertung INT (1),
    PRIMARY KEY (ID)
);

CREATE TABLE `Bestellung`(
    Abholzeitpunkt DATETIME,
    Bestellzeitpunkt DATETIME,
    Nummer INT,
    Endpreis DECIMAL(4,2),
    BenutzerNr INT UNSIGNED

);

CREATE TABLE `Deklarationen`(
    Zeichen CHAR,
    Beschriftung VARCHAR(254) NOT NULL ,
    PRIMARY KEY (Zeichen)

);

CREATE TABLE `Mahlzeiten`(
    ID int,
    Beschreibung TEXT(1000),
    Vorrat int(3),
    Verfügbar Bool,
    PRIMARY KEY (ID)

);

CREATE TABLE `Preise` (
    Jahr Int(4),
    Gastpreis DECIMAL(4,2),
    Studentpreis DECIMAL(4,2),
    `MA-Preis` DECIMAL(4,2)

);

CREATE TABLE `Kategorien`(
    ID INT UNSIGNED,
    Bezeichnung VARCHAR(100),
    PRIMARY KEY (ID)
);

CREATE TABLE `Bilder`(
    ID INT UNSIGNED,
    `Alt-Text` VARCHAR(100),
    Title VARCHAR(50),
    Binärdaten mediumblob,
    PRIMARY KEY (ID)
);

CREATE TABLE `Zutaten` (
    ID INT(5) ,
    Name VARCHAR(50),
    Bio BOOL,
    Vegetarisch BOOL,
    Vegan BOOL,
    Glutenfrei BOOL,
    PRIMARY KEY (ID)
)