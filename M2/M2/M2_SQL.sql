USE `db3188412`;
DROP TABLE IF EXISTS `MahlzeitBrauchtDeklaration`;
DROP TABLE IF EXISTS `FbGehörtZuFhAngehörige`;
DROP TABLE IF EXISTS `BestellungEnthältMahlzeiten`;
DROP TABLE IF EXISTS `BenutzerBefreundetMitBenutzer`;
DROP TABLE IF EXISTS `MahlzeitenEnthaltenZutaten`;
DROP TABLE IF EXISTS `MahlzeitenHabenBilder`;
DROP TABLE IF EXISTS `Gäste`;
DROP TABLE IF EXISTS `Fachbereich`;
DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Kommentare`;
DROP TABLE IF EXISTS `Studenten`;
DROP TABLE IF EXISTS `FH Angehörige`;
DROP TABLE IF EXISTS `Bestellung`;
DROP TABLE IF EXISTS `Zutaten`
DROP TABLE IF EXISTS `Preise`;
DROP TABLE IF EXISTS `Mahlzeiten`;
DROP TABLE IF EXISTS `Benutzer`;
DROP TABLE IF EXISTS `Deklarationen`;
DROP TABLE IF EXISTS `Kategorien`;
DROP TABLE IF EXISTS `Bilder`;


CREATE TABLE `Benutzer`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    `E-Mail` VARCHAR(254) NOT NULL DEFAULT 'Max.Mustermann@fh-aachen.de',
    Bild mediumblob NOT NULL DEFAULT (0x00),
    Nutzername VARCHAR(50) NOT NULL,
    Hash VARCHAR(60),
    `Letzter Login` DATETIME DEFAULT NULL,
    `Anlege Datum` DATE NOT NULL DEFAULT CURRENT_DATE,
    Aktiv BOOL DEFAULT NULL,
    Vorname VARCHAR(50) NOT NULL,
    Nachname VARCHAR(50) NOT NULL,
    Geburtsdatum DATE,
    `Alter` INT unsigned AS (DATEDIFF(CURRENT_DATE, Geburtsdatum)/365),
    PRIMARY KEY (Nummer),
    CONSTRAINT UN_Nutzername UNIQUE (`Nutzername`),
    CONSTRAINT UN_EMail UNIQUE (`E-Mail`)
);

CREATE TABLE `BenutzerBefreundetMitBenutzer`(
    BenutzerNummer1 INT UNSIGNED,
    BenutzerNUmmer2 INT UNSIGNED,
    CONSTRAINT FK_BenutzerBefreundetMItBenutzer_1 FOREIGN KEY (BenutzerNummer1) REFERENCES Benutzer(Nummer),
    CONSTRAINT FK_BenutzerBefreundetMItBenutzer_2 FOREIGN KEY (BenutzerNummer2) REFERENCES Benutzer(Nummer)
);

CREATE TABLE `Gäste`(
    Nummer INT UNSIGNED,
    Grund VARCHAR(254),
    Ablaufdatum DATE DEFAULT (CURRENT_DATE() + TO_DAYS(7)),
    CONSTRAINT FK_GästeNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES Benutzer(Nummer),
    PRIMARY KEY (Nummer)
);

CREATE TABLE `FH Angehörige`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    CONSTRAINT FK_FhAngehörigeNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES Benutzer(Nummer),
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Mitarbeiter`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    `Büro` VARCHAR(20),
    `Telefon` INT(20),
    CONSTRAINT FK_MitarbeiterNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES `FH Angehörige`(Nummer),
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Studenten`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    Studiengang VARCHAR(3) NOT NULL,
    Matrikelnummer INT(9) NOT NULL,
    CONSTRAINT MatrikelNrEindeutig UNIQUE (Matrikelnummer),
    PRIMARY KEY (Nummer),
    CONSTRAINT UN_Matrikelnummer UNIQUE (Matrikelnummer),
    CONSTRAINT FK_StudentNummerOfBenutzer FOREIGN KEY (Nummer) REFERENCES `FH Angehörige`(Nummer),
    CONSTRAINT Ch_Values CHECK ( Studiengang='ET' OR Studiengang='INF' OR Studiengang='ISE' OR Studiengang='MCD' OR Studiengang='WI'),
    CONSTRAINT CH_Value_Matrikelnummer CHECK (Matrikelnummer > 9999999 AND Matrikelnummer < 100000000)
);

CREATE TABLE `Fachbereich`(
    Website VARCHAR(100),
    Name VARCHAR(100) NOT NULL,
    `ID` INT AUTO_INCREMENT,
    PRIMARY KEY (ID)
);

CREATE TABLE `FbGehörtZuFhAngehörige`(
    ID INT ,
    Nummer INT UNSIGNED ,
    CONSTRAINT FK_FbGehörtZuFhAngehörige_Fachbereich FOREIGN KEY (ID) REFERENCES Fachbereich(ID),
    CONSTRAINT FK_FbGehörtZuFhAngehörige_FhAngehörige FOREIGN KEY (Nummer) REFERENCES `FH Angehörige`(Nummer)
);

CREATE TABLE `Bilder`(
    ID INT UNSIGNED,
    `Alt-Text` VARCHAR(100),
    Title VARCHAR(50),
    Binärdaten mediumblob,
    PRIMARY KEY (ID)
);

CREATE TABLE `Kategorien`(
    ID INT UNSIGNED,
    Bezeichnung VARCHAR(100),
    hatKategorie INT UNSIGNED,
    hatBilder INT UNSIGNED,
    PRIMARY KEY (ID),
    CONSTRAINT FK_KategorienHatKategorien FOREIGN KEY (hatKategorie) REFERENCES Kategorien(ID),
    CONSTRAINT FK_KategorienHatBilder FOREIGN KEY (hatBilder) REFERENCES Bilder(ID)
);

CREATE TABLE `Mahlzeiten`(
    ID int,
    Beschreibung TEXT(1000),
    Vorrat int(3) DEFAULT 0,
    Verfügbar Bool DEFAULT FALSE,
    inKategorie INT UNSIGNED,
    PRIMARY KEY (ID),
    CONSTRAINT FK_MahlzeitenInKategorien FOREIGN KEY (inKategorie) REFERENCES Kategorien(ID)
);

CREATE TABLE `Deklarationen`(
    Zeichen CHAR(2) NOT NULL ,
    Beschriftung VARCHAR(254) NOT NULL ,
    PRIMARY KEY (Zeichen),
    CONSTRAINT CH_Char CHECK ( Zeichen < 3 )

);

CREATE TABLE `MahlzeitBrauchtDeklaration`(
    ID INT,
    Zeichen CHAR,
    CONSTRAINT FK_MahlzeitBrauchtDejklaration_Mahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID),
    CONSTRAINT FK_MahlzeitBrauchtDejklaration_Deklarationen FOREIGN KEY (Zeichen) REFERENCES Deklarationen(Zeichen)
);

CREATE TABLE `Kommentare`(
    `ID` INT AUTO_INCREMENT,
    Bemerkung VARCHAR(254),
    Bewertung INT (1),
    GeschriebenVon INT UNSIGNED,
    GehörtZu INT,
    PRIMARY KEY (ID),
    CONSTRAINT FK_KommentareGeschriebenVonStudenten FOREIGN KEY (GeschriebenVon) REFERENCES Studenten(Nummer),
    CONSTRAINT FK_KommentareZuMahlzeiten FOREIGN KEY (GehörtZu) REFERENCES Mahlzeiten(ID)
);

CREATE TABLE `Bestellung`(
    Abholzeitpunkt DATETIME DEFAULT NULL,
    Bestellzeitpunkt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Nummer INT AUTO_INCREMENT,
    Endpreis DECIMAL(6,2) DEFAULT 0,
    BenutzerNr INT UNSIGNED NOT NULL ,
    getaetigtVon INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_BestellungBenutzer FOREIGN KEY (getaetigtVon) REFERENCES Benutzer(Nummer),
    CONSTRAINT CH_Abholzeitpunkt CHECK ( Abholzeitpunkt = NULL OR Abholzeitpunkt > Bestellzeitpunkt),
    PRIMARY KEY (Nummer)
);

CREATE TABLE `BestellungEnthältMahlzeiten`(

    Nummer INT,
    ID INT,
    Anzahl INT,
    CONSTRAINT FK_BestellungEnthältMahlzeiten_Bestellung FOREIGN KEY (Nummer) REFERENCES Bestellung(Nummer),
    CONSTRAINT FK_BestellungEnthältMahlzeiten_Mahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID)
);


CREATE TABLE `Preise` (
    Jahr Int(4),
    Gastpreis DECIMAL(4,2) UNSIGNED,
    Studentpreis DECIMAL(4,2) UNSIGNED,
    `MA-Preis` DECIMAL(4,2) UNSIGNED,
    ID INT,
    CONSTRAINT FK_IDVonMahlzeiten FOREIGN KEY (ID) REFERENCES Mahlzeiten(ID),
    CONSTRAINT CH_Preis CHECK ( Studentpreis > `MA-Preis` ),
    CONSTRAINT PK_Key PRIMARY KEY (Jahr, ID)

);

CREATE TABLE `Zutaten` (
    ID INT(5) NOT NULL ,
    Name VARCHAR(50) NOT NULL ,
    Bio BOOL DEFAULT FALSE,
    Vegetarisch BOOL DEFAULT FALSE,
    Vegan BOOL DEFAULT FALSE,
    Glutenfrei BOOL DEFAULT FALSE,
    PRIMARY KEY (ID),
    CONSTRAINT CH_stellenVonZahlID CHECK ( ID > 9999 AND ID < 100000 ),
    CONSTRAINT CH_ValueBIO CHECK ( Bio = '0' OR Bio = '1' ),
    CONSTRAINT CH_ValueVegetarisch CHECK ( Vegetarisch = '0' OR Vegetarisch = '1' ),
    CONSTRAINT CH_ValueVegan CHECK ( Vegan = '0' OR Vegan = '1' ),
    CONSTRAINT CH_ValueGlutenfrei CHECK ( Glutenfrei = '0' OR Glutenfrei = '1' )
);

CREATE TABLE `MahlzeitenEnthaltenZutaten`(
    ID_M INT,
    ID_Z INT,
    CONSTRAINT FK_MahlzeitenEnthaltenZutaten_Mahlzeiten FOREIGN KEY (ID_M) REFERENCES Mahlzeiten(ID),
    CONSTRAINT FK_MahlzeitenEnthaltenZutaten_Zutaten FOREIGN KEY (ID_Z) REFERENCES Zutaten(ID)
);

CREATE TABLE `MahlzeitenHabenBilder`(
    ID_M INT,
    ID_B INT UNSIGNED,
    CONSTRAINT FK_MahlzeitenHabenBilder_Mahlzeiten FOREIGN KEY (ID_M) REFERENCES Mahlzeiten(ID),
    CONSTRAINT FK_MahlzeitenHabenBilder_Bilder FOREIGN KEY (ID_B) REFERENCES Bilder(ID)
);


