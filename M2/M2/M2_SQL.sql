USE `db3188412`;
DROP TABLE IF EXISTS `MahlzeitBrauchtDeklaration`;
DROP TABLE IF EXISTS `FbGehörtZuFhAngehörige`;
DROP TABLE IF EXISTS `BestellungEnthältMahlzeiten`;
DROP TABLE IF EXISTS `BenutzerBefreundetMitBenutzer`;
DROP TABLE IF EXISTS `MahlzeitenEnthaltenZutaten`;
DROP TABLE IF EXISTS `MahlzeitenHabenBilder`;
DROP TABLE IF EXISTS `Gäste`;
DROP TABLE IF EXISTS `FH Angehörige`;
DROP TABLE IF EXISTS `Mitarbeiter`;
DROP TABLE IF EXISTS `Kommentare`;
DROP TABLE IF EXISTS `Studenten`;
DROP TABLE IF EXISTS `Fachbereich`;
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
    `E-Mail` VARCHAR(254) NOT NULL,
    Bild VARBINARY(1000),
    Nutzername VARCHAR(50) NOT NULL,
    Hash VARCHAR(60),
    `Letzter Login` DATETIME,
    `Anlege Datum` DATE NOT NULL DEFAULT CURRENT_DATE,
    Aktiv BOOL,
    Vorname VARCHAR(50) NOT NULL,
    Nachname VARCHAR(50) NOT NULL,
    Geburtsdatum DATE NOT NULL,
    `Alter` INT unsigned AS (DATEDIFF(CURRENT_DATE, Geburtsdatum)/365),
    PRIMARY KEY (Nummer)
);

CREATE TABLE `BenutzerBefreundetMitBenutzer`(
    BenutzerNummer1 INT UNSIGNED,
    BenutzerNUmmer2 INT UNSIGNED,
    CONSTRAINT FK_BenutzerBefreundetMItBenutzer_1 FOREIGN KEY (BenutzerNummer1) REFERENCES Benutzer(Nummer),
    CONSTRAINT FK_BenutzerBefreundetMItBenutzer_2 FOREIGN KEY (BenutzerNummer2) REFERENCES Benutzer(Nummer)
);

CREATE TABLE `Gäste`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    Grund VARCHAR(254),
    Ablaufdatum DATETIME,
    PRIMARY KEY (Nummer)
);

CREATE TABLE `FH Angehörige`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Mitarbeiter`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    `Büro` VARCHAR(20),
    `Telefon` INT(20),
    PRIMARY KEY (Nummer)
);

CREATE TABLE `Studenten`(
    Nummer INT UNSIGNED AUTO_INCREMENT,
    Studiengang VARCHAR(3) NOT NULL,
    Matrikelnummer INT(9) NOT NULL,
    CONSTRAINT MatrikelNrEindeutig UNIQUE (Matrikelnummer),
    PRIMARY KEY (Nummer)
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
    Vorrat int(3),
    Verfügbar Bool,
    inKategorie INT UNSIGNED,
    PRIMARY KEY (ID),
    CONSTRAINT FK_MahlzeitenInKategorien FOREIGN KEY (inKategorie) REFERENCES Kategorien(ID)
);

CREATE TABLE `Deklarationen`(
    Zeichen CHAR,
    Beschriftung VARCHAR(254) NOT NULL ,
    PRIMARY KEY (Zeichen)

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
    Abholzeitpunkt DATETIME,
    Bestellzeitpunkt DATETIME,
    Nummer INT,
    Endpreis DECIMAL(4,2),
    BenutzerNr INT UNSIGNED,
    getaetigtVon INT UNSIGNED NOT NULL ,
    CONSTRAINT FK_BestellungBenutzer FOREIGN KEY (getaetigtVon) REFERENCES Benutzer(Nummer),
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
    Gastpreis DECIMAL(4,2),
    Studentpreis DECIMAL(4,2),
    `MA-Preis` DECIMAL(4,2)

);

CREATE TABLE `Zutaten` (
    ID INT(5) ,
    Name VARCHAR(50),
    Bio BOOL,
    Vegetarisch BOOL,
    Vegan BOOL,
    Glutenfrei BOOL,
    PRIMARY KEY (ID)
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


