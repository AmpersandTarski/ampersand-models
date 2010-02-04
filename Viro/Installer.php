<?php
  // Try to connect to the database

  if(isset($DB_host)&&!isset($_REQUEST['DB_host'])){
    $included = true; // this means user/pass are probably correct
    $DB_link = @mysql_connect(@$DB_host,@$DB_user,@$DB_pass);
  }else{
    $included = false; // get user/pass elsewhere
    if(file_exists("dbsettings.php")) include "dbsettings.php";
    else { // no settings found.. try some default settings
      if(!( $DB_link=@mysql_connect($DB_host='localhost',$DB_user='root',$DB_pass='')))
      { // we still have no working settings.. ask the user!
        die("Install failed: cannot connect to MySQL"); // todo
      }
    } 
  }
  if($DB_slct = @mysql_select_db('VIRO')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `VIRO` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('VIRO');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database");
  }else{
    if(!$included && !file_exists("dbsettings.php")){ // we have a link now; try to write the dbsettings.php file
       if($fh = @fopen("dbsettings.php", 'w')){
         fwrite($fh, '<'.'?php $DB_link=mysql_connect($DB_host="'.$DB_host.'", $DB_user="'.$DB_user.'", $DB_pass="'.$DB_pass.'"); $DB_debug = 3; ?'.'>');
         fclose($fh);
       }else die('<P>Error: could not write dbsettings.php, make sure that the directory of Installer.php is writable
                  or create dbsettings.php in the same directory as Installer.php
                  and paste the following code into it:</P><code>'.
                 '&lt;'.'?php $DB_link=mysql_connect($DB_host="'.$DB_host.'", $DB_user="'.$DB_user.'", $DB_pass="'.$DB_pass.'"); $DB_debug = 3; ?'.'&gt;</code>');
    }

    $error=false;
    /*** Create new SQL tables ***/
    //// Number of plugs: 70
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `usecase`")){
        mysql_query("DROP TABLE `usecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `zitting`")){
        mysql_query("DROP TABLE `zitting`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `document`")){
        mysql_query("DROP TABLE `document`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `sessie`")){
        mysql_query("DROP TABLE `sessie`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `procedur`")){
        mysql_query("DROP TABLE `procedur`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `behandeling`")){
        mysql_query("DROP TABLE `behandeling`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `gerecht`")){
        mysql_query("DROP TABLE `gerecht`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `kamer`")){
        mysql_query("DROP TABLE `kamer`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `actie`")){
        mysql_query("DROP TABLE `actie`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `machtiging`")){
        mysql_query("DROP TABLE `machtiging`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `cluster`")){
        mysql_query("DROP TABLE `cluster`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `plaats`")){
        mysql_query("DROP TABLE `plaats`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `digid`")){
        mysql_query("DROP TABLE `digid`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `documenttype`")){
        mysql_query("DROP TABLE `documenttype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `orgaan`")){
        mysql_query("DROP TABLE `orgaan`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `persoon`")){
        mysql_query("DROP TABLE `persoon`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rechtsgebied`")){
        mysql_query("DROP TABLE `rechtsgebied`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `proceduresoort`")){
        mysql_query("DROP TABLE `proceduresoort`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `tekst`")){
        mysql_query("DROP TABLE `tekst`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `datum`")){
        mysql_query("DROP TABLE `datum`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `sector`")){
        mysql_query("DROP TABLE `sector`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `gerechtshof`")){
        mysql_query("DROP TABLE `gerechtshof`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `artikel`")){
        mysql_query("DROP TABLE `artikel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `handeling`")){
        mysql_query("DROP TABLE `handeling`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objecttype`")){
        mysql_query("DROP TABLE `objecttype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `werkwoord`")){
        mysql_query("DROP TABLE `werkwoord`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ding`")){
        mysql_query("DROP TABLE `ding`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rol`")){
        mysql_query("DROP TABLE `rol`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `moscow`")){
        mysql_query("DROP TABLE `moscow`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `fase`")){
        mysql_query("DROP TABLE `fase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `gpstap`")){
        mysql_query("DROP TABLE `gpstap`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `component`")){
        mysql_query("DROP TABLE `component`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `formcodes`")){
        mysql_query("DROP TABLE `formcodes`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `referentie`")){
        mysql_query("DROP TABLE `referentie`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `tijdstip`")){
        mysql_query("DROP TABLE `tijdstip`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `buservice`")){
        mysql_query("DROP TABLE `buservice`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `zaaksdossier`")){
        mysql_query("DROP TABLE `zaaksdossier`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `eiser`")){
        mysql_query("DROP TABLE `eiser`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `gedaagde`")){
        mysql_query("DROP TABLE `gedaagde`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `gevoegde`")){
        mysql_query("DROP TABLE `gevoegde`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `gemachtigde`")){
        mysql_query("DROP TABLE `gemachtigde`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `inzake`")){
        mysql_query("DROP TABLE `inzake`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `machtigingdocument`")){
        mysql_query("DROP TABLE `machtigingdocument`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `clusterprocedur`")){
        mysql_query("DROP TABLE `clusterprocedur`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `grond`")){
        mysql_query("DROP TABLE `grond`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `rechter`")){
        mysql_query("DROP TABLE `rechter`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `griffier`")){
        mysql_query("DROP TABLE `griffier`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `bevoegd`")){
        mysql_query("DROP TABLE `bevoegd`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `bezetting`")){
        mysql_query("DROP TABLE `bezetting`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `wetstekst`")){
        mysql_query("DROP TABLE `wetstekst`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `handelingartikel`")){
        mysql_query("DROP TABLE `handelingartikel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `orgaanartikel`")){
        mysql_query("DROP TABLE `orgaanartikel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `object`")){
        mysql_query("DROP TABLE `object`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objectusecase`")){
        mysql_query("DROP TABLE `objectusecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `werkwoordartikel`")){
        mysql_query("DROP TABLE `werkwoordartikel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objecttypeartikel`")){
        mysql_query("DROP TABLE `objecttypeartikel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `werkwoordusecase`")){
        mysql_query("DROP TABLE `werkwoordusecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `werkwoordhandeling`")){
        mysql_query("DROP TABLE `werkwoordhandeling`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objectactie`")){
        mysql_query("DROP TABLE `objectactie`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `als`")){
        mysql_query("DROP TABLE `als`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `type`")){
        mysql_query("DROP TABLE `type`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `vervult`")){
        mysql_query("DROP TABLE `vervult`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `sub`")){
        mysql_query("DROP TABLE `sub`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `use_case`")){
        mysql_query("DROP TABLE `use_case`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `mag`")){
        mysql_query("DROP TABLE `mag`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `faseusecase`")){
        mysql_query("DROP TABLE `faseusecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `servicerol`")){
        mysql_query("DROP TABLE `servicerol`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `aut`")){
        mysql_query("DROP TABLE `aut`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `aan`")){
        mysql_query("DROP TABLE `aan`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `uwkenmerk`")){
        mysql_query("DROP TABLE `uwkenmerk`");
      }
    }
    /**************************************\
    * Plug usecase                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * prio  [UNI]                          *
    * categorie  [UNI]                     *
    * omschrijving  [UNI]                  *
    * iS_component_objecttype  [UNI]       *
    * opmerkingen  [UNI]                   *
    * form  [UNI]                          *
    * bron  [UNI]                          *
    \**************************************/
    mysql_query("CREATE TABLE `usecase`
                     ( `i` VARCHAR(255) NOT NULL
                     , `prio` VARCHAR(255)
                     , `categorie` VARCHAR(255)
                     , `omschrijving` VARCHAR(255)
                     , `is_component_objecttype` VARCHAR(255)
                     , `opmerkingen` VARCHAR(255)
                     , `form` VARCHAR(255)
                     , `bron` VARCHAR(255)
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug zitting                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * griffier  [TOT,UNI]                  *
    * geagendeerd  [UNI,TOT]               *
    * plaatsgevonden  [UNI]                *
    * plaats  [UNI,TOT]                    *
    * locatie  [UNI,TOT]                   *
    * kamer  [UNI,TOT]                     *
    \**************************************/
    mysql_query("CREATE TABLE `zitting`
                     ( `i` VARCHAR(255) NOT NULL
                     , `griffier` VARCHAR(255) NOT NULL
                     , `geagendeerd` VARCHAR(255) NOT NULL
                     , `plaatsgevonden` VARCHAR(255)
                     , `plaats` VARCHAR(255) NOT NULL
                     , `locatie` VARCHAR(255) NOT NULL
                     , `kamer` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `zitting` (`i` ,`griffier` ,`geagendeerd` ,`plaatsgevonden` ,`plaats` ,`locatie` ,`kamer` )
                VALUES ('Zitting RbAms 1094', 'mr. V.M. Behrens', '23 januari 2009', NULL, 'Amsterdam', 'Rechtbank Amsterdam', 'Enkelvoudige kamer van de sector Bestuursrecht Algemeen van de Rechtbank Amsterdam')
                      , ('Zitting RvS 83', 'mr. J.J. Schuurman', '15 september 2000', NULL, 'Den Haag', 'Raad van State', 'Kamer 2 afdeling bestuursrechtspraak van de Raad van State')
                      , ('Zitting RvS 84', 'mr. J.J. Schuurman', '16 november 2000', NULL, 'Den Haag', 'Raad van State', 'Kamer 2 afdeling bestuursrechtspraak van de Raad van State')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug document                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * type  [UNI,TOT]                      *
    * van  [UNI,TOT]                       *
    * verzonden  [UNI,TOT]                 *
    * ontvangen  [UNI]                     *
    * kenmerkVan  [UNI,TOT]                *
    \**************************************/
    mysql_query("CREATE TABLE `document`
                     ( `i` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , `van` VARCHAR(255) NOT NULL
                     , `verzonden` VARCHAR(255) NOT NULL
                     , `ontvangen` VARCHAR(255)
                     , `kenmerkvan` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `document` (`i` ,`type` ,`van` ,`verzonden` ,`ontvangen` ,`kenmerkvan` )
                VALUES ('doc987384', 'Vonnis', 'Raad van State', '10-10-2000', NULL, 'doc987384')
                      , ('doc763820', 'Bewijsmiddel', 'AWB 07/2481 WRO', '???', NULL, 'doc763820')
                      , ('brief 2009/87743', 'Correspondentie', 'Mevr. El Amrani', '10 april 2009', '14 april 2009', 'Vreugdenhil')
                      , ('brief 2009/87743a', 'Beroepschrift', 'Rechtbank Utrecht', '16 april 2009', NULL, '2009/87743a')
                      , ('bijlage 2009/87743.1', 'Bewijsmiddel', 'Gemeente Utrecht', '27 februari 2009', '14 april 2009', 'B. en W.-besluit van 27 februari 2009, Gemeenteblad van Utrecht 2009 Nr. 8')
                      , ('brief 2000/864821a', 'Machtiging', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst', '2-3-2000', NULL, '2000/864821a')
                      , ('brief 2000/860338e', 'Machtiging', 'de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen', '5-3-2000', NULL, '2000/860338e')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug sessie                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * start  [UNI,TOT]                     *
    * einde  [UNI]                         *
    * digid  [UNI,TOT]                     *
    * rol  [UNI,TOT]                       *
    * login~  [TOT,UNI]                    *
    \**************************************/
    mysql_query("CREATE TABLE `sessie`
                     ( `i` VARCHAR(255) NOT NULL
                     , `start` VARCHAR(255) NOT NULL
                     , `einde` VARCHAR(255)
                     , `digid` VARCHAR(255) NOT NULL
                     , `rol` VARCHAR(255) NOT NULL
                     , `login` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug procedur                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * zorgdrager  [UNI,TOT]                *
    * rechtsgebied  [UNI,TOT]              *
    * proceduresoort  [UNI,TOT]            *
    \**************************************/
    mysql_query("CREATE TABLE `procedur`
                     ( `i` VARCHAR(255) NOT NULL
                     , `zorgdrager` VARCHAR(255) NOT NULL
                     , `rechtsgebied` VARCHAR(255) NOT NULL
                     , `proceduresoort` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `procedur` (`i` ,`zorgdrager` ,`rechtsgebied` ,`proceduresoort` )
                VALUES ('199902238', 'Raad van State', 'Bestuursrecht', 'Hoger Beroep')
                      , ('AWB 07/2481 WRO', 'Rechtbank Amsterdam', 'Bestuursrecht Algemeen', 'Beroep')
                      , ('SBR 02/74331', 'Rechtbank Utrecht', 'Bestuursrecht', 'Beroep')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug behandeling                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * zitting  [UNI,TOT]                   *
    * zaak  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `behandeling`
                     ( `i` VARCHAR(255) NOT NULL
                     , `zitting` VARCHAR(255) NOT NULL
                     , `zaak` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `behandeling` (`i` ,`zitting` ,`zaak` )
                VALUES ('199902238/1', 'Zitting RvS 83', '199902238')
                      , ('199902238/2', 'Zitting RvS 84', '199902238')
                      , ('AWB 07/2481 WRO/1', 'Zitting RbAms 1094', 'AWB 07/2481 WRO')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug gerecht                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * ressort  [UNI,TOT]                   *
    * hoofdplaats  [UNI,TOT]               *
    \**************************************/
    mysql_query("CREATE TABLE `gerecht`
                     ( `i` VARCHAR(255) NOT NULL
                     , `ressort` VARCHAR(255) NOT NULL
                     , `hoofdplaats` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `gerecht` (`i` ,`ressort` ,`hoofdplaats` )
                VALUES ('Rechtbank Amsterdam', 'Gerechtshof Amsterdam', 'Amsterdam')
                      , ('Raad van State', 'Raad van State', 'Den Haag')
                      , ('Rechtbank Utrecht', 'Gerechtshof Amsterdam', 'Utrecht')
                      , ('Rechtbank Alkmaar', 'Gerechtshof Amsterdam', 'Alkmaar')
                      , ('Rechtbank Haarlem', 'Gerechtshof Amsterdam', 'Haarlem')
                      , ('Rechtbank Almelo', 'Gerechtshof Arnhem', 'Almelo')
                      , ('Rechtbank Arnhem', 'Gerechtshof Arnhem', 'Arnhem')
                      , ('Rechtbank Zutphen', 'Gerechtshof Arnhem', 'Zutphen')
                      , ('Rechtbank Zwolle-Lelystad', 'Gerechtshof Arnhem', 'Zwolle')
                      , ('Rechtbank Dordrecht', 'Gerechtshof \'s-Gravenhage', 'Dordrecht')
                      , ('Rechtbank \'s-Gravenhage', 'Gerechtshof \'s-Gravenhage', 'Den Haag')
                      , ('Rechtbank Middelburg', 'Gerechtshof \'s-Gravenhage', 'Middelburg')
                      , ('Rechtbank Rotterdam', 'Gerechtshof \'s-Gravenhage', 'Rotterdam')
                      , ('Rechtbank Breda', 'Gerechtshof \'s-Hertogenbosch', 'Breda')
                      , ('Rechtbank \'s-Hertogenbosch', 'Gerechtshof \'s-Hertogenbosch', 'Den Bosch')
                      , ('Rechtbank Maastricht', 'Gerechtshof \'s-Hertogenbosch', 'Maastricht')
                      , ('Rechtbank Roermond', 'Gerechtshof \'s-Hertogenbosch', 'Roermond')
                      , ('Rechtbank Assen', 'Gerechtshof Leeuwarden', 'Assen')
                      , ('Rechtbank Groningen', 'Gerechtshof Leeuwarden', 'Groningen')
                      , ('Rechtbank Leeuwarden', 'Gerechtshof Leeuwarden', 'Leeuwarden')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug kamer                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * gerecht  [UNI,TOT]                   *
    * sector  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `kamer`
                     ( `i` VARCHAR(255) NOT NULL
                     , `gerecht` VARCHAR(255) NOT NULL
                     , `sector` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `kamer` (`i` ,`gerecht` ,`sector` )
                VALUES ('Vierde enkelvoudige kamer van de Rechtbank Amsterdam, sector Kanton', 'Rechtbank Amsterdam', 'Kanton')
                      , ('Enkelvoudige kamer van de Rechtbank Roermond, sector Kanton', 'Rechtbank Roermond', 'Kanton')
                      , ('Enkelvoudige kamer van de sector Bestuursrecht Algemeen van de Rechtbank Amsterdam', 'Rechtbank Amsterdam', 'Bestuursrecht')
                      , ('Kamer 2 afdeling bestuursrechtspraak van de Raad van State', 'Raad van State', 'Bestuursrecht')
                      , ('Meervoudige kamer voor de behandeling van wrakingszaken van de Rechtbank Utrecht', 'Rechtbank Utrecht', 'Bestuursrecht')
                      , ('Enkelvoudige kamer voor de behandeling van bestuursrechtelijke zaken van de Rechtbank Utrecht', 'Rechtbank Utrecht', 'Bestuursrecht')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug actie                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * subject  [UNI,TOT]                   *
    * type  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `actie`
                     ( `i` VARCHAR(255) NOT NULL
                     , `subject` VARCHAR(255) NOT NULL
                     , `type` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug machtiging                      *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * door  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `machtiging`
                     ( `i` VARCHAR(255) NOT NULL
                     , `door` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `machtiging` (`i` ,`door` )
                VALUES ('brief 2000/864821a', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('brief 2000/860338e', 'de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen')
                      , ('brief 2007/33-9887', 'Jan met de Vilten Hoed')
                      , ('brief 2007/33-9854', 'de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam')
                      , ('brief 2007/33-9910', 'het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug cluster                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * naam  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `cluster`
                     ( `i` VARCHAR(255) NOT NULL
                     , `naam` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug plaats                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * neven  [UNI]                         *
    \**************************************/
    mysql_query("CREATE TABLE `plaats`
                     ( `i` VARCHAR(255) NOT NULL
                     , `neven` VARCHAR(255)
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `plaats` (`i` ,`neven` )
                VALUES ('Den Helder', 'Rechtbank Alkmaar')
                      , ('Hoorn', 'Rechtbank Alkmaar')
                      , ('Hilversum', 'Rechtbank Amsterdam')
                      , ('Zaanstad', 'Rechtbank Haarlem')
                      , ('Amersfoort', 'Rechtbank Utrecht')
                      , ('Enschede', 'Rechtbank Almelo')
                      , ('Nijmegen', 'Rechtbank Arnhem')
                      , ('Tiel', 'Rechtbank Arnhem')
                      , ('Wageningen', 'Rechtbank Arnhem')
                      , ('Apeldoorn', 'Rechtbank Zutphen')
                      , ('Groenlo', 'Rechtbank Zutphen')
                      , ('Harderwijk', 'Rechtbank Zutphen')
                      , ('Terborg', 'Rechtbank Zutphen')
                      , ('Deventer', 'Rechtbank Zwolle-Lelystad')
                      , ('Lelystad', 'Rechtbank Zwolle-Lelystad')
                      , ('Gorinchem', 'Rechtbank Dordrecht')
                      , ('Oud-Beijerland', 'Rechtbank Dordrecht')
                      , ('Alphen aan de Rijn', 'Rechtbank \'s-Gravenhage')
                      , ('Delft', 'Rechtbank \'s-Gravenhage')
                      , ('Gouda', 'Rechtbank \'s-Gravenhage')
                      , ('Leiden', 'Rechtbank \'s-Gravenhage')
                      , ('Schouwen-Duiveland', 'Rechtbank Middelburg')
                      , ('Terneuzen', 'Rechtbank Middelburg')
                      , ('Brielle', 'Rechtbank Rotterdam')
                      , ('Middelharnis', 'Rechtbank Rotterdam')
                      , ('Schiedam', 'Rechtbank Rotterdam')
                      , ('Bergen op Zoom', 'Rechtbank Breda')
                      , ('Tilburg', 'Rechtbank Breda')
                      , ('Boxmeer', 'Rechtbank \'s-Hertogenbosch')
                      , ('Eindhoven', 'Rechtbank \'s-Hertogenbosch')
                      , ('Helmond', 'Rechtbank \'s-Hertogenbosch')
                      , ('Heerlen', 'Rechtbank Maastricht')
                      , ('Sittard-Geleen', 'Rechtbank Maastricht')
                      , ('Venlo', 'Rechtbank Roermond')
                      , ('Emmen', 'Rechtbank Assen')
                      , ('Meppel', 'Rechtbank Assen')
                      , ('Winschoten', 'Rechtbank Groningen')
                      , ('Heerenveen', 'Rechtbank Leeuwarden')
                      , ('Sneek', 'Rechtbank Leeuwarden')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug digid                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * digid  [UNI,TOT]                     *
    \**************************************/
    mysql_query("CREATE TABLE `digid`
                     ( `i` VARCHAR(255) NOT NULL
                     , `digid` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `digid` (`i` ,`digid` )
                VALUES ('DigID1', 'mr. M.R.A. Dekker')
                      , ('DigID2', 'drs. D. de Rooij')
                      , ('DigID3', 'mr. S.M. Klein')
                      , ('DigID4', 'mr. G.L.M. Teeuwen')
                      , ('DigID5', 'mr. J.H.A. van der Grinten')
                      , ('DigID6', 'mr. M.L.M. Lohman')
                      , ('DigID3456', 'Mevr. El Amrani')
                      , ('DigID7', 'Dhr. Klaas Vreugdenhil')
                      , ('DigID8', 'Mw. Annemarie Stegeman')
                      , ('DigID9', 'mr. F. H. Goossens')
                      , ('DigID60', 'Emilio Garcia')
                      , ('DigID51', 'Frits Ticherus')
                      , ('DigID42', 'mr. K.L.M. Lenaerts')
                      , ('DigID33', 'mw.mr. Chr.Ph. Tetrode')
                      , ('DigID24', 'mr. P. van der Vossen')
                      , ('DigID15', 'mr. M.M. Mijwaard')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug documenttype                    *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `documenttype`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `documenttype` (`i` )
                VALUES ('Vonnis')
                      , ('Bewijsmiddel')
                      , ('Machtiging')
                      , ('Correspondentie')
                      , ('Beroepschrift')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug orgaan                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `orgaan`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `orgaan` (`i` )
                VALUES ('Raad van State')
                      , ('Rechtbank Amsterdam')
                      , ('Rechtbank Utrecht')
                      , ('bestuursorgaan')
                      , ('burger')
                      , ('bestuursrechter')
                      , ('')
                      , ('griffier')
                      , ('bestuur van gerecht')
                      , ('griffie')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug persoon                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `persoon`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `persoon` (`i` )
                VALUES ('de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('Jan met de Vilten Hoed')
                      , ('Mevr. El Amrani')
                      , ('de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen')
                      , ('het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam')
                      , ('Gemeente Utrecht')
                      , ('de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam')
                      , ('Dhr. Klaas Vreugdenhil')
                      , ('mr. M.R.A. Dekker')
                      , ('drs. D. de Rooij')
                      , ('mr. S.M. Klein')
                      , ('mr. G.L.M. Teeuwen')
                      , ('mr. J.H.A. van der Grinten')
                      , ('mr. M.L.M. Lohman')
                      , ('mr. T.M.A. van L�ben Sels')
                      , ('mr. G.M.P. Brouns')
                      , ('mr. N.M. van Waterschoot')
                      , ('mr. J.H.B. van der Meer')
                      , ('mr. Ph.Q. van Otterloo-Pannerden')
                      , ('mr. H.P. Kijlstra')
                      , ('M. Vaandrager')
                      , ('mr. J. Sap')
                      , ('mr. M. ter Brugge')
                      , ('mr. L.E. Verschoor-Bergsma')
                      , ('mr. J. Ebbens')
                      , ('Mw. Annemarie Stegeman')
                      , ('mr. F. H. Goossens')
                      , ('Emilio Garcia')
                      , ('Frits Ticherus')
                      , ('mr. K.L.M. Lenaerts')
                      , ('mw.mr. Chr.Ph. Tetrode')
                      , ('mr. P. van der Vossen')
                      , ('mr. M.M. Mijwaard')
                      , ('mr. V.M. Behrens')
                      , ('mr. J.J. Schuurman')
                      , ('mr. K.F. van Dam')
                      , ('mr. Ch. Dequaistenit')
                      , ('Raad van State')
                      , ('AWB 07/2481 WRO')
                      , ('Rechtbank Utrecht')
                      , ('???')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug rechtsgebied                    *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `rechtsgebied`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `rechtsgebied` (`i` )
                VALUES ('Bestuursrecht')
                      , ('Bestuursrecht Algemeen')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug proceduresoort                  *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `proceduresoort`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `proceduresoort` (`i` )
                VALUES ('Hoger Beroep')
                      , ('Beroep')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug tekst                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `tekst`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `tekst` (`i` )
                VALUES ('doc987384')
                      , ('2000/864821a')
                      , ('2000/860338e')
                      , ('doc763820')
                      , ('Vreugdenhil')
                      , ('2009/87743a')
                      , ('B. en W.-besluit van 27 februari 2009, Gemeenteblad van Utrecht 2009 Nr. 8')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug datum                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `datum`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `datum` (`i` )
                VALUES ('23 januari 2009')
                      , ('15 september 2000')
                      , ('16 november 2000')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug sector                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `sector`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `sector` (`i` )
                VALUES ('Kanton')
                      , ('Bestuursrecht')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug gerechtshof                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `gerechtshof`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `gerechtshof` (`i` )
                VALUES ('Gerechtshof Amsterdam')
                      , ('Gerechtshof Arnhem')
                      , ('Gerechtshof \'s-Gravenhage')
                      , ('Gerechtshof \'s-Hertogenbosch')
                      , ('Gerechtshof Leeuwarden')
                      , ('Raad van State')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug artikel                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `artikel`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `artikel` (`i` )
                VALUES ('Artikel 1:3 lid 3 Awb')
                      , ('Artikel 4:1 Awb')
                      , ('Artikel 1:5 lid 1 Awb')
                      , ('Artikel 1:5 lid 2 Awb')
                      , ('Artikel 1:5 lid 3 Awb')
                      , ('Artikel 6:6 Awb')
                      , ('Artikel 6:6 Awb; 8:70 lid b Awb')
                      , ('Artikel 8:55 lid 5 sub a Awb')
                      , ('Artikel 8:70 sub a Awb')
                      , ('Artikel 8:70 sub c Awb')
                      , ('Artikel 8:70 sub d Awb')
                      , ('Artikel 8:82 lid 3 Awb')
                      , ('Artikel 8:84 lid 2 sub a Awb')
                      , ('Artikel 8:84 lid 2 sub b Awb')
                      , ('Artikel 8:84 lid 2 sub c Awb')
                      , ('Artikel 8:84 lid 2 sub d Awb')
                      , ('Artikel 8:87 lid 3 Awb')
                      , ('Artikel 48 lid 1 RO')
                      , ('Artikel 6 lid 1 RO')
                      , ('Artikel 7:1a lid 6 Awb')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug handeling                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `handeling`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug objecttype                      *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `objecttype`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug werkwoord                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `werkwoord`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug ding                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `ding`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug rol                             *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `rol`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `rol` (`i` )
                VALUES ('Rechter')
                      , ('Griffier')
                      , ('Archivaris')
                      , ('Eiser')
                      , ('Gedaagde')
                      , ('Gevoegde')
                      , ('Niemand')
                      , ('Gemachtigde')
                      , ('Indiener')
                      , ('Verweerder')
                      , ('Gemeenteambtenaar')
                      , ('Advocaat')
                      , ('Belanghebbende')
                      , ('Hoofd Administratie')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug moscow                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `moscow`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug fase                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `fase`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug gpstap                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `gpstap`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug component                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `component`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug formcodes                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `formcodes`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug referentie                      *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `referentie`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug tijdstip                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `tijdstip`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `tijdstip` (`i` )
                VALUES ('10-10-2000')
                      , ('2-3-2000')
                      , ('5-3-2000')
                      , ('???')
                      , ('10 april 2009')
                      , ('16 april 2009')
                      , ('27 februari 2009')
                      , ('14 april 2009')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug buservice                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `buservice`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `buservice` (`i` )
                VALUES ('getZaak')
                      , ('newZaak')
                      , ('delZaak')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************************\
    * Plug zaaksdossier                 *
    *                                   *
    * fields:                           *
    * I/\zaaksdossier;zaaksdossier~  [] *
    * zaaksdossier  []                  *
    \***********************************/
    mysql_query("CREATE TABLE `zaaksdossier`
                     ( `document` VARCHAR(255) NOT NULL
                     , `procedur` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `zaaksdossier` (`document` ,`procedur` )
                VALUES ('doc987384', '199902238')
                      , ('doc763820', 'AWB 07/2481 WRO')
                      , ('brief 2009/87743', 'SBR 02/74331')
                      , ('brief 2009/87743a', 'SBR 02/74331')
                      , ('bijlage 2009/87743.1', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug eiser                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * eiser~  [TOT]                        *
    \**************************************/
    mysql_query("CREATE TABLE `eiser`
                     ( `procedur` VARCHAR(255) NOT NULL
                     , `persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `eiser` (`procedur` ,`persoon` )
                VALUES ('199902238', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('AWB 07/2481 WRO', 'Jan met de Vilten Hoed')
                      , ('SBR 02/74331', 'Mevr. El Amrani')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug gedaagde             *
    *                           *
    * fields:                   *
    * I/\gedaagde;gedaagde~  [] *
    * gedaagde  []              *
    \***************************/
    mysql_query("CREATE TABLE `gedaagde`
                     ( `persoon` VARCHAR(255) NOT NULL
                     , `procedur` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `gedaagde` (`persoon` ,`procedur` )
                VALUES ('de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen', '199902238')
                      , ('het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam', 'AWB 07/2481 WRO')
                      , ('Gemeente Utrecht', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug gevoegde             *
    *                           *
    * fields:                   *
    * I/\gevoegde;gevoegde~  [] *
    * gevoegde  []              *
    \***************************/
    mysql_query("CREATE TABLE `gevoegde`
                     ( `persoon` VARCHAR(255) NOT NULL
                     , `procedur` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `gevoegde` (`persoon` ,`procedur` )
                VALUES ('de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam', 'AWB 07/2481 WRO')
                      , ('Dhr. Klaas Vreugdenhil', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug gemachtigde                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * gemachtigde~  [TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `gemachtigde`
                     ( `machtiging` VARCHAR(255) NOT NULL
                     , `persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `gemachtigde` (`machtiging` ,`persoon` )
                VALUES ('brief 2000/864821a', 'mr. M.R.A. Dekker')
                      , ('brief 2000/864821a', 'drs. D. de Rooij')
                      , ('brief 2000/860338e', 'mr. S.M. Klein')
                      , ('brief 2007/33-9887', 'mr. G.L.M. Teeuwen')
                      , ('brief 2007/33-9854', 'mr. J.H.A. van der Grinten')
                      , ('brief 2007/33-9910', 'mr. M.L.M. Lohman')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug inzake           *
    *                       *
    * fields:               *
    * I/\inzake;inzake~  [] *
    * inzake  []            *
    \***********************/
    mysql_query("CREATE TABLE `inzake`
                     ( `machtiging` VARCHAR(255) NOT NULL
                     , `procedur` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `inzake` (`machtiging` ,`procedur` )
                VALUES ('brief 2000/864821a', '199902238')
                      , ('brief 2000/860338e', '199902238')
                      , ('brief 2007/33-9887', 'AWB 07/2481 WRO')
                      , ('brief 2007/33-9854', 'AWB 07/2481 WRO')
                      , ('brief 2007/33-9910', 'AWB 07/2481 WRO')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug machtigingdocument       *
    *                               *
    * fields:                       *
    * I/\machtiging;machtiging~  [] *
    * machtiging  []                *
    \*******************************/
    mysql_query("CREATE TABLE `machtigingdocument`
                     ( `document` VARCHAR(255) NOT NULL
                     , `machtiging` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug clusterprocedur    *
    *                         *
    * fields:                 *
    * I/\cluster;cluster~  [] *
    * cluster  []             *
    \*************************/
    mysql_query("CREATE TABLE `clusterprocedur`
                     ( `procedur` VARCHAR(255) NOT NULL
                     , `cluster` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug grond                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * grond  [TOT]                         *
    \**************************************/
    mysql_query("CREATE TABLE `grond`
                     ( `cluster` VARCHAR(255) NOT NULL
                     , `tekst` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug rechter                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * rechter  [TOT]                       *
    \**************************************/
    mysql_query("CREATE TABLE `rechter`
                     ( `zitting` VARCHAR(255) NOT NULL
                     , `persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `rechter` (`zitting` ,`persoon` )
                VALUES ('Zitting RbAms 1094', 'mr. N.M. van Waterschoot')
                      , ('Zitting RvS 83', 'mr. J.H.B. van der Meer')
                      , ('Zitting RvS 84', 'mr. Ph.Q. van Otterloo-Pannerden')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug griffier             *
    *                           *
    * fields:                   *
    * I/\griffier;griffier~  [] *
    * griffier  []              *
    \***************************/
    mysql_query("CREATE TABLE `griffier`
                     ( `gerecht` VARCHAR(255) NOT NULL
                     , `persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `griffier` (`gerecht` ,`persoon` )
                VALUES ('Rechtbank Amsterdam', 'mr. V.M. Behrens')
                      , ('Raad van State', 'mr. J.J. Schuurman')
                      , ('Rechtbank Utrecht', 'mr. K.F. van Dam')
                      , ('Rechtbank Utrecht', 'mr. Ch. Dequaistenit')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug bevoegd            *
    *                         *
    * fields:                 *
    * I/\bevoegd;bevoegd~  [] *
    * bevoegd  []             *
    \*************************/
    mysql_query("CREATE TABLE `bevoegd`
                     ( `procedur` VARCHAR(255) NOT NULL
                     , `gerecht` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `bevoegd` (`procedur` ,`gerecht` )
                VALUES ('199902238', 'Raad van State')
                      , ('AWB 07/2481 WRO', 'Rechtbank Amsterdam')
                      , ('SBR 02/74331', 'Rechtbank Utrecht')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug bezetting              *
    *                             *
    * fields:                     *
    * I/\bezetting;bezetting~  [] *
    * bezetting  []               *
    \*****************************/
    mysql_query("CREATE TABLE `bezetting`
                     ( `persoon` VARCHAR(255) NOT NULL
                     , `kamer` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `bezetting` (`persoon` ,`kamer` )
                VALUES ('mr. T.M.A. van L�ben Sels', 'Vierde enkelvoudige kamer van de Rechtbank Amsterdam, sector Kanton')
                      , ('mr. G.M.P. Brouns', 'Enkelvoudige kamer van de Rechtbank Roermond, sector Kanton')
                      , ('mr. N.M. van Waterschoot', 'Enkelvoudige kamer van de sector Bestuursrecht Algemeen van de Rechtbank Amsterdam')
                      , ('mr. J.H.B. van der Meer', 'Kamer 2 afdeling bestuursrechtspraak van de Raad van State')
                      , ('mr. Ph.Q. van Otterloo-Pannerden', 'Kamer 2 afdeling bestuursrechtspraak van de Raad van State')
                      , ('mr. H.P. Kijlstra', 'Enkelvoudige kamer van de sector Bestuursrecht Algemeen van de Rechtbank Amsterdam')
                      , ('M. Vaandrager', 'Kamer 2 afdeling bestuursrechtspraak van de Raad van State')
                      , ('mr. J. Sap', 'Meervoudige kamer voor de behandeling van wrakingszaken van de Rechtbank Utrecht')
                      , ('mr. M. ter Brugge', 'Meervoudige kamer voor de behandeling van wrakingszaken van de Rechtbank Utrecht')
                      , ('mr. L.E. Verschoor-Bergsma', 'Meervoudige kamer voor de behandeling van wrakingszaken van de Rechtbank Utrecht')
                      , ('mr. J. Ebbens', 'Enkelvoudige kamer voor de behandeling van bestuursrechtelijke zaken van de Rechtbank Utrecht')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug wetstekst              *
    *                             *
    * fields:                     *
    * I/\wetstekst;wetstekst~  [] *
    * wetstekst  []               *
    \*****************************/
    mysql_query("CREATE TABLE `wetstekst`
                     ( `artikel` VARCHAR(255) NOT NULL
                     , `tekst` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug handelingartikel       *
    *                             *
    * fields:                     *
    * I/\handeling;handeling~  [] *
    * handeling  []               *
    \*****************************/
    mysql_query("CREATE TABLE `handelingartikel`
                     ( `artikel` VARCHAR(255) NOT NULL
                     , `handeling` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug orgaanartikel    *
    *                       *
    * fields:               *
    * I/\orgaan;orgaan~  [] *
    * orgaan  []            *
    \***********************/
    mysql_query("CREATE TABLE `orgaanartikel`
                     ( `artikel` VARCHAR(255) NOT NULL
                     , `orgaan` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `orgaanartikel` (`artikel` ,`orgaan` )
                VALUES ('Artikel 1:3 lid 3 Awb', 'bestuursorgaan')
                      , ('Artikel 4:1 Awb', 'bestuursorgaan')
                      , ('Artikel 1:5 lid 1 Awb', 'burger')
                      , ('Artikel 1:5 lid 2 Awb', 'burger')
                      , ('Artikel 1:5 lid 3 Awb', 'burger')
                      , ('Artikel 6:6 Awb', 'bestuursorgaan')
                      , ('Artikel 6:6 Awb; 8:70 lid b Awb', 'bestuursrechter')
                      , ('Artikel 6:6 Awb', 'bestuursorgaan')
                      , ('Artikel 6:6 Awb; 8:70 lid b Awb', 'bestuursrechter')
                      , ('Artikel 8:55 lid 5 sub a Awb', 'bestuursrechter')
                      , ('Artikel 8:70 sub a Awb', '')
                      , ('Artikel 8:70 sub c Awb', '')
                      , ('Artikel 8:70 sub d Awb', '')
                      , ('Artikel 8:82 lid 3 Awb', 'griffier')
                      , ('Artikel 8:84 lid 2 sub a Awb', '')
                      , ('Artikel 8:84 lid 2 sub b Awb', '')
                      , ('Artikel 8:84 lid 2 sub c Awb', '')
                      , ('Artikel 8:84 lid 2 sub d Awb', '')
                      , ('Artikel 8:87 lid 3 Awb', 'griffier')
                      , ('Artikel 48 lid 1 RO', 'bestuur van gerecht')
                      , ('Artikel 6 lid 1 RO', 'bestuur van gerecht')
                      , ('Artikel 7:1a lid 6 Awb', 'griffie')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug object           *
    *                       *
    * fields:               *
    * I/\object;object~  [] *
    * object  []            *
    \***********************/
    mysql_query("CREATE TABLE `object`
                     ( `handeling` VARCHAR(255) NOT NULL
                     , `objecttype` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug objectusecase    *
    *                       *
    * fields:               *
    * I/\object;object~  [] *
    * object  []            *
    \***********************/
    mysql_query("CREATE TABLE `objectusecase`
                     ( `usecase` VARCHAR(255) NOT NULL
                     , `objecttype` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug werkwoordartikel       *
    *                             *
    * fields:                     *
    * I/\werkwoord;werkwoord~  [] *
    * werkwoord  []               *
    \*****************************/
    mysql_query("CREATE TABLE `werkwoordartikel`
                     ( `artikel` VARCHAR(255) NOT NULL
                     , `werkwoord` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug objecttypeartikel        *
    *                               *
    * fields:                       *
    * I/\objecttype;objecttype~  [] *
    * objecttype  []                *
    \*******************************/
    mysql_query("CREATE TABLE `objecttypeartikel`
                     ( `artikel` VARCHAR(255) NOT NULL
                     , `objecttype` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug werkwoordusecase       *
    *                             *
    * fields:                     *
    * I/\werkwoord;werkwoord~  [] *
    * werkwoord  []               *
    \*****************************/
    mysql_query("CREATE TABLE `werkwoordusecase`
                     ( `usecase` VARCHAR(255) NOT NULL
                     , `werkwoord` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug werkwoordhandeling     *
    *                             *
    * fields:                     *
    * I/\werkwoord;werkwoord~  [] *
    * werkwoord  []               *
    \*****************************/
    mysql_query("CREATE TABLE `werkwoordhandeling`
                     ( `handeling` VARCHAR(255) NOT NULL
                     , `werkwoord` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug objectactie      *
    *                       *
    * fields:               *
    * I/\object;object~  [] *
    * object  []            *
    \***********************/
    mysql_query("CREATE TABLE `objectactie`
                     ( `actie` VARCHAR(255) NOT NULL
                     , `ding` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug als        *
    *                 *
    * fields:         *
    * I/\als;als~  [] *
    * als  []         *
    \*****************/
    mysql_query("CREATE TABLE `als`
                     ( `actie` VARCHAR(255) NOT NULL
                     , `orgaan` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug type         *
    *                   *
    * fields:           *
    * I/\type;type~  [] *
    * type  []          *
    \*******************/
    mysql_query("CREATE TABLE `type`
                     ( `ding` VARCHAR(255) NOT NULL
                     , `objecttype` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug vervult            *
    *                         *
    * fields:                 *
    * I/\vervult;vervult~  [] *
    * vervult  []             *
    \*************************/
    mysql_query("CREATE TABLE `vervult`
                     ( `persoon` VARCHAR(255) NOT NULL
                     , `rol` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug sub        *
    *                 *
    * fields:         *
    * I/\sub;sub~  [] *
    * sub  [ASY]      *
    \*****************/
    mysql_query("CREATE TABLE `sub`
                     ( `usecase` VARCHAR(255) NOT NULL
                     , `usecase1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug use_case             *
    *                           *
    * fields:                   *
    * I/\use_case;use_case~  [] *
    * use_case  []              *
    \***************************/
    mysql_query("CREATE TABLE `use_case`
                     ( `usecase` VARCHAR(255) NOT NULL
                     , `handeling` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug mag        *
    *                 *
    * fields:         *
    * I/\mag;mag~  [] *
    * mag  []         *
    \*****************/
    mysql_query("CREATE TABLE `mag`
                     ( `handeling` VARCHAR(255) NOT NULL
                     , `rol` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug faseusecase  *
    *                   *
    * fields:           *
    * I/\fase;fase~  [] *
    * fase  []          *
    \*******************/
    mysql_query("CREATE TABLE `faseusecase`
                     ( `usecase` VARCHAR(255) NOT NULL
                     , `fase` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug servicerol               *
    *                               *
    * fields:                       *
    * I/\serviceRol;serviceRol~  [] *
    * serviceRol  []                *
    \*******************************/
    mysql_query("CREATE TABLE `servicerol`
                     ( `buservice` VARCHAR(255) NOT NULL
                     , `rol` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `servicerol` (`buservice` ,`rol` )
                VALUES ('getZaak', 'Rechter')
                      , ('getZaak', 'Griffier')
                      , ('newZaak', 'Griffier')
                      , ('delZaak', 'Archivaris')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug aut        *
    *                 *
    * fields:         *
    * I/\aut;aut~  [] *
    * aut  []         *
    \*****************/
    mysql_query("CREATE TABLE `aut`
                     ( `persoon` VARCHAR(255) NOT NULL
                     , `rol` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `aut` (`persoon` ,`rol` )
                VALUES ('de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst', 'Eiser')
                      , ('de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen', 'Gedaagde')
                      , ('het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam', 'Gedaagde')
                      , ('de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam', 'Gevoegde')
                      , ('Jan met de Vilten Hoed', 'Niemand')
                      , ('mr. M.R.A. Dekker', 'Gemachtigde')
                      , ('drs. D. de Rooij', 'Gemachtigde')
                      , ('mr. S.M. Klein', 'Gemachtigde')
                      , ('mr. G.L.M. Teeuwen', 'Gemachtigde')
                      , ('mr. J.H.A. van der Grinten', 'Gemachtigde')
                      , ('mr. M.L.M. Lohman', 'Gemachtigde')
                      , ('Mevr. El Amrani', 'Indiener')
                      , ('Dhr. Klaas Vreugdenhil', 'Verweerder')
                      , ('Mw. Annemarie Stegeman', 'Gemeenteambtenaar')
                      , ('mr. F. H. Goossens', 'Advocaat')
                      , ('Emilio Garcia', 'Belanghebbende')
                      , ('Frits Ticherus', 'Hoofd Administratie')
                      , ('mr. K.L.M. Lenaerts', 'Rechter')
                      , ('mw.mr. Chr.Ph. Tetrode', 'Griffier')
                      , ('mr. P. van der Vossen', 'Rechter')
                      , ('mr. M.M. Mijwaard', 'Griffier')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug aan                             *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * aan  [TOT]                           *
    \**************************************/
    mysql_query("CREATE TABLE `aan`
                     ( `document` VARCHAR(255) NOT NULL
                     , `persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `aan` (`document` ,`persoon` )
                VALUES ('doc987384', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('doc987384', 'de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen')
                      , ('doc987384', 'mr. M.R.A. Dekker')
                      , ('doc987384', 'drs. D. de Rooij')
                      , ('doc987384', 'mr. S.M. Klein')
                      , ('brief 2000/864821a', 'Raad van State')
                      , ('brief 2000/860338e', 'Raad van State')
                      , ('doc763820', '???')
                      , ('brief 2009/87743', 'Rechtbank Utrecht')
                      , ('brief 2009/87743a', 'Mevr. El Amrani')
                      , ('bijlage 2009/87743.1', 'Dhr. Klaas Vreugdenhil')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug uwkenmerk              *
    *                             *
    * fields:                     *
    * I/\uwKenmerk;uwKenmerk~  [] *
    * uwKenmerk  []               *
    \*****************************/
    mysql_query("CREATE TABLE `uwkenmerk`
                     ( `document` VARCHAR(255) NOT NULL
                     , `tekst` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
