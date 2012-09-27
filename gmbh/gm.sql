-- MySQL dump 10.11
--
-- Host: a.db.sylon.net    Database: openbits_godmode_openbits
-- ------------------------------------------------------
-- Server version	5.0.45

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Filemanager`
--

DROP TABLE IF EXISTS `Filemanager`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Filemanager` (
  `id` int(11) NOT NULL auto_increment,
  `file` varchar(100) collate latin1_german1_ci NOT NULL default '',
  `text` text collate latin1_german1_ci,
  `kontakt` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Filemanager`
--

LOCK TABLES `Filemanager` WRITE;
/*!40000 ALTER TABLE `Filemanager` DISABLE KEYS */;
/*!40000 ALTER TABLE `Filemanager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Konfiguration`
--

DROP TABLE IF EXISTS `Konfiguration`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Konfiguration` (
  `context` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `key` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `value` text collate latin1_german1_ci NOT NULL,
  `text` varchar(255) collate latin1_german1_ci default NULL,
  `inputtype` varchar(255) collate latin1_german1_ci default NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Konfiguration`
--

LOCK TABLES `Konfiguration` WRITE;
/*!40000 ALTER TABLE `Konfiguration` DISABLE KEYS */;
INSERT INTO `Konfiguration` VALUES ('Programmkonfiguration','title','Faktura Godemode-Demo','Godmode Titel','input'),('Programmkonfiguration','startmodule','kontakte','Modul das beim Start geladen wird','getModulesList(\"startmodule\",$_config_startmodule,250,\"\")'),('Programmkonfiguration','tbl_bgcolor1','AAAAAA','Listen: Erste Hintergrundfarbe','input'),('Programmkonfiguration','tbl_bgcolor2','FFFFFF','Listen: Zweite Hintergrundfarbe','input'),('Programmkonfiguration','tbl_bghover','CCFFCC','Listen: RollOver Farbe','input'),('Programmkonfiguration','entrysperpage','400','Listen: Angezeigte Eintr?ge pro Seite','input'),('Programmkonfiguration','date','%d.%m.%Y','Datumsformat','input'),('Programmkonfiguration','modules','kontakte,produkte,rechnungenOloid,statistiken,konfiguration','Aktivierte Module','input'),('Rechnungen','rechnung_zahlungsfrist','15','Zahlungsfrist in Tagen','input'),('Rechnungen','rechnung_ort','Basel','Ort','input'),('Rechnungen','rechnung_subject','Rechnung ','Standardwert f?r Betreff','input'),('Rechnungen','rechnung_pdf_author','Tagi-Widehopf GmbH','Author des PDF\'s','input'),('Kontakte','kontakte_me','0','Eigene Firma','getKontakteList(\"kontakte_me\",$_config_kontakte_me,250,\"Bitte ausw?hlen\")'),('Kontakte','kontakte_default_anrede','3','Standardanrede','getAnredeList(\"kontakte_default_anrede\",$_config_kontakte_default_anrede,\"150\")'),('Kontakte','kontakte_kontaktpersonen_show_adresse','true','Kontaktpersonen : Adresse Anzeigen','bool'),('Kontakte','kontakte_show_fields','kontakt,ort,telefon1,id','Liste: Felder (aus Datenbank)','input'),('Kontakte','kontakte_show_fields_name','Kontakt,Ort,Telefon,ID','Liste: ?berschriften','input'),('Kontakte','kontakte_show_field_size','300,*','Liste: Breite der Felder (* = rest)','input'),('Kontakte','kontakte_module1','adresse','Modul 1','getKontakteModulesList(\"kontakte_module1\",$_config_kontakte_module1,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module2','kontakt','Modul 2','getKontakteModulesList(\"kontakte_module2\",$_config_kontakte_module2,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module3','informationen','Modul 3','getKontakteModulesList(\"kontakte_module3\",$_config_kontakte_module3,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module4','kontoinformationen','Modul 4','getKontakteModulesList(\"kontakte_module4\",$_config_kontakte_module4,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module5','gebiete','Modul 5','getKontakteModulesList(\"kontakte_module5\",$_config_kontakte_module5,250,\"Bitte Ausw?hlen\")'),('Produkte','produkte_int_prod_nr','true','Interne Produkte-Nr verwenden','bool'),('Produkte','produkte_ext_prod_nr','false','Externe Produkte-Nr verwenden','bool'),('Produkte','produkte_gruppe','true','Produktgruppen verwenden','bool'),('Produkte','produkte_preis1','true','Preis 1 verwenden','bool'),('Produkte','produkte_preis1_name','CHF Preis','Preis 1: Name','input'),('Produkte','produkte_preis2','true','Preis 2 verwenden','bool'),('Produkte','produkte_preis2_waehrung','2','Preis 2: Waehrung','getWaehrungsList(\"produkte_preis2_waehrung\",$_config_produkte_preis2_waehrung,250)'),('Produkte','produkte_preis3','true','Preis 3 verwenden','bool'),('Produkte','produkte_preis3_name','US Dollar Preis','Preis 3: Name','input'),('Produkte','produkte_preis4','true','Preis 4 verwenden','bool'),('Produkte','produkte_preis4_name','Garantie','Preis 4: Name','input'),('Produkte','produkte_text1','true','Text 1 verwenden','bool'),('Produkte','produkte_text1_name','Details','Name von Text 1','input'),('Produkte','produkte_text2','true','Text 2 verwenden','bool'),('Produkte','produkte_text1_name','Details','Name von Text 2','input'),('Produkte','produkte_rabattstufe','false','Rabattstufe verwenden','bool'),('Produkte','produkte_show_field_in_select','Bezeichnung','Feld das in Auswahllisten Angezeigt werden soll','input'),('Domains','domains_default_betrag','0.00','Standardbetrag','input'),('Domains','domains_inform_admin','false','Admin Informieren ?ber neue Domains','bool'),('Domains','domains_inform_admin_mail','borter@borter.info','Admin Informieren: E-Mail Adresse Admin','input'),('Domains','domains_inform_admin_from','Demo Demo','Admin Informieren: Absender fuer E-Mails (Name)','input'),('Domains','domains_inform_admin_from_mail','borter@borter.info','Admin Informieren: Absender fuer E-Mails (E-Mail)','input'),('Domains','domains_verrechnen_tage_vorher','15','Tage vor Verrechnen (oder so)','input'),('Domains','domains_mwst','0','MWSt.-Satz','input'),('Anbindung Buchhaltung','kursveraenderungen_buchen','false','Kursveraenderungen verbuchen','bool'),('Anbindung Buchhaltung','kursveraenderungen_haben','123','Kursveraenderungen: Haben-Konto','input'),('Anbindung Buchhaltung','kursveraenderungen_soll','4','Kursveraenderungen: Soll-Konto','input'),('Anbindung Buchhaltung','bezahlte_rechnungen_buchen','true','Bezahlte Rechnungen verbuchen','bool'),('Anbindung Buchhaltung','bezahlte_rechnungen_haben','77%KONTAKT%','Bezahlte Rechnungen: Haben-Konto','input'),('Anbindung Buchhaltung','bezahlte_rechnungen_soll','1200','Bezahlte Rechnungen: Soll-Konto','input'),('Kontakte','kontakte_module6','adressinfo','Modul 6','getKontakteModulesList(\"kontakte_module6\",$_config_kontakte_module6,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_gebiet2','Buchhaltung','Gebiet 2','input'),('Kontakte','kontakte_gebiet1','Tech.  Kontakt','Gebiet 1','input'),('Kontakte','kontakte_gebiet3','Geschäftsleitung','Gebiet 3','input'),('Rechnungen','kontakte_gebiete_rechnungen','2','Gebiet f?r Rechnungsempf?nger','getGebieteList(\"kontakte_gebiete_rechnungen\",$_config_kontakte_gebiete_rechnungen,250,\"\")'),('Rechnungen','rechnung_text_1','\r\nStandardtext 3','Standardtext 1','textarea'),('Rechnungen','rechnung_text_2','Standardtext 3','Standardtext 2','textarea'),('Produkte','produkte_preis1_waehrung','1','Preis 1: W?hrung','getWaehrungsList(\"produkte_preis1_waehrung\",$_config_produkte_preis1_waehrung,250)'),('Produkte','produkte_preis2_name','EUR Preis','Preis 2: Name','input'),('Produkte','produkte_preis3_waehrung','3','Preis 3: Waehrung','getWaehrungsList(\"produkte_preis3_waehrung\",$_config_produkte_preis3_waehrung,250)'),('Produkte','produkte_preis4_waehrung','2','Preis 4: Waehrung','getWaehrungsList(\"produkte_preis4_waehrung\",$_config_produkte_preis4_waehrung,250)'),('Rechnungen','rechnung_text_3','Standardtext 3\r\n','Standardtext 3','textarea'),('Rechnungen','rechnung_text_4','Standardtext 4','Standardtext 4','textarea'),('Rechnungen','rechnung_text_5','','Standardtext 5','textarea'),('Rechnungen','rechnung_text2_5','Standard Footer 5','Standardtext2 5','textarea'),('Rechnungen','rechnung_text2_4','Standard Footer 4','Standardtext2 4','textarea'),('Rechnungen','rechnung_text2_3','Standard Footer 3','Standardtext2 3','textarea'),('Rechnungen','rechnung_text2_2','Vielen Dank für Ihr Vertrauen\r\n\r\nWir bitten Sie um Überweisung des Rechnungsbetrages mit beiliegendem Einzahlungsschein innert 15 Tagen.\r\n\r\n\r\nDemo zum Demo GmbH','Standardtext2 2','textarea'),('Rechnungen','rechnung_text2_1','Vielen Dank für Ihr Vertrauen\r\n\r\nWir bitten Sie um Überweisung des Rechnungsbetrages mit beiliegendem Einzahlungsschein innert 15 Tagen.\r\n\r\n\r\nDemo zum Demo GmbH','Standardtext2 1','textarea'),('Rechnungen','rechnung_mahnung_text_1','Mahnungstext 1\r\n','Mahnungstext 1','textarea'),('Rechnungen','rechnung_mahnung_text_2','Mahnungstext 2','Mahnungstext 2','textarea'),('Anbindung Buchhaltung','export_rechnungen_haben','8280','Export Haben','input'),('Anbindung Buchhaltung','export_rechnungen_soll','77%KONTAKT%','Export Soll','input'),('Rechnungen','rechnung_mahnung_text_3','Mahnungstext 3','Mahnungstext 3','textarea'),('Rechnungen','rechnung_mahnung_text_4','Mahnungstext 4','Mahnungstext 4','textarea'),('Rechnungen','rechnung_mahnung_text_5','Mahnungstext 5','Mahnungstext 5','textarea'),('Programmkonfiguration','title','Faktura Godemode-Demo','Godmode Titel','input'),('Programmkonfiguration','startmodule','kontakte','Modul das beim Start geladen wird','getModulesList(\"startmodule\",$_config_startmodule,250,\"\")'),('Programmkonfiguration','tbl_bgcolor1','AAAAAA','Listen: Erste Hintergrundfarbe','input'),('Programmkonfiguration','tbl_bgcolor2','FFFFFF','Listen: Zweite Hintergrundfarbe','input'),('Programmkonfiguration','tbl_bghover','CCFFCC','Listen: RollOver Farbe','input'),('Programmkonfiguration','entrysperpage','400','Listen: Angezeigte Eintr?ge pro Seite','input'),('Programmkonfiguration','date','%d.%m.%Y','Datumsformat','input'),('Programmkonfiguration','modules','kontakte,produkte,rechnungenOloid,statistiken,konfiguration','Aktivierte Module','input'),('Rechnungen','rechnung_zahlungsfrist','15','Zahlungsfrist in Tagen','input'),('Rechnungen','rechnung_ort','Basel','Ort','input'),('Rechnungen','rechnung_subject','Rechnung ','Standardwert f?r Betreff','input'),('Rechnungen','rechnung_pdf_author','Tagi-Widehopf GmbH','Author des PDF\'s','input'),('Kontakte','kontakte_me','0','Eigene Firma','getKontakteList(\"kontakte_me\",$_config_kontakte_me,250,\"Bitte ausw?hlen\")'),('Kontakte','kontakte_default_anrede','3','Standardanrede','getAnredeList(\"kontakte_default_anrede\",$_config_kontakte_default_anrede,\"150\")'),('Kontakte','kontakte_kontaktpersonen_show_adresse','true','Kontaktpersonen : Adresse Anzeigen','bool'),('Kontakte','kontakte_show_fields','kontakt,ort,telefon1,id','Liste: Felder (aus Datenbank)','input'),('Kontakte','kontakte_show_fields_name','Kontakt,Ort,Telefon,ID','Liste: ?berschriften','input'),('Kontakte','kontakte_show_field_size','300,*','Liste: Breite der Felder (* = rest)','input'),('Kontakte','kontakte_module1','adresse','Modul 1','getKontakteModulesList(\"kontakte_module1\",$_config_kontakte_module1,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module2','kontakt','Modul 2','getKontakteModulesList(\"kontakte_module2\",$_config_kontakte_module2,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module3','informationen','Modul 3','getKontakteModulesList(\"kontakte_module3\",$_config_kontakte_module3,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module4','kontoinformationen','Modul 4','getKontakteModulesList(\"kontakte_module4\",$_config_kontakte_module4,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_module5','gebiete','Modul 5','getKontakteModulesList(\"kontakte_module5\",$_config_kontakte_module5,250,\"Bitte Ausw?hlen\")'),('Produkte','produkte_int_prod_nr','true','Interne Produkte-Nr verwenden','bool'),('Produkte','produkte_ext_prod_nr','false','Externe Produkte-Nr verwenden','bool'),('Produkte','produkte_gruppe','true','Produktgruppen verwenden','bool'),('Produkte','produkte_preis1','true','Preis 1 verwenden','bool'),('Produkte','produkte_preis1_name','CHF Preis','Preis 1: Name','input'),('Produkte','produkte_preis2','true','Preis 2 verwenden','bool'),('Produkte','produkte_preis2_waehrung','2','Preis 2: Waehrung','getWaehrungsList(\"produkte_preis2_waehrung\",$_config_produkte_preis2_waehrung,250)'),('Produkte','produkte_preis3','true','Preis 3 verwenden','bool'),('Produkte','produkte_preis3_name','US Dollar Preis','Preis 3: Name','input'),('Produkte','produkte_preis4','true','Preis 4 verwenden','bool'),('Produkte','produkte_preis4_name','Garantie','Preis 4: Name','input'),('Produkte','produkte_text1','true','Text 1 verwenden','bool'),('Produkte','produkte_text1_name','Details','Name von Text 1','input'),('Produkte','produkte_text2','true','Text 2 verwenden','bool'),('Produkte','produkte_text1_name','Details','Name von Text 2','input'),('Produkte','produkte_rabattstufe','false','Rabattstufe verwenden','bool'),('Produkte','produkte_show_field_in_select','Bezeichnung','Feld das in Auswahllisten Angezeigt werden soll','input'),('Domains','domains_default_betrag','0.00','Standardbetrag','input'),('Domains','domains_inform_admin','false','Admin Informieren ?ber neue Domains','bool'),('Domains','domains_inform_admin_mail','borter@borter.info','Admin Informieren: E-Mail Adresse Admin','input'),('Domains','domains_inform_admin_from','Demo Demo','Admin Informieren: Absender fuer E-Mails (Name)','input'),('Domains','domains_inform_admin_from_mail','borter@borter.info','Admin Informieren: Absender fuer E-Mails (E-Mail)','input'),('Domains','domains_verrechnen_tage_vorher','15','Tage vor Verrechnen (oder so)','input'),('Domains','domains_mwst','0','MWSt.-Satz','input'),('Anbindung Buchhaltung','kursveraenderungen_buchen','false','Kursveraenderungen verbuchen','bool'),('Anbindung Buchhaltung','kursveraenderungen_haben','123','Kursveraenderungen: Haben-Konto','input'),('Anbindung Buchhaltung','kursveraenderungen_soll','4','Kursveraenderungen: Soll-Konto','input'),('Anbindung Buchhaltung','bezahlte_rechnungen_buchen','true','Bezahlte Rechnungen verbuchen','bool'),('Anbindung Buchhaltung','bezahlte_rechnungen_haben','77%KONTAKT%','Bezahlte Rechnungen: Haben-Konto','input'),('Anbindung Buchhaltung','bezahlte_rechnungen_soll','1200','Bezahlte Rechnungen: Soll-Konto','input'),('Kontakte','kontakte_module6','adressinfo','Modul 6','getKontakteModulesList(\"kontakte_module6\",$_config_kontakte_module6,250,\"Bitte Ausw?hlen\")'),('Kontakte','kontakte_gebiet2','Buchhaltung','Gebiet 2','input'),('Kontakte','kontakte_gebiet1','Tech.  Kontakt','Gebiet 1','input'),('Kontakte','kontakte_gebiet3','Geschäftsleitung','Gebiet 3','input'),('Rechnungen','kontakte_gebiete_rechnungen','2','Gebiet f?r Rechnungsempf?nger','getGebieteList(\"kontakte_gebiete_rechnungen\",$_config_kontakte_gebiete_rechnungen,250,\"\")'),('Rechnungen','rechnung_text_1','\r\nStandardtext 3','Standardtext 1','textarea'),('Rechnungen','rechnung_text_2','Standardtext 3','Standardtext 2','textarea'),('Produkte','produkte_preis1_waehrung','1','Preis 1: W?hrung','getWaehrungsList(\"produkte_preis1_waehrung\",$_config_produkte_preis1_waehrung,250)'),('Produkte','produkte_preis2_name','EUR Preis','Preis 2: Name','input'),('Produkte','produkte_preis3_waehrung','3','Preis 3: Waehrung','getWaehrungsList(\"produkte_preis3_waehrung\",$_config_produkte_preis3_waehrung,250)'),('Produkte','produkte_preis4_waehrung','2','Preis 4: Waehrung','getWaehrungsList(\"produkte_preis4_waehrung\",$_config_produkte_preis4_waehrung,250)'),('Rechnungen','rechnung_text_3','Standardtext 3\r\n','Standardtext 3','textarea'),('Rechnungen','rechnung_text_4','Standardtext 4','Standardtext 4','textarea'),('Rechnungen','rechnung_text_5','','Standardtext 5','textarea'),('Rechnungen','rechnung_text2_5','Standard Footer 5','Standardtext2 5','textarea'),('Rechnungen','rechnung_text2_4','Standard Footer 4','Standardtext2 4','textarea'),('Rechnungen','rechnung_text2_3','Standard Footer 3','Standardtext2 3','textarea'),('Rechnungen','rechnung_text2_2','Vielen Dank für Ihr Vertrauen\r\n\r\nWir bitten Sie um Überweisung des Rechnungsbetrages mit beiliegendem Einzahlungsschein innert 15 Tagen.\r\n\r\n\r\nDemo zum Demo GmbH','Standardtext2 2','textarea'),('Rechnungen','rechnung_text2_1','Vielen Dank für Ihr Vertrauen\r\n\r\nWir bitten Sie um Überweisung des Rechnungsbetrages mit beiliegendem Einzahlungsschein innert 15 Tagen.\r\n\r\n\r\nDemo zum Demo GmbH','Standardtext2 1','textarea'),('Rechnungen','rechnung_mahnung_text_1','Mahnungstext 1\r\n','Mahnungstext 1','textarea'),('Rechnungen','rechnung_mahnung_text_2','Mahnungstext 2','Mahnungstext 2','textarea'),('Anbindung Buchhaltung','export_rechnungen_haben','8280','Export Haben','input'),('Anbindung Buchhaltung','export_rechnungen_soll','77%KONTAKT%','Export Soll','input'),('Rechnungen','rechnung_mahnung_text_3','Mahnungstext 3','Mahnungstext 3','textarea'),('Rechnungen','rechnung_mahnung_text_4','Mahnungstext 4','Mahnungstext 4','textarea'),('Rechnungen','rechnung_mahnung_text_5','Mahnungstext 5','Mahnungstext 5','textarea');
/*!40000 ALTER TABLE `Konfiguration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Kontakte`
--

DROP TABLE IF EXISTS `Kontakte`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Kontakte` (
  `id` int(11) NOT NULL auto_increment,
  `erfasst` date default '0000-00-00',
  `updated` date default '0000-00-00',
  `aktiv` tinyint(4) NOT NULL default '1',
  `firma` varchar(100) character set utf8 collate utf8_unicode_ci default NULL,
  `firma2` varchar(100) collate latin1_german1_ci default NULL,
  `anrede` int(11) NOT NULL default '3',
  `adresse` varchar(50) collate latin1_german1_ci default NULL,
  `adresse2` varchar(50) collate latin1_german1_ci default NULL,
  `plz` varchar(10) collate latin1_german1_ci default NULL,
  `ort` varchar(50) collate latin1_german1_ci default NULL,
  `land` varchar(20) collate latin1_german1_ci NOT NULL default '',
  `telefon1` varchar(20) collate latin1_german1_ci default NULL,
  `telefon2` varchar(20) collate latin1_german1_ci NOT NULL default '',
  `mobile` varchar(20) collate latin1_german1_ci default NULL,
  `fax` varchar(50) collate latin1_german1_ci default NULL,
  `mail` varchar(50) collate latin1_german1_ci default NULL,
  `www` varchar(50) collate latin1_german1_ci default NULL,
  `text` text collate latin1_german1_ci,
  `konto` varchar(50) collate latin1_german1_ci default NULL,
  `kontonr` varchar(50) collate latin1_german1_ci default NULL,
  `blz` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `swift` varchar(50) collate latin1_german1_ci default NULL,
  `iban` varchar(50) collate latin1_german1_ci default NULL,
  `pl` int(11) NOT NULL default '0',
  `kontakt1` int(11) default NULL,
  `kontakt2` int(11) default NULL,
  `kontakt3` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Kontakte`
--

LOCK TABLES `Kontakte` WRITE;
/*!40000 ALTER TABLE `Kontakte` DISABLE KEYS */;
INSERT INTO `Kontakte` VALUES (3,'2025-02-20','0000-00-00',1,'Demo zum Demo','',3,'Jungstrasse 36','','4056','Basel','','','','','','','','','','','','','',0,0,0,0),(4,'2011-02-25','0000-00-00',1,'Muster','Hans',1,'','','','','','','','','','','','','','','','','',0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Kontakte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Kontakte_anreden`
--

DROP TABLE IF EXISTS `Kontakte_anreden`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Kontakte_anreden` (
  `id` int(11) NOT NULL default '0',
  `anrede` varchar(100) collate latin1_german1_ci NOT NULL default '',
  `anrede_lang` varchar(150) collate latin1_german1_ci NOT NULL default '',
  `privat` tinyint(4) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Kontakte_anreden`
--

LOCK TABLES `Kontakte_anreden` WRITE;
/*!40000 ALTER TABLE `Kontakte_anreden` DISABLE KEYS */;
INSERT INTO `Kontakte_anreden` VALUES (1,'Herr','Sehr geehrter Herr',1),(2,'Frau','Sehr geehrte Frau',1),(3,'Damen und Herren','Sehr geehrte Damen und Herren',NULL),(4,'Monsieur','Cher Monsieur',1),(5,'Madame','Madame',1),(6,'Monsieur le Maire','Cher Monsieur le Maire',NULL),(7,'Mister','Dear Mister',1),(8,'Madame et Monsieur','Cher Madame, cher Monsieur',NULL),(9,'Mrs.','Mrs.',1),(10,'Madam','Dear Madam',1),(11,'Misses','Dear Misses',1);
/*!40000 ALTER TABLE `Kontakte_anreden` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Kontakte_kontaktpersonen`
--

DROP TABLE IF EXISTS `Kontakte_kontaktpersonen`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Kontakte_kontaktpersonen` (
  `id` int(11) NOT NULL auto_increment,
  `firma` int(11) NOT NULL default '0',
  `name` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `vorname` varchar(50) collate latin1_german1_ci default NULL,
  `anrede` int(11) default NULL,
  `position` varchar(30) collate latin1_german1_ci NOT NULL default '',
  `abteilung` varchar(50) collate latin1_german1_ci default NULL,
  `adresse` varchar(50) collate latin1_german1_ci default NULL,
  `adresse2` varchar(50) collate latin1_german1_ci default NULL,
  `plz` varchar(10) collate latin1_german1_ci default NULL,
  `ort` varchar(50) collate latin1_german1_ci default NULL,
  `land` varchar(50) collate latin1_german1_ci default NULL,
  `tel_privat` varchar(30) collate latin1_german1_ci default NULL,
  `tel_gesch` varchar(30) collate latin1_german1_ci default NULL,
  `tel_direkt` varchar(30) collate latin1_german1_ci default NULL,
  `tel_mobile` varchar(30) collate latin1_german1_ci default NULL,
  `fax` varchar(30) collate latin1_german1_ci default NULL,
  `mail` varchar(50) collate latin1_german1_ci default NULL,
  `mail2` varchar(50) collate latin1_german1_ci default NULL,
  `text` text collate latin1_german1_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Kontakte_kontaktpersonen`
--

LOCK TABLES `Kontakte_kontaktpersonen` WRITE;
/*!40000 ALTER TABLE `Kontakte_kontaktpersonen` DISABLE KEYS */;
INSERT INTO `Kontakte_kontaktpersonen` VALUES (5,1,'wfawfasfd','adsfasdfasf',3,'adfasdfasdf','adfasdfasdf','','','','',NULL,'','','','','','','','');
/*!40000 ALTER TABLE `Kontakte_kontaktpersonen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Produkte`
--

DROP TABLE IF EXISTS `Produkte`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Produkte` (
  `id` int(11) NOT NULL auto_increment,
  `nr_int` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `nr_ext` varchar(50) collate latin1_german1_ci default NULL,
  `gruppe` varchar(50) collate latin1_german1_ci default NULL,
  `text1` text collate latin1_german1_ci,
  `text2` text collate latin1_german1_ci,
  `preis1` float default NULL,
  `preis2` float default NULL,
  `preis3` float default NULL,
  `preis4` float default NULL,
  `waehrung` int(11) NOT NULL default '1',
  `rabattstufe` varchar(50) collate latin1_german1_ci default NULL,
  `warenbestand` int(11) default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nr_int` (`nr_int`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Produkte`
--

LOCK TABLES `Produkte` WRITE;
/*!40000 ALTER TABLE `Produkte` DISABLE KEYS */;
/*!40000 ALTER TABLE `Produkte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Projekte_leadmanager`
--

DROP TABLE IF EXISTS `Projekte_leadmanager`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Projekte_leadmanager` (
  `id` int(11) NOT NULL auto_increment,
  `kontakt` int(11) NOT NULL default '0',
  `zustaendig` int(11) default NULL,
  `text` text collate latin1_german1_ci,
  `beginn` varchar(255) collate latin1_german1_ci default NULL,
  `zustellen_bis` varchar(255) collate latin1_german1_ci default NULL,
  `nummer` varchar(100) collate latin1_german1_ci default NULL,
  `status` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Projekte_leadmanager`
--

LOCK TABLES `Projekte_leadmanager` WRITE;
/*!40000 ALTER TABLE `Projekte_leadmanager` DISABLE KEYS */;
/*!40000 ALTER TABLE `Projekte_leadmanager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Projekte_leadmanager_status`
--

DROP TABLE IF EXISTS `Projekte_leadmanager_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Projekte_leadmanager_status` (
  `id` int(11) NOT NULL auto_increment,
  `text` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `color` varchar(6) collate latin1_german1_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Projekte_leadmanager_status`
--

LOCK TABLES `Projekte_leadmanager_status` WRITE;
/*!40000 ALTER TABLE `Projekte_leadmanager_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `Projekte_leadmanager_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Projekte_taskliste`
--

DROP TABLE IF EXISTS `Projekte_taskliste`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Projekte_taskliste` (
  `id` int(11) NOT NULL auto_increment,
  `kontakt` int(11) NOT NULL default '0',
  `text` text collate latin1_german1_ci,
  `faellig` date NOT NULL default '0000-00-00',
  `erledigt` text collate latin1_german1_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Projekte_taskliste`
--

LOCK TABLES `Projekte_taskliste` WRITE;
/*!40000 ALTER TABLE `Projekte_taskliste` DISABLE KEYS */;
/*!40000 ALTER TABLE `Projekte_taskliste` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Projekte_traktandenliste`
--

DROP TABLE IF EXISTS `Projekte_traktandenliste`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Projekte_traktandenliste` (
  `id` int(11) NOT NULL auto_increment,
  `kontakt` int(11) NOT NULL default '0',
  `text` text collate latin1_german1_ci,
  `faellig` date NOT NULL default '0000-00-00',
  `erledigt` text collate latin1_german1_ci,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Projekte_traktandenliste`
--

LOCK TABLES `Projekte_traktandenliste` WRITE;
/*!40000 ALTER TABLE `Projekte_traktandenliste` DISABLE KEYS */;
/*!40000 ALTER TABLE `Projekte_traktandenliste` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rechnungen`
--

DROP TABLE IF EXISTS `Rechnungen`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Rechnungen` (
  `id` double NOT NULL auto_increment,
  `fixiert` tinyint(1) NOT NULL default '0',
  `kontakt` int(11) NOT NULL default '0',
  `waehrung` int(11) NOT NULL default '1',
  `fx` float NOT NULL default '1',
  `fx1` float default '1',
  `datum` date default NULL,
  `bezahlt` date default NULL,
  `adresse` text collate latin1_german1_ci NOT NULL,
  `betreff` varchar(255) collate latin1_german1_ci default NULL,
  `text` text collate latin1_german1_ci,
  `footer` text collate latin1_german1_ci,
  `zahlungsfrist` int(11) NOT NULL default '30',
  `besrnr` varchar(100) collate latin1_german1_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Rechnungen`
--

LOCK TABLES `Rechnungen` WRITE;
/*!40000 ALTER TABLE `Rechnungen` DISABLE KEYS */;
/*!40000 ALTER TABLE `Rechnungen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rechnungen_gutschriften`
--

DROP TABLE IF EXISTS `Rechnungen_gutschriften`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Rechnungen_gutschriften` (
  `id` int(11) NOT NULL auto_increment,
  `kontakt` int(11) NOT NULL default '0',
  `betrag` float NOT NULL default '0',
  `waehrung` int(11) NOT NULL default '1',
  `fx` float NOT NULL default '1',
  `mwst` float NOT NULL default '0',
  `datum` date NOT NULL default '0000-00-00',
  `text` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `bezahlt` int(11) default NULL,
  `auszahlen` tinyint(4) NOT NULL default '1',
  `abhaengig` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Rechnungen_gutschriften`
--

LOCK TABLES `Rechnungen_gutschriften` WRITE;
/*!40000 ALTER TABLE `Rechnungen_gutschriften` DISABLE KEYS */;
/*!40000 ALTER TABLE `Rechnungen_gutschriften` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rechnungen_mahnungen`
--

DROP TABLE IF EXISTS `Rechnungen_mahnungen`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Rechnungen_mahnungen` (
  `id` double NOT NULL auto_increment,
  `rechnung` double NOT NULL default '0',
  `datum` date NOT NULL default '0000-00-00',
  `adresse` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `betreff` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `text` text collate latin1_german1_ci NOT NULL,
  `footer` text collate latin1_german1_ci NOT NULL,
  `zahlungsfrist` int(11) NOT NULL default '0',
  `besrnr` varchar(255) collate latin1_german1_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Rechnungen_mahnungen`
--

LOCK TABLES `Rechnungen_mahnungen` WRITE;
/*!40000 ALTER TABLE `Rechnungen_mahnungen` DISABLE KEYS */;
/*!40000 ALTER TABLE `Rechnungen_mahnungen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rechnungen_positionen`
--

DROP TABLE IF EXISTS `Rechnungen_positionen`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Rechnungen_positionen` (
  `id` double NOT NULL auto_increment,
  `kontakt` int(11) NOT NULL default '0',
  `rechnung` double default NULL,
  `text` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `text1` varchar(255) collate latin1_german1_ci default NULL,
  `anzahl` int(11) NOT NULL default '1',
  `betrag` double NOT NULL default '0',
  `waehrung` int(11) NOT NULL default '1',
  `fx` float NOT NULL default '1',
  `mwst` float NOT NULL default '0',
  `datum` date default NULL,
  `key` varchar(20) collate latin1_german1_ci default NULL,
  `value` varchar(200) collate latin1_german1_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Rechnungen_positionen`
--

LOCK TABLES `Rechnungen_positionen` WRITE;
/*!40000 ALTER TABLE `Rechnungen_positionen` DISABLE KEYS */;
/*!40000 ALTER TABLE `Rechnungen_positionen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Statistiken`
--

DROP TABLE IF EXISTS `Statistiken`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Statistiken` (
  `id` int(11) NOT NULL auto_increment,
  `aktiv` tinyint(1) NOT NULL default '1',
  `titel` varchar(100) collate latin1_german1_ci NOT NULL default '',
  `sql` text collate latin1_german1_ci NOT NULL,
  `ueberschriften` varchar(255) collate latin1_german1_ci NOT NULL default '',
  `filename` varchar(100) collate latin1_german1_ci NOT NULL default '0',
  `datumsfeld` varchar(50) collate latin1_german1_ci NOT NULL default '',
  `total` varchar(100) collate latin1_german1_ci default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Statistiken`
--

LOCK TABLES `Statistiken` WRITE;
/*!40000 ALTER TABLE `Statistiken` DISABLE KEYS */;
/*!40000 ALTER TABLE `Statistiken` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Timesheet`
--

DROP TABLE IF EXISTS `Timesheet`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Timesheet` (
  `id` int(11) NOT NULL auto_increment,
  `kunde` int(11) NOT NULL,
  `start_stamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `end_stamp` timestamp NOT NULL default '0000-00-00 00:00:00',
  `user` int(11) default NULL,
  `notice` text,
  `ISRUNNING` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=431 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Timesheet`
--

LOCK TABLES `Timesheet` WRITE;
/*!40000 ALTER TABLE `Timesheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `Timesheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Timesheet_Kontakte`
--

DROP TABLE IF EXISTS `Timesheet_Kontakte`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Timesheet_Kontakte` (
  `id` int(11) NOT NULL auto_increment,
  `Kunde` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Timesheet_Kontakte`
--

LOCK TABLES `Timesheet_Kontakte` WRITE;
/*!40000 ALTER TABLE `Timesheet_Kontakte` DISABLE KEYS */;
INSERT INTO `Timesheet_Kontakte` VALUES (56,5),(93,18),(91,16),(54,3),(92,17),(58,23),(82,9),(90,2),(68,10),(89,25);
/*!40000 ALTER TABLE `Timesheet_Kontakte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Waehrungen`
--

DROP TABLE IF EXISTS `Waehrungen`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Waehrungen` (
  `id` int(11) NOT NULL auto_increment,
  `text` varchar(10) collate latin1_german1_ci NOT NULL default '',
  `html` varchar(10) collate latin1_german1_ci NOT NULL default '',
  `round` int(11) NOT NULL default '0',
  `yahoo_fx` char(3) collate latin1_german1_ci NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Waehrungen`
--

LOCK TABLES `Waehrungen` WRITE;
/*!40000 ALTER TABLE `Waehrungen` DISABLE KEYS */;
INSERT INTO `Waehrungen` VALUES (1,'CHF','CHF',5,'CHF'),(2,'EUR','&euro;',1,'EUR'),(3,'US Dollar','US $',1,'USD');
/*!40000 ALTER TABLE `Waehrungen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Zahlungsarten`
--

DROP TABLE IF EXISTS `Zahlungsarten`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `Zahlungsarten` (
  `id` int(11) NOT NULL auto_increment,
  `art` varchar(100) collate latin1_german1_ci NOT NULL default '',
  `monate` int(11) NOT NULL default '0',
  `raten` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `Zahlungsarten`
--

LOCK TABLES `Zahlungsarten` WRITE;
/*!40000 ALTER TABLE `Zahlungsarten` DISABLE KEYS */;
INSERT INTO `Zahlungsarten` VALUES (1,'J?hrlich',12,1),(2,'Viertelj?hrlich',3,4),(3,'Monatlich',1,12);
/*!40000 ALTER TABLE `Zahlungsarten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'openbits_godmode_openbits'
--
DELIMITER ;;
DELIMITER ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-12-13 14:35:09
