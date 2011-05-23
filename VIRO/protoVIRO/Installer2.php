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
  if($DB_slct = @mysql_select_db('VIRO453ENG')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `VIRO453ENG` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('VIRO453ENG');
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
    //// Number of plugs: 58
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `session`")){
        mysql_query("DROP TABLE `session`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `document`")){
        mysql_query("DROP TABLE `document`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `case`")){
        mysql_query("DROP TABLE `case`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `process`")){
        mysql_query("DROP TABLE `process`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `court`")){
        mysql_query("DROP TABLE `court`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `panel`")){
        mysql_query("DROP TABLE `panel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `action`")){
        mysql_query("DROP TABLE `action`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authorization`")){
        mysql_query("DROP TABLE `authorization`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `cluster`")){
        mysql_query("DROP TABLE `cluster`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `city`")){
        mysql_query("DROP TABLE `city`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `usecase`")){
        mysql_query("DROP TABLE `usecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `documenttype`")){
        mysql_query("DROP TABLE `documenttype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `organ`")){
        mysql_query("DROP TABLE `organ`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `party`")){
        mysql_query("DROP TABLE `party`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `areaoflaw`")){
        mysql_query("DROP TABLE `areaoflaw`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `casetype`")){
        mysql_query("DROP TABLE `casetype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `text`")){
        mysql_query("DROP TABLE `text`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `date`")){
        mysql_query("DROP TABLE `date`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `sector`")){
        mysql_query("DROP TABLE `sector`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `courtofappeal`")){
        mysql_query("DROP TABLE `courtofappeal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `article`")){
        mysql_query("DROP TABLE `article`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `act`")){
        mysql_query("DROP TABLE `act`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objecttype`")){
        mysql_query("DROP TABLE `objecttype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `verb`")){
        mysql_query("DROP TABLE `verb`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `object`")){
        mysql_query("DROP TABLE `object`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `role`")){
        mysql_query("DROP TABLE `role`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `moscow`")){
        mysql_query("DROP TABLE `moscow`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `timestamp`")){
        mysql_query("DROP TABLE `timestamp`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `casefile`")){
        mysql_query("DROP TABLE `casefile`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `plaintiff`")){
        mysql_query("DROP TABLE `plaintiff`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `defendant`")){
        mysql_query("DROP TABLE `defendant`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `joinedinterestedparty`")){
        mysql_query("DROP TABLE `joinedinterestedparty`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authorizedrepresentative`")){
        mysql_query("DROP TABLE `authorizedrepresentative`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `for`")){
        mysql_query("DROP TABLE `for`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authorizationdocument`")){
        mysql_query("DROP TABLE `authorizationdocument`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `clustercase`")){
        mysql_query("DROP TABLE `clustercase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `base`")){
        mysql_query("DROP TABLE `base`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `judge`")){
        mysql_query("DROP TABLE `judge`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `clerk`")){
        mysql_query("DROP TABLE `clerk`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authorized`")){
        mysql_query("DROP TABLE `authorized`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `members`")){
        mysql_query("DROP TABLE `members`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `lawtext`")){
        mysql_query("DROP TABLE `lawtext`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `actarticle`")){
        mysql_query("DROP TABLE `actarticle`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `organarticle`")){
        mysql_query("DROP TABLE `organarticle`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objectact`")){
        mysql_query("DROP TABLE `objectact`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objectusecase`")){
        mysql_query("DROP TABLE `objectusecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `verbarticle`")){
        mysql_query("DROP TABLE `verbarticle`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objecttypearticle`")){
        mysql_query("DROP TABLE `objecttypearticle`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `verbusecase`")){
        mysql_query("DROP TABLE `verbusecase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `verbact`")){
        mysql_query("DROP TABLE `verbact`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objectaction`")){
        mysql_query("DROP TABLE `objectaction`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `as`")){
        mysql_query("DROP TABLE `as`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objecttypeobject`")){
        mysql_query("DROP TABLE `objecttypeobject`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `actsas`")){
        mysql_query("DROP TABLE `actsas`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `use_case`")){
        mysql_query("DROP TABLE `use_case`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `may`")){
        mysql_query("DROP TABLE `may`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `to`")){
        mysql_query("DROP TABLE `to`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `yourproperty`")){
        mysql_query("DROP TABLE `yourproperty`");
      }
    }
    /**************************************\
    * Plug session                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * clerk  [TOT,UNI]                     *
    * scheduled  [UNI,TOT]                 *
    * occured  [UNI]                       *
    * city  [UNI,TOT]                      *
    * location  [UNI,TOT]                  *
    * panel  [UNI,TOT]                     *
    \**************************************/
    mysql_query("CREATE TABLE `session`
                     ( `i` VARCHAR(255) NOT NULL
                     , `clerk` VARCHAR(255) NOT NULL
                     , `scheduled` VARCHAR(255) NOT NULL
                     , `occured` VARCHAR(255)
                     , `city` VARCHAR(255) NOT NULL
                     , `location` VARCHAR(255) NOT NULL
                     , `panel` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `session` (`i` ,`clerk` ,`scheduled` ,`occured` ,`city` ,`location` ,`panel` )
                VALUES ('Session RbAms 1094', 'mr. V.M. Behrens', '23 januari 2009', NULL, 'Amsterdam', 'Amsterdam district court', 'Amsterdam district court single-judge panel for cases of administrative law')
                      , ('Session RvS 83', 'mr. J.J. Schuurman', '15 september 2000', NULL, 'Den Haag', 'Council of State', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('Session RvS 84', 'mr. J.J. Schuurman', '16 november 2000', NULL, 'Den Haag', 'Council of State', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('SBR 2009/05/02', 'mr. Ch. Dequaistenit', '2 mei 2009', NULL, 'Utrecht', 'Utrecht district court', 'Utrecht district court single-judge panel for cases of administrative law')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug document                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * documentType  [UNI,TOT]              *
    * from  [UNI,TOT]                      *
    * sent  [UNI,TOT]                      *
    * received  [UNI]                      *
    * propertyOf  [UNI,TOT]                *
    \**************************************/
    mysql_query("CREATE TABLE `document`
                     ( `i` VARCHAR(255) NOT NULL
                     , `documenttype` VARCHAR(255) NOT NULL
                     , `from` VARCHAR(255) NOT NULL
                     , `sent` VARCHAR(255) NOT NULL
                     , `received` VARCHAR(255)
                     , `propertyof` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `document` (`i` ,`documenttype` ,`from` ,`sent` ,`received` ,`propertyof` )
                VALUES ('doc987384', 'Verdict', 'Council of State', '10-10-2000', NULL, 'doc987384')
                      , ('doc763820', 'Evidence', 'AWB 07/2481 WRO', '???', NULL, 'doc763820')
                      , ('letter 2009/87743', 'Correspondence', 'Mevr. El Amrani', '10 april 2009', '14 april 2009', 'Vreugdenhil')
                      , ('letter 2009/87743a', 'Appeal', 'Utrecht district court', '16 april 2009', NULL, '2009/87743a')
                      , ('schedule 2009/87743.1', 'Evidence', 'Gemeente Utrecht', '27 februari 2009', '14 april 2009', 'B. en W.-besluit van 27 februari 2009, Gemeenteblad van Utrecht 2009 Nr. 8')
                      , ('letter 2000/864821a', 'Authorization', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst', '2-3-2000', NULL, '2000/864821a')
                      , ('letter 2000/860338e', 'Authorization', 'de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen', '5-3-2000', NULL, '2000/860338e')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug case                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * caretaker  [UNI,TOT]                 *
    * areaOfLaw  [UNI,TOT]                 *
    * caseType  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `case`
                     ( `i` VARCHAR(255) NOT NULL
                     , `caretaker` VARCHAR(255) NOT NULL
                     , `areaoflaw` VARCHAR(255) NOT NULL
                     , `casetype` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `case` (`i` ,`caretaker` ,`areaoflaw` ,`casetype` )
                VALUES ('199902238', 'Council of State', 'Administrative law', 'Appeal to a higher court')
                      , ('AWB 07/2481 WRO', 'Amsterdam district court', 'Administrative law', 'Appeal')
                      , ('SBR 02/74331', 'Utrecht district court', 'Administrative law', 'Appeal')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug process                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * session  [UNI,TOT]                   *
    * case  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `process`
                     ( `i` VARCHAR(255) NOT NULL
                     , `session` VARCHAR(255) NOT NULL
                     , `case` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `process` (`i` ,`session` ,`case` )
                VALUES ('199902238/1', 'Session RvS 83', '199902238')
                      , ('199902238/2', 'Session RvS 84', '199902238')
                      , ('AWB 07/2481 WRO/1', 'Session RbAms 1094', 'AWB 07/2481 WRO')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug court                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * district  [UNI,TOT]                  *
    * mainCity  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `court`
                     ( `i` VARCHAR(255) NOT NULL
                     , `district` VARCHAR(255) NOT NULL
                     , `maincity` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `court` (`i` ,`district` ,`maincity` )
                VALUES ('Amsterdam district court', 'Amsterdam court of appeal', 'Amsterdam')
                      , ('Council of State', 'Council of State', 'Den Haag')
                      , ('Utrecht district court', 'Amsterdam court of appeal', 'Utrecht')
                      , ('Alkmaar district court', 'Amsterdam court of appeal', 'Alkmaar')
                      , ('Haarlem district court', 'Amsterdam court of appeal', 'Haarlem')
                      , ('Almelo district court', 'Arnhem court of appeal', 'Almelo')
                      , ('Arnhem district court', 'Arnhem court of appeal', 'Arnhem')
                      , ('Zutphen district court', 'Arnhem court of appeal', 'Zutphen')
                      , ('Zwolle-Lelystad district court', 'Arnhem court of appeal', 'Zwolle')
                      , ('Dordrecht district court', '\'s-Gravenhage court of appeal', 'Dordrecht')
                      , ('\'s-Gravenhage district court', '\'s-Gravenhage court of appeal', 'Den Haag')
                      , ('Middelburg district court', '\'s-Gravenhage court of appeal', 'Middelburg')
                      , ('Rotterdam district court', '\'s-Gravenhage court of appeal', 'Rotterdam')
                      , ('Breda district court', '\'s-Hertogenbosch court of appeal', 'Breda')
                      , ('\'s-Hertogenbosch district court', '\'s-Hertogenbosch court of appeal', 'Den Bosch')
                      , ('Maastricht district court', '\'s-Hertogenbosch court of appeal', 'Maastricht')
                      , ('Roermond district court', '\'s-Hertogenbosch court of appeal', 'Roermond')
                      , ('Assen district court', 'Leeuwarden court of appeal', 'Assen')
                      , ('Groningen district court', 'Leeuwarden court of appeal', 'Groningen')
                      , ('Leeuwarden district court', 'Leeuwarden court of appeal', 'Leeuwarden')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug panel                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * court  [UNI,TOT]                     *
    * sector  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `panel`
                     ( `i` VARCHAR(255) NOT NULL
                     , `court` VARCHAR(255) NOT NULL
                     , `sector` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `panel` (`i` ,`court` ,`sector` )
                VALUES ('Amsterdam district court fourth single-judge panel', 'Amsterdam district court', 'District')
                      , ('Roermond district court single-judge panel', 'Roermond district court', 'District')
                      , ('Amsterdam district court single-judge panel for cases of administrative law', 'Amsterdam district court', 'Administrative law')
                      , ('Panel 2 department administrative administration of justice of the Council of State', 'Council of State', 'Administrative law')
                      , ('Three-judge panel to process judicial disqualifications of Utrecht district court', 'Utrecht district court', 'Administrative law')
                      , ('Utrecht district court three-judge panel for cases of administrative law', 'Utrecht district court', 'Administrative law')
                      , ('Utrecht district court single-judge panel for cases of administrative law', 'Utrecht district court', 'Administrative law')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug action                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * subject  [UNI,TOT]                   *
    * actionType  [UNI,TOT]                *
    \**************************************/
    mysql_query("CREATE TABLE `action`
                     ( `i` VARCHAR(255) NOT NULL
                     , `subject` VARCHAR(255) NOT NULL
                     , `actiontype` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug authorization                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * by  [UNI,TOT]                        *
    \**************************************/
    mysql_query("CREATE TABLE `authorization`
                     ( `i` VARCHAR(255) NOT NULL
                     , `by` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `authorization` (`i` ,`by` )
                VALUES ('letter 2000/864821a', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('letter 2000/860338e', 'de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen')
                      , ('letter 2007/33-9887', 'Jan met de Vilten Hoed')
                      , ('letter 2007/33-9854', 'de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam')
                      , ('letter 2007/33-9910', 'het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug cluster                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * name  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `cluster`
                     ( `i` VARCHAR(255) NOT NULL
                     , `name` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug city                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * localCities  [UNI]                   *
    \**************************************/
    mysql_query("CREATE TABLE `city`
                     ( `i` VARCHAR(255) NOT NULL
                     , `localcities` VARCHAR(255)
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `city` (`i` ,`localcities` )
                VALUES ('Den Helder', 'Alkmaar district court')
                      , ('Hoorn', 'Alkmaar district court')
                      , ('Hilversum', 'Amsterdam district court')
                      , ('Ztostad', 'Haarlem district court')
                      , ('Amersfoort', 'Utrecht district court')
                      , ('Enschede', 'Almelo district court')
                      , ('Nijmegen', 'Arnhem district court')
                      , ('Tiel', 'Arnhem district court')
                      , ('Wageningen', 'Arnhem district court')
                      , ('Apelbyn', 'Zutphen district court')
                      , ('Groenlo', 'Zutphen district court')
                      , ('Harderwijk', 'Zutphen district court')
                      , ('Terborg', 'Zutphen district court')
                      , ('Deventer', 'Zwolle-Lelystad district court')
                      , ('Lelystad', 'Zwolle-Lelystad district court')
                      , ('Gorinchem', 'Dordrecht district court')
                      , ('Oud-Beijerland', 'Dordrecht district court')
                      , ('Alphen to de Rijn', '\'s-Gravenhage district court')
                      , ('Delft', '\'s-Gravenhage district court')
                      , ('Gouda', '\'s-Gravenhage district court')
                      , ('Leiden', '\'s-Gravenhage district court')
                      , ('Schouwen-Duiveland', 'Middelburg district court')
                      , ('Terneuzen', 'Middelburg district court')
                      , ('Brielle', 'Rotterdam district court')
                      , ('Middelharnis', 'Rotterdam district court')
                      , ('Schiedam', 'Rotterdam district court')
                      , ('Bergen op Zoom', 'Breda district court')
                      , ('Tilburg', 'Breda district court')
                      , ('Boxmeer', '\'s-Hertogenbosch district court')
                      , ('Eindhoven', '\'s-Hertogenbosch district court')
                      , ('Helmond', '\'s-Hertogenbosch district court')
                      , ('Heerlen', 'Maastricht district court')
                      , ('Sittard-Geleen', 'Maastricht district court')
                      , ('Venlo', 'Roermond district court')
                      , ('Emmen', 'Assen district court')
                      , ('Meppel', 'Assen district court')
                      , ('Winschoten', 'Groningen district court')
                      , ('Heerenveen', 'Leeuwarden district court')
                      , ('Sneek', 'Leeuwarden district court')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug usecase                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * prio  [UNI]                          *
    \**************************************/
    mysql_query("CREATE TABLE `usecase`
                     ( `i` VARCHAR(255) NOT NULL
                     , `prio` VARCHAR(255)
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
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
                VALUES ('Verdict')
                      , ('Evidence')
                      , ('Authorization')
                      , ('Correspondence')
                      , ('Appeal')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug organ                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `organ`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `organ` (`i` )
                VALUES ('Council of State')
                      , ('Amsterdam district court')
                      , ('Utrecht district court')
                      , ('authorities')
                      , ('citizen')
                      , ('judge')
                      , ('')
                      , ('clerk')
                      , ('district authorities')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug party                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `party`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `party` (`i` )
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
                      , ('mr. T.M.A. van Löben Sels')
                      , ('mr. G.M.P. Brouns')
                      , ('mr. N.M. van Waterschoot')
                      , ('mr. J.H.B. van der Meer')
                      , ('mr. Ph.Q. van Otterloo-Pannerden')
                      , ('mr. H.P. Kijlstra')
                      , ('M. Vtodrager')
                      , ('mr. J. Sap')
                      , ('mr. M. ter Brugge')
                      , ('mr. L.E. Verschoor-Bergsma')
                      , ('mr. J. Ebbens')
                      , ('mr. B.J. van Ettekoven')
                      , ('mr. G.J. van Binsbergen')
                      , ('mr. J. Struiksma')
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
                      , ('Council of State')
                      , ('AWB 07/2481 WRO')
                      , ('Utrecht district court')
                      , ('???')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug areaoflaw                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `areaoflaw`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `areaoflaw` (`i` )
                VALUES ('Administrative law')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug casetype                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `casetype`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `casetype` (`i` )
                VALUES ('Appeal to a higher court')
                      , ('Appeal')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug text                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `text`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `text` (`i` )
                VALUES ('Onder bestuursorgaan wordt verstaan: a. een orgaan van een rechtspersoon die krachtens publiekrecht is ingesteld.')
                      , ('Onder bestuursorgaan wordt verstaan: b. een ander persoon of college, met enig openbaar gezag bekleed.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: a. de wetgevende macht.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: b. de kamers en de verenigde vergadering der Staten-Generaal.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: c. onafhankelijke, bij de wet ingestelde organen die met rechtspraak zijn belast, alsmede de Raad voor de rechtspraak en het College van afgevaardigden.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: d. de Raad van State en zijn afdelingen.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: e. de Algemene Rekenkamer.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: f. de Nationale ombudsman en de substituut-ombudsmannen als bedoeld in artikel 9, eerste lid, van de Wet Nationale ombudsman, en ombudsmannen en ombudscommissies als bedoeld in [1]artikel 9:17, onderdeel b.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: g. de voorzitters, leden, griffiers en secretarissen van de in de onderdelen b tot en met f bedoelde organen, de procureur-generaal, de plaatsvervangend procureur-generaal en de advocaten-generaal bij de Hoge Raad, de besturen van de in onderdeel c bedoelde organen alsmede de voorzitters van die besturen, alsmede de commissies uit het midden van de in de onderdelen b tot en met f bedoelde organen.')
                      , ('De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: h. de commissie van toezicht betreffende de inlichtingen- en veiligheidsdiensten, bedoeld in artikel 64 van de Wet op de inlichtingen- en veiligheidsdiensten 2002.')
                      , ('Een ingevolge het tweede par uitgezonderd orgaan, persoon of college wordt wel als bestuursorgaan aangemerkt voor zover het orgaan, de persoon of het college besluiten neemt of handelingen verricht ten aanzien van een niet voor het leven benoemde ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig, zijn nagelaten betrekkingen of zijn rechtverkrijgenden.')
                      , ('Onder belanghebbende wordt verstaan: degene wiens belang rechtstreeks bij een besluit is betrokken.')
                      , ('Ten aanzien van bestuursorganen worden de hun toevertrouwde belangen als hun belangen beschouwd.')
                      , ('Ten aanzien van rechtspersonen worden als hun belangen mede beschouwd de algemene en collectieve belangen die zij krachtens hun doelstellingen en blijkens hun feitelijke werkzaamheden in het bijzonder behartigen.')
                      , ('Onder besluit wordt verstaan: een schriftelijke beslissing van een bestuursorgaan, inhoudende een publiekrechtelijke rechtshandeling.')
                      , ('Onder beschikking wordt verstaan: een besluit dat niet van algemene strekking is, met inbegrip van de afwijzing van een aanvraag daarvan.')
                      , ('Onder aanvraag wordt verstaan: een verzoek van een belanghebbende, een besluit te nemen.')
                      , ('Onder beleidsregel wordt verstaan: een bij besluit vastgestelde algemene regel, niet zijnde een algemeen verbindend voorschrift, omtrent de afweging van belangen, de vaststelling van feiten of de uitleg van wettelijke voorschriften bij het gebruik van een bevoegdheid van een bestuursorgaan.')
                      , ('Onder administratieve rechter wordt verstaan: een onafhankelijk, bij de wet ingesteld orgaan dat met administratieve rechtspraak is belast.')
                      , ('Een tot de rechterlijke macht behorend gerecht wordt als administratieve rechter aangemerkt voor zover [2]hoofdstuk 8 of de Wet administratiefrechtelijke handhaving verkeersvoorschriften - met uitzondering van hoofdstuk VIII - van toepassing of van overeenkomstige toepassing is.')
                      , ('Onder het maken van bezwaar wordt verstaan: het gebruik maken van de ingevolge een wettelijk voorschrift bestaande bevoegdheid, voorziening tegen een besluit te vragen bij het bestuursorgaan dat het besluit heeft genomen.')
                      , ('Onder het instellen van administratief beroep wordt verstaan: het gebruik maken van de ingevolge een wettelijk voorschrift bestaande bevoegdheid, voorziening tegen een besluit te vragen bij een ander bestuursorgaan dan hetwelk het besluit heeft genomen.')
                      , ('Onder het instellen van beroep wordt verstaan: het instellen van administratief beroep, dan wel van beroep bij een administratieve rechter.')
                      , ('De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: a. de opsporing en vervolging van strafbare feiten, alsmede de tenuitvoerlegging van strafrechtelijke beslissingen.')
                      , ('De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: b. de tenuitvoerlegging van vrijheidsbenemende maatregelen op grond van de Vreemdelingenwet 2000.')
                      , ('De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: c. de tenuitvoerlegging van andere vrijheidsbenemende maatregelen in een inrichting die in hoofdzaak bestemd is voor de tenuitvoerlegging van strafrechtelijke beslissingen.')
                      , ('De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: d. besluiten en handelingen ter uitvoering van de Wet militair tuchtrecht.')
                      , ('De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: e. besluiten en handelingen ter uitvoering van de Wet toetsing levensbeëindiging op verzoek en hulp bij zelfdoding.')
                      , ('Indien door een bestuursorgaan ingevolge enig wettelijk voorschrift advies moet worden gevraagd of extern overleg moet worden gevoerd inzake een besluit alvorens een zodanig besluit kan worden genomen, geldt dat voorschrift niet indien het voorgenomen besluit uitsluitend strekt tot uitvoering van een bindend besluit van de Raad van de Europese Unie, van het Europees Parlement en de Raad gezamenlijk of van de Commissie van de Europese Gemeenschappen.')
                      , ('Het eerste par is niet van toepassing op het horen van de Raad van State.')
                      , ('Indien door een bestuursorgaan ingevolge enig wettelijk voorschrift van het ontwerp van een besluit kennis moet worden gegeven alvorens een zodanig besluit kan worden genomen, geldt dat voorschrift niet indien het voorgenomen besluit uitsluitend strekt tot uitvoering van een bindend besluit van de Raad van de Europese Unie, van het Europees Parlement en de Raad gezamenlijk of van de Commissie van de Europese Gemeenschappen.')
                      , ('Het eerste par is niet van toepassing op de overlegging van het ontwerp van een algemene maatregel van bestuur of ministeriële regeling aan de Staten-Generaal, indien: a. bij de wet is bepaald dat door of namens een der Kamers der Staten-Generaal of door een aantal leden daarvan de wens te kennen kan worden gegeven dat het onderwerp of de inwerkingtreding van die algemene maatregel van bestuur of ministeriële regeling bij de wet wordt geregeld.')
                      , ('Het eerste par is niet van toepassing op de overlegging van het ontwerp van een algemene maatregel van bestuur of ministeriële regeling aan de Staten-Generaal, indien: b. artikel 21.6, zesde lid, van de Wet milieubeheer of artikel 33 van de Wet verontreiniging oppervlaktewateren van toepassing is.')
                      , ('Deze titel is van overeenkomstige toepassing op voorstellen van wet.')
                      , ('Een ieder kan zich ter behartiging van zijn belangen in het verkeer met bestuursorganen laten bijstaan of door een gemachtigde laten vertegenwoordigen.')
                      , ('Het bestuursorgaan kan van een gemachtigde een schriftelijke machtiging verlangen.')
                      , ('Het bestuursorgaan kan bijstand of vertegenwoordiging door een persoon tegen wie ernstige bezwaren bestaan, weigeren.')
                      , ('De belanghebbende en de in het eerste par bedoelde persoon worden van de weigering onverwijld schriftelijk in kennis gesteld.')
                      , ('Het eerste par is niet van toepassing ten aanzien van advocaten.')
                      , ('Het bestuursorgaan zendt geschriften tot behandeling waarvan kennelijk een ander bestuursorgaan bevoegd is, onverwijld door naar dat orgaan, onder gelijktijdige mededeling daarvan aan de afzender.')
                      , ('Het bestuursorgaan zendt geschriften die niet voor hem bestemd zijn en die ook niet worden doorgezonden, zo spoedig mogelijk terug aan de afzender.')
                      , ('Het bestuursorgaan vervult zijn taak zonder vooringenomenheid.')
                      , ('Het bestuursorgaan waakt ertegen dat tot het bestuursorgaan behorende of daarvoor werkzame personen die een persoonlijk belang bij een besluit hebben, de besluitvorming beïnvloeden.')
                      , ('Een ieder die is betrokken bij de uitvoering van de taak van een bestuursorgaan en daarbij de beschikking krijgt over gegevens waarvan hij het vertrouwelijke karakter kent of redelijkerwijs moet vermoeden, en voor wie niet reeds uit hoofde van ambt, beroep of wettelijk voorschrift ter zake van die gegevens een geheimhoudingsplicht geldt, is verplicht tot geheimhouding van die gegevens, behoudens voor zover enig wettelijk voorschrift hem tot mededeling verplicht of uit zijn taak de noodzaak tot mededeling voortvloeit.')
                      , ('Het eerste par is mede van toepassing op instellingen en daartoe behorende of daarvoor werkzame personen die door een bestuursorgaan worden betrokken bij de uitvoering van zijn taak, en op instellingen en daartoe behorende of daarvoor werkzame personen die een bij of krachtens de wet toegekende taak uitoefenen.')
                      , ('Bestuursorganen en onder hun verantwoordelijkheid werkzame personen gebruiken de Nederlandse taal, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('In afwijking van het eerste par kan een andere taal worden gebruikt indien het gebruik daarvan doelmatiger is en de belangen van derden daardoor niet onevenredig worden geschaad.')
                      , ('Een ieder kan de Friese taal gebruiken in het verkeer met bestuursorganen, voor zover deze in de provincie Fryslân zijn gevestigd.')
                      , ('Het eerste par geldt niet, indien het bestuursorgaan heeft verzocht de Nederlandse taal te gebruiken op de grond, dat het gebruik van de Friese taal tot een onevenredige belasting van het bestuurlijk verkeer zou leiden.')
                      , ('Bestuursorganen kunnen in het mondeling verkeer binnen de provincie Fryslân de Friese taal gebruiken.')
                      , ('Het eerste par geldt niet, indien de wederpartij heeft verzocht de Nederlandse taal te gebruiken op de grond, dat het gebruik van de Friese taal tot een onbevredigend verloop van het mondeling verkeer zou leiden.')
                      , ('In de provincie Fryslân gevestigde bestuursorganen die niet tot de centrale overheid behoren, kunnen regels stellen over het gebruik van de Friese taal in schriftelijke stukken.')
                      , ('Onze Minister wie het aangaat kan voor onderdelen van de centrale overheid waarvan het werkterrein zich uitstrekt tot de provincie Fryslân of een deel daarvan, regels stellen over het gebruik van de Friese taal in schriftelijke stukken.')
                      , ('Een schriftelijk stuk in de Friese taal wordt tevens in de Nederlandse taal opgesteld, indien het: a. bestemd of mede bestemd is voor buiten de provincie Fryslân gevestigde bestuursorganen of bestuursorganen van de centrale overheid.')
                      , ('Een schriftelijk stuk in de Friese taal wordt tevens in de Nederlandse taal opgesteld, indien het: b. algemeen verbindende voorschriften of beleidsregels inhoudt.')
                      , ('Een schriftelijk stuk in de Friese taal wordt tevens in de Nederlandse taal opgesteld, indien het: c. is opgesteld ter directe voorbereiding van de onder b genoemde voorschriften of regels.')
                      , ('De bekendmaking, mededeling of terinzagelegging van een schriftelijk stuk als bedoeld in het eerste par geschiedt in ieder geval ook in de Nederlandse taal, tenzij redelijkerwijs kan worden aangenomen dat daaraan geen behoefte bestaat.')
                      , ('Indien een schriftelijk stuk in de Friese taal is opgesteld, verstrekt het bestuursorgaan daarvan op verzoek een vertaling in de Nederlandse taal.')
                      , ('Het bestuursorgaan kan voor het vertalen een vergoeding van ten hoogste de kosten verlangen.')
                      , ('Voor het vertalen kan geen vergoeding worden verlangd, indien het schriftelijk stuk: a. de notulen van de vergadering van een vertegenwoordigend orgaan inhoudt, en het belang van de verzoeker rechtstreeks bij het genotuleerde is betrokken, dan wel de notulen van de vergadering van een vertegenwoordigend orgaan inhoudt, en de vaststelling van algemeen verbindende voorschriften of beleidsregels betreft.')
                      , ('Voor het vertalen kan geen vergoeding worden verlangd, indien het schriftelijk stuk: b. een besluit of andere handeling inhoudt waarbij de verzoeker belanghebbende is.')
                      , ('Een ieder kan in vergaderingen van in de provincie Fryslân gevestigde vertegenwoordigende organen de Friese taal gebruiken.')
                      , ('Hetgeen in de Friese taal is gezegd, wordt in de Friese taal genotuleerd.')
                      , ('In het verkeer tussen burgers en bestuursorganen kan een bericht elektronisch worden verzonden, mits de bepalingen van deze afdeling in acht worden genomen.')
                      , ('Het eerste par geldt niet, indien: a. dit bij of krachtens wettelijk voorschrift is bepaald.')
                      , ('Het eerste par geldt niet, indien: b. een vormvoorschrift zich tegen elektronische verzending verzet.')
                      , ('Een bestuursorgaan kan een bericht dat tot een of meer geadresseerden is gericht, elektronisch verzenden voor zover de geadresseerde kenbaar heeft gemaakt dat hij langs deze weg voldoende bereikbaar is.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald, geschiedt de verzending van berichten die niet tot een of meer geadresseerden zijn gericht, niet uitsluitend elektronisch.')
                      , ('Indien een bestuursorgaan een bericht elektronisch verzendt, geschiedt dit op een voldoende betrouwbare en vertrouwelijke manier, gelet op de aard en de inhoud van het bericht en het doel waarvoor het wordt gebruikt.')
                      , ('Een bericht kan elektronisch naar een bestuursorgaan worden verzonden voor zover het bestuursorgaan kenbaar heeft gemaakt dat deze weg is geopend. Het bestuursorgaan kan nadere eisen stellen aan het gebruik van de elektronische weg.')
                      , ('Een bestuursorgaan kan elektronisch verschafte gegevens en bescheiden weigeren voor zover de aanvaarding daarvan tot een onevenredige belasting voor het bestuursorgaan zou leiden.')
                      , ('Een bestuursorgaan kan een elektronisch verzonden bericht weigeren voor zover de betrouwbaarheid of vertrouwelijkheid van dit bericht onvoldoende is gewaarborgd, gelet op de aard en de inhoud van het bericht en het doel waarvoor het wordt gebruikt.')
                      , ('Het bestuursorgaan deelt een weigering op grond van dit artikel zo spoedig mogelijk aan de afzender mede.')
                      , ('Aan het vereiste van ondertekening is voldaan door een elektronische handtekening, indien de methode die daarbij voor authentificatie is gebruikt voldoende betrouwbaar is, gelet op de aard en de inhoud van het elektronische bericht en het doel waarvoor het wordt gebruikt. De artikelen 15a, tweede tot en met zesde lid, en 15b van Boek 3 van het Burgerlijk Wetboek zijn van overeenkomstige toepassing, voor zover de aard van het bericht zich daartegen niet verzet. Bij wettelijk voorschrift kunnen aanvullende eisen worden gesteld.')
                      , ('Als tijdstip waarop een bericht door een bestuursorgaan elektronisch is verzonden, geldt het tijdstip waarop het bericht een systeem voor gegevensverwerking bereikt waarover het bestuursorgaan geen controle heeft of, indien het bestuursorgaan en de geadresseerde gebruik maken van hetzelfde systeem voor gegevensverwerking, het tijdstip waarop het bericht toegankelijk wordt voor de geadresseerde.')
                      , ('Als tijdstip waarop een bericht door een bestuursorgaan elektronisch is ontvangen, geldt het tijdstip waarop het bericht zijn systeem voor gegevensverwerking heeft bereikt.')
                      , ('Op besluiten, inhoudende algemeen verbindende voorschriften: a. is [5]afdeling 3.2 slechts van toepassing, voor zover de aard van de besluiten zich daartegen niet verzet.')
                      , ('Op besluiten, inhoudende algemeen verbindende voorschriften: b. zijn de [6]afdelingen 3.6 en [7]3.7 niet van toepassing.')
                      , ('Op andere handelingen van bestuursorganen dan besluiten zijn de [8]afdelingen 3.2 tot en met 3.4 van overeenkomstige toepassing, voor zover de aard van de handelingen zich daartegen niet verzet.')
                      , ('Bij de voorbereiding van een besluit vergaart het bestuursorgaan de nodige kennis omtrent de relevante feiten en de af te wegen belangen.')
                      , ('Het bestuursorgaan gebruikt de bevoegdheid tot het nemen van een besluit niet voor een ander doel dan waarvoor die bevoegdheid is verleend.')
                      , ('Het bestuursorgaan weegt de rechtstreeks bij het besluit betrokken belangen af, voor zover niet uit een wettelijk voorschrift of uit de aard van de uit te oefenen bevoegdheid een beperking voortvloeit.')
                      , ('De voor een of meer belanghebbenden nadelige gevolgen van een besluit mogen niet onevenredig zijn in verhouding tot de met het besluit te dienen doelen.')
                      , ('In deze afdeling wordt verstaan onder adviseur: een persoon of college, bij of krachtens wettelijk voorschrift belast met het adviseren inzake door een bestuursorgaan te nemen besluiten en niet werkzaam onder verantwoordelijkheid van dat bestuursorgaan.')
                      , ('Deze afdeling is niet van toepassing op het horen van de Raad van State.')
                      , ('Indien aan de adviseur niet reeds bij wettelijk voorschrift een termijn is gesteld, kan het bestuursorgaan aangeven binnen welke termijn een advies wordt verwacht. Deze termijn mag niet zodanig kort zijn, dat de adviseur zijn taak niet naar behoren kan vervullen.')
                      , ('Indien het advies niet tijdig wordt uitgebracht staat het enkele ontbreken daarvan niet in de weg aan het nemen van het besluit.')
                      , ('Het bestuursorgaan waaraan advies wordt uitgebracht, stelt aan de adviseur, al dan niet op verzoek, de gegevens ter beschikking die nodig zijn voor een goede vervulling van diens taak.')
                      , ('Article 10 van de Wet openbaarheid van bestuur is van overeenkomstige toepassing.')
                      , ('In of bij het besluit wordt de adviseur vermeld die advies heeft uitgebracht.')
                      , ('Indien een besluit berust op een onderzoek naar feiten en gedragingen dat door een adviseur is verricht, dient het bestuursorgaan zich ervan te vergewissen dat dit onderzoek op zorgvuldige wijze heeft plaatsgevonden.')
                      , ('Deze afdeling is van overeenkomstige toepassing op voorstellen van wet.')
                      , ('Deze afdeling is van toepassing op de voorbereiding van besluiten indien dat bij wettelijk voorschrift of bij besluit van het bestuursorgaan is bepaald.')
                      , ('Tenzij bij wettelijk voorschrift of bij besluit van het bestuursorgaan anders is bepaald, is deze afdeling niet van toepassing op de voorbereiding van een besluit inhoudende de afwijzing van een aanvraag tot intrekking of wijziging van een besluit.')
                      , ('[9]Afdeling 4.1.1 is mede van toepassing op andere besluiten dan beschikkingen, indien deze op aanvraag worden genomen en voorbereid overeenkomstig deze afdeling.')
                      , ('Het bestuursorgaan legt het ontwerp van het te nemen besluit, met de daarop betrekking hebbende stukken die redelijkerwijs nodig zijn voor een beoordeling van het ontwerp, ter inzage.')
                      , ('Article 10 van de Wet openbaarheid van bestuur is van overeenkomstige toepassing. Indien op grond daarvan bepaalde stukken niet ter inzage worden gelegd, wordt daarvan mededeling gedaan.')
                      , ('Tegen vergoeding van ten hoogste de kosten verstrekt het bestuursorgaan afschrift van de ter inzage gelegde stukken.')
                      , ('De stukken liggen ter inzage gedurende de in [10]artikel 3:16, eerste lid, bedoelde termijn.')
                      , ('Voorafgaand aan de terinzagelegging geeft het bestuursorgaan in een of meer dag-, nieuws-, of huis-aan-huisbladen of op een andere geschikte wijze kennis van het ontwerp. Volstaan kan worden met het vermelden van de zakelijke inhoud.')
                      , ('Indien het een besluit van een tot de centrale overheid behorend bestuursorgaan betreft, wordt de kennisgeving in ieder geval in de Staatscourant geplaatst, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('In de kennisgeving wordt vermeld: a. waar en wanneer de stukken ter inzage zullen liggen.')
                      , ('In de kennisgeving wordt vermeld: b. wie in de gelegenheid worden gesteld om zienswijzen naar voren te brengen.')
                      , ('In de kennisgeving wordt vermeld: c. op welke wijze dit kan geschieden.')
                      , ('In de kennisgeving wordt vermeld: d. indien toepassing is gegeven aan [11]artikel 3:18, tweede lid: de termijn waarbinnen het besluit zal worden genomen.')
                      , ('Indien het besluit tot een of meer belanghebbenden zal zijn gericht, zendt het bestuursorgaan voorafgaand aan de terinzagelegging het ontwerp toe aan hen, onder wie begrepen de aanvrager.')
                      , ('[12]Artikel 3:12, derde lid, is van overeenkomstige toepassing.')
                      , ('Het bestuursorgaan vult de ter inzage gelegde stukken aan met nieuwe relevante stukken en gegevens.')
                      , ('[13]Artikel 3:11, tweede tot en met vierde lid, is van toepassing.')
                      , ('Belanghebbenden kunnen bij het bestuursorgaan naar keuze schriftelijk of mondeling hun zienswijze over het ontwerp naar voren brengen.')
                      , ('Bij wettelijk voorschrift of door het bestuursorgaan kan worden bepaald dat ook aan anderen de gelegenheid moet worden geboden hun zienswijze naar voren te brengen.')
                      , ('Indien het een besluit op aanvraag betreft, stelt het bestuursorgaan de aanvrager zo nodig in de gelegenheid te reageren op de naar voren gebrachte zienswijzen.')
                      , ('Indien het een besluit tot wijziging of intrekking van een besluit betreft, stelt het bestuursorgaan degene tot wie het te wijzigen of in te trekken besluit is gericht zo nodig in de gelegenheid te reageren op de naar voren gebrachte zienswijzen.')
                      , ('De termijn voor het naar voren brengen van zienswijzen en het uitbrengen van adviezen als bedoeld in [14]afdeling 3.3, bedraagt zes weken, tenzij bij wettelijk voorschrift een langere termijn is bepaald.')
                      , ('De termijn vangt aan met ingang van de dag waarop het ontwerp ter inzage is gelegd.')
                      , ('Op schriftelijk naar voren gebrachte zienswijzen zijn de [15]artikelen 6:9 en [16]6:10 van overeenkomstige toepassing.')
                      , ('Van hetgeen overeenkomstig [17]artikel 3:15 mondeling naar voren is gebracht, wordt een verslag gemaakt.')
                      , ('Indien het een besluit op aanvraag betreft, neemt het bestuursorgaan het besluit zo spoedig mogelijk, doch uiterlijk zes maanden na ontvangst van de aanvraag.')
                      , ('Indien de aanvraag een zeer ingewikkeld of omstreden onderwerp betreft, kan het bestuursorgaan, alvorens een ontwerp ter inzage te leggen, binnen acht weken na ontvangst van de aanvraag de in het eerste par bedoelde termijn met een redelijke termijn verlengen. Voordat het bestuursorgaan een besluit tot verlenging neemt, stelt het de aanvrager in de gelegenheid zijn zienswijze daarover naar voren te brengen.')
                      , ('In afwijking van het eerste par neemt het bestuursorgaan het besluit uiterlijk twaalf weken na de terinzagelegging van het ontwerp, indien het een besluit betreft: a. inzake intrekking van een besluit.')
                      , ('In afwijking van het eerste par neemt het bestuursorgaan het besluit uiterlijk twaalf weken na de terinzagelegging van het ontwerp, indien het een besluit betreft: b. inzake wijziging van een besluit en de aanvraag is gedaan door een ander dan degene tot wie het te wijzigen besluit is gericht.')
                      , ('Indien geen zienswijzen naar voren zijn gebracht, doet het bestuursorgaan daarvan zo spoedig mogelijk nadat de termijn voor het naar voren brengen van zienswijzen is verstreken, mededeling op de wijze, bedoeld in [18]artikel 3:12, eerste en tweede lid. In afwijking van het eerste of derde par neemt het bestuursorgaan het besluit in dat geval binnen vier weken nadat de termijn voor het naar voren brengen van zienswijzen is verstreken.')
                      , ('Deze afdeling is van toepassing op besluiten die nodig zijn om een bepaalde activiteit te mogen verrichten en op besluiten die strekken tot het vaststellen van een financiële aanspraak met het oog op die activiteit.')
                      , ('Het bestuursorgaan bevordert dat een aanvrager in kennis wordt gesteld van andere op aanvraag te nemen besluiten waarvan het bestuursorgaan redelijkerwijs kan aannemen dat deze nodig zijn voor de door de aanvrager te verrichten activiteit.')
                      , ('Bij de kennisgeving wordt per besluit in ieder geval vermeld: a. naam en adres van het bestuursorgaan, bevoegd tot het nemen van het besluit.')
                      , ('Bij de kennisgeving wordt per besluit in ieder geval vermeld: b. krachtens welk wettelijk voorschrift het besluit wordt genomen.')
                      , ('Deze paragraaf is van toepassing op besluiten ten aanzien waarvan dit is bepaald: a. bij wettelijk voorschrift.')
                      , ('Deze paragraaf is van toepassing op besluiten ten aanzien waarvan dit is bepaald: b. bij besluit van de tot het nemen van die besluiten bevoegde bestuursorganen.')
                      , ('Deze paragraaf is niet van toepassing op besluiten als bedoeld in [19]artikel 4:21, tweede lid, of ten aanzien waarvan bij of krachtens wettelijk voorschrift een periode is vastgesteld, na afloop waarvan wordt beslist op aanvragen die in die periode zijn ingediend.')
                      , ('Bij of krachtens het in [20]artikel 3:21, eerste lid, onderdeel a, bedoelde wettelijk voorschrift of bij het in [21]artikel 3:21, eerste lid, onderdeel b, bedoelde besluit wordt een van de betrokken bestuursorganen aangewezen als coördinerend bestuursorgaan.')
                      , ('Het coördinerend bestuursorgaan bevordert een doelmatige en samenhangende besluitvorming, waarbij de bestuursorganen bij de beoordeling van de aanvragen in ieder geval rekening houden met de onderlinge samenhang daartussen en tevens letten op de samenhang tussen de te nemen besluiten.')
                      , ('De andere betrokken bestuursorganen verlenen de medewerking die voor het welslagen van een doelmatige en samenhangende besluitvorming nodig is.')
                      , ('De besluiten worden zoveel mogelijk gelijktijdig aangevraagd, met dien verstande dat de laatste aanvraag niet later wordt ingediend dan zes weken na ontvangst van de eerste aanvraag.')
                      , ('De aanvragen worden ingediend bij het coördinerend bestuursorgaan. Het coördinerend bestuursorgaan zendt terstond na ontvangst van de aanvragen een afschrift daarvan aan de bevoegde bestuursorganen.')
                      , ('Indien een aanvraag voor een van de besluiten ontbreekt, stelt het coördinerend bestuursorgaan de aanvrager in de gelegenheid de ontbrekende aanvraag binnen een door het coördinerend bestuursorgaan te bepalen termijn in te dienen. Indien de ontbrekende aanvraag niet tijdig wordt ingediend, is het coördinerend bestuursorgaan bevoegd om deze paragraaf ten aanzien van bepaalde besluiten buiten toepassing te laten. In dat geval wordt voor de toepassing van bij wettelijk voorschrift geregelde termijnen het tijdstip waarop tot het buiten toepassing laten wordt beslist, gelijkgesteld met het tijdstip van ontvangst van de aanvraag.')
                      , ('Bij het in [22]artikel 3:21, eerste lid, onderdeel a, bedoelde wettelijk voorschrift kan worden bepaald dat de aanvraag voor een besluit niet wordt behandeld indien niet tevens de aanvraag voor een ander besluit is ingediend.')
                      , ('Onverminderd [23]artikel 3:24, derde en vierde lid, vangt de termijn voor het nemen van de besluiten aan met ingang van de dag waarop de laatste aanvraag is ontvangen.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: a. de ingevolge de [25]artikelen 3:11 en [26]3:44, eerste lid, onderdeel a, vereiste terinzagelegging geschiedt in ieder geval ten kantore van het coördinerend bestuursorgaan.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: b. het coördinerend bestuursorgaan draagt er zorg voor dat de gelegenheid tot het mondeling naar voren brengen van zienswijzen wordt gegeven met betrekking tot de ontwerpen van alle besluiten gezamenlijk.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: c. zienswijzen kunnen in ieder geval bij het coördinerend bestuursorgaan naar voren worden gebracht.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: d. indien over het ontwerp van een van de besluiten zienswijzen naar voren kunnen worden gebracht door een ieder, geldt dit eveneens met betrekking tot de ontwerpen van de andere besluiten.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: e. de ingevolge die afdeling en [27]afdeling 3.6 vereiste mededelingen, kennisgevingen en toezendingen geschieden door het coördinerend bestuursorgaan.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: f. alle besluiten worden genomen binnen de termijn die geldt voor het besluit met de langste beslistermijn.')
                      , ('Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: g. de dag van terinzagelegging bij het coördinerend bestuursorgaan is bepalend voor de aanvang van de beroepstermijn ingevolge [28]artikel 6:8, vierde lid.')
                      , ('Indien [29]afdeling 3.4 niet van toepassing is, geschiedt de voorbereiding met toepassing of overeenkomstige toepassing van [30]afdeling 4.1.2 en de onderdelen b tot en met f van het eerste par van dit artikel.')
                      , ('De bevoegde bestuursorganen zenden de door hen genomen besluiten toe aan het coördinerend bestuursorgaan.')
                      , ('Het coördinerend bestuursorgaan maakt de besluiten gelijktijdig bekend en legt deze gelijktijdig ter inzage.')
                      , ('Indien tegen een van de besluiten bezwaar kan worden gemaakt of administratief beroep kan worden ingesteld, geschiedt dit door het indienen van het bezwaar- of beroepschrift bij het coördinerend bestuursorgaan. Het coördinerend bestuursorgaan zendt terstond na ontvangst van het bezwaar- of beroepschrift een afschrift daarvan aan het bevoegde bestuursorgaan.')
                      , ('De bevoegde bestuursorganen zenden de door hen genomen beslissingen op bezwaar of beroep toe aan het coördinerend bestuursorgaan. Het coördinerend bestuursorgaan maakt de beslissingen gelijktijdig bekend en doet de ingevolge [31]artikel 7:12, derde lid, of [32]7:26, vierde lid, vereiste mededelingen.')
                      , ('Een beslissing op een verzoek in te stemmen met rechtstreeks beroep bij de administratieve rechter als bedoeld in [33]artikel 7:1a, vierde lid, wordt genomen door het coördinerend bestuursorgaan. Onverminderd [34]artikel 7:1a, tweede lid, wijst het coördinerend bestuursorgaan het verzoek in ieder geval af, indien tegen een van de andere besluiten een bezwaarschrift is ingediend waarin eenzelfde verzoek ontbreekt.')
                      , ('Indien tegen een of meer van de besluiten beroep kan worden ingesteld bij de rechtbank, staat tegen alle besluiten beroep open bij de rechtbank binnen het rechtsgebied waarvan het coördinerend bestuursorgaan zijn zetel heeft.')
                      , ('Indien tegen alle besluiten beroep kan worden ingesteld bij een andere administratieve rechter dan de rechtbank, staat tegen alle besluiten beroep open bij: a. de Afdeling bestuursrechtspraak van de Raad van State, indien tegen een of meer van de besluiten bij de Afdeling beroep kan worden ingesteld.')
                      , ('Indien tegen alle besluiten beroep kan worden ingesteld bij een andere administratieve rechter dan de rechtbank, staat tegen alle besluiten beroep open bij: b. het College van Beroep voor het bedrijfsleven, indien tegen een of meer van de besluiten beroep kan worden ingesteld bij het College en onderdeel a niet van toepassing is.')
                      , ('Indien tegen alle besluiten beroep kan worden ingesteld bij een andere administratieve rechter dan de rechtbank, staat tegen alle besluiten beroep open bij: c. de Centrale Raad van Beroep, indien tegen een of meer van de besluiten beroep kan worden ingesteld bij de Centrale Raad van Beroep en de onderdelen a en b niet van toepassing zijn.')
                      , ('Indien tegen de uitspraak van de rechtbank inzake een of meer besluiten hoger beroep kan worden ingesteld bij: a. de Afdeling bestuursrechtspraak van de Raad van State, staat inzake alle besluiten hoger beroep open bij de Afdeling.')
                      , ('Indien tegen de uitspraak van de rechtbank inzake een of meer besluiten hoger beroep kan worden ingesteld bij: b. het College van Beroep voor het bedrijfsleven en onderdeel a niet van toepassing is, staat inzake alle besluiten hoger beroep open bij het College.')
                      , ('Indien tegen de uitspraak van de rechtbank inzake een of meer besluiten hoger beroep kan worden ingesteld bij: c. de Centrale Raad van Beroep en de onderdelen b en c niet van toepassing zijn, staat inzake alle besluiten hoger beroep open bij de Centrale Raad van Beroep.')
                      , ('De ingevolge het eerste par bevoegde rechtbank of de ingevolge het tweede of derde par bevoegde administratieve rechter kan de behandeling van de beroepen in eerste aanleg dan wel de hoger beroepen verwijzen naar een andere rechtbank onderscheidenlijk een andere administratieve rechter die voor de behandeling ervan meer geschikt wordt geacht. [35]Artikel 8:13, tweede en derde lid, is van overeenkomstige toepassing.')
                      , ('Een besluit treedt niet in werking voordat het is bekendgemaakt.')
                      , ('De bekendmaking van besluiten die tot een of meer belanghebbenden zijn gericht, geschiedt door toezending of uitreiking aan hen, onder wie begrepen de aanvrager.')
                      , ('Indien de bekendmaking van het besluit niet kan geschieden op de wijze als voorzien in het eerste lid, geschiedt zij op een andere geschikte wijze.')
                      , ('De bekendmaking van besluiten die niet tot een of meer belanghebbenden zijn gericht, geschiedt door kennisgeving van het besluit of van de zakelijke inhoud ervan in een van overheidswege uitgegeven blad of een dag-, nieuws- of huis-aan-huisblad, dan wel op een andere geschikte wijze.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald, geschiedt de bekendmaking niet elektronisch.')
                      , ('Indien alleen van de zakelijke inhoud wordt kennisgegeven, wordt het besluit tegelijkertijd ter inzage gelegd. In de kennisgeving wordt vermeld waar en wanneer het besluit ter inzage ligt.')
                      , ('Tegelijkertijd met of zo spoedig mogelijk na de bekendmaking wordt van het besluit mededeling gedaan aan degenen die bij de voorbereiding ervan hun zienswijze naar voren hebben gebracht. Aan een adviseur als bedoeld in [36]artikel 3:5 wordt in ieder geval mededeling gedaan indien van het advies wordt afgeweken.')
                      , ('Bij de mededeling van een besluit wordt tevens vermeld wanneer en hoe de bekendmaking ervan heeft plaatsgevonden.')
                      , ('Indien bij de voorbereiding van het besluit toepassing is gegeven aan [37]afdeling 3.4, geschiedt de mededeling, bedoeld in [38]artikel 3:43, eerste lid: a. met overeenkomstige toepassing van de [39]artikelen 3:11 en [40]3:12, eerste of tweede lid, en derde lid, onderdeel a, met dien verstande dat de stukken ter inzage liggen totdat de beroepstermijn is verstreken, en b. door toezending van een exemplaar van het besluit aan degenen die over het ontwerp van het besluit zienswijzen naar voren hebben gebracht.')
                      , ('In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: a. indien de omvang van het besluit daartoe aanleiding geeft, volstaan met een ieder van de daar bedoelde personen de strekking van het besluit mee te delen.')
                      , ('In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: b. indien een zienswijze door meer dan vijf personen naar voren is gebracht bij hetzelfde geschrift, volstaan met toezending van een exemplaar aan de vijf personen wier namen en adressen als eerste in dat geschrift zijn vermeld.')
                      , ('In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: c. indien een zienswijze naar voren is gebracht door meer dan vijf personen bij hetzelfde geschrift en de omvang van het besluit daartoe aanleiding geeft, volstaan met het meedelen aan de vijf personen wier namen en adressen als eerste in dat geschrift zijn vermeld, van de strekking van het besluit.')
                      , ('In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: d. indien toezending zou moeten geschieden aan meer dan 250 personen, die toezending achterwege laten.')
                      , ('Indien tegen een besluit bezwaar kan worden gemaakt of beroep kan worden ingesteld, wordt daarvan bij de bekendmaking en bij de mededeling van het besluit melding gemaakt.')
                      , ('Hierbij wordt vermeld door wie, binnen welke termijn en bij welk orgaan bezwaar kan worden gemaakt of beroep kan worden ingesteld.')
                      , ('Een besluit dient te berusten op een deugdelijke motivering.')
                      , ('De motivering wordt vermeld bij de bekendmaking van het besluit.')
                      , ('Daarbij wordt zo mogelijk vermeld krachtens welk wettelijk voorschrift het besluit wordt genomen.')
                      , ('Indien de motivering in verband met de vereiste spoed niet aanstonds bij de bekendmaking van het besluit kan worden vermeld, verstrekt het bestuursorgaan deze binnen een week na de bekendmaking.')
                      , ('In dat geval zijn de [41]artikelen 3:41 tot en met 3:43 van overeenkomstige toepassing.')
                      , ('De vermelding van de motivering kan achterwege blijven indien redelijkerwijs kan worden aangenomen dat daaraan geen behoefte bestaat.')
                      , ('Verzoekt een belanghebbende binnen een redelijke termijn om de motivering, dan wordt deze zo spoedig mogelijk verstrekt.')
                      , ('Ter motivering van een besluit of een onderdeel daarvan kan worden volstaan met een verwijzing naar een met het oog daarop uitgebracht advies, indien het advies zelf de motivering bevat en van het advies kennis is of wordt gegeven.')
                      , ('Indien het bestuursorgaan een besluit neemt dat afwijkt van een met het oog daarop krachtens wettelijk voorschrift uitgebracht advies, wordt zulks met de redenen voor de afwijking in de motivering vermeld.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald, wordt de aanvraag tot het geven van een beschikking schriftelijk ingediend bij het bestuursorgaan dat bevoegd is op de aanvraag te beslissen.')
                      , ('De aanvraag wordt ondertekend en bevat ten minste: a. de naam en het adres van de aanvrager.')
                      , ('De aanvraag wordt ondertekend en bevat ten minste: b. de dagtekening.')
                      , ('De aanvraag wordt ondertekend en bevat ten minste: c. een aanduiding van de beschikking die wordt gevraagd.')
                      , ('De aanvrager verschaft voorts de gegevens en bescheiden die voor de beslissing op de aanvraag nodig zijn en waarover hij redelijkerwijs de beschikking kan krijgen.')
                      , ('De aanvrager kan weigeren gegevens en bescheiden te verschaffen voor zover het belang daarvan voor de beslissing van het bestuursorgaan niet opweegt tegen het belang van de eerbiediging van de persoonlijke levenssfeer, met inbegrip van de bescherming van medische en psychologische onderzoeksresultaten, of tegen het belang van de bescherming van bedrijfs- en fabricagegegevens.')
                      , ('Het eerste par is niet van toepassing op bij wettelijk voorschrift aangewezen gegevens en bescheiden waarvan is bepaald dat deze dienen te worden overgelegd.')
                      , ('Het bestuursorgaan bevestigt de ontvangst van een elektronisch ingediende aanvraag.')
                      , ('Het bestuursorgaan dat bevoegd is op de aanvraag te beslissen, kan voor het indienen van aanvragen en het verstrekken van gegevens een formulier vaststellen, voor zover daarin niet is voorzien bij wettelijk voorschrift.')
                      , ('Het bestuursorgaan kan besluiten de aanvraag niet te behandelen, indien: a. de aanvrager niet heeft voldaan aan enig wettelijk voorschrift voor het in behandeling nemen van de aanvraag, mits de aanvrager de gelegenheid heeft gehad de aanvraag binnen een door het bestuursorgaan gestelde termijn aan te vullen.')
                      , ('Het bestuursorgaan kan besluiten de aanvraag niet te behandelen, indien: b. de aanvraag geheel of gedeeltelijk is geweigerd op grond van [42]artikel 2:15, mits de aanvrager de gelegenheid heeft gehad de aanvraag binnen een door het bestuursorgaan gestelde termijn aan te vullen.')
                      , ('Het bestuursorgaan kan besluiten de aanvraag niet te behandelen, indien: c. de verstrekte gegevens en bescheiden onvoldoende zijn voor de beoordeling van de aanvraag of voor de voorbereiding van de beschikking, mits de aanvrager de gelegenheid heeft gehad de aanvraag binnen een door het bestuursorgaan gestelde termijn aan te vullen.')
                      , ('Indien de aanvraag of een van de daarbij behorende gegevens of bescheiden in een vreemde taal is gesteld en een vertaling daarvan voor de beoordeling van de aanvraag of voor de voorbereiding van de beschikking noodzakelijk is, kan het bestuursorgaan besluiten de aanvraag niet te behandelen, mits de aanvrager de gelegenheid heeft gehad binnen een door het bestuursorgaan gestelde termijn de aanvraag met een vertaling aan te vullen.')
                      , ('Indien de aanvraag of een van de daarbij behorende gegevens of bescheiden omvangrijk of ingewikkeld is en een samenvatting voor de beoordeling van de aanvraag of voor de voorbereiding van de beschikking noodzakelijk is, kan het bestuursorgaan besluiten de aanvraag niet te behandelen, mits de aanvrager de gelegenheid heeft gehad binnen een door het bestuursorgaan gestelde termijn de aanvraag met een samenvatting aan te vullen.')
                      , ('Een besluit om de aanvraag niet te behandelen wordt aan de aanvrager bekendgemaakt binnen vier weken nadat de aanvraag is aangevuld of nadat de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Indien na een geheel of gedeeltelijk afwijzende beschikking een nieuwe aanvraag wordt gedaan, is de aanvrager gehouden nieuw gebleken feiten of veranderde omstandigheden te vermelden.')
                      , ('Wanneer geen nieuw gebleken feiten of veranderde omstandigheden worden vermeld, kan het bestuursorgaan zonder toepassing te geven aan [43]artikel 4:5 de aanvraag afwijzen onder verwijzing naar zijn eerdere afwijzende beschikking.')
                      , ('Voordat een bestuursorgaan een aanvraag tot het geven van een beschikking geheel of gedeeltelijk afwijst, stelt het de aanvrager in de gelegenheid zijn zienswijze naar voren te brengen indien: a. de afwijzing zou steunen op gegevens over feiten en belangen, en b. die gegevens afwijken van gegevens die de aanvrager ter zake zelf heeft verstrekt.')
                      , ('Het eerste par geldt niet indien sprake is van een afwijking van de aanvraag die slechts van geringe betekenis voor de aanvrager kan zijn.')
                      , ('Voordat een bestuursorgaan een beschikking geeft waartegen een belanghebbende die de beschikking niet heeft aangevraagd naar verwachting bedenkingen zal hebben, stelt het die belanghebbende in de gelegenheid zijn zienswijze naar voren te brengen indien: a. de beschikking zou steunen op gegevens over feiten en belangen die de belanghebbende betreffen, en b. die gegevens niet door de belanghebbende zelf ter zake zijn verstrekt.')
                      , ('Het eerste par geldt niet indien de belanghebbende niet heeft voldaan aan een wettelijke verplichting gegevens te verstrekken.')
                      , ('Bij toepassing van de [44]artikelen 4:7 en [45]4:8 kan de belanghebbende naar keuze schriftelijk of mondeling zijn zienswijze naar voren brengen.')
                      , ('Het bestuursorgaan kan toepassing van de [46]artikelen 4:7 en [47]4:8 achterwege laten voor zover: a. de vereiste spoed zich daartegen verzet.')
                      , ('Het bestuursorgaan kan toepassing van de [46]artikelen 4:7 en [47]4:8 achterwege laten voor zover: b. de belanghebbende reeds eerder in de gelegenheid is gesteld zijn zienswijze naar voren te brengen en zich sindsdien geen nieuwe feiten of omstandigheden hebben voorgedaan.')
                      , ('Het bestuursorgaan kan toepassing van de [46]artikelen 4:7 en [47]4:8 achterwege laten voor zover: c. het met de beschikking beoogde doel slechts kan worden bereikt indien de belanghebbende daarvan niet reeds tevoren in kennis is gesteld.')
                      , ('Het bestuursorgaan kan toepassing van de [48]artikelen 4:7 en [49]4:8 voorts achterwege laten bij een beschikking die strekt tot het vaststellen van een financiële verplichting of aanspraak indien: a. tegen die beschikking bezwaar kan worden gemaakt of administratief beroep kan worden ingesteld, en b. de nadelige gevolgen na bezwaar of administratief beroep volledig ongedaan kunnen worden gemaakt.')
                      , ('Het eerste par geldt niet bij een beschikking die strekt tot: a. het op grond van [50]artikel 4:35 of met toepassing van [51]artikel 4:51 weigeren van een subsidie.')
                      , ('Het eerste par geldt niet bij een beschikking die strekt tot: b. het op grond van [52]artikel 4:46, tweede lid, lager vaststellen van een subsidie.')
                      , ('Het eerste par geldt niet bij een beschikking die strekt tot: c. het intrekken of ten nadele van de ontvanger wijzigen van een subsidieverlening of een subsidievaststelling.')
                      , ('Een beschikking dient te worden gegeven binnen de bij wettelijk voorschrift bepaalde termijn of, bij het ontbreken van zulk een termijn, binnen een redelijke termijn na ontvangst van de aanvraag.')
                      , ('De in het eerste par bedoelde redelijke termijn is in ieder geval verstreken wanneer het bestuursorgaan binnen acht weken na ontvangst van de aanvraag geen beschikking heeft gegeven, noch een kennisgeving als bedoeld in [53]artikel 4:14, derde lid, heeft gedaan.')
                      , ('Indien een beschikking niet binnen de bij wettelijk voorschrift bepaalde termijn kan worden gegeven, deelt het bestuursorgaan dit aan de aanvrager mede en noemt het daarbij een zo kort mogelijke termijn waarbinnen de beschikking wel tegemoet kan worden gezien.')
                      , ('Het eerste par is niet van toepassing indien het bestuursorgaan na het verstrijken van de bij wettelijk voorschrift bepaalde termijn niet langer bevoegd is.')
                      , ('Indien, bij het ontbreken van een bij wettelijk voorschrift bepaalde termijn, een beschikking niet binnen acht weken kan worden gegeven, stelt het bestuursorgaan de aanvrager daarvan in kennis en noemt het daarbij een redelijke termijn waarbinnen de beschikking wel tegemoet kan worden gezien.')
                      , ('De termijn voor het geven van een beschikking wordt opgeschort met ingang van de dag waarop het bestuursorgaan krachtens [54]artikel 4:5 de aanvrager uitnodigt de aanvraag aan te vullen, tot de dag waarop de aanvraag is aangevuld of de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Onder subsidie wordt verstaan: de aanspraak op financiële middelen, door een bestuursorgaan verstrekt met het oog op bepaalde activiteiten van de aanvrager, anders dan als betaling voor aan het bestuursorgaan geleverde goederen of diensten.')
                      , ('Deze titel is niet van toepassing op aanspraken of verplichtingen die voortvloeien uit een wettelijk voorschrift inzake: a. belastingen.')
                      , ('Deze titel is niet van toepassing op aanspraken of verplichtingen die voortvloeien uit een wettelijk voorschrift inzake: b. de heffing van een premie dan wel een premievervangende belasting ingevolge de Wet financiering sociale verzekeringen.')
                      , ('Deze titel is niet van toepassing op aanspraken of verplichtingen die voortvloeien uit een wettelijk voorschrift inzake: c. de heffing van een inkomensafhankelijke bijdrage dan wel een bijdragevervangende belasting ingevolge de Zorgverzekeringswet.')
                      , ('Deze titel is niet van toepassing op de aanspraak op financiële middelen die wordt verstrekt op grond van een wettelijk voorschrift dat uitsluitend voorziet in verstrekking aan rechtspersonen die krachtens publiekrecht zijn ingesteld.')
                      , ('Deze titel is van overeenkomstige toepassing op de bekostiging van het onderwijs en onderzoek.')
                      , ('Onder subsidieplafond wordt verstaan: het bedrag dat gedurende een bepaald tijdvak ten hoogste beschikbaar is voor de verstrekking van subsidies krachtens een bepaald wettelijk voorschrift.')
                      , ('Een bestuursorgaan verstrekt slechts subsidie op grond van een wettelijk voorschrift dat regelt voor welke activiteiten subsidie kan worden verstrekt.')
                      , ('Indien een zodanig wettelijk voorschrift is opgenomen in een niet op een wet berustende algemene maatregel van bestuur, vervalt dat voorschrift vier jaren nadat het in werking is getreden, tenzij voor dat tijdstip een voorstel van wet bij de Staten-Generaal is ingediend waarin de subsidie wordt geregeld.')
                      , ('Het eerste par is niet van toepassing: a. in afwachting van de totstandkoming van een wettelijk voorschrift gedurende ten hoogste een jaar of totdat een binnen dat jaar bij de Staten-Generaal ingediend wetsvoorstel is verworpen of tot wet is verheven en in werking is getreden.')
                      , ('Het eerste par is niet van toepassing: b. indien de subsidie rechtstreeks op grond van een door de Raad van de Europese Unie, het Europees Parlement en de Raad gezamenlijk of de Commissie van de Europese Gemeenschappen vastgesteld programma wordt verstrekt.')
                      , ('Het eerste par is niet van toepassing: c. indien de begroting de subsidie-ontvanger en het bedrag waarop de subsidie ten hoogste kan worden vastgesteld, vermeldt')
                      , ('Het eerste par is niet van toepassing: d. in incidentele gevallen, mits de subsidie voor ten hoogste vier jaren wordt verstrekt.')
                      , ('Het bestuursorgaan publiceert jaarlijks een verslag van de verstrekking van subsidies met toepassing van het derde lid, onderdelen a en d.')
                      , ('Indien een subsidie op een wettelijk voorschrift berust, wordt ten minste eenmaal in de vijf jaren een verslag gepubliceerd over de doeltreffendheid en de effecten van de subsidie in de praktijk, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Een subsidieplafond kan slechts bij of krachtens wettelijk voorschrift worden vastgesteld.')
                      , ('Een subsidie wordt geweigerd voor zover door verstrekking van de subsidie het subsidieplafond zou worden overschreden.')
                      , ('Indien niet tijdig, dan wel in bezwaar of beroep of ter uitvoering van een rechterlijke uitspraak omtrent verstrekking wordt beslist, geldt de verplichting van het tweede par slechts voor zover zij ook gold op het tijdstip, waarop de beslissing in eerste aanleg werd genomen of had moeten worden genomen.')
                      , ('Bij of krachtens wettelijk voorschrift wordt bepaald hoe het beschikbare bedrag wordt verdeeld.')
                      , ('Bij de bekendmaking van het subsidieplafond wordt de wijze van verdeling vermeld.')
                      , ('Het subsidieplafond wordt bekendgemaakt voor de aanvang van het tijdvak waarvoor het is vastgesteld.')
                      , ('Indien het subsidieplafond of een verlaging daarvan later wordt bekendgemaakt, heeft deze bekendmaking geen gevolgen voor voordien ingediende aanvragen.')
                      , ('[55]Artikel 4:27, tweede lid, is niet van toepassing, indien: a. de aanvragen voor het tijdvak waarvoor het subsidieplafond is vastgesteld ingevolge wettelijk voorschrift moeten worden ingediend op een tijdstip waarop de begroting nog niet is vastgesteld of goedgekeurd; b. het een verlaging betreft die voortvloeit uit de vaststelling of goedkeuring van de begroting, en c. bij de bekendmaking van het subsidieplafond is gewezen op de mogelijkheid van verlaging en de gevolgen daarvan voor reeds ingediende aanvragen.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald kan voorafgaand aan een subsidievaststelling een beschikking omtrent subsidieverlening worden gegeven, indien een aanvraag daartoe is ingediend voor de afloop van de activiteit of het tijdvak waarvoor de subsidie wordt gevraagd.')
                      , ('De beschikking tot subsidieverlening bevat een omschrijving van de activiteiten waarvoor subsidie wordt verleend.')
                      , ('De omschrijving kan later worden uitgewerkt, voor zover de beschikking tot subsidieverlening dit vermeldt.')
                      , ('De beschikking tot subsidieverlening vermeldt het bedrag van de subsidie, dan wel de wijze waarop dit bedrag wordt bepaald.')
                      , ('Indien de beschikking tot subsidieverlening het bedrag van de subsidie niet vermeldt, vermeldt zij het bedrag waarop de subsidie ten hoogste kan worden vastgesteld, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Een subsidie in de vorm van een periodieke aanspraak op financiële middelen wordt verleend voor een bepaald tijdvak, dat in de beschikking tot subsidieverlening wordt vermeld.')
                      , ('Een subsidie kan niet worden verleend onder de voorwaarde dat uitsluitend het bestuursorgaan of uitsluitend de subsidie-ontvanger een bepaalde handeling verricht, tenzij het betreft de voorwaarde dat: a. de subsidie-ontvanger medewerkt aan de totstandkoming van een overeenkomst ter uitvoering van de beschikking tot subsidieverlening.')
                      , ('Een subsidie kan niet worden verleend onder de voorwaarde dat uitsluitend het bestuursorgaan of uitsluitend de subsidie-ontvanger een bepaalde handeling verricht, tenzij het betreft de voorwaarde dat: b. de subsidie-ontvanger aantoont dat een gebeurtenis, niet zijnde een handeling van het bestuursorgaan of van de subsidie-ontvanger, heeft plaatsgevonden.')
                      , ('Voor zover een subsidie wordt verleend ten laste van een begroting die nog niet is vastgesteld of goedgekeurd, kan zij worden verleend onder de voorwaarde dat voldoende gelden ter beschikking worden gesteld.')
                      , ('De voorwaarde kan niet worden gesteld, voor zover zulks voortvloeit uit het wettelijk voorschrift waarop de subsidie berust.')
                      , ('De voorwaarde vervalt, indien het bestuursorgaan daarop niet binnen vier weken na de vaststelling of goedkeuring van de begroting een beroep heeft gedaan.')
                      , ('Het beroep op de voorwaarde geschiedt bij een subsidie voor een activiteit die door het bestuursorgaan ook in het voorafgaande begrotingsjaar werd gesubsidieerd door een intrekking wegens veranderde omstandigheden overeenkomstig [56]artikel 4:50.')
                      , ('In andere gevallen geschiedt het beroep op de voorwaarde door een intrekking overeenkomstig [57]artikel 4:48, eerste lid.')
                      , ('De subsidieverlening kan in ieder geval worden geweigerd indien een gegronde reden bestaat om aan te nemen dat: a. de activiteiten niet of niet geheel zullen plaatsvinden.')
                      , ('De subsidieverlening kan in ieder geval worden geweigerd indien een gegronde reden bestaat om aan te nemen dat: b. de aanvrager niet zal voldoen aan de aan de subsidie verbonden verplichtingen.')
                      , ('De subsidieverlening kan in ieder geval worden geweigerd indien een gegronde reden bestaat om aan te nemen dat: c. de aanvrager niet op een behoorlijke wijze rekening en verantwoording zal afleggen omtrent de verrichte activiteiten en de daaraan verbonden uitgaven en inkomsten, voor zover deze voor de vaststelling van de subsidie van belang zijn.')
                      , ('De subsidieverlening kan voorts in ieder geval worden geweigerd indien de aanvrager: a. in het kader van de aanvraag onjuiste of onvolledige gegevens heeft verstrekt en de verstrekking van deze gegevens tot een onjuiste beschikking op de aanvraag zou hebben geleid.')
                      , ('De subsidieverlening kan voorts in ieder geval worden geweigerd indien de aanvrager: b. failliet is verklaard of aan hem surséance van betaling is verleend of ten aanzien van hem de schuldsaneringsregeling natuurlijke personen van toepassing is verklaard, dan wel een verzoek daartoe bij de rechtbank is ingediend.')
                      , ('Ter uitvoering van de beschikking tot subsidieverlening kan een overeenkomst worden gesloten.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald of de aard van de subsidie zich daartegen verzet, kan in de overeenkomst worden bepaald dat de subsidie-ontvanger verplicht is de activiteiten te verrichten waarvoor de subsidie is verleend.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: a. aard en omvang van de activiteiten waarvoor subsidie wordt verleend.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: b. de administratie van aan de activiteiten verbonden uitgaven en inkomsten.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: c. het vóór de subsidievaststelling verstrekken van gegevens en bescheiden die nodig zijn voor een beslissing omtrent de subsidie.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: d. de te verzekeren risico?s.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: e. het stellen van zekerheid voor verleende voorschotten.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: f. het afleggen van rekening en verantwoording omtrent de verrichte activiteiten en de daaraan verbonden uitgaven en inkomsten, voor zover deze voor de vaststelling van de subsidie van belang zijn.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: g. het beperken of wegnemen van de nadelige gevolgen van de subsidie voor derden.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: h. het uitoefenen van controle door een accountant als bedoeld in artikel 393, eerste lid, van Boek 2 van het Burgerlijk Wetboek op het door het bestuursorgaan gevoerde financiële beheer en de financiële verantwoording daarover.')
                      , ('Indien een verplichting als bedoeld in het eerste lid, onderdeel c, wordt opgelegd, zijn de [58]artikelen 4:3 en [59]4:4 van overeenkomstige toepassing.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger ook andere verplichtingen opleggen die strekken tot verwezenlijking van het doel van de subsidie.')
                      , ('Indien de subsidie op een wettelijk voorschrift berust, worden de verplichtingen opgelegd bij wettelijk voorschrift of krachtens wettelijk voorschrift bij de subsidieverlening.')
                      , ('Indien de subsidie niet op een wettelijk voorschrift berust, kunnen de verplichtingen worden opgelegd bij de subsidieverlening.')
                      , ('Verplichtingen die niet strekken tot verwezenlijking van het doel van de subsidie kunnen slechts aan de subsidie worden verbonden voor zover dit bij wettelijk voorschrift is bepaald.')
                      , ('Verplichtingen als bedoeld in het eerste par kunnen slechts betrekking hebben op de wijze waarop of de middelen waarmee de gesubsidieerde activiteit wordt verricht.')
                      , ('De verplichtingen kunnen na de subsidieverlening worden uitgewerkt, voor zover de beschikking tot subsidieverlening dit vermeldt.')
                      , ('In de gevallen, genoemd in het tweede lid, is de subsidie-ontvanger, voor zover het verstrekken van de subsidie heeft geleid tot vermogensvorming, daarvoor een vergoeding verschuldigd aan het bestuursorgaan, mits: a. dit bij wettelijk voorschrift of, indien de subsidie niet op een wettelijk voorschrift berust, bij de subsidieverlening is bepaald, en b. daarbij is aangegeven hoe de hoogte van de vergoeding wordt bepaald.')
                      , ('De vergoeding is slechts verschuldigd indien: a. de subsidie-ontvanger voor de gesubsidieerde activiteiten gebruikte of bestemde goederen vervreemdt of bezwaart of de bestemming daarvan wijzigt.')
                      , ('De vergoeding is slechts verschuldigd indien: b. de subsidie-ontvanger een schadevergoeding ontvangt voor verlies of beschadiging van voor de gesubsidieerde activiteiten gebruikte of bestemde goederen.')
                      , ('De vergoeding is slechts verschuldigd indien: c. de gesubsidieerde activiteiten geheel of gedeeltelijk worden beëindigd.')
                      , ('De vergoeding is slechts verschuldigd indien: d. de subsidieverlening of de subsidievaststelling wordt ingetrokken of de subsidie wordt beëindigd.')
                      , ('De vergoeding is slechts verschuldigd indien: e. de rechtspersoon die de subsidie ontving wordt ontbonden.')
                      , ('De vergoeding wordt vastgesteld binnen een jaar nadat het bestuursorgaan op de hoogte is gekomen of kon zijn van de gebeurtenis die het recht op vergoeding deed ontstaan, doch in ieder geval binnen vijf jaren na de bekendmaking van de laatste beschikking tot subsidievaststelling.')
                      , ('De beschikking tot subsidievaststelling stelt het bedrag van de subsidie vast en geeft aanspraak op betaling van het vastgestelde bedrag overeenkomstig [60]afdeling 4.2.7.')
                      , ('Indien geen beschikking tot subsidieverlening is gegeven, bevat de beschikking tot subsidievaststelling een aanduiding van de activiteiten waarvoor subsidie wordt verstrekt.')
                      , ('De [61]artikelen 4:32, [62]4:35, tweede lid, [63]4:38 en [64]4:39 zijn van overeenkomstige toepassing.')
                      , ('Indien een beschikking tot subsidieverlening is gegeven, dient de subsidie-ontvanger na afloop van de activiteiten of het tijdvak waarvoor de subsidie is verleend een aanvraag tot vaststelling van de subsidie in, tenzij: a. de subsidie met toepassing van [65]artikel 4:47, onderdeel a , ambtshalve wordt vastgesteld.')
                      , ('Indien een beschikking tot subsidieverlening is gegeven, dient de subsidie-ontvanger na afloop van de activiteiten of het tijdvak waarvoor de subsidie is verleend een aanvraag tot vaststelling van de subsidie in, tenzij: b. bij wettelijk voorschrift of bij de subsidieverlening is bepaald dat de aanvraag wordt inged iend telkens na afloop van een gedeelte van het tijdvak waarvoor de subsidie is verleend.')
                      , ('Indien een beschikking tot subsidieverlening is gegeven, dient de subsidie-ontvanger na afloop van de activiteiten of het tijdvak waarvoor de subsidie is verleend een aanvraag tot vaststelling van de subsidie in, tenzij: c. de vaststelling van de subsidie bij een overeenkomst als bedoeld in [66]artikel 4:36, eerste lid, anders is geregeld.')
                      , ('Indien bij wettelijk voorschrift geen termijn is bepaald, wordt de aanvraag tot vaststelling ingediend binnen een bij de subsidieverlening te bepalen termijn.')
                      , ('Indien voor de indiening van de aanvraag tot vaststelling geen termijn is bepaald of de aanvraag na afloop van de daarvoor bepaalde termijn niet is ingediend kan het bestuursorgaan de subsidie-ontvanger een termijn stellen binnen welke de aanvraag moet zijn ingediend.')
                      , ('Indien na afloop van deze termijn geen aanvraag is ingediend, kan de subsidie ambtshalve worden vastgesteld.')
                      , ('Bij de aanvraag tot subsidievaststelling toont de aanvrager aan dat de activiteiten hebben plaatsgevonden overeenkomstig de aan de subsidie verbonden verplichtingen, tenzij de subsidie voor de aanvang van de activiteiten wordt vastgesteld.')
                      , ('Bij de aanvraag tot subsidievaststelling legt de aanvrager rekening en verantwoording af omtrent de aan de activiteiten verbonden uitgaven en inkomsten, voor zover deze voor de vaststelling van de subsidie van belang zijn.')
                      , ('Indien een beschikking tot subsidieverlening is gegeven, stelt het bestuursorgaan de subsidie overeenkomstig de subsidieverlening vast.')
                      , ('De subsidie kan lager worden vastgesteld indien: a. de activiteiten waarvoor subsidie is verleend niet of niet geheel hebben plaatsgevonden.')
                      , ('De subsidie kan lager worden vastgesteld indien: b. de subsidie-ontvanger niet heeft voldaan aan de aan de subsidie verbonden verplichtingen.')
                      , ('De subsidie kan lager worden vastgesteld indien: c. de subsidie-ontvanger onjuiste of onvolledige gegevens heeft verstrekt en de verstrekking van juiste of volledige gegevens tot een andere beschikking op de aanvraag tot subsidieverlening zou hebben geleid.')
                      , ('De subsidie kan lager worden vastgesteld indien: d. de subsidieverlening anderszins onjuist was en de subsidie-ontvanger dit wist of behoorde te weten.')
                      , ('Voor zover het bedrag van de subsidie afhankelijk is van de werkelijke kosten van de activiteiten waarvoor subsidie is verleend, worden kosten die in redelijkheid niet als noodzakelijk kunnen worden beschouwd bij de vaststelling van de subsidie niet in aanmerking genomen.')
                      , ('Het bestuursorgaan kan de subsidie geheel of gedeeltelijk ambtshalve vaststellen, indien: a. bij wettelijk voorschrift of bij de subsidieverlening een termijn is bepaald binnen welke de subsidie ambtshalve wordt vastgesteld.')
                      , ('Het bestuursorgaan kan de subsidie geheel of gedeeltelijk ambtshalve vaststellen, indien: b. toepassing wordt gegeven aan [67]artikel 4:44, vierde lid.')
                      , ('Het bestuursorgaan kan de subsidie geheel of gedeeltelijk ambtshalve vaststellen, indien: c. de beschikking tot subsidieverlening of de beschikking tot subsidievaststelling wordt ingetrokken of ten nadele van de ontvanger wordt gewijzigd.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: a. de activiteiten waarvoor subsidie is verleend niet of niet geheel hebben plaatsgevonden of zullen plaatsvinden.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: b. de subsidie-ontvanger niet heeft voldaan aan de aan de subsidie verbonden verplichtingen.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: c. de subsidie-ontvanger onjuiste of onvolledige gegevens heeft verstrekt en de verstrekking van juiste of volledige gegevens tot een andere beschikking op de aanvraag tot subsidieverlening zou hebben geleid.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: d. de subsidieverlening anderszins onjuist was en de subsidie-ontvanger dit wist of behoorde te weten.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: e. met toepassing van [68]artikel 4:34, vijfde lid, een beroep wordt gedaan op de voorwaarde dat voldoende gelden ter beschikking worden gesteld.')
                      , ('De intrekking of wijziging werkt terug tot en met het tijdstip waarop de subsidie is verleend, tenzij bij de intrekking of wijziging anders is bepaald.')
                      , ('Het bestuursorgaan kan de subsidievaststelling intrekken of ten nadele van de ontvanger wijzigen: a. op grond van feiten of omstandigheden waarvan het bij de subsidievaststelling redelijkerwijs niet op de hoogte kon zijn en op grond waarvan de subsidie lager dan overeenkomstig de subsidieverlening zou zijn vastgesteld.')
                      , ('Het bestuursorgaan kan de subsidievaststelling intrekken of ten nadele van de ontvanger wijzigen: b. indien de subsidievaststelling onjuist was en de subsidie-ontvanger dit wist of behoorde te weten.')
                      , ('Het bestuursorgaan kan de subsidievaststelling intrekken of ten nadele van de ontvanger wijzigen: c. indien de subsidie-ontvanger na de subsidievaststelling niet heeft voldaan aan aan de subsidie verbonden verplichtingen.')
                      , ('De intrekking of wijziging werkt terug tot en met het tijdstip waarop de subsidie is vastgesteld, tenzij bij de intrekking of wijziging anders is bepaald.')
                      , ('De subsidievaststelling kan niet meer worden ingetrokken of ten nadele van de ontvanger worden gewijzigd indien vijf jaren zijn verstreken sedert de dag waarop zij is bekendgemaakt dan wel, in het geval, bedoeld in het eerste lid, onderdeel c, sedert de dag waarop de handeling in strijd met de verplichting is verricht of de dag waarop aan de verplichting had moeten zijn voldaan.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening met inachtneming van een redelijke termijn intrekken of ten nadele van de subsidie-ontvanger wijzigen: a. voor zover de subsidieverlening onjuist is.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening met inachtneming van een redelijke termijn intrekken of ten nadele van de subsidie-ontvanger wijzigen: b. voor zover veranderde omstandigheden of gewijzigde inzichten zich in overwegende mate tegen voortzetting of ongewijzigde voortzetting van de subsidie verzetten.')
                      , ('Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening met inachtneming van een redelijke termijn intrekken of ten nadele van de subsidie-ontvanger wijzigen: c. in andere bij wettelijk voorschrift geregelde gevallen.')
                      , ('Bij intrekking of wijziging op grond van het eerste lid, onderdeel a of b, vergoedt het bestuursorgaan de schade die de subsidie-ontvanger lijdt doordat hij in vertrouwen op de subsidie anders heeft gehandeld dan hij zonder subsidie zou hebben gedaan.')
                      , ('Indien aan een subsidie-ontvanger voor drie of meer achtereenvolgende jaren subsidie is verstrekt voor dezelfde of in hoofdzaak dezelfde voortdurende activiteiten, geschiedt gehele of gedeeltelijke weigering van de subsidie voor een daarop aansluitend tijdvak op de grond, dat veranderde omstandigheden of gewijzigde inzichten zich tegen voortzetting of ongewijzigde voortzetting van de subsidie verzetten, slechts met inachtneming van een redelijke termijn.')
                      , ('Voor zover aan het einde van het tijdvak waarvoor subsidie is verleend sedert de bekendmaking van het voornemen tot weigering voor een daarop aansluitend tijdvak nog geen redelijke termijn is verstreken, wordt de subsidie voor het resterende deel van die termijn verleend, zo nodig in afwijking van [69]artikel 4:25, tweede lid.')
                      , ('Het subsidiebedrag wordt overeenkomstig de subsidievaststelling betaald, onder verrekening van de betaalde voorschotten.')
                      , ('Het subsidiebedrag wordt binnen vier weken na de subsidievaststelling betaald, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Indien de subsidie niet op een wettelijk voorschrift berust, kan bij de subsidieverlening, of, indien geen beschikking tot subsidieverlening is gegeven, bij de subsidievaststelling, een andere termijn worden bepaald waarbinnen het subsidiebedrag wordt betaald.')
                      , ('Het subsidiebedrag kan in gedeelten worden betaald, mits bij wettelijk voorschrift is bepaald hoe de gedeelten worden berekend en op welke tijdstippen zij worden betaald.')
                      , ('Indien de subsidie niet op een wettelijk voorschrift berust, kan het subsidiebedrag in gedeelten worden betaald, mits bij de subsidieverlening, of indien geen beschikking tot subsidieverlening is gegeven, bij de subsidievaststelling, is bepaald hoe de gedeelten worden berekend en op welke tijdstippen zij worden betaald.')
                      , ('Het bestuursorgaan kan de subsidie-ontvanger voorschotten verlenen, voor zover dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald.')
                      , ('De beschikking tot voorschotverlening vermeldt het bedrag van het voorschot, dan wel de wijze waarop dit bedrag wordt bepaald.')
                      , ('Voorschotten worden overeenkomstig de voorschotverlening betaald.')
                      , ('De voorschotten worden binnen vier weken na de voorschotverlening betaald, tenzij bij wettelijk voorschrift of bij de voorschotverlening anders is bepaald.')
                      , ('De verplichting tot betaling van een subsidiebedrag of een voorschot wordt opgeschort met ingang van de dag waarop het bestuursorgaan aan de subsidie-ontvanger schriftelijk kennis geeft van het ernstige vermoeden dat er grond bestaat om toepassing te geven aan [70]artikel 4:48 of [71]4:49, tot en met de dag waarop de beschikking omtrent de intrekking of wijziging is bekendgemaakt of de dag waarop sedert de kennisgeving van het ernstige vermoeden dertien weken zijn verstreken.')
                      , ('Onverschuldigd betaalde subsidiebedragen en voorschotten kunnen worden teruggevorderd voor zover na de dag waarop de subsidie is vastgesteld, dan wel de handeling als bedoeld in [72]artikel 4:49, eerste lid, onderdeel c, heeft plaatsgevonden, nog geen vijf jaren zijn verstreken.')
                      , ('Deze afdeling is van toepassing op per boekjaar verstrekte subsidies, indien dat bij wettelijk voorschrift of bij besluit van het bestuursorgaan is bepaald.')
                      , ('Bij algemene maatregel van bestuur kan worden bepaald dat deze afdeling van toepassing is op daarbij aangewezen subsidies.')
                      , ('Het bestuursorgaan dat met toepassing van deze afdeling een subsidie verleent kan een of meer toezichthouders aanwijzen die zijn belast met het toezicht op de naleving van de aan de ontvanger van die subsidie opgelegde verplichtingen.')
                      , ('De toezichthouder beschikt niet over de bevoegdheden, vermeld in de [73]artikelen 5:18 en [74]5:19.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald, wordt de aanvraag van de subsidie uiterlijk dertien weken voor de aanvang van het boekjaar ingediend.')
                      , ('De aanvraag van de subsidie gaat in ieder geval vergezeld van: a. een activiteitenplan, tenzij redelijkerwijs kan worden aangenomen dat daaraan geen behoefte is, en b. een begroting, tenzij deze voor de berekening van het bedrag van de subsidie niet van belang is.')
                      , ('Indien de aanvrager beschikt over een egalisatiereserve als bedoeld in [75]artikel 4:72, vermeldt de aanvraag de omvang daarvan.')
                      , ('Het activiteitenplan behelst een overzicht van de activiteiten waarvoor subsidie wordt gevraagd en de daarmee nagestreefde doelstellingen en vermeldt per activiteit de daarvoor benodigde personele en materiële middelen.')
                      , ('De begroting behelst een overzicht van de voor het boekjaar geraamde inkomsten en uitgaven van de aanvrager, voor zover deze betrekking hebben op de activiteiten waarvoor subsidie wordt gevraagd.')
                      , ('De begrotingsposten worden ieder afzonderlijk van een toelichting voorzien.')
                      , ('Tenzij voor de activiteiten waarop de aanvraag betrekking heeft nog niet eerder subsidie werd verstrekt, behelst de begroting een vergelijking met de begroting van het lopende boekjaar en de gerealiseerde inkomsten en uitgaven van het jaar, voorafgaand aan het lopende boekjaar.')
                      , ('Tenzij de aanvraag wordt ingediend door een krachtens publiekrecht ingestelde rechtspersoon, gaat deze, indien voor het jaar voorafgaand aan het subsidiejaar geen subsidie werd aangevraagd, voorts vergezeld van: a. een afschrift van de oprichtingsakte van de rechtspersoon dan wel van de statuten zoals deze laatstelijk zijn gewijzigd, en b. de laatst opgemaakte jaarrekening als bedoeld in artikel 361 van Boek 2 van het Burgerlijk Wetboek dan wel de balans en de staat van baten en lasten en de toelichting daarop of, indien deze bescheiden ontbreken, een verslag over de financiële positie van de aanvrager op het moment van de aanvraag.')
                      , ('De in het eerste lid, onderdeel b, bedoelde bescheiden dan wel het verslag over de financiële positie zijn voorzien van een van een accountant als bedoeld in artikel 393, eerste lid, van Boek 2 van het Burgerlijk Wetboek afkomstige schriftelijke verklaring omtrent de getrouwheid onderscheidenlijk een mededeling, inhoudende dat van onjuistheden niet is gebleken.')
                      , ('Bij wettelijk voorschrift of bij besluit van het bestuursorgaan kan vrijstelling of ontheffing worden verleend van het in het tweede par bepaalde.')
                      , ('Voor zover de aanvrager voor dezelfde begrote uitgaven tevens subsidie heeft aangevraagd bij een of meer andere bestuursorganen, doet hij daarvan mededeling in de aanvraag, onder vermelding van de stand van zaken met betrekking tot de beoordeling van die aanvraag of aanvragen.')
                      , ('De subsidie wordt slechts verleend aan een rechtspersoon met volledige rechtsbevoegdheid.')
                      , ('De subsidie wordt voor een boekjaar of voor een bepaald aantal boekjaren verleend.')
                      , ('Indien de subsidie voor twee of meer boekjaren wordt verleend, wordt aan de subsidie de verplichting verbonden tot het periodiek aan het bestuursorgaan verstrekken van de gegevens die voor de vaststelling van de subsidie van belang zijn.')
                      , ('De beschikking tot subsidieverlening vermeldt welke gegevens de subsidie-ontvanger krachtens het tweede par moet verstrekken, alsmede op welke tijdstippen de gegevens moeten worden verstrekt.')
                      , ('Tenzij bij wettelijk voorschrift of bij de subsidieverlening anders is bepaald, stelt de subsidie-ontvanger het boekjaar gelijk aan het kalenderjaar.')
                      , ('De subsidie-ontvanger voert een zodanig ingerichte administratie, dat daaruit te allen tijde de voor de vaststelling van de subsidie van belang zijnde rechten en verplichtingen alsmede de betalingen en de ontvangsten kunnen worden nagegaan.')
                      , ('De administratie en de daartoe behorende bescheiden worden gedurende zeven jaren bewaard.')
                      , ('Indien gedurende het boekjaar aanmerkelijke verschillen ontstaan of dreigen te ontstaan tussen de werkelijke uitgaven en inkomsten en de begrote uitgaven en inkomsten doet de subsidie-ontvanger daarvan onverwijld mededeling aan het bestuursorgaan onder vermelding van de oorzaak van de verschillen.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: a. het oprichten van dan wel deelnemen in een rechtspersoon.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: b. het wijzigen van de statuten.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: c. het in eigendom verwerven, het vervreemden of het bezwaren van registergoederen, indien zij mede zijn verworven door middel van de subsidiegelden, dan wel de lasten daarvoor mede worden bekostigd uit de subsidiegelden.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: d. het aangaan en beëindigen van overeenkomsten tot verkrijging, vervreemding of bezwaring van registergoederen of tot huur, verhuur of pacht daarvan, indien deze goederen geheel of gedeeltelijk zijn verworven door middel van de subsidie dan wel de uitgaven daarvoor mede zijn bekostigd uit de subsidie.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: e. het aangaan van kredietovereenkomsten en van overeenkomsten van geldlening.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: f. het aangaan van overeenkomsten waarbij de subsidie-ontvanger zich verbindt tot zekerheidsstelling met inbegrip van zekerheidsstelling voor schulden van derden of waarbij hij zich als borg of hoofdelijk medeschuldenaar verbindt of zich voor een derde sterk maakt.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: g. het vormen van fondsen en reserveringen.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: h. het vaststellen of wijzigen van tarieven voor door de subsidie-ontvanger in de gewone uitoefening van zijn gesubsidieerde activiteiten te verrichten prestaties.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: i. het ontbinden van de rechtspersoon.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: j. het doen van aangifte tot zijn faillissement of het aanvragen van zijn surséance van betaling.')
                      , ('Het bestuursorgaan beslist binnen vier weken omtrent de toestemming.')
                      , ('De beslissing kan eenmaal voor ten hoogste vier weken worden verdaagd.')
                      , ('Indien omtrent de toestemming niet tijdig is beslist, wordt de toestemming geacht te zijn verleend.')
                      , ('Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, vormt de ontvanger een egalisatiereserve.')
                      , ('Het verschil tussen de vastgestelde subsidie en de werkelijke kosten van de activiteiten waarvoor subsidie werd verleend komt ten gunste onderscheidenlijk ten laste van de egalisatiereserve.')
                      , ('De egalisatiereserve wordt zo hoog rentend en zo veilig als redelijkerwijs mogelijk is belegd.')
                      , ('De van de egalisatiereserve genoten rente wordt aan de egalisatiereserve toegevoegd.')
                      , ('In de gevallen bedoeld in [76]artikel 4:41, tweede lid, onderdelen c, d en e, is de subsidie-ontvanger ter zake van de egalisatiereserve vergoedingsplichtig naar evenredigheid van de mate waarin de subsidie aan de egalisatiereserve heeft bijgedragen.')
                      , ('De subsidie wordt per boekjaar vastgesteld.')
                      , ('De subsidie-ontvanger dient binnen zes maanden na afloop van het boekjaar een aanvraag tot vaststelling van de subsidie in, tenzij bij wettelijk voorschrift anders is bepaald of de subsidie met toepassing van [77]artikel 4:67, tweede lid, voor twee of meer boekjaren is verleend.')
                      , ('De aanvraag tot vaststelling gaat in ieder geval vergezeld van een financieel verslag en een activiteitenverslag.')
                      , ('Indien de subsidie-ontvanger ingevolge wettelijk voorschrift verplicht is tot het opstellen van een jaarrekening als bedoeld in artikel 361 van Boek 2 van het Burgerlijk Wetboek, of indien dit bij de subsidieverlening is bepaald, legt hij in plaats van het financieel verslag de jaarrekening over, onverminderd [78]artikel 4:45, tweede lid.')
                      , ('Indien de subsidie-ontvanger zijn inkomsten geheel ontleent aan de subsidie omvat het financiële verslag de balans en de exploitatierekening met de toelichting en zijn het tweede tot en met vijfde par van toepassing.')
                      , ('Het financiële verslag geeft volgens normen die in het maatschappelijk verkeer als aanvaardbaar worden beschouwd, een zodanig inzicht dat een verantwoord oordeel kan worden gevormd omtrent: a. het vermogen en het exploitatiesaldo, en b. voor zover de aard van het financiële verslag dat toelaat, omtrent de solvabiliteit en de liquiditeit van de subsidie-ontvanger.')
                      , ('De balans met de toelichting geeft getrouw, duidelijk en stelselmatig de grootte en de samenstelling in actief- en passiefposten van het vermogen op het einde van het boekjaar weer.')
                      , ('De exploitatierekening met de toelichting geeft getrouw, duidelijk en stelselmatig de grootte van het exploitatiesaldo van het boekjaar weer.')
                      , ('Het financiële verslag sluit aan op de begroting waarvoor subsidie is verleend en behelst een vergelijking met de gerealiseerde inkomsten en uitgaven van het jaar, voorafgaand aan het boekjaar.')
                      , ('Indien de subsidie-ontvanger zijn inkomsten in overwegende mate ontleent aan de subsidie kan bij wettelijk voorschrift of bij de subsidieverlening worden bepaald dat [79]artikel 4:76 van overeenkomstige toepassing is.')
                      , ('De subsidie-ontvanger geeft opdracht tot onderzoek van het financiële verslag aan een accountant als bedoeld in artikel 393, eerste lid, van Boek 2 van het Burgerlijk Wetboek.')
                      , ('De accountant onderzoekt of het financiële verslag voldoet aan de bij of krachtens de wet gestelde voorschriften en of het activiteitenverslag, voor zover hij dat verslag kan beoordelen, met het financiële verslag verenigbaar is.')
                      , ('De accountant geeft de uitslag van zijn onderzoek weer in een schriftelijke verklaring omtrent de getrouwheid van het financiële verslag.')
                      , ('De aanvraag tot vaststelling van de subsidie gaat vergezeld van de in het derde par bedoelde verklaring.')
                      , ('Bij wettelijk voorschrift of bij de subsidieverlening kan vrijstelling of ontheffing worden verleend van het eerste tot en met het vierde lid.')
                      , ('Bij wettelijk voorschrift of bij de subsidieverlening kan worden bepaald dat de in [80]artikel 4:78, eerste lid, bedoelde opdracht tevens strekt tot onderzoek van de naleving van aan de subsidie verbonden verplichtingen.')
                      , ('Bij toepassing van het eerste par gaat de opdracht vergezeld van een bij of krachtens wettelijk voorschrift of bij de subsidieverlening vast te stellen aanwijzing over de reikwijdte en de intensiteit van de controle.')
                      , ('Bij toepassing van het eerste lid, gaat het financiële verslag tevens vergezeld van een schriftelijke verklaring van de accountant over de naleving door de subsidie-ontvanger van de aan de subsidie verbonden verplichtingen.')
                      , ('Het activiteitenverslag beschrijft de aard en omvang van de activiteiten waarvoor subsidie werd verleend en bevat een vergelijking tussen de nagestreefde en de gerealiseerde doelstellingen en een toelichting op de verschillen.')
                      , ('Een bestuursorgaan kan beleidsregels vaststellen met betrekking tot een hem toekomende of onder zijn verantwoordelijkheid uitgeoefende, dan wel door hem gedelegeerde bevoegdheid.')
                      , ('In andere gevallen kan een bestuursorgaan slechts beleidsregels vaststellen, voor zover dit bij wettelijk voorschrift is bepaald.')
                      , ('Ter motivering van een besluit kan slechts worden volstaan met een verwijzing naar een vaste gedragslijn voor zover deze is neergelegd in een beleidsregel.')
                      , ('Bij de bekendmaking van het besluit, inhoudende een beleidsregel, wordt zo mogelijk het wettelijk voorschrift vermeld waaruit de bevoegdheid waarop het besluit, inhoudende een beleidsregel, betrekking heeft voortvloeit.')
                      , ('Het bestuursorgaan handelt overeenkomstig de beleidsregel, tenzij dat voor een of meer belanghebbenden gevolgen zou hebben die wegens bijzondere omstandigheden onevenredig zijn in verhouding tot de met de beleidsregel te dienen doelen.')
                      , ('Onder toezichthouder wordt verstaan: een persoon, bij of krachtens wettelijk voorschrift belast met het houden van toezicht op de naleving van het bepaalde bij of krachtens enig wettelijk voorschrift.')
                      , ('Bij de uitoefening van zijn taak draagt een toezichthouder een legitimatiebewijs bij zich, dat is uitgegeven door het bestuursorgaan onder verantwoordelijkheid waarvan de toezichthouder werkzaam is.')
                      , ('Een toezichthouder toont zijn legitimatiebewijs desgevraagd aanstonds.')
                      , ('Het legitimatiebewijs bevat een foto van de toezichthouder en vermeldt in ieder geval diens naam en hoedanigheid. Het model van het legitimatiebewijs wordt vastgesteld bij regeling van Onze Minister van Justitie.')
                      , ('Een toezichthouder maakt van zijn bevoegdheden slechts gebruik voor zover dat redelijkerwijs voor de vervulling van zijn taak nodig is.')
                      , ('Bij wettelijk voorschrift of bij besluit van het bestuursorgaan dat de toezichthouder als zodanig aanwijst, kunnen de aan de toezichthouder toekomende bevoegdheden worden beperkt.')
                      , ('Een toezichthouder is bevoegd, met medeneming van de benodigde apparatuur, elke plaats te betreden met uitzondering van een woning zonder toestemming van de bewoner.')
                      , ('Zo nodig verschaft hij zich toegang met behulp van de sterke arm.')
                      , ('Hij is bevoegd zich te doen vergezellen door personen die daartoe door hem zijn aangewezen.')
                      , ('Een toezichthouder is bevoegd inlichtingen te vorderen.')
                      , ('Een toezichthouder is bevoegd van personen inzage te vorderen van een identiteitsbewijs als bedoeld in artikel 1 van de Wet op de identificatieplicht.')
                      , ('Een toezichthouder is bevoegd inzage te vorderen van zakelijke gegevens en bescheiden.')
                      , ('Hij is bevoegd van de gegevens en bescheiden kopieën te maken.')
                      , ('Indien het maken van kopieën niet ter plaatse kan geschieden, is hij bevoegd de gegevens en bescheiden voor dat doel voor korte tijd mee te nemen tegen een door hem af te geven schriftelijk bewijs.')
                      , ('Een toezichthouder is bevoegd zaken te onderzoeken, aan opneming te onderwerpen en daarvan monsters te nemen.')
                      , ('Hij is bevoegd daartoe verpakkingen te openen.')
                      , ('De toezichthouder neemt op verzoek van de belanghebbende indien mogelijk een tweede monster, tenzij bij of krachtens wettelijk voorschrift anders is bepaald.')
                      , ('Indien het onderzoek, de opneming of de monsterneming niet ter plaatse kan geschieden, is hij bevoegd de zaken voor dat doel voor korte tijd mee te nemen tegen een door hem af te geven schriftelijk bewijs.')
                      , ('De genomen monsters worden voor zover mogelijk teruggegeven.')
                      , ('De belanghebbende wordt op zijn verzoek zo spoedig mogelijk in kennis gesteld van de resultaten van het onderzoek, de opneming of de monsterneming.')
                      , ('Een toezichthouder is bevoegd vervoermiddelen te onderzoeken met betrekking waartoe hij een toezichthoudende taak heeft.')
                      , ('Hij is bevoegd vervoermiddelen waarmee naar zijn redelijk oordeel zaken worden vervoerd met betrekking waartoe hij een toezichthoudende taak heeft, op hun lading te onderzoeken.')
                      , ('Hij is bevoegd van de bestuurder van een vervoermiddel inzage te vorderen van de wettelijk voorgeschreven bescheiden met betrekking waartoe hij een toezichthoudende taak heeft.')
                      , ('Hij is bevoegd met het oog op de uitoefening van deze bevoegdheden van de bestuurder van een voertuig of van de schipper van een vaartuig te vorderen dat deze zijn vervoermiddel stilhoudt en naar een door hem aangewezen plaats overbrengt.')
                      , ('Bij regeling van Onze Minister van Justitie wordt bepaald op welke wijze de vordering tot stilhouden wordt gedaan.')
                      , ('Een ieder is verplicht aan een toezichthouder binnen de door hem gestelde redelijke termijn alle medewerking te verlenen die deze redelijkerwijs kan vorderen bij de uitoefening van zijn bevoegdheden.')
                      , ('Zij die uit hoofde van ambt, beroep of wettelijk voorschrift verplicht zijn tot geheimhouding, kunnen het verlenen van medewerking weigeren, voor zover dit uit hun geheimhoudingsplicht voortvloeit.')
                      , ('Onder bestuursdwang wordt verstaan: het door feitelijk handelen door of vanwege een bestuursorgaan optreden tegen hetgeen in strijd met bij of krachtens enig wettelijk voorschrift gestelde verplichtingen is of wordt gedaan, gehouden of nagelaten.')
                      , ('De bevoegdheid tot toepassing van bestuursdwang bestaat slechts indien zij bij of krachtens de wet is toegekend.')
                      , ('Deze afdeling is niet van toepassing indien wordt opgetreden ter onmiddellijke handhaving van de openbare orde.')
                      , ('Een beslissing tot toepassing van bestuursdwang wordt op schrift gesteld. De schriftelijke beslissing is een beschikking.')
                      , ('De beschikking vermeldt welk voorschrift is of wordt overtreden.')
                      , ('De bekendmaking geschiedt aan de overtreder, aan de rechthebbenden op het gebruik van de zaak ten aanzien waarvan bestuursdwang zal worden toegepast en aan de aanvrager.')
                      , ('In de beschikking wordt een termijn gesteld waarbinnen de belanghebbenden de tenuitvoerlegging kunnen voorkomen door zelf maatregelen te treffen. Het bestuursorgaan omschrijft de te nemen maatregelen.')
                      , ('Geen termijn behoeft te worden gegund, indien de vereiste spoed zich daartegen verzet.')
                      , ('Indien de situatie dermate spoedeisend is dat het bestuursorgaan de beslissing tot toepassing van bestuursdwang niet tevoren op schrift kan stellen, zorgt het alsnog zo spoedig mogelijk voor de opschriftstelling en voor de bekendmaking.')
                      , ('De overtreder is de kosten verbonden aan de toepassing van bestuursdwang verschuldigd, tenzij de kosten redelijkerwijze niet of niet geheel te zijnen laste behoren te komen.')
                      , ('De beschikking vermeldt dat de toepassing van bestuursdwang op kosten van de overtreder plaatsvindt.')
                      , ('Indien echter de kosten geheel of gedeeltelijk niet ten laste van de overtreder zullen worden gebracht, wordt zulks in de beschikking vermeld.')
                      , ('Onder de kosten, bedoeld in het eerste lid, worden begrepen de kosten verbonden aan de voorbereiding van bestuursdwang, voor zover deze kosten zijn gemaakt na het tijdstip waarop de termijn, bedoeld in [81]artikel 5:24, vierde lid, is verstreken.')
                      , ('De kosten zijn ook verschuldigd indien de bestuursdwang door opheffing van de onwettige situatie niet of niet volledig is uitgevoerd.')
                      , ('Onder de kosten, bedoeld in het eerste lid, worden tevens begrepen de kosten voortvloeiende uit de vergoeding van schade ingevolge [82]artikel 5:27, zesde lid.')
                      , ('Het bestuursorgaan dat bestuursdwang heeft toegepast, kan van de overtreder bij dwangbevel de ingevolge [83]artikel 5:25 verschuldigde kosten, verhoogd met de op de invordering vallende kosten, invorderen.')
                      , ('Het dwangbevel wordt op kosten van de overtreder bij deurwaardersexploit betekend en levert een executoriale titel op in de zin van het Tweede Boek van het Wetboek van Burgerlijke Rechtsvordering.')
                      , ('Gedurende zes weken na de dag van betekening staat verzet tegen het dwangbevel open door dagvaarding van de rechtspersoon waartoe het bestuursorgaan behoort.')
                      , ('Het verzet schorst de tenuitvoerlegging. Op verzoek van de rechtspersoon kan de rechter de schorsing van de tenuitvoerlegging opheffen.')
                      , ('Om aan een beslissing tot toepassing van bestuursdwang uitvoering te geven, hebben personen die daartoe zijn aangewezen door het bestuursorgaan dat bestuursdwang toepast, toegang tot elke plaats, voor zover dat redelijkerwijs voor de vervulling van hun taak nodig is.')
                      , ('Voor het binnentreden in een woning zonder toestemming van de bewoner is het bestuursorgaan dat bestuursdwang toepast bevoegd tot het geven van een machtiging als bedoeld in artikel 2 van de Algemene wet op het binnentreden.')
                      , ('Een plaats die niet bij de overtreding is betrokken, wordt niet betreden dan nadat het bestuursorgaan dat bestuursdwang toepast dit de rechthebbende ten minste achtenveertig uren tevoren schriftelijk heeft aangezegd.')
                      , ('Het derde par geldt niet, indien tijdige aanzegging wegens de vereiste spoed niet mogelijk is. De aanzegging geschiedt dan zo spoedig mogelijk.')
                      , ('De aanzegging omschrijft de wijze waarop het betreden zal plaatsvinden.')
                      , ('De rechtspersoon waartoe het bestuursorgaan behoort, vergoedt de schade die door het betreden van een plaats als bedoeld in het derde par wordt veroorzaakt, voor zover deze redelijkerwijs niet ten laste van de rechthebbende behoort te komen, onverminderd het recht tot verhaal van deze schade op de overtreder ingevolge [84]artikel 5:25, zesde lid.')
                      , ('Tot de bevoegdheid tot toepassing van bestuursdwang behoort het verzegelen van gebouwen, terreinen en hetgeen zich daarin of daarop bevindt.')
                      , ('Tot de bevoegdheid tot toepassing van bestuursdwang behoort het meevoeren en opslaan van daarvoor vatbare zaken voor zover de toepassing van bestuursdwang dit vereist.')
                      , ('Indien zaken zijn meegevoerd en opgeslagen, doet het bestuursorgaan dat bestuursdwang heeft toegepast daarvan proces-verbaal opmaken, waarvan afschrift wordt verstrekt aan degene die de zaken onder zijn beheer had.')
                      , ('Het bestuursorgaan draagt zorg voor de bewaring van de opgeslagen zaken en geeft deze zaken terug aan de rechthebbende.')
                      , ('Het bestuursorgaan is bevoegd de afgifte op te schorten totdat de ingevolge [85]artikel 5:25 verschuldigde kosten zijn voldaan. Indien de rechthebbende niet tevens de overtreder is, is het bestuursorgaan bevoegd de afgifte op te schorten totdat de kosten van bewaring zijn voldaan.')
                      , ('Het bestuursorgaan dat bestuursdwang heeft toegepast, is bevoegd, indien een ingevolge [86]artikel 5:29, eerste lid, meegevoerde en opgeslagen zaak niet binnen dertien weken na de meevoering kan worden teruggegeven, deze te verkopen of, indien verkoop naar zijn oordeel niet mogelijk is, de zaak om niet aan een derde in eigendom over te dragen of te laten vernietigen.')
                      , ('Gelijke bevoegdheid heeft het bestuursorgaan ook binnen die termijn, zodra de ingevolge [87]artikel 5:25 verschuldigde kosten, vermeerderd met de voor de verkoop, de eigendomsoverdracht om niet of de vernietiging geraamde kosten, in verhouding tot de waarde van de zaak onevenredig hoog worden.')
                      , ('Verkoop, eigendomsoverdracht of vernietiging vindt niet plaats binnen twee weken na de verstrekking van het afschrift, bedoeld in [88]artikel 5:29, tweede lid, tenzij het gevaarlijke stoffen of eerder aan bederf onderhevige stoffen betreft.')
                      , ('Gedurende drie jaren na het tijdstip van verkoop heeft degene die op dat tijdstip eigenaar was, recht op de opbrengst van de zaak onder aftrek van de ingevolge [89]artikel 5:25 verschuldigde kosten en de kosten van de verkoop. Na het verstrijken van die termijn vervalt het eventuele batige saldo aan de rechtspersoon waartoe het bestuursorgaan behoort.')
                      , ('Een beslissing tot toepassing van bestuursdwang wordt niet genomen zolang een ter zake van de betrokken overtreding reeds gegeven beschikking tot oplegging van een last onder dwangsom niet is ingetrokken.')
                      , ('Een bestuursorgaan dat bevoegd is bestuursdwang toe te passen, kan in plaats daarvan aan de overtreder een last onder dwangsom opleggen.')
                      , ('Een last onder dwangsom strekt ertoe de overtreding ongedaan te maken of verdere overtreding dan wel een herhaling van de overtreding te voorkomen.')
                      , ('Voor het opleggen van een last onder dwangsom wordt niet gekozen, indien het belang dat het betrokken voorschrift beoogt te beschermen, zich daartegen verzet.')
                      , ('Het bestuursorgaan stelt de dwangsom vast hetzij op een bedrag ineens, hetzij op een bedrag per tijdseenheid waarin de last niet is uitgevoerd, dan wel per overtreding van de last. Het bestuursorgaan stelt tevens een bedrag vast waarboven geen dwangsom meer wordt verbeurd. Het vastgestelde bedrag staat in redelijke verhouding tot de zwaarte van het geschonden belang en de beoogde werking van de dwangsomoplegging.')
                      , ('In de beschikking tot oplegging van een last onder dwangsom die strekt tot het ongedaan maken van een overtreding of het voorkomen van verdere overtreding, wordt een termijn gesteld gedurende welke de overtreder de last kan uitvoeren zonder dat een dwangsom wordt verbeurd.')
                      , ('Verbeurde dwangsommen komen toe aan de rechtspersoon waartoe het bestuursorgaan behoort dat de dwangsom heeft vastgesteld. Het bestuursorgaan kan bij dwangbevel het verschuldigde bedrag, verhoogd met de op de invordering vallende kosten, invorderen.')
                      , ('[90]Artikel 5:26, tweede tot en met vierde lid, is van toepassing.')
                      , ('Het bestuursorgaan dat een last onder dwangsom heeft opgelegd, kan op verzoek van de overtreder de last opheffen, de looptijd ervan opschorten voor een bepaalde termijn of de dwangsom verminderen ingeval van blijvende of tijdelijke gehele of gedeeltelijke onmogelijkheid voor de overtreder om aan zijn verplichtingen te voldoen.')
                      , ('Het bestuursorgaan dat de last onder dwangsom heeft opgelegd, kan op verzoek van de overtreder de last opheffen indien de beschikking een jaar van kracht is geweest zonder dat de dwangsom is verbeurd.')
                      , ('De bevoegdheid tot invordering van verbeurde bedragen verjaart door verloop van zes maanden na de dag waarop zij zijn verbeurd.')
                      , ('De verjaring wordt geschorst door faillissement, toepassing van de schuldsaneringsregeling natuurlijke personen en ieder wettelijk beletsel voor invordering van de dwangsom.')
                      , ('Een last onder dwangsom wordt niet opgelegd zolang een ter zake van de betrokken overtreding reeds genomen beslissing tot toepassing van bestuursdwang niet is ingetrokken.')
                      , ('De [91]hoofdstukken 6 en [92]7 zijn van overeenkomstige toepassing indien is voorzien in de mogelijkheid van bezwaar of beroep tegen andere handelingen van bestuursorganen dan besluiten.')
                      , ('Voor de toepassing van wettelijke voorschriften over bezwaar en beroep worden met een besluit gelijkgesteld: a. de schriftelijke weigering een besluit te nemen, en b. het niet tijdig nemen van een besluit.')
                      , ('Een beslissing inzake de procedure ter voorbereiding van een besluit is niet vatbaar voor bezwaar of beroep, tenzij deze beslissing de belanghebbende los van het voor te bereiden besluit rechtstreeks in zijn belang treft.')
                      , ('Het maken van bezwaar geschiedt door het indienen van een bezwaarschrift bij het bestuursorgaan dat het besluit heeft genomen.')
                      , ('Het instellen van administratief beroep geschiedt door het indienen van een beroepschrift bij het beroepsorgaan.')
                      , ('Het instellen van beroep op een administratieve rechter geschiedt door het indienen van een beroepschrift bij die rechter.')
                      , ('Het bezwaar- of beroepschrift wordt ondertekend en bevat ten minste: a. de naam en het adres van de indiener; b. de dagtekening; c. een omschrijving van het besluit waartegen het bezwaar of beroep is gericht; d. de gronden van het bezwaar of beroep.')
                      , ('Bij het beroepschrift wordt zo mogelijk een afschrift van het besluit waarop het geschil betrekking heeft, overgelegd.')
                      , ('Indien het bezwaar- of beroepschrift in een vreemde taal is gesteld en een vertaling voor een goede behandeling van het bezwaar of beroep noodzakelijk is, dient de indiener zorg te dragen voor een vertaling.')
                      , ('Het bezwaar of beroep kan niet-ontvankelijk worden verklaard, indien: a. niet is voldaan aan [93]artikel 6:5 of aan enig ander bij de wet gesteld vereiste voor het in behandeling nemen van het bezwaar of beroep,  mits de indiener de gelegenheid heeft gehad het verzuim te herstellen binnen een hem daartoe gestelde termijn.')
                      , ('Het bezwaar of beroep kan niet-ontvankelijk worden verklaard, indien: b. het bezwaar- of beroepschrift geheel of gedeeltelijk is geweigerd op grond van [94]artikel 2:15, mits de indiener de gelegenheid heeft gehad het verzuim te herstellen binnen een hem daartoe gestelde termijn.')
                      , ('De termijn voor het indienen van een bezwaar- of beroepschrift bedraagt zes weken.')
                      , ('De termijn vangt aan met ingang van de dag na die waarop het besluit op de voorgeschreven wijze is bekendgemaakt.')
                      , ('De termijn voor het indienen van een bezwaarschrift tegen een besluit waartegen alleen door een of meer bepaalde belanghebbenden administratief beroep kon worden ingesteld, vangt aan met ingang van de dag na die waarop de beroepstermijn ongebruikt is verstreken.')
                      , ('De termijn voor het indienen van een beroepschrift tegen een besluit dat aan goedkeuring is onderworpen, vangt aan met ingang van de dag na die waarop het besluit, inhoudende de goedkeuring van dat besluit, op de voorgeschreven wijze is bekendgemaakt.')
                      , ('De termijn voor het indienen van een beroepschrift tegen een besluit dat is voorbereid met toepassing van [95]afdeling 3.4 vangt aan met ingang van de dag na die waarop het besluit overeenkomstig [96]artikel 3:44, eerste lid, onderdeel a, ter inzage is gelegd.')
                      , ('Een bezwaar- of beroepschrift is tijdig ingediend indien het voor het einde van de termijn is ontvangen.')
                      , ('Bij verzending per post is een bezwaar- of beroepschrift tijdig ingediend indien het voor het einde van de termijn ter post is bezorgd, mits het niet later dan een week na afloop van de termijn is ontvangen.')
                      , ('Ten aanzien van een voor het begin van de termijn ingediend bezwaar- of beroepschrift blijft niet-ontvankelijkverklaring op grond daarvan achterwege indien het besluit ten tijde van de indiening: a. wel reeds tot stand was gekomen.')
                      , ('Ten aanzien van een voor het begin van de termijn ingediend bezwaar- of beroepschrift blijft niet-ontvankelijkverklaring op grond daarvan achterwege indien het besluit ten tijde van de indiening: b. nog niet tot stand was gekomen, maar de indiener redelijkerwijs kon menen dat dit wel reeds het geval was.')
                      , ('De behandeling van het bezwaar of beroep kan worden aangehouden tot het begin van de termijn.')
                      , ('Ten aanzien van een na afloop van de termijn ingediend bezwaar- of beroepschrift blijft niet-ontvankelijkverklaring op grond daarvan achterwege indien redelijkerwijs niet kan worden geoordeeld dat de indiener in verzuim is geweest.')
                      , ('Indien het bezwaar of beroep is gericht tegen het niet tijdig nemen van een besluit, is het niet aan een termijn gebonden.')
                      , ('Het bezwaar- of beroepschrift kan worden ingediend zodra het bestuursorgaan in gebreke is tijdig een besluit te nemen.')
                      , ('Het bezwaar of beroep wordt niet-ontvankelijk verklaard indien het bezwaar- of beroepschrift onredelijk laat is ingediend.')
                      , ('Geen beroep bij de administratieve rechter kan worden ingesteld door een belanghebbende aan wie redelijkerwijs kan worden verweten dat hij geen zienswijzen als bedoeld in [97]artikel 3:15 naar voren heeft gebracht, geen bezwaar heeft gemaakt of geen administratief beroep heeft ingesteld.')
                      , ('Het orgaan waarbij het bezwaar- of beroepschrift is ingediend, bevestigt de ontvangst daarvan schriftelijk.')
                      , ('Het orgaan waarbij het beroepschrift is ingediend, geeft daarvan zo spoedig mogelijk kennis aan het bestuursorgaan dat het bestreden besluit heeft genomen.')
                      , ('Indien het bezwaar- of beroepschrift wordt ingediend bij een onbevoegd bestuursorgaan of bij een onbevoegde administratieve rechter, wordt het, nadat daarop de datum van ontvangst is aangetekend, zo spoedig mogelijk doorgezonden aan het bevoegde orgaan, onder gelijktijdige mededeling hiervan aan de afzender.')
                      , ('Het eerste par is van overeenkomstige toepassing indien in plaats van een bezwaarschrift een beroepschrift is ingediend of omgekeerd.')
                      , ('Het tijdstip van indiening bij het onbevoegde orgaan is bepalend voor de vraag of het bezwaar- of beroepschrift tijdig is ingediend, behoudens in geval van kennelijk onredelijk gebruik van procesrecht.')
                      , ('Het bezwaar of beroep schorst niet de werking van het besluit waartegen het is gericht, tenzij bij of krachtens wettelijk voorschrift anders is bepaald.')
                      , ('Indien iemand zich laat vertegenwoordigen, zendt het orgaan dat bevoegd is op het bezwaar of beroep te beslissen, de op de zaak betrekking hebbende stukken in ieder geval aan de gemachtigde.')
                      , ('Het aanhangig zijn van bezwaar of beroep tegen een besluit brengt geen verandering in een los van het bezwaar of beroep reeds bestaande bevoegdheid tot intrekking of wijziging van dat besluit.')
                      , ('Gaat het bestuursorgaan tot intrekking of wijziging van het bestreden besluit over, dan doet het daarvan onverwijld mededeling aan het orgaan waarbij het bezwaar of beroep aanhangig is.')
                      , ('Na de intrekking of wijziging mag het bestuursorgaan, zolang het bezwaar of beroep aanhangig blijft, geen besluit nemen waarvan de inhoud of strekking met het oorspronkelijke besluit overeenstemt, tenzij: a. gewijzigde omstandigheden dit rechtvaardigen en b. het bestuursorgaan daartoe los van het bezwaar of beroep ook bevoegd zou zijn geweest.')
                      , ('Een bestuursorgaan doet van een besluit als bedoeld in het derde par onverwijld mededeling aan het orgaan waarbij het bezwaar of beroep aanhangig is.')
                      , ('Indien een bestuursorgaan een besluit heeft genomen als bedoeld in [98]artikel 6:18, wordt het bezwaar of beroep geacht mede te zijn gericht tegen het nieuwe besluit, tenzij dat besluit aan het bezwaar of beroep geheel tegemoet komt.')
                      , ('De beslissing op het bezwaar of beroep tegen het nieuwe besluit kan echter worden verwezen naar een ander orgaan waarbij bezwaar of beroep tegen dat nieuwe besluit aanhangig is, dan wel kan of kon worden gemaakt.')
                      , ('Intrekking van het bestreden besluit staat niet in de weg aan vernietiging van dat besluit indien de indiener van het bezwaar- of beroepschrift daarbij belang heeft.')
                      , ('Indien het bezwaar of beroep is gericht tegen het niet tijdig nemen van een besluit, blijft het bestuursorgaan verplicht een besluit op de aanvraag te nemen.')
                      , ('Het in het eerste par bepaalde geldt niet: a. gedurende de periode dat het bezwaar aanhangig is.')
                      , ('Het in het eerste par bepaalde geldt niet: b. na de beslissing op het bezwaar of beroep indien de indiener van de aanvraag als gevolg daarvan geen belang meer heeft bij een besluit op de aanvraag.')
                      , ('Indien het bestuursorgaan een besluit op de aanvraag neemt, doet het daarvan onverwijld mededeling aan het orgaan waarbij het bezwaar of beroep tegen het niet tijdig beslissen aanhangig is.')
                      , ('Het bezwaar of beroep wordt geacht mede te zijn gericht tegen het besluit op de aanvraag, tenzij dat besluit aan het bezwaar of beroep geheel tegemoet komt.')
                      , ('De beslissing op het bezwaar of beroep tegen het besluit op de aanvraag kan echter worden verwezen naar een ander orgaan waarbij bezwaar of beroep tegen het besluit op de aanvraag aanhangig is, kan of kon worden gemaakt.')
                      , ('Het bezwaar of beroep tegen het niet tijdig beslissen op de aanvraag kan alsnog gegrond worden verklaard, indien de indiener van het bezwaar- of beroepschrift daarbij belang heeft.')
                      , ('Het bezwaar of beroep kan schriftelijk worden ingetrokken.')
                      , ('Tijdens het horen kan de intrekking ook mondeling geschieden.')
                      , ('Een besluit waartegen bezwaar is gemaakt of beroep is ingesteld, kan, ondanks schending van een vormvoorschrift, door het orgaan dat op het bezwaar of beroep beslist, in stand worden gelaten indien blijkt dat de belanghebbenden daardoor niet zijn benadeeld.')
                      , ('Indien beroep kan worden ingesteld tegen de beslissing op het bezwaar of beroep, wordt daarvan bij de bekendmaking van de beslissing melding gemaakt.')
                      , ('Hierbij wordt vermeld door wie, binnen welke termijn en bij welk orgaan beroep kan worden ingesteld.')
                      , ('Deze afdeling is met uitzondering van [99]artikel 6:12 van overeenkomstige toepassing indien hoger beroep of beroep in cassatie kan worden ingesteld.')
                      , ('Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: a. op bezwaar of in administratief beroep is genomen.')
                      , ('Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: b. aan goedkeuring is onderworpen.')
                      , ('Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: c. de goedkeuring van een ander besluit of de weigering van die goedkeuring inhoudt.')
                      , ('Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: d. is voorbereid met toepassing van [100]afdeling 3.4.')
                      , ('Tegen de beslissing op het bezwaar kan beroep worden ingesteld met toepassing van de voorschriften die gelden voor het instellen van beroep tegen het besluit waartegen bezwaar is gemaakt.')
                      , ('In het bezwaarschrift kan de indiener het bestuursorgaan verzoeken in te stemmen met rechtstreeks beroep bij de administratieve rechter, zulks in afwijking van [101]artikel 7:1.')
                      , ('Het bestuursorgaan wijst het verzoek in ieder geval af, indien: a. het bezwaarschrift is gericht tegen het niet tijdig nemen van een besluit.')
                      , ('Het bestuursorgaan wijst het verzoek in ieder geval af, indien: b. tegen het besluit een ander bezwaarschrift is ingediend waarin eenzelfde verzoek ontbreekt, tenzij dat andere bezwaarschrift kennelijk niet-ontvankelijk is.')
                      , ('Het bestuursorgaan kan instemmen met het verzoek indien de zaak daarvoor geschikt is.')
                      , ('Het bestuursorgaan beslist zo spoedig mogelijk op het verzoek. Een beslissing tot instemming wordt genomen zodra redelijkerwijs kan worden aangenomen dat geen nieuwe bezwaarschriften zullen worden ingediend. De [102]artikelen 4:7 en [103]4:8 zijn niet van toepassing.')
                      , ('Indien het bestuursorgaan instemt met het verzoek zendt het het bezwaarschrift, nadat daarop de datum van ontvangst is aangetekend, onverwijld door aan de bevoegde rechter.')
                      , ('Een na de instemming ontvangen bezwaarschrift wordt eveneens onverwijld doorgezonden aan de bevoegde rechter. Indien dit bezwaarschrift geen verzoek als bedoeld in het eerste par bevat, wordt, in afwijking van [104]artikel 8:41, eerste lid, geen griffierecht geheven.')
                      , ('Voordat een bestuursorgaan op het bezwaar beslist, stelt het belanghebbenden in de gelegenheid te worden gehoord.')
                      , ('Het bestuursorgaan stelt daarvan in ieder geval de indiener van het bezwaarschrift op de hoogte alsmede de belanghebbenden die bij de voorbereiding van het besluit hun zienswijze naar voren hebben gebracht.')
                      , ('Van het horen van belanghebbenden kan worden afgezien indien: a. het bezwaar kennelijk niet-ontvankelijk is.')
                      , ('Van het horen van belanghebbenden kan worden afgezien indien: b. het bezwaar kennelijk ongegrond is.')
                      , ('Van het horen van belanghebbenden kan worden afgezien indien: c. de belanghebbenden hebben verklaard geen gebruik te willen maken van het recht te worden gehoord.')
                      , ('Van het horen van belanghebbenden kan worden afgezien indien: d. aan het bezwaar volledig tegemoet wordt gekomen en andere belanghebbenden daardoor niet in hun belangen kunnen worden geschaad.')
                      , ('Tot tien dagen voor het horen kunnen belanghebbenden nadere stukken indienen.')
                      , ('Het bestuursorgaan legt het bezwaarschrift en alle verder op de zaak betrekking hebbende stukken voorafgaand aan het horen gedurende ten minste een week voor belanghebbenden ter inzage.')
                      , ('Bij de oproeping voor het horen worden belanghebbenden gewezen op het eerste par en wordt vermeld waar en wanneer de stukken ter inzage zullen liggen.')
                      , ('Belanghebbenden kunnen van deze stukken tegen vergoeding van ten hoogste de kosten afschriften verkrijgen.')
                      , ('Voor zover de belanghebbenden daarmee instemmen, kan toepassing van het tweede par achterwege worden gelaten.')
                      , ('Het bestuursorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het tweede par voorts achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. Van de toepassing van deze bepaling wordt mededeling gedaan.')
                      , ('Gewichtige redenen zijn in ieder geval niet aanwezig, voor zover ingevolge de Wet openbaarheid van bestuur de verplichting bestaat een verzoek om informatie, vervat in deze stukken, in te willigen.')
                      , ('Indien een gewichtige reden is gelegen in de vrees voor schade aan de lichamelijke of geestelijke gezondheid van een belanghebbende, kan inzage van de desbetreffende stukken worden voorbehouden aan een gemachtigde die hetzij advocaat hetzij arts is.')
                      , ('Tenzij het horen geschiedt door of mede door het bestuursorgaan zelf dan wel de voorzitter of een par ervan, geschiedt het horen door: a. een persoon die niet bij de voorbereiding van het bestreden besluit betrokken is geweest.')
                      , ('Tenzij het horen geschiedt door of mede door het bestuursorgaan zelf dan wel de voorzitter of een par ervan, geschiedt het horen door: b. meer dan een persoon van wie de meerderheid, onder wie degene die het horen leidt, niet bij de voorbereiding van het besluit betrokken is geweest.')
                      , ('Voor zover niet bij wettelijk voorschrift anders is bepaald, besluit het bestuursorgaan of het horen in het openbaar plaatsvindt.')
                      , ('Belanghebbenden worden in elkaars aanwezigheid gehoord.')
                      , ('Ambtshalve of op verzoek kunnen belanghebbenden afzonderlijk worden gehoord, indien aannemelijk is dat gezamenlijk horen een zorgvuldige behandeling zal belemmeren of dat tijdens het horen feiten of omstandigheden bekend zullen worden waarvan geheimhouding om gewichtige redenen is geboden.')
                      , ('Wanneer belanghebbenden afzonderlijk zijn gehoord, wordt ieder van hen op de hoogte gesteld van het verhandelde tijdens het horen buiten zijn aanwezigheid.')
                      , ('Het bestuursorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het derde par achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. [105]Artikel 7:4, zesde lid, tweede volzin, zevende en achtste lid, is van overeenkomstige toepassing.')
                      , ('Van het horen wordt een verslag gemaakt.')
                      , ('Op verzoek van de belanghebbende kunnen door hem meegebrachte getuigen en deskundigen worden gehoord.')
                      , ('Wanneer na het horen aan het bestuursorgaan feiten of omstandigheden bekend worden die voor de op het bezwaar te nemen beslissing van aanmerkelijk belang kunnen zijn, wordt dit aan belanghebbenden meegedeeld en worden zij in de gelegenheid gesteld daarover te worden gehoord.')
                      , ('Het bestuursorgaan beslist binnen zes weken of - indien een commissie als bedoeld in [106]artikel 7:13 is ingesteld - binnen tien weken na ontvangst van het bezwaarschrift.')
                      , ('De termijn wordt opgeschort met ingang van de dag waarop de indiener is verzocht een verzuim als bedoeld in [107]artikel 6:6 te herstellen, tot de dag waarop het verzuim is hersteld of de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Het bestuursorgaan kan de beslissing voor ten hoogste vier weken verdagen. Van de verdaging wordt schriftelijk mededeling gedaan.')
                      , ('Verder uitstel is mogelijk voor zover de indiener van het bezwaarschrift daarmee instemt en andere belanghebbenden daardoor niet in hun belangen kunnen worden geschaad of ermee instemmen.')
                      , ('Indien het bezwaar ontvankelijk is, vindt op grondslag daarvan een heroverweging van het bestreden besluit plaats.')
                      , ('Voor zover de heroverweging daartoe aanleiding geeft, herroept het bestuursorgaan het bestreden besluit en neemt het voor zover nodig in de plaats daarvan een nieuw besluit.')
                      , ('De beslissing op het bezwaar dient te berusten op een deugdelijke motivering, die bij de bekendmaking van de beslissing wordt vermeld. Daarbij wordt, indien ingevolge [108]artikel 7:3 van het horen is afgezien, tevens aangegeven op welke grond dat is geschied.')
                      , ('De beslissing wordt bekendgemaakt door toezending of uitreiking aan degenen tot wie zij is gericht. Betreft het een besluit dat niet tot een of meer belanghebbenden was gericht, dan wordt de beslissing bekendgemaakt op dezelfde wijze als waarop dat besluit bekendgemaakt is.')
                      , ('Zo spoedig mogelijk na de bekendmaking van de beslissing wordt hiervan mededeling gedaan aan de belanghebbenden die in bezwaar of bij de voorbereiding van het bestreden besluit hun zienswijze naar voren hebben gebracht.')
                      , ('Bij de mededeling, bedoeld in het derde lid, is [109]artikel 6:23 van overeenkomstige toepassing en wordt met het oog op de aanvang van de beroepstermijn zo duidelijk mogelijk aangegeven wanneer de bekendmaking van de beslissing overeenkomstig het tweede par heeft plaatsgevonden.')
                      , ('Dit artikel is van toepassing indien ten behoeve van de beslissing op het bezwaar een adviescommissie is ingesteld: a. die bestaat uit een voorzitter en ten minste twee leden, b. waarvan de voorzitter geen deel uitmaakt van en niet werkzaam is onder verantwoordelijkheid van het bestuursorgaan en c. die voldoet aan eventueel bij wettelijk voorschrift gestelde andere eisen.')
                      , ('Indien een commissie over het bezwaar zal adviseren, deelt het bestuursorgaan dit zo spoedig mogelijk mede aan de indiener van het bezwaarschrift.')
                      , ('Het horen geschiedt door de commissie. De commissie kan het horen opdragen aan de voorzitter of een par dat geen deel uitmaakt van en niet werkzaam is onder verantwoordelijkheid van het bestuursorgaan.')
                      , ('De commissie beslist over de toepassing van artikel 7:4, zesde lid, van [110]artikel 7:5, tweede lid, en, voor zover bij wettelijk voorschrift niet anders is bepaald, van [111]artikel 7:3.')
                      , ('Een vertegenwoordiger van het bestuursorgaan wordt voor het horen uitgenodigd en wordt in de gelegenheid gesteld een toelichting op het standpunt van het bestuursorgaan te geven.')
                      , ('Het advies van de commissie wordt schriftelijk uitgebracht en bevat een verslag van het horen.')
                      , ('Indien de beslissing op het bezwaar afwijkt van het advies van de commissie, wordt in de beslissing de reden voor die afwijking vermeld en wordt het advies met de beslissing meegezonden.')
                      , ('[112]Artikel 3:6, tweede lid, [113]afdeling 3.4, de [114]artikelen 3:41 tot en met 3:45, [115]afdeling 3.7, met uitzondering van [116]artikel 3:49, en [117]hoofdstuk 4 zijn niet van toepassing op besluiten op grond van deze afdeling.')
                      , ('Voor de behandeling van het bezwaar is geen recht verschuldigd.')
                      , ('De kosten, die de belanghebbende in verband met de behandeling van het bezwaar redelijkerwijs heeft moeten maken, worden door het bestuursorgaan uitsluitend vergoed op verzoek van de belanghebbende voorzover het bestreden besluit wordt herroepen wegens aan het bestuursorgaan te wijten onrechtmatigheid. Art. 243, tweede lid, van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Het verzoek wordt gedaan voordat het bestuursorgaan op het bezwaar heeft beslist. Het bestuursorgaan beslist op het verzoek bij de beslissing op het bezwaar.')
                      , ('Bij algemene maatregel van bestuur worden nadere regels gesteld over de kosten waarop de vergoeding uitsluitend betrekking kan hebben en over de wijze waarop het bedrag van de kosten wordt vastgesteld.')
                      , ('Voordat een beroepsorgaan op het beroep beslist, stelt het belanghebbenden in de gelegenheid te worden gehoord.')
                      , ('Het beroepsorgaan stelt daarvan in ieder geval de indiener van het beroepschrift op de hoogte, alsmede het bestuursorgaan dat het besluit heeft genomen en de belanghebbenden die bij de voorbereiding van het besluit of bij de behandeling van het bezwaarschrift hun zienswijze naar voren hebben gebracht.')
                      , ('Van het horen van belanghebbenden kan worden afgezien indien: a. het beroep kennelijk niet-ontvankelijk is.')
                      , ('Van het horen van belanghebbenden kan worden afgezien indien: b. het beroep kennelijk ongegrond is.')
                      , ('Het beroepsorgaan legt het beroepschrift en alle verder op de zaak betrekking hebbende stukken voorafgaand aan het horen gedurende ten minste een week voor belanghebbenden ter inzage.')
                      , ('Het beroepsorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het tweede par voorts achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. Van de toepassing van deze bepaling wordt mededeling gedaan.')
                      , ('Het horen geschiedt door het beroepsorgaan.')
                      , ('Bij of krachtens de wet kan het horen worden opgedragen aan een adviescommissie waarin een of meer leden zitting hebben die geen deel uitmaken van en niet werkzaam zijn onder verantwoordelijkheid van het beroepsorgaan.')
                      , ('Het horen geschiedt in het openbaar, tenzij het beroepsorgaan op verzoek van een belanghebbende of om gewichtige redenen ambtshalve anders beslist.')
                      , ('Het beroepsorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het derde par achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. [118]Artikel 7:18, zesde lid, tweede volzin, zevende en achtste lid, is van overeenkomstige toepassing.')
                      , ('Wanneer na het horen aan het beroepsorgaan feiten of omstandigheden bekend worden die voor de op het beroep te nemen beslissing van aanmerkelijk belang kunnen zijn, wordt dit aan belanghebbenden meegedeeld en worden zij in de gelegenheid gesteld daarover te worden gehoord.')
                      , ('Het beroepsorgaan beslist binnen zestien weken na ontvangst van het beroepschrift.')
                      , ('Indien het beroepsorgaan evenwel behoort tot dezelfde rechtspersoon als het bestuursorgaan tegen welks besluit het beroep is gericht, beslist het binnen zes weken of, indien een commissie als bedoeld in [119]artikel 7:19, tweede lid, is ingesteld, binnen tien weken na ontvangst van het beroepschrift.')
                      , ('De termijn wordt opgeschort met ingang van de dag waarop de indiener is verzocht een verzuim als bedoeld in [120]artikel 6:6 te herstellen, tot de dag waarop het verzuim is hersteld of de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Het beroepsorgaan kan de beslissing voor ten hoogste acht weken verdagen.')
                      , ('In het geval, bedoeld in het tweede lid, kan het beroepsorgaan de beslissing echter voor ten hoogste vier weken verdagen.')
                      , ('Van de verdaging wordt schriftelijk mededeling gedaan.')
                      , ('Verder uitstel is mogelijk voor zover de indiener daarmee instemt en andere belanghebbenden daardoor niet in hun belangen kunnen worden geschaad of ermee instemmen.')
                      , ('Voor zover het beroepsorgaan het beroep ontvankelijk en gegrond acht, vernietigt het het bestreden besluit en neemt het voor zover nodig in de plaats daarvan een nieuw besluit.')
                      , ('De beslissing op het beroep dient te berusten op een deugdelijke motivering, die bij de bekendmaking van de beslissing wordt vermeld. Daarbij wordt, indien ingevolge [121]artikel 7:17 van het horen is afgezien, tevens aangegeven op welke grond dat is geschied.')
                      , ('Indien de beslissing afwijkt van het advies van een commissie als bedoeld in [122]artikel 7:19, tweede lid, worden in de beslissing de redenen voor die afwijking vermeld en wordt het advies met de beslissing meegezonden.')
                      , ('Zo spoedig mogelijk na de bekendmaking van de beslissing wordt hiervan mededeling gedaan aan het bestuursorgaan tegen welks besluit het beroep was gericht, aan degenen tot wie het bestreden besluit was gericht en aan de belanghebbenden die in beroep hun zienswijze naar voren hebben gebracht.')
                      , ('Bij de mededeling, bedoeld in het vierde lid, is [123]artikel 6:23 van overeenkomstige toepassing en wordt met het oog op de aanvang van de beroepstermijn zo duidelijk mogelijk aangegeven wanneer de bekendmaking van de beslissing overeenkomstig het derde par heeft plaatsgevonden.')
                      , ('[124]Artikel 3:6, tweede lid, [125]afdeling 3.4, de [126]artikelen 3:41 tot en met 3:45, [127]afdeling 3.7, met uitzondering van [128]artikel 3:49, en [129]hoofdstuk 4 zijn niet van toepassing op besluiten op grond van deze afdeling.')
                      , ('Voor de behandeling van het beroep is geen recht verschuldigd.')
                      , ('De kosten, die de belanghebbende in verband met de behandeling van het beroep redelijkerwijs heeft moeten maken, worden door het bestuursorgaan uitsluitend vergoed op verzoek van de belanghebbende voorzover het bestreden besluit wordt herroepen wegens aan het bestuursorgaan te wijten onrechtmatigheid. In dat geval stelt het beroepsorgaan de vergoeding vast die het bestuursorgaan verschuldigd is. Artikel 243, tweede lid, van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Het verzoek wordt gedaan voordat het beroepsorgaan op het beroep heeft beslist. Het beroepsorgaan beslist op het verzoek bij de beslissing op het beroep.')
                      , ('[Vervallen per 01-01-1994]')
                      , ('Een belanghebbende kan tegen een besluit beroep instellen bij de rechtbank.')
                      , ('Met een besluit wordt gelijkgesteld een andere handeling van een bestuursorgaan waarbij een ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig of een dienstplichtige als bedoeld in hoofdstuk 2 van de Kaderwet dienstplicht als zodanig, hun nagelaten betrekkingen of hun rechtverkrijgenden belanghebbende zijn.')
                      , ('Met een besluit worden gelijkgesteld: a. de schriftelijke beslissing, inhoudende de weigering van de goedkeuring van een besluit, inhoudende een algemeen verbindend voorschrift of een beleidsregel of de intrekking of de vaststelling van de inwerkingtreding van een algemeen verbindend voorschrift of een beleidsregel, en b. de schriftelijke beslissing, inhoudende de weigering van de goedkeuring van een besluit ter voorbereiding van een privaatrechtelijke rechtshandeling.')
                      , ('Geen beroep kan worden ingesteld tegen: a. een besluit, inhoudende een algemeen verbindend voorschrift of een beleidsregel.')
                      , ('Geen beroep kan worden ingesteld tegen: b. een besluit, inhoudende de intrekking of de vaststelling van de inwerkingtreding van een algemeen verbindend voorschrift of een beleidsregel.')
                      , ('Geen beroep kan worden ingesteld tegen: c. een besluit, inhoudende de goedkeuring van een besluit, inhoudende een algemeen verbindend voorschrift of een beleidsregel of de intrekking of de vaststelling van de inwerkingtreding van een algemeen verbindend voorschrift of een beleidsregel.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit ter voorbereiding van een privaatrechtelijke rechtshandeling.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: a. inhoudende schorsing of vernietiging van een besluit van een ander bestuursorgaan.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: b. op grond van een in enig wettelijk voorschrift voor het geval van buitengewone omstandigheden toegekende bevoegdheid of opgelegde verplichting in deze omstandigheden genomen.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: c. genomen op grond van een wettelijk voorschrift ter beveiliging van de militaire belangen van het Koninkrijk of zijn bondgenoten.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: d. tot benoeming of aanstelling, tenzij beroep wordt ingesteld door een ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig of een dienstplichtige als bedoeld in hoofdstuk 2 van de Kaderwet dienstplicht als zodanig, hun nagelaten betrekkingen of hun rechtverkrijgenden.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: e. inhoudende een beoordeling van het kennen of kunnen van een kandidaat of leerling die ter zake is geëxamineerd of op enigerlei andere wijze is getoetst, dan wel inhoudende de vaststelling van opgaven, beoordelingsnormen of nadere regels voor die examinering of toetsing.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: f. inhoudende een technische beoordeling van een voertuig of een luchtvaartuig, dan wel een meetmiddel, een onderdeel daarvan of een hulpinrichting daarvoor.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: g. inzake de nummering van kandidatenlijsten, de geldigheid van lijstverbindingen, het verloop van de stemming, de stemopneming, de vaststelling van de stemwaarden en de vaststelling van de uitslag bij verkiezingen van de leden van vertegenwoordigende organen, de benoemdverklaring in opengevallen plaatsen, de toelating van nieuwe leden van provinciale staten, van de gemeenteraad en van het algemeen bestuur van een waterschap, alsmede de verlening van tijdelijk ontslag wegens zwangerschap en bevalling of ziekte.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: h. genomen op grond van een wettelijk voorschrift inzake de verplichte krijgsdienst, voor zover het keuring, herkeuring, werkelijke dienst, groot verlof of diensteindiging betreft, tenzij het besluit betrekking heeft op verlenging van werkelijke dienst of kostwinnersvergoeding, of het besluit is genomen op grond van de Wet voor het reservepersoneel der krijgsmacht 1985.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: i. houdende een ambtshandeling van een gerechtsdeurwaarder of notaris.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: j. als bedoeld in [130]artikel 7:1a, vierde lid.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: k. inhoudende een weigering op grond van [131]artikel 2:15.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit: l. een besluit als bedoeld in [132]artikel 3:21, eerste lid, onderdeel b.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit, genomen op grond van een wettelijk voorschrift dat is opgenomen in de bijlage die bij deze wet behoort.')
                      , ('Bij een wijziging van de bijlage blijft de bijlage zoals deze luidde voor het tijdstip van inwerkingtreding van de wijziging van toepassing ten aanzien van de mogelijkheid om beroep in te stellen tegen een besluit dat voor dat tijdstip is bekendgemaakt.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit waartegen beroep bij een andere administratieve rechter kan of kon worden ingesteld.')
                      , ('Geen beroep kan worden ingesteld tegen een besluit waartegen administratief beroep kan worden ingesteld of door de belanghebbende kon worden ingesteld.')
                      , ('Indien beroep wordt ingesteld tegen een besluit van een bestuursorgaan van een provincie, een gemeente, een waterschap of een regio als bedoeld in artikel 21 van de Politiewet 1993 dan wel tegen een besluit van een gemeenschappelijk orgaan of een bestuursorgaan van een openbaar lichaam dat is ingesteld met toepassing van de Wet gemeenschappelijke regelingen, is de rechtbank binnen het rechtsgebied waarvan het bestuursorgaan zijn zetel heeft bevoegd.')
                      , ('Indien beroep wordt ingesteld tegen een besluit van een ander bestuursorgaan, is de rechtbank binnen het rechtsgebied waarvan de indiener van het beroepschrift zijn woonplaats in Nederland heeft bevoegd. Indien de indiener van het beroepschrift geen woonplaats in Nederland heeft, is de rechtbank binnen het rechtsgebied waarvan het bestuursorgaan zijn zetel heeft bevoegd.')
                      , ('Indien tegen hetzelfde besluit bij meer dan één bevoegde rechtbank beroep is ingesteld, worden de zaken verder behandeld door de bevoegde rechtbank waarbij als eerste beroep is ingesteld. Indien gelijktijdig bij meer dan één bevoegde rechtbank als eerste beroep is ingesteld, worden de zaken verder behandeld door de bevoegde rechtbank die als eerste wordt genoemd in de Wet op de rechterlijke indeling.')
                      , ('De andere rechtbank verwijst onderscheidenlijk de andere rechtbanken verwijzen de daar aanhangig gemaakte zaak of zaken naar de rechtbank die de zaken verder behandelt. De op de zaak of zaken betrekking hebbende stukken worden toegezonden aan de rechtbank die de zaken verder behandelt.')
                      , ('Indien tegen hetzelfde besluit bij meer dan één rechtbank beroep is ingesteld, doet het bestuursorgaan daarvan onverwijld mededeling aan die rechtbanken.')
                      , ('Indien het bestuursorgaan ingevolge [133]artikel 7:1a, vijfde of zesde lid, verschillende bezwaarschriften doorzendt, zendt het bestuursorgaan deze door aan de rechtbank die ingevolge de tweede volzin van het eerste par de zaak zal behandelen.')
                      , ('De Afdeling bestuursrechtspraak van de Raad van State onderscheidenlijk de Centrale Raad van Beroep oordelen in hoogste ressort over geschillen tussen de rechtbanken over de toepassing van [134]artikel 8:7 in zaken tot de kennisneming waarvan zij in hoger beroep bevoegd zijn.')
                      , ('De zaken die bij de rechtbank aanhangig worden gemaakt, worden in behandeling genomen door een enkelvoudige kamer.')
                      , ('Indien een zaak naar het oordeel van de enkelvoudige kamer ongeschikt is voor behandeling door één rechter, verwijst zij deze naar een meervoudige kamer. De enkelvoudige kamer kan ook in andere gevallen een zaak naar een meervoudige kamer verwijzen.')
                      , ('Indien een zaak naar het oordeel van de meervoudige kamer geschikt is voor verdere behandeling door één rechter, kan zij deze verwijzen naar een enkelvoudige kamer.')
                      , ('Verwijzing kan geschieden in elke stand van het geding. Een verwezen zaak wordt voortgezet in de stand waarin zij zich bevindt.')
                      , ('De voorschriften omtrent de behandeling van het beroep zijn op de behandeling zowel door een enkelvoudige als door een meervoudige kamer van toepassing.')
                      , ('Degene die zitting heeft in een enkelvoudige kamer heeft tevens de bevoegdheden en de verplichtingen die de voorzitter van een meervoudige kamer heeft.')
                      , ('De rechtbank kan aan een rechter-commissaris opdragen het vooronderzoek of een gedeelte daarvan te verrichten.')
                      , ('De rechtbank kan een bij haar aanhangig gemaakte zaak ter verdere behandeling verwijzen naar de rechtbank waar een andere zaak aanhangig is gemaakt, indien naar haar oordeel behandeling van die zaken door één rechtbank gewenst is. Zij kan een bij haar aanhangig gemaakte zaak ter verdere behandeling verwijzen naar een andere rechtbank, indien naar haar oordeel door betrokkenheid van de rechtbank behandeling van die zaak door een andere rechtbank gewenst is.')
                      , ('Een verzoek tot verwijzing kan worden gedaan tot de aanvang van het onderzoek ter zitting.')
                      , ('Indien de rechtbank waarnaar een zaak is verwezen, instemt met de verwijzing, worden de op de zaak betrekking hebbende stukken aan haar toegezonden.')
                      , ('De rechtbank kan zaken over hetzelfde of een verwant onderwerp ter behandeling voegen en de behandeling van gevoegde zaken splitsen.')
                      , ('Een verzoek daartoe kan worden gedaan tot de sluiting van het onderzoek ter zitting.')
                      , ('Op verzoek van een partij kan elk van de rechters die een zaak behandelen, worden gewraakt op grond van feiten of omstandigheden waardoor de rechterlijke onpartijdigheid schade zou kunnen lijden.')
                      , ('Het verzoek wordt gedaan zodra de feiten of omstandigheden aan de verzoeker bekend zijn geworden.')
                      , ('Het verzoek geschiedt schriftelijk en is gemotiveerd. Na de aanvang van het onderzoek ter zitting onderscheidenlijk na de aanvang van het horen van partijen of getuigen in het vooronderzoek kan het ook mondeling geschieden.')
                      , ('Alle feiten of omstandigheden moeten tegelijk worden voorgedragen.')
                      , ('Een volgend verzoek om wraking van dezelfde rechter wordt niet in behandeling genomen, tenzij feiten of omstandigheden worden voorgedragen die pas na het eerdere verzoek aan de verzoeker bekend zijn geworden.')
                      , ('Geschiedt het verzoek ter zitting, dan wordt het onderzoek ter zitting geschorst.')
                      , ('Een rechter wiens wraking is verzocht, kan in de wraking berusten.')
                      , ('Het verzoek om wraking wordt zo spoedig mogelijk ter zitting behandeld door een meervoudige kamer waarin de rechter wiens wraking is verzocht, geen zitting heeft.')
                      , ('De verzoeker en de rechter wiens wraking is verzocht, worden in de gelegenheid gesteld te worden gehoord. De rechtbank kan ambtshalve of op verzoek van de verzoeker of de rechter wiens wraking is verzocht, bepalen dat zij niet in elkaars aanwezigheid zullen worden gehoord.')
                      , ('De rechtbank beslist zo spoedig mogelijk. De rechtbank spreekt de beslissing in het openbaar uit. De beslissing is gemotiveerd en wordt onverwijld aan de verzoeker, de andere partijen en de rechter wiens wraking was verzocht medegedeeld.')
                      , ('In geval van misbruik kan de rechtbank bepalen dat een volgend verzoek niet in behandeling wordt genomen. Hiervan wordt in de beslissing melding gemaakt.')
                      , ('Tegen de beslissing staat geen rechtsmiddel open.')
                      , ('Op grond van feiten of omstandigheden als bedoeld in [135]artikel 8:15 kan elk van de rechters die een zaak behandelen, verzoeken zich te mogen verschonen.')
                      , ('Het verzoek geschiedt schriftelijk en is gemotiveerd. Na de aanvang van het onderzoek ter zitting, onderscheidenlijk na de aanvang van het horen van partijen of getuigen in het vooronderzoek kan het ook mondeling geschieden.')
                      , ('Het verzoek om verschoning wordt zo spoedig mogelijk behandeld door een meervoudige kamer waarin de rechter die om verschoning heeft verzocht, geen zitting heeft.')
                      , ('De rechtbank beslist zo spoedig mogelijk. De beslissing is gemotiveerd en wordt onverwijld aan partijen en de rechter die om verschoning had verzocht medegedeeld.')
                      , ('Natuurlijke personen, onbekwaam om in rechte te staan, worden in het geding vertegenwoordigd door hun vertegenwoordigers naar burgerlijk recht. De wettelijke vertegenwoordiger behoeft niet de machtiging van de kantonrechter, bedoeld in artikel 349 van Boek 1 van het Burgerlijk Wetboek.')
                      , ('De in het eerste par bedoelde personen kunnen zelf in het geding optreden, indien zij tot redelijke waardering van hun belangen in staat kunnen worden geacht.')
                      , ('Indien geen wettelijke vertegenwoordiger aanwezig is, of deze niet beschikbaar is en de zaak spoedeisend is, kan de rechtbank een voorlopige vertegenwoordiger benoemen. De benoeming vervalt zodra een wettelijke vertegenwoordiger aanwezig is of de wettelijke vertegenwoordiger weer beschikbaar is.')
                      , ('In geval van faillissement of surséance van betaling of toepassing van de schuldsaneringsregeling natuurlijke personen zijn de artikelen 25, 27 en 31 van de Faillissementswet van overeenkomstige toepassing.')
                      , ('De artikelen 25, tweede lid, en 27 vinden geen toepassing, indien partijen vóór de faillietverklaring zijn uitgenodigd om op een zitting van de rechtbank te verschijnen.')
                      , ('Een bestuursorgaan dat een college is, wordt in het geding vertegenwoordigd door een of meer door het bestuursorgaan aangewezen leden.')
                      , ('De Kroon wordt in het geding vertegenwoordigd door Onze Minister wie het aangaat onderscheidenlijk door een of meer van Onze Ministers wie het aangaat.')
                      , ('Partijen kunnen zich laten bijstaan of door een gemachtigde laten vertegenwoordigen.')
                      , ('De rechtbank kan van een gemachtigde een schriftelijke machtiging verlangen.')
                      , ('Het tweede par is niet van toepassing ten aanzien van advocaten.')
                      , ('De rechtbank kan bijstand of vertegenwoordiging door een persoon tegen wie ernstige bezwaren bestaan, weigeren.')
                      , ('De betrokken partij en de in het eerste par bedoelde persoon worden onverwijld in kennis gesteld van de weigering en de reden daarvoor.')
                      , ('De rechtbank kan tot de sluiting van het onderzoek ter zitting ambtshalve, op verzoek van een partij of op hun eigen verzoek, belanghebbenden in de gelegenheid stellen als partij aan het geding deel te nemen.')
                      , ('Indien de rechtbank vermoedt dat er onbekende belanghebbenden zijn, kan zij in de Staatscourant doen aankondigen dat een zaak bij haar aanhangig is. Naast de aankondiging in de Staatscourant kan ook een ander middel voor de aankondiging worden gebruikt.')
                      , ('Partijen die door de rechtbank zijn opgeroepen om in persoon dan wel in persoon of bij gemachtigde te verschijnen, al dan niet voor het geven van inlichtingen, zijn verplicht te verschijnen en de verlangde inlichtingen te geven. Partijen worden hierop gewezen, alsmede op [136]artikel 8:31.')
                      , ('Indien het een rechtspersoon betreft of een bestuursorgaan dat een college is, kan de rechtbank een of meer bepaalde bestuurders onderscheidenlijk een of meer bepaalde leden oproepen.')
                      , ('Partijen aan wie door de rechtbank is verzocht schriftelijk inlichtingen te geven, zijn verplicht de verlangde inlichtingen te geven. Partijen worden hierop gewezen, alsmede op [137]artikel 8:31.')
                      , ('Partijen die verplicht zijn inlichtingen te geven dan wel stukken over te leggen, kunnen, indien daarvoor gewichtige redenen zijn, het geven van inlichtingen dan wel het overleggen van stukken weigeren of de rechtbank mededelen dat uitsluitend zij kennis zal mogen nemen van de inlichtingen onderscheidenlijk de stukken.')
                      , ('Gewichtige redenen zijn voor een bestuursorgaan in ieder geval niet aanwezig, voor zover ingevolge de Wet openbaarheid van bestuur de verplichting zou bestaan een verzoek om informatie, vervat in de over te leggen stukken, in te willigen.')
                      , ('De rechtbank beslist of de in het eerste par bedoelde weigering onderscheidenlijk de beperking van de kennisneming gerechtvaardigd is.')
                      , ('Indien de rechtbank heeft beslist dat de weigering gerechtvaardigd is, vervalt de verplichting.')
                      , ('Indien de rechtbank heeft beslist dat de beperking van de kennisneming gerechtvaardigd is, kan zij slechts met toestemming van de andere partijen mede op de grondslag van die inlichtingen onderscheidenlijk die stukken uitspraak doen. Indien de toestemming wordt geweigerd, wordt de zaak verwezen naar een andere kamer.')
                      , ('Partijen zijn verplicht mee te werken aan een onderzoek als bedoeld in [138]artikel 8:47, eerste lid. Partijen worden hierop gewezen, alsmede op [139]artikel 8:31.')
                      , ('Indien een partij niet voldoet aan de verplichting te verschijnen, inlichtingen te geven, stukken over te leggen of mee te werken aan een onderzoek als bedoeld in [140]artikel 8:47, eerste lid, kan de rechtbank daaruit de gevolgtrekkingen maken die haar geraden voorkomen.')
                      , ('De rechtbank kan, indien de vrees bestaat dat kennisneming van stukken door een partij haar lichamelijke of geestelijke gezondheid zou schaden, bepalen dat deze kennisneming is voorbehouden aan een gemachtigde die advocaat of arts is dan wel daarvoor van de rechtbank bijzondere toestemming heeft gekregen.')
                      , ('De rechtbank kan, indien kennisneming van stukken door een partij de persoonlijke levenssfeer van een ander onevenredig zou schaden, bepalen dat deze kennisneming is voorbehouden aan een gemachtigde die advocaat of arts is dan wel daarvoor van de rechtbank bijzondere toestemming heeft gekregen.')
                      , ('Ieder die door de rechtbank als getuige wordt opgeroepen, is verplicht aan de oproeping gevolg te geven en getuigenis af te leggen.')
                      , ('In de oproeping worden vermeld de plaats en het tijdstip waarop de getuige zal worden gehoord, de feiten waarop het horen betrekking zal hebben en de gevolgen die zijn verbonden aan het niet verschijnen.')
                      , ('De artikelen 165, tweede en derde lid, 172, 173, eerste lid, eerste volzin, tweede en derde lid, 174, eerste lid, 175, 176, eerste en derde lid, 177, eerste par en 178 van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing')
                      , ('De rechtbank kan bepalen dat getuigen niet zullen worden gehoord dan na het afleggen van de eed of de belofte. Zij leggen in dat geval de eed of de belofte af dat zij zullen zeggen de gehele waarheid en niets dan de waarheid.')
                      , ('De deskundige die zijn benoeming heeft aanvaard, is verplicht zijn opdracht onpartijdig en naar beste weten te vervullen.')
                      , ('Article 165, tweede lid, onderdeel b, en derde lid, van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('De tolk die zijn benoeming heeft aanvaard en die door de rechtbank wordt opgeroepen, is verplicht aan de oproeping gevolg te geven en zijn opdracht onpartijdig en naar beste weten te vervullen. De artikelen 172 en 178 van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing.')
                      , ('In de oproeping worden vermeld de plaats en het tijdstip waarop de opdracht moet worden vervuld en de gevolgen die zijn verbonden aan het niet verschijnen.')
                      , ('Aan de door de rechtbank opgeroepen getuigen, deskundigen en tolken en de deskundigen die een onderzoek als bedoeld in [141]artikel 8:47, eerste lid, hebben ingesteld, wordt ten laste van het Rijk een vergoeding toegekend. Het bij en krachtens de Wet tarieven in strafzaken bepaalde is van overeenkomstige toepassing.')
                      , ('De partij die een getuige of deskundige heeft meegebracht of opgeroepen, dan wel aan wie een verslag van een deskundige is uitgebracht, is aan deze een vergoeding verschuldigd. Het bij en krachtens de Wet tarieven in strafzaken bepaalde is van overeenkomstige toepassing.')
                      , ('Oproepingen, de uitnodiging om op een zitting van de rechtbank te verschijnen, alsmede de verzending van een afschrift van de uitspraak en van het proces-verbaal van de mondelinge uitspraak geschieden door de griffier bij aangetekende brief of bij brief met ontvangstbevestiging, tenzij de rechtbank anders bepaalt.')
                      , ('Voor het overige geschiedt de verzending van stukken door de griffier bij gewone brief, tenzij de rechtbank anders bepaalt.')
                      , ('In een brief wordt de datum van verzending vermeld.')
                      , ('Indien de griffier een bij aangetekende brief of bij brief met ontvangstbevestiging verzonden stuk terug ontvangt en hem blijkt dat de geadresseerde op de dag van verzending of uiterlijk een week daarna in de gemeentelijke basisadministratie persoonsgegevens stond ingeschreven op het op het stuk vermelde adres, dan verzendt hij het stuk zo spoedig mogelijk bij gewone brief.')
                      , ('In de overige gevallen waarin de griffier een bij aangetekende brief of bij brief met ontvangstbevestiging verzonden stuk terug ontvangt, verbetert hij, indien mogelijk, het op het stuk vermelde adres en verzendt hij het stuk opnieuw bij aangetekende brief of bij brief met ontvangstbevestiging.')
                      , ('De griffier zendt de op de zaak betrekking hebbende stukken zo spoedig mogelijk aan partijen, voor zover de rechtbank niet op grond van de [142]artikelen 8:29 of [143]8:32 anders heeft beslist.')
                      , ('De griffier kan de toezending van zeer omvangrijke stukken of van stukken die bezwaarlijk kunnen worden vermenigvuldigd, achterwege laten. Hij stelt partijen daarvan in kennis en vermeldt daarbij dat deze stukken gedurende een door hem te bepalen termijn van ten minste een week ter griffie ter inzage worden gelegd.')
                      , ('Partijen kunnen afschriften van of uittreksels uit de in het tweede par bedoelde stukken verkrijgen. Met betrekking tot de kosten is het bij en krachtens de Wet tarieven in strafzaken bepaalde van overeenkomstige toepassing.')
                      , ('Indien het beroepschrift is ingediend door twee of meer personen, kan worden volstaan met verzending van de oproeping, de uitnodiging om op een zitting van de rechtbank te verschijnen, de op de zaak betrekking hebbende stukken en een afschrift van de uitspraak of van het proces-verbaal van de mondelinge uitspraak aan de persoon die als eerste in het beroepschrift is vermeld.')
                      , ('Van de indiener van het beroepschrift wordt door de griffier een griffierecht geheven. Indien het een beroepschrift ter zake van twee of meer samenhangende besluiten of van twee of meer indieners ter zake van hetzelfde besluit betreft, is eenmaal griffierecht verschuldigd. In die gevallen bedraagt het griffierecht het hoogste op grond van het derde par ter zake van een van de besluiten onderscheidenlijk door een van de indieners verschuldigde bedrag.')
                      , ('De griffier wijst de indiener van het beroepschrift op de verschuldigdheid van het griffierecht en deelt hem mee dat het verschuldigde bedrag binnen vier weken na de dag van verzending van zijn mededeling dient te zijn bijgeschreven op de rekening van de rechtbank dan wel ter griffie dient te zijn gestort. Indien het bedrag niet binnen deze termijn is bijgeschreven of gestort, wordt het beroep niet-ontvankelijk verklaard, tenzij redelijkerwijs niet kan worden geoordeeld dat de indiener in verzuim is geweest.')
                      , ('Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 1°. een besluit, genomen op grond van een wettelijk voorschrift dat is opgenomen in de onderdelen B en C, onder 1 tot en met 25, 29 en 33, dit laatste voor zover het een besluit betreft dat is genomen op grond van artikel 30d van de Wet structuur uitvoeringsorganisatie werk en inkomen, van de bijlage die bij de Beroepswet behoort.')
                      , ('Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 2°. een besluit inzake een uitkering bij werkloosheid of ziekte, genomen ten aanzien van een ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig of een dienstplichtige als bedoeld in hoofdstuk 2 van de Kaderwet dienstplicht als zodanig, hun nagelaten betrekkingen of hun rechtverkrijgenden.')
                      , ('Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 3°. een besluit inzake een uitkering op grond van blijvende arbeidsongeschiktheid op grond van een wettelijk voorschrift waarbij de natuurlijke persoon ter zake van zijn arbeidsongeschiktheid vanwege het Rijk invaliditeitspensioen is verzekerd of een besluit, genomen op grond van artikel P 9 van de Algemene burgerlijke pensioenwet.')
                      , ('Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 4e een besluit genomen op grond van de Wet op de huurtoeslag.')
                      , ('Het griffierecht bedraagt: b. EUR 150 indien door een natuurlijke persoon beroep is ingesteld tegen een ander besluit dan een besluit als bedoeld in onderdeel a, tenzij bij wet anders is bepaald.')
                      , ('Het griffierecht bedraagt: c. EUR 297 indien anders dan door een natuurlijke persoon beroep is ingesteld.')
                      , ('Indien het beroep wordt ingetrokken omdat het bestuursorgaan geheel of gedeeltelijk aan de indiener van het beroepschrift is tegemoetgekomen, wordt het door de indiener betaalde griffierecht aan hem vergoed door de desbetreffende rechtspersoon. In de overige gevallen kan de desbetreffende rechtspersoon, indien het beroep wordt ingetrokken, het betaalde griffierecht geheel of gedeeltelijk vergoeden.')
                      , ('De in het derde par genoemde bedragen kunnen bij algemene maatregel van bestuur worden gewijzigd voor zover de consumentenprijsindex daartoe aanleiding geeft.')
                      , ('Binnen vier weken na de dag van verzending van het beroepschrift aan het bestuursorgaan zendt dit de op de zaak betrekking hebbende stukken aan de rechtbank en dient het een verweerschrift in.')
                      , ('De rechtbank kan de in het eerste par bedoelde termijn verlengen.')
                      , ('De rechtbank kan de indiener van het beroepschrift in de gelegenheid stellen schriftelijk te repliceren. In dat geval wordt het bestuursorgaan in de gelegenheid gesteld schriftelijk te dupliceren. De rechtbank stelt de termijnen voor repliek en dupliek vast.')
                      , ('De rechtbank stelt andere partijen dan de in het eerste par bedoelde in de gelegenheid om ten minste eenmaal een schriftelijke uiteenzetting over de zaak te geven. Zij stelt hiervoor een termijn vast.')
                      , ('De rechtbank kan partijen oproepen om in persoon dan wel in persoon of bij gemachtigde te verschijnen om te worden gehoord, al dan niet voor het geven van inlichtingen. Indien niet alle partijen worden opgeroepen, worden de niet opgeroepen partijen in de gelegenheid gesteld het horen bij te wonen en een uiteenzetting over de zaak te geven.')
                      , ('Van het geven van inlichtingen wordt door de griffier een proces-verbaal opgemaakt.')
                      , ('Het wordt door de voorzitter van de meervoudige kamer en de griffier ondertekend. Bij verhindering van de voorzitter of de griffier wordt dit in het proces-verbaal vermeld.')
                      , ('De rechtbank kan partijen en anderen verzoeken binnen een door haar te bepalen termijn schriftelijk inlichtingen te geven en onder hen berustende stukken in te zenden.')
                      , ('Bestuursorganen zijn, ook als zij geen partij zijn, verplicht aan het verzoek, bedoeld in het eerste lid, te voldoen. [144]Artikel 8:29 is van overeenkomstige toepassing.')
                      , ('Werkgevers van partijen zijn, ook als zij geen partij zijn, verplicht aan het verzoek, bedoeld in het eerste lid, te voldoen. [145]Artikel 8:29 is van overeenkomstige toepassing.')
                      , ('De rechtbank kan getuigen oproepen.')
                      , ('De rechtbank deelt de namen en woonplaatsen van de getuigen, de plaats en het tijdstip waarop dezen zullen worden gehoord en de feiten waarop het horen betrekking zal hebben, ten minste een week tevoren aan partijen mee.')
                      , ('De artikelen 179, eerste, tweede en derde lid, eerste volzin, en 180, eerste tot en met derde en vijfde lid, van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing.')
                      , ('De rechtbank kan een deskundige benoemen voor het instellen van een onderzoek.')
                      , ('Bij de benoeming worden vermeld de opdracht die moet worden vervuld en de termijn, bedoeld in het vierde lid.')
                      , ('Van het voornemen tot het benoemen van een deskundige als bedoeld in het eerste par wordt aan partijen mededeling gedaan. De rechtbank kan partijen in de gelegenheid stellen om hun wensen omtrent het onderzoek binnen een door haar te bepalen termijn schriftelijk aan haar kenbaar te maken.')
                      , ('De rechtbank stelt een termijn binnen welke de deskundige aan haar een schriftelijk verslag van het onderzoek uitbrengt.')
                      , ('Partijen kunnen binnen vier weken na de dag van verzending van het verslag aan hen schriftelijk hun zienswijze met betrekking tot het verslag naar voren brengen.')
                      , ('De rechtbank kan de in het vijfde par bedoelde termijn verlengen.')
                      , ('De arts die voor het instellen van een onderzoek als bedoeld in [146]artikel 8:47, eerste lid, een persoon moet onderzoeken, kan de voor het onderzoek van belang zijnde inlichtingen over deze persoon inwinnen bij de behandelend arts of de behandelende artsen, de verzekeringsarts en de adviserend arts van het bestuursorgaan.')
                      , ('Zij verstrekken de gevraagde inlichtingen voor zover daardoor de persoonlijke levenssfeer van de betrokken persoon niet onevenredig wordt geschaad.')
                      , ('De rechtbank kan tolken benoemen.')
                      , ('De rechtbank kan een onderzoek ter plaatse instellen. Zij heeft daarbij toegang tot elke plaats voor zover dat redelijkerwijs voor de vervulling van haar taak nodig is.')
                      , ('Bestuursorganen verlenen de medewerking die in het belang van het onderzoek is vereist.')
                      , ('Van plaats en tijdstip van het onderzoek wordt aan partijen mededeling gedaan. Zij kunnen bij het onderzoek aanwezig zijn.')
                      , ('Van het onderzoek wordt door de griffier een proces-verbaal opgemaakt.')
                      , ('De rechtbank kan aan een door haar aangewezen gerechtsauditeur of aan de griffier opdragen een onderzoek ter plaatse in te stellen. Deze heeft daarbij toegang tot elke plaats voor zover dat redelijkerwijs voor de vervulling van de hem opgedragen taak nodig is. De rechtbank is bevoegd tot het geven van een machtiging tot binnentreden.')
                      , ('[147]Artikel 8:50, tweede en derde lid, is van overeenkomstige toepassing.')
                      , ('Van het onderzoek wordt door de gerechtsauditeur of de griffier een proces-verbaal opgemaakt, dat door hem wordt ondertekend.')
                      , ('De rechtbank kan, indien de zaak spoedeisend is, bepalen dat deze versneld wordt behandeld.')
                      , ('In dat geval kan de rechtbank: a. de in [148]artikel 8:41, tweede lid, bedoelde termijn verkorten.')
                      , ('In dat geval kan de rechtbank: b. de in [149]artikel 8:42, eerste lid, bedoelde termijn verkorten.')
                      , ('In dat geval kan de rechtbank: c. [150]artikel 8:43, tweede lid, geheel of gedeeltelijk buiten toepassing laten.')
                      , ('In dat geval kan de rechtbank: d. [151]artikel 8:47, derde lid, geheel of gedeeltelijk buiten toepassing laten.')
                      , ('In dat geval kan de rechtbank: e. de in [152]artikel 8:47, vijfde lid, bedoelde termijn verkorten.')
                      , ('Indien de rechtbank bepaalt dat de zaak versneld wordt behandeld, bepaalt zij tevens zo spoedig mogelijk het tijdstip waarop de zitting zal plaatsvinden en doet zij daarvan onverwijld mededeling aan partijen. [153]Artikel 8:56 is niet van toepassing.')
                      , ('Blijkt aan de rechtbank bij de behandeling dat de zaak niet voldoende spoedeisend is om een versnelde behandeling te rechtvaardigen of dat de zaak een gewone behandeling vordert, dan bepaalt zij dat de zaak verder op de gewone wijze wordt behandeld.')
                      , ('Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: a. zij kennelijk onbevoegd is.')
                      , ('Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: b. het beroep kennelijk niet-ontvankelijk is.')
                      , ('Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: c. het beroep kennelijk ongegrond is.')
                      , ('Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: d. het beroep kennelijk gegrond is.')
                      , ('In de uitspraak na toepassing van het eerste par worden partijen gewezen op [154]artikel 8:55, eerste lid.')
                      , ('Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat het bestuursorgaan kennelijk ten onrechte heeft ingestemd met rechtstreeks beroep bij de rechtbank.')
                      , ('In dat geval strekt de uitspraak ertoe dat het bestuursorgaan het beroepschrift als bezwaarschrift behandelt. [155]Artikel 7:10 is van overeenkomstige toepassing.')
                      , ('Tegen de uitspraak, bedoeld in [156]artikel 8:54, tweede lid, kunnen een belanghebbende en het bestuursorgaan verzet doen bij de rechtbank. De indiener van het verzetschrift kan daarbij vragen in de gelegenheid te worden gesteld over het verzet te worden gehoord. De [157]artikelen 6:4, derde lid, [158]6:5 tot en met 6:9, [159]6:11, [160]6:14, [161]6:15, [162]6:17 en [163]6:21 zijn van overeenkomstige toepassing.')
                      , ('Indien bij wet de werking van een uitspraak wordt opgeschort totdat de termijn voor het instellen van hoger beroep is verstreken of, indien hoger beroep is ingesteld, op het hoger beroep is beslist, wordt de werking van de uitspraak, bedoeld in [164]artikel 8:54, tweede lid, op overeenkomstige wijze opgeschort.')
                      , ('Alvorens uitspraak te doen op het verzet, stelt de rechtbank de indiener van het verzetschrift die daarom heeft gevraagd, in de gelegenheid op een zitting te worden gehoord, tenzij zij van oordeel is dat het verzet gegrond is. Indien de indiener van het verzetschrift daarom niet heeft gevraagd, kan de rechtbank hem in de gelegenheid stellen op een zitting te worden gehoord.')
                      , ('Indien de uitspraak waartegen verzet is gedaan, is gedaan door een meervoudige kamer, wordt uitspraak op het verzet gedaan door een meervoudige kamer. Van de kamer die uitspraak doet op het verzet maakt geen deel uit degene die zitting heeft gehad in de kamer die de uitspraak heeft gedaan waartegen verzet is gedaan.')
                      , ('De uitspraak strekt tot: a. niet-ontvankelijkverklaring van het verzet.')
                      , ('De uitspraak strekt tot: b. ongegrondverklaring van het verzet.')
                      , ('De uitspraak strekt tot: c. gegrondverklaring van het verzet.')
                      , ('Indien de rechtbank het verzet niet-ontvankelijk of ongegrond verklaart, blijft de uitspraak waartegen verzet was gedaan in stand.')
                      , ('Indien de rechtbank het verzet gegrond verklaart, vervalt de uitspraak waartegen verzet was gedaan en wordt het onderzoek voortgezet in de stand waarin het zich bevond.')
                      , ('Na afloop van het vooronderzoek worden partijen ten minste drie weken tevoren uitgenodigd om op een in de uitnodiging te vermelden plaats en tijdstip op een zitting van de rechtbank te verschijnen.')
                      , ('Indien partijen daarvoor toestemming hebben gegeven, kan de rechtbank bepalen dat het onderzoek ter zitting achterwege blijft. In dat geval sluit de rechtbank het onderzoek.')
                      , ('Tot tien dagen voor de zitting kunnen partijen nadere stukken indienen.')
                      , ('Op deze bevoegdheid worden partijen in de uitnodiging, bedoeld in [165]artikel 8:56, gewezen.')
                      , ('De rechtbank kan een partij oproepen om in persoon dan wel in persoon of bij gemachtigde te verschijnen, al dan niet voor het geven van inlichtingen.')
                      , ('De rechtbank kan getuigen oproepen en deskundigen en tolken benoemen.')
                      , ('De opgeroepen getuige en de deskundige of de tolk die zijn benoeming heeft aanvaard en door de rechtbank wordt opgeroepen, zijn verplicht aan de oproeping gevolg te geven. De artikelen 172 en 178 van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing. In de oproeping van de deskundige worden vermeld de opdracht die moet worden vervuld, de plaats en het tijdstip waarop de opdracht moet worden vervuld en de gevolgen die zijn verbonden aan het niet verschijnen.')
                      , ('Namen en woonplaatsen van de opgeroepen getuigen en deskundigen en de feiten waarop het horen betrekking zal hebben onderscheidenlijk de opdracht die moet worden vervuld, worden bij de uitnodiging, bedoeld in [166]artikel 8:56, aan partijen zoveel mogelijk medegedeeld.')
                      , ('Partijen kunnen getuigen en deskundigen meebrengen of bij aangetekende brief of deurwaardersexploit oproepen, mits daarvan uiterlijk een week voor de dag van de zitting aan de rechtbank en aan de andere partijen mededeling is gedaan, met vermelding van namen en woonplaatsen. Op deze bevoegdheid worden partijen in de uitnodiging, bedoeld in [167]artikel 8:56, gewezen.')
                      , ('De voorzitter van de meervoudige kamer heeft de leiding van de zitting.')
                      , ('De griffier houdt aantekening van het verhandelde ter zitting.')
                      , ('De griffier maakt een proces-verbaal op van de zitting, indien de rechtbank dit ambtshalve of op verzoek van een partij die daarbij belang heeft, bepaalt en indien hoger beroep wordt ingesteld.')
                      , ('Het bevat de namen van de rechter of de rechters die de zaak behandelt onderscheidenlijk behandelen, die van partijen en van hun vertegenwoordigers of gemachtigden die op de zitting zijn verschenen en van degenen die hen hebben bijgestaan, en die van de getuigen, deskundigen en tolken die op de zitting zijn verschenen.')
                      , ('Het houdt een vermelding in van hetgeen op de zitting met betrekking tot de zaak is voorgevallen.')
                      , ('Aan het proces-verbaal kunnen overgelegde pleitnotities worden gehecht.')
                      , ('De rechtbank kan bepalen dat de verklaring van een partij, getuige of deskundige geheel in het proces-verbaal zal worden opgenomen. In dat geval wordt de verklaring onverwijld op schrift gesteld en aan de partij, getuige of deskundige voorgelezen. Deze mag daarin wijzigingen aanbrengen, die op schrift worden gesteld en aan de partij, getuige of deskundige worden voorgelezen. De verklaring wordt door de partij, getuige of deskundige ondertekend. Heeft ondertekening niet plaats, dan wordt de reden daarvan in het proces-verbaal vermeld.')
                      , ('De zitting is openbaar.')
                      , ('De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: a. in het belang van de openbare orde of de goede zeden.')
                      , ('De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: b. in het belang van de veiligheid van de Staat.')
                      , ('De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: c. indien de belangen van minderjarigen of de eerbiediging van de persoonlijke levenssfeer van partijen dit eisen.')
                      , ('De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: d. indien openbaarheid het belang van een goede rechtspleging ernstig zou schaden.')
                      , ('Op het horen van getuigen en deskundigen is artikel 179, tweede en derde lid, eerste volzin, van het Wetboek van Burgerlijke Rechtsvordering van overeenkomstige toepassing. Op het horen van getuigen is artikel 179, eerste lid, van het Wetboek van Burgerlijke Rechtsvordering van overeenkomstige toepassing.')
                      , ('De rechtbank kan afzien van het horen van door een partij meegebrachte of opgeroepen getuigen en deskundigen indien zij van oordeel is dat dit redelijkerwijs niet kan bijdragen aan de beoordeling van de zaak.')
                      , ('Indien een door een partij opgeroepen getuige of deskundige niet is verschenen, kan de rechtbank deze oproepen. In dat geval schorst de rechtbank het onderzoek ter zitting.')
                      , ('De rechtbank kan het onderzoek ter zitting schorsen. Zij kan daarbij bepalen dat het vooronderzoek wordt hervat.')
                      , ('Indien bij de schorsing geen tijdstip van de nadere zitting is bepaald, bepaalt de rechtbank dit zo spoedig mogelijk. De griffier doet zo spoedig mogelijk mededeling aan partijen van het tijdstip van de nadere zitting.')
                      , ('In de gevallen waarin schorsing van het onderzoek ter zitting heeft plaatsgevonden, wordt de zaak op de nadere zitting hervat in de stand waarin zij zich bevond.')
                      , ('De rechtbank kan bepalen dat het onderzoek ter zitting opnieuw wordt aangevangen.')
                      , ('Indien partijen daarvoor toestemming hebben gegeven, kan de rechtbank bepalen dat de nadere zitting achterwege blijft. In dat geval sluit de rechtbank het onderzoek.')
                      , ('De rechtbank sluit het onderzoek ter zitting, wanneer zij van oordeel is dat het is voltooid.')
                      , ('Voordat het onderzoek ter zitting wordt gesloten, hebben partijen het recht voor het laatst het woord te voeren.')
                      , ('Zodra het onderzoek ter zitting is gesloten, deelt de voorzitter mee wanneer uitspraak zal worden gedaan.')
                      , ('Tenzij mondeling uitspraak wordt gedaan, doet de rechtbank binnen zes weken na de sluiting van het onderzoek schriftelijk uitspraak.')
                      , ('In bijzondere omstandigheden kan de rechtbank deze termijn met ten hoogste zes weken verlengen.')
                      , ('Van deze verlenging wordt aan partijen mededeling gedaan.')
                      , ('De rechtbank kan na de sluiting van het onderzoek ter zitting onmiddellijk mondeling uitspraak doen. De uitspraak kan voor ten hoogste een week worden verdaagd onder aanzegging aan partijen van het tijdstip van de uitspraak.')
                      , ('De mondelinge uitspraak bestaat uit de beslissing en de gronden van de beslissing.')
                      , ('Van de mondelinge uitspraak wordt door de griffier een proces-verbaal opgemaakt.')
                      , ('De rechtbank spreekt de beslissing, bedoeld in het tweede lid, in het openbaar uit, in tegenwoordigheid van de griffier. Daarbij wordt vermeld door wie, binnen welke termijn en bij welke administratieve rechter welk rechtsmiddel kan worden aangewend.')
                      , ('De mededeling, bedoeld in het vijfde lid, tweede volzin, wordt in het proces-verbaal vermeld.')
                      , ('Indien de rechtbank van oordeel is dat het onderzoek niet volledig is geweest, kan zij het heropenen. De rechtbank bepaalt daarbij op welke wijze het onderzoek wordt voortgezet.')
                      , ('De griffier doet zo spoedig mogelijk mededeling daarvan aan partijen.')
                      , ('De rechtbank doet uitspraak op de grondslag van het beroepschrift, de overgelegde stukken, het verhandelde tijdens het vooronderzoek en het onderzoek ter zitting.')
                      , ('De rechtbank vult ambtshalve de rechtsgronden aan.')
                      , ('De rechtbank kan ambtshalve de feiten aanvullen.')
                      , ('De uitspraak strekt tot: a. onbevoegdverklaring van de rechtbank.')
                      , ('De uitspraak strekt tot: b. niet-ontvankelijkverklaring van het beroep.')
                      , ('De uitspraak strekt tot: c. ongegrondverklaring van het beroep.')
                      , ('De uitspraak strekt tot: d. gegrondverklaring van het beroep.')
                      , ('Voor zover uitsluitend een vordering bij de burgerlijke rechter kan worden ingesteld, wordt dit in de uitspraak vermeld. De burgerlijke rechter is aan die beslissing gebonden.')
                      , ('Indien de rechtbank het beroep gegrond verklaart, vernietigt zij het bestreden besluit geheel of gedeeltelijk.')
                      , ('Vernietiging van een besluit of een gedeelte van een besluit brengt vernietiging van de rechtsgevolgen van dat besluit of van het vernietigde gedeelte daarvan mee.')
                      , ('De rechtbank kan bepalen dat de rechtsgevolgen van het vernietigde besluit of het vernietigde gedeelte daarvan geheel of gedeeltelijk in stand blijven.')
                      , ('Indien de rechtbank het beroep gegrond verklaart, kan zij het bestuursorgaan opdragen een nieuw besluit te nemen of een andere handeling te verrichten met inachtneming van haar uitspraak, dan wel kan zij bepalen dat haar uitspraak in de plaats treedt van het vernietigde besluit of het vernietigde gedeelte daarvan.')
                      , ('De rechtbank kan het bestuursorgaan een termijn stellen voor het nemen van een nieuw besluit of het verrichten van een andere handeling, alsmede zo nodig een voorlopige voorziening treffen. In het laatste geval bepaalt de rechtbank het tijdstip waarop de voorlopige voorziening vervalt.')
                      , ('De rechtbank kan bepalen dat een voorlopige voorziening vervalt op een later tijdstip dan het tijdstip waarop zij uitspraak heeft gedaan.')
                      , ('De rechtbank kan bepalen dat, indien of zolang het bestuursorgaan niet voldoet aan een uitspraak, de door haar aangewezen rechtspersoon aan een door haar aangewezen partij een in de uitspraak vast te stellen dwangsom verbeurt. De artikelen 611a tot en met 611i van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing.')
                      , ('Indien de rechtbank het beroep gegrond verklaart, kan zij, indien daarvoor gronden zijn, op verzoek van een partij de door haar aangewezen rechtspersoon veroordelen tot vergoeding van de schade die die partij lijdt.')
                      , ('Indien de rechtbank de omvang van de schadevergoeding bij haar uitspraak niet of niet volledig kan vaststellen, bepaalt zij in haar uitspraak dat ter voorbereiding van een nadere uitspraak daarover het onderzoek wordt heropend. De rechtbank bepaalt daarbij op welke wijze het onderzoek wordt voortgezet.')
                      , ('Ingeval van intrekking van het beroep omdat het bestuursorgaan geheel of gedeeltelijk aan de indiener van het beroepschrift is tegemoetgekomen, kan de rechtbank, op verzoek van de indiener de door haar aangewezen rechtspersoon bij afzonderlijke uitspraak met toepassing van [168]artikel 8:73 veroordelen tot vergoeding van de schade die de verzoeker lijdt. Het verzoek wordt gedaan tegelijk met de intrekking van het beroep. Indien aan dit vereiste niet is voldaan, wordt het verzoek niet-ontvankelijk verklaard.')
                      , ('De rechtbank stelt de verzoeker zo nodig in de gelegenheid het verzoek schriftelijk toe te lichten en stelt het bestuursorgaan in de gelegenheid een verweerschrift in te dienen. Zij stelt hiervoor termijnen vast. Indien het verzoek mondeling wordt gedaan, kan de rechtbank bepalen dat het toelichten van het verzoek en het voeren van verweer onmiddellijk mondeling geschieden.')
                      , ('Indien het toelichten van het verzoek en het voeren van verweer mondeling zijn geschied, sluit de rechtbank het onderzoek. In de overige gevallen zijn de [169]afdelingen 8.2.4 en [170]8.2.5 van overeenkomstige toepassing.')
                      , ('Indien de rechtbank het beroep gegrond verklaart, houdt de uitspraak tevens in dat aan de indiener van het beroepschrift het door hem betaalde griffierecht wordt vergoed door de door de rechtbank aangewezen rechtspersoon.')
                      , ('In de overige gevallen kan de uitspraak inhouden dat het betaalde griffierecht door de door de rechtbank aangewezen rechtspersoon geheel of gedeeltelijk wordt vergoed.')
                      , ('De rechtbank is bij uitsluiting bevoegd een partij te veroordelen in de kosten die een andere partij in verband met de behandeling van het beroep bij de rechtbank, en van het bezwaar of van het administratief beroep redelijkerwijs heeft moeten maken. De [171]artikelen 7:15, tweede tot en met vierde lid, en [172]7:28, tweede lid, eerste volzin, derde en vierde lid, zijn van toepassing. Een natuurlijke persoon kan slechts in de kosten worden veroordeeld in geval van kennelijk onredelijk gebruik van procesrecht. Bij algemene maatregel van bestuur worden nadere regels gesteld over de kosten waarop een veroordeling als bedoeld in de eerste volzin uitsluitend betrekking kan hebben en over de wijze waarop bij de uitspraak het bedrag van de kosten wordt vastgesteld.')
                      , ('In geval van een veroordeling in de kosten ten behoeve van een partij aan wie ter zake van het beroep op de rechtbank, het bezwaar of het administratief beroep een toevoeging is verleend krachtens de Wet op de rechtsbijstand, wordt het bedrag van de kosten betaald aan de griffier. Artikel 243 van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Indien een bestuursorgaan in de kosten wordt veroordeeld, wijst de rechtbank de rechtspersoon aan die de kosten moet vergoeden.')
                      , ('In geval van intrekking van het beroep omdat het bestuursorgaan geheel of gedeeltelijk aan de indiener van het beroepschrift is tegemoetgekomen, kan het bestuursorgaan op verzoek van de indiener bij afzonderlijke uitspraak met toepassing van [173]artikel 8:75 in de kosten worden veroordeeld. Het verzoek wordt gedaan tegelijk met de intrekking van het beroep. Indien aan dit vereiste niet is voldaan, wordt het verzoek niet-ontvankelijk verklaard.')
                      , ('[174]Artikel 8:73a, tweede en derde lid, is van overeenkomstige toepassing.')
                      , ('Voor zover een uitspraak strekt tot betaling van een bepaald geldbedrag kan zij ten uitvoer worden gelegd overeenkomstig de bepalingen van het Tweede Boek van het Wetboek van Burgerlijke Rechtsvordering.')
                      , ('De schriftelijke uitspraak vermeldt: a. de namen van partijen en van hun vertegenwoordigers of gemachtigden, b. de gronden van de beslissing, c. de beslissing, d. de naam van de rechter of de namen van de rechters die de zaak heeft onderscheidenlijk hebben behandeld, e. de dag waarop de beslissing is uitgesproken, en f. door wie, binnen welke termijn en bij welke administratieve rechter welk rechtsmiddel kan worden aangewend.')
                      , ('Indien de uitspraak strekt tot gegrondverklaring van het beroep, wordt in de uitspraak vermeld welke geschreven of ongeschreven rechtsregel of welk algemeen rechtsbeginsel geschonden wordt geoordeeld.')
                      , ('De uitspraak wordt ondertekend door de voorzitter van de meervoudige kamer en de griffier. Bij verhindering van de voorzitter of de griffier wordt dit in de uitspraak vermeld.')
                      , ('De rechtbank spreekt de beslissing, bedoeld in [175]artikel 8:77, eerste lid, onderdeel c, in het openbaar uit, in tegenwoordigheid van de griffier.')
                      , ('Binnen twee weken na de dagtekening van de uitspraak zendt de griffier kosteloos een afschrift van de uitspraak of van het proces-verbaal van de mondelinge uitspraak aan partijen.')
                      , ('Anderen dan partijen kunnen afschriften of uittreksels van de uitspraak of van het proces-verbaal van de mondelinge uitspraak verkrijgen. Met betrekking tot de kosten is het bij en krachtens de Wet tarieven in strafzaken bepaalde van overeenkomstige toepassing.')
                      , ('Indien de rechtbank bepaalt dat haar uitspraak in de plaats treedt van het vernietigde besluit, wordt de uitspraak bovendien overeenkomstig de voor dat besluit voorgeschreven wijze bekendgemaakt door het bevoegde bestuursorgaan.')
                      , ('Indien tegen een besluit bij de rechtbank beroep is ingesteld dan wel, voorafgaand aan een mogelijk beroep bij de rechtbank, bezwaar is gemaakt of administratief beroep is ingesteld, kan de voorzieningenrechter van de rechtbank die bevoegd is of kan worden in de hoofdzaak, op verzoek een voorlopige voorziening treffen indien onverwijlde spoed, gelet op de betrokken belangen, dat vereist.')
                      , ('Indien bij de rechtbank beroep is ingesteld, kan een verzoek om voorlopige voorziening worden gedaan door een partij in de hoofdzaak.')
                      , ('Indien voorafgaand aan een mogelijk beroep bij de rechtbank bezwaar is gemaakt of administratief beroep is ingesteld, kan een verzoek om voorlopige voorziening worden gedaan door de indiener van het bezwaarschrift, onderscheidenlijk door de indiener van het beroepschrift of door de belanghebbende die geen recht heeft tot het instellen van administratief beroep.')
                      , ('De [176]artikelen 6:4, derde lid, [177]6:5, [178]6:6, [179]6:14, [180]6:15, [181]6:17 en [182]6:21 zijn van overeenkomstige toepassing. De indiener van het verzoekschrift die bezwaar heeft gemaakt dan wel beroep heeft ingesteld, legt daarbij een afschrift van het bezwaar- of beroepschrift over.')
                      , ('Indien een verzoek om voorlopige voorziening is gedaan nadat bezwaar is gemaakt of administratief beroep is ingesteld en op dit bezwaar of beroep wordt beslist voordat de zitting heeft plaatsgevonden, wordt de verzoeker in de gelegenheid gesteld beroep bij de rechtbank in te stellen. Het verzoek om voorlopige voorziening wordt gelijkgesteld met een verzoek dat wordt gedaan hangende het beroep bij de rechtbank.')
                      , ('Van de verzoeker wordt door de griffier een griffierecht geheven. [183]Artikel 8:41, eerste lid, tweede en derde volzin, derde en vijfde lid, is van overeenkomstige toepassing.')
                      , ('[184]Artikel 8:41, tweede lid, is van overeenkomstige toepassing, met dien verstande dat de termijn binnen welke de bijschrijving of storting van het verschuldigde bedrag dient plaats te vinden, twee weken bedraagt. De voorzieningenrechter kan een kortere termijn stellen.')
                      , ('Indien een verzoek om opheffing of wijziging is gedaan door het bestuursorgaan of het beroepsorgaan en het verzoek geheel of gedeeltelijk wordt toegewezen, kan de uitspraak inhouden dat het betaalde griffierecht door de griffier aan de desbetreffende rechtspersoon wordt terugbetaald.')
                      , ('De uitspraak kan inhouden dat het betaalde griffierecht door de door de voorzieningenrechter aangewezen rechtspersoon geheel of gedeeltelijk wordt vergoed.')
                      , ('Partijen worden zo spoedig mogelijk uitgenodigd om op een in de uitnodiging te vermelden plaats en tijdstip op een zitting te verschijnen. Binnen een door de voorzieningenrechter te bepalen termijn zendt het bestuursorgaan de op de zaak betrekking hebbende stukken aan hem. [185]Artikel 8:58 is van overeenkomstige toepassing, met dien verstande dat tot één dag voor de zitting nadere stukken kunnen worden ingediend. De [186]artikelen 8:59 tot en met 8:65 zijn van overeenkomstige toepassing, met dien verstande dat getuigen en deskundigen kunnen worden meegebracht of opgeroepen zonder dat de in [187]artikel 8:60, vierde lid, eerste volzin, bedoelde mededeling is gedaan.')
                      , ('Indien administratief beroep is ingesteld, wordt het beroepsorgaan eveneens uitgenodigd om op de zitting te verschijnen. Het beroepsorgaan wordt in de gelegenheid gesteld ter zitting een uiteenzetting over de zaak te geven.')
                      , ('Indien de voorzieningenrechter kennelijk onbevoegd is of het verzoek kennelijk niet-ontvankelijk, kennelijk ongegrond of kennelijk gegrond is, kan de voorzieningenrechter uitspraak doen zonder toepassing van het eerste lid.')
                      , ('Indien onverwijlde spoed dat vereist en partijen daardoor niet in hun belangen worden geschaad, kan de voorzieningenrechter ook in andere gevallen uitspraak doen zonder toepassing van het eerste lid.')
                      , ('De voorzieningenrechter doet zo spoedig mogelijk schriftelijk of mondeling uitspraak.')
                      , ('De uitspraak strekt tot: a. onbevoegdverklaring van de voorzieningenrechter.')
                      , ('De uitspraak strekt tot: b. niet-ontvankelijkverklaring van het verzoek.')
                      , ('De uitspraak strekt tot: c. afwijzing van het verzoek.')
                      , ('De uitspraak strekt tot: d. gehele of gedeeltelijke toewijzing van het verzoek.')
                      , ('De griffier zendt onverwijld een afschrift van de uitspraak of van het proces-verbaal van de mondelinge uitspraak kosteloos aan partijen.')
                      , ('De [188]artikelen 8:67, tweede tot en met vijfde lid, [189]8:68, [190]8:69, [191]8:72, vijfde en zevende lid, [192]8:75, [193]8:75a, [194]8:76, [195]8:77, eerste en derde lid, [196]8:78, [197]8:79, tweede lid, en [198]8:80 zijn van overeenkomstige toepassing.')
                      , ('De voorzieningenrechter kan in zijn uitspraak bepalen wanneer de voorlopige voorziening vervalt.')
                      , ('De voorlopige voorziening vervalt in ieder geval zodra: a. de termijn voor het instellen van beroep bij de rechtbank tegen het besluit dat op bezwaar of in administratief beroep is genomen, ongebruikt is verstreken.')
                      , ('De voorlopige voorziening vervalt in ieder geval zodra: b. het bezwaar of het beroep is ingetrokken.')
                      , ('De voorlopige voorziening vervalt in ieder geval zodra: c. de rechtbank uitspraak heeft gedaan, tenzij bij de uitspraak een later tijdstip is bepaald.')
                      , ('Indien het verzoek wordt gedaan indien beroep bij de rechtbank is ingesteld en de voorzieningenrechter van oordeel is dat na de zitting, bedoeld in [199]artikel 8:83, eerste lid, nader onderzoek redelijkerwijs niet kan bijdragen aan de beoordeling van de zaak, kan hij onmiddellijk uitspraak doen in de hoofdzaak.')
                      , ('Op deze bevoegdheid van de voorzieningenrechter worden partijen in de uitnodiging, bedoeld in [200]artikel 8:83, eerste lid, gewezen.')
                      , ('De voorzieningenrechter kan, ook ambtshalve, een voorlopige voorziening opheffen of wijzigen.')
                      , ('De [201]artikelen 8:81, tweede, derde en vierde lid, en [202]8:82 tot en met [203]8:86 zijn van overeenkomstige toepassing. Indien voorafgaand aan een mogelijk beroep bij de rechtbank bezwaar is gemaakt of administratief beroep is ingesteld, kan een verzoek om opheffing of wijziging eveneens worden gedaan door een belanghebbende die door de voorlopige voorziening rechtstreeks in zijn belang wordt getroffen, door het bestuursorgaan of door het beroepsorgaan.')
                      , ('De rechtbank kan op verzoek van een partij een onherroepelijk geworden uitspraak herzien op grond van feiten of omstandigheden die: a. hebben plaatsgevonden vóór de uitspraak, b. bij de indiener van het verzoekschrift vóór de uitspraak niet bekend waren en redelijkerwijs niet bekend konden zijn, en c. waren zij bij de rechtbank eerder bekend geweest, tot een andere uitspraak zouden hebben kunnen leiden.')
                      , ('[204]Hoofdstuk 6 en de titels 8.2 en 8.3 zijn voor zover nodig van overeenkomstige toepassing.')
                      , ('Een ieder heeft het recht om over de wijze waarop een bestuursorgaan zich in een bepaalde aangelegenheid jegens hem of een ander heeft gedragen, een klacht in te dienen bij dat bestuursorgaan.')
                      , ('Een gedraging van een persoon, werkzaam onder de verantwoordelijkheid van een bestuursorgaan, wordt aangemerkt als een gedraging van dat bestuursorgaan.')
                      , ('Het bestuursorgaan draagt zorg voor een behoorlijke behandeling van mondelinge en schriftelijke klachten over zijn gedragingen en over gedragingen van bestuursorganen die onder zijn verantwoordelijkheid werkzaam zijn.')
                      , ('Tegen een besluit inzake de behandeling van een klacht over een gedraging van een bestuursorgaan kan geen beroep worden ingesteld.')
                      , ('Indien een schriftelijke klacht betrekking heeft op een gedraging jegens de klager en voldoet aan de vereisten van het tweede lid, zijn de [205]artikelen 9:5 tot en met 9:12 van toepassing.')
                      , ('Het klaagschrift wordt ondertekend en bevat ten minste: a. de naam en het adres van de indiener; b. de dagtekening; c. een omschrijving van de gedraging waartegen de klacht is gericht.')
                      , ('[206]Artikel 6:5, derde lid, is van overeenkomstige toepassing.')
                      , ('Zodra het bestuursorgaan naar tevredenheid van de klager aan diens klacht tegemoet is gekomen, vervalt de verplichting tot het verder toepassen van dit hoofdstuk.')
                      , ('Het bestuursorgaan bevestigt de ontvangst van het klaagschrift schriftelijk.')
                      , ('De behandeling van de klacht geschiedt door een persoon die niet bij de gedraging waarop de klacht betrekking heeft, betrokken is geweest.')
                      , ('Het eerste par is niet van toepassing indien de klacht betrekking heeft op een gedraging van het bestuursorgaan zelf dan wel de voorzitter of een par ervan.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: a. waarover reeds eerder een klacht is ingediend die met inachtneming van de [207]artikelen 9:4 en volgende is behandeld.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: b. die langer dan een jaar voor indiening van de klacht heeft plaatsgevonden.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: c. waartegen door de klager bezwaar gemaakt had kunnen worden.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: d. waartegen door de klager beroep kan worden ingesteld, tenzij die gedraging bestaat uit het niet tijdig nemen van een besluit, of beroep kon worden ingesteld.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: e. die door het instellen van een procedure aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen is, dan wel onderworpen is geweest.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: f. zolang terzake daarvan een opsporingsonderzoek op bevel van de officier van justitie of een vervolging gaande is, dan wel indien de gedraging deel uitmaakt van de opsporing of vervolging van een strafbaar feit en terzake van dat feit een opsporingsonderzoek op bevel van de officier van justitie of een vervolging gaande is.')
                      , ('Het bestuursorgaan is niet verplicht de klacht te behandelen indien het belang van de klager dan wel het gewicht van de gedraging kennelijk onvoldoende is.')
                      , ('Van het niet in behandeling nemen van de klacht wordt de klager zo spoedig mogelijk doch uiterlijk binnen vier weken na ontvangst van het klaagschrift schriftelijk in kennis gesteld. [208]Artikel 9:12, tweede lid, is van overeenkomstige toepassing.')
                      , ('Aan degene op wiens gedraging de klacht betrekking heeft, wordt een afschrift van het klaagschrift alsmede van de daarbij meegezonden stukken toegezonden.')
                      , ('Het bestuursorgaan stelt de klager en degene op wiens gedraging de klacht betrekking heeft, in de gelegenheid te worden gehoord.')
                      , ('Van het horen van de klager kan worden afgezien indien de klacht kennelijk ongegrond is dan wel indien de klager heeft verklaard geen gebruik te willen maken van het recht te worden gehoord.')
                      , ('Het bestuursorgaan handelt de klacht af binnen zes weken of ? indien [209]afdeling 9.1.3 van toepassing is ? binnen tien weken na ontvangst van het klaagschrift.')
                      , ('Het bestuursorgaan kan de afhandeling voor ten hoogste vier weken verdagen. Van de verdaging wordt schriftelijk mededeling gedaan aan de klager en aan degene op wiens gedraging de klacht betrekking heeft.')
                      , ('Het bestuursorgaan stelt de klager schriftelijk en gemotiveerd in kennis van de bevindingen van het onderzoek naar de klacht, zijn oordeel daarover alsmede van de eventuele conclusies die het daaraan verbindt.')
                      , ('Bij de kennisgeving wordt vermeld bij welke ombudsman en binnen welke termijn de klager vervolgens een verzoekschrift kan indienen.')
                      , ('Het bestuursorgaan draagt zorg voor registratie van de bij hem ingediende schriftelijke klachten. De geregistreerde klachten worden jaarlijks gepubliceerd.')
                      , ('De in deze afdeling geregelde procedure voor de behandeling van klachten wordt in aanvulling op [210]afdeling 9.1.2 gevolgd indien dat bij wettelijk voorschrift of bij besluit van het bestuursorgaan is bepaald.')
                      , ('Bij wettelijk voorschrift of bij besluit van het bestuursorgaan wordt een persoon of commissie belast met de behandeling van en de advisering over klachten.')
                      , ('Het bestuursorgaan kan de persoon of commissie slechts in het algemeen instructies geven.')
                      , ('Bij het bericht van ontvangst, bedoeld in [211]artikel 9:6, wordt vermeld dat een persoon of commissie over de klacht zal adviseren.')
                      , ('Het horen geschiedt door de in [212]artikel 9:14 bedoelde persoon of commissie. Indien een commissie is ingesteld, kan deze het horen opdragen aan de voorzitter of een par van de commissie.')
                      , ('De persoon of commissie beslist over de toepassing van [213]artikel 9:10, tweede lid.')
                      , ('De persoon of commissie zendt een rapport van bevindingen, vergezeld van het advies en eventuele aanbevelingen, aan het bestuursorgaan. Het rapport bevat het verslag van het horen.')
                      , ('Indien de conclusies van het bestuursorgaan afwijken van het advies, wordt in de conclusies de reden voor die afwijking vermeld en wordt het advies meegezonden met de kennisgeving, bedoeld in [214]artikel 9:12.')
                      , ('Onder ombudsman wordt verstaan: a. de Nationale ombudsman.')
                      , ('Onder ombudsman wordt verstaan: b. een ombudsman of ombudscommissie ingesteld krachtens de Gemeentewet, de Provinciewet, de Waterschapswet of de Wet gemeenschappelijke regelingen.')
                      , ('Een ieder heeft het recht de ombudsman schriftelijk te verzoeken een onderzoek in te stellen naar de wijze waarop een bestuursorgaan zich in een bepaalde aangelegenheid jegens hem of een ander heeft gedragen.')
                      , ('Indien het verzoekschrift bij een onbevoegde ombudsman wordt ingediend, wordt het, nadat daarop de datum van ontvangst is aangetekend, zo spoedig mogelijk doorgezonden aan de bevoegde ombudsman, onder gelijktijdige mededeling hiervan aan de verzoeker.')
                      , ('De ombudsman is verplicht aan een verzoek als bedoeld in het eerste par gevolg te geven, tenzij [215]artikel 9:22, [216]9:23 of [217]9:24 van toepassing is.')
                      , ('Indien naar het oordeel van de ombudsman ten aanzien van de in het verzoekschrift bedoelde gedraging voor de verzoeker de mogelijkheid van bezwaar, beroep of beklag openstaat, wijst hij de verzoeker zo spoedig mogelijk op deze mogelijkheid en draagt hij het verzoekschrift, nadat daarop de datum van ontvangst is aangetekend, aan de bevoegde instantie over, tenzij de verzoeker kenbaar heeft gemaakt dat het verzoekschrift aan hem moet worden teruggezonden.')
                      , ('[218]Artikel 6:15, derde lid, is van overeenkomstige toepassing.')
                      , ('Alvorens het verzoek aan een ombudsman te doen, dient de verzoeker over de gedraging een klacht in bij het betrokken bestuursorgaan, tenzij dit redelijkerwijs niet van hem kan worden gevergd.')
                      , ('Het eerste par geldt niet indien het verzoek betrekking heeft op de wijze van klachtbehandeling door het betrokken bestuursorgaan.')
                      , ('Op het verkeer met de ombudsman is [219]hoofdstuk 2 van overeenkomstige toepassing, met uitzondering van [220]artikel 2:3, eerste lid.')
                      , ('De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: a. een aangelegenheid die behoort tot het algemeen regeringsbeleid, daaronder begrepen het algemeen beleid ter handhaving van de rechtsorde, of tot het algemeen beleid van het betrokken bestuursorgaan.')
                      , ('De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: b. een algemeen verbindend voorschrift.')
                      , ('De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: c. een gedraging waartegen beklag kan worden gedaan of beroep kan worden ingesteld, tenzij die gedraging bestaat uit het niet tijdig nemen van een besluit, of waartegen een beklag- of beroepsprocedure aanhangig is.')
                      , ('De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: d. een gedraging ten aanzien waarvan door een administratieve rechter uitspraak is gedaan.')
                      , ('De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: e. een gedraging ten aanzien waarvan een procedure bij een andere rechterlijke instantie dan een administratieve rechter aanhangig is, dan wel beroep openstaat tegen een uitspraak die in een zodanige procedure is gedaan.')
                      , ('De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: f. een gedraging waarop de rechterlijke macht toeziet.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: a. het verzoekschrift niet voldoet aan de vereisten, bedoeld in [221]artikel 9:28, eerste en tweede lid.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: b. het verzoek kennelijk ongegrond is.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: c. het belang van de verzoeker bij een onderzoek door de ombudsman dan wel het gewicht van de gedraging kennelijk onvoldoende is.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: d. de verzoeker een ander is dan degene jegens wie de gedraging heeft plaatsgevonden.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: e. het verzoek betrekking heeft op een gedraging waartegen bezwaar kan worden gemaakt, tenzij die gedraging bestaat uit het niet tijdig nemen van een besluit, of waartegen een bezwaarprocedure aanhangig is.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: f. het verzoek betrekking heeft op een gedraging waartegen door de verzoeker bezwaar had kunnen worden gemaakt, beroep had kunnen worden ingesteld of beklag had kunnen worden gedaan.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: g. het verzoek betrekking heeft op een gedraging ten aanzien waarvan door een andere rechterlijke instantie dan een administratieve rechter uitspraak is gedaan.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: h. niet is voldaan aan het vereiste van [222]artikel 9:20, eerste lid.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: i. een verzoek, dezelfde gedraging betreffende, bij hem in behandeling is of ? behoudens indien een nieuw feit of een nieuwe omstandigheid bekend is geworden en zulks tot een ander oordeel over de bedoelde gedraging zou hebben kunnen leiden ? door hem is afgedaan.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: j. ten aanzien van een gedraging van het bestuursorgaan die nauw samenhangt met het onderwerp van het verzoekschrift een procedure aanhangig is bij een rechterlijke instantie, dan wel ingevolge bezwaar, administratief beroep of beklag bij een andere instantie.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: k. het verzoek betrekking heeft op een gedraging die nauw samenhangt met een onderwerp, dat door het instellen van een procedure aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen is.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: l. na tussenkomst van de ombudsman naar diens oordeel alsnog naar behoren aan de grieven van de verzoeker tegemoet is gekomen.')
                      , ('De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: m. het verzoek, dezelfde gedraging betreffende, ingevolge een wettelijk geregelde klachtvoorziening bij een onafhankelijke klachtinstantie niet zijnde een ombudsman in behandeling is of daardoor is afgedaan.')
                      , ('Voorts is de ombudsman niet verplicht een onderzoek in te stellen of voort te zetten, indien het verzoek wordt ingediend later dan een jaar: a. na de kennisgeving door het bestuursorgaan van de bevindingen van het onderzoek.')
                      , ('Voorts is de ombudsman niet verplicht een onderzoek in te stellen of voort te zetten, indien het verzoek wordt ingediend later dan een jaar: b. nadat de klachtbehandeling door het bestuursorgaan op andere wijze is geëindigd, dan wel ingevolge [223]artikel 9:11 beëindigd had moeten zijn.')
                      , ('In afwijking van het eerste par eindigt de termijn een jaar nadat de gedraging heeft plaatsgevonden, indien redelijkerwijs niet van verzoeker kan worden gevergd dat hij eerst een klacht bij het bestuursorgaan indient. Is de gedraging binnen een jaar nadat zij plaatsvond, aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen, of is daartegen bezwaar gemaakt, administratief beroep ingesteld dan wel beklag gedaan, dan eindigt de termijn een jaar na de datum waarop: a. in die procedure een uitspraak is gedaan waartegen geen beroep meer openstaat.')
                      , ('In afwijking van het eerste par eindigt de termijn een jaar nadat de gedraging heeft plaatsgevonden, indien redelijkerwijs niet van verzoeker kan worden gevergd dat hij eerst een klacht bij het bestuursorgaan indient. Is de gedraging binnen een jaar nadat zij plaatsvond, aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen, of is daartegen bezwaar gemaakt, administratief beroep ingesteld dan wel beklag gedaan, dan eindigt de termijn een jaar na de datum waarop: b. de procedure op een andere wijze is geëindigd.')
                      , ('Indien de ombudsman op grond van [224]artikel 9:22, [225]9:23 of [226]9:24 geen onderzoek instelt of dit niet voortzet, deelt hij dit onder vermelding van de redenen zo spoedig mogelijk schriftelijk aan de verzoeker mede.')
                      , ('In het geval dat hij een onderzoek niet voortzet, doet hij de in het eerste par bedoelde mededeling tevens aan het bestuursorgaan en, in voorkomend geval, aan degene op wiens gedraging het onderzoek betrekking heeft.')
                      , ('Tenzij [227]artikel 9:22 van toepassing is, is de ombudsman bevoegd uit eigen beweging een onderzoek in te stellen naar de wijze waarop een bestuursorgaan zich in een bepaalde aangelegenheid heeft gedragen.')
                      , ('De ombudsman beoordeelt of het bestuursorgaan zich in de door hem onderzochte aangelegenheid al dan niet behoorlijk heeft gedragen.')
                      , ('Indien ten aanzien van de gedraging waarop het onderzoek van de ombudsman betrekking heeft door een rechterlijke instantie uitspraak is gedaan, neemt de ombudsman de rechtsgronden in acht waarop die uitspraak steunt of mede steunt.')
                      , ('De ombudsman kan naar aanleiding van het door hem verrichte onderzoek aan het bestuursorgaan aanbevelingen doen.')
                      , ('Het verzoekschrift wordt ondertekend en bevat ten minste: a. de naam en het adres van de verzoeker; b. de dagtekening; c. een omschrijving van de gedraging waartegen het verzoek is gericht, een aanduiding van degene die zich aldus heeft gedragen en een aanduiding van degene jegens wie de gedraging heeft plaatsgevonden, indien deze niet de verzoeker is; d. de gronden van het verzoek; e. de wijze waarop een klacht bij het bestuursorgaan is ingediend, en zo mogelijk de bevindingen van het onderzoek naar de klacht door het bestuursorgaan, zijn oordeel daarover alsmede de eventuele conclusies die het bestuursorgaan hieraan verbonden heeft.')
                      , ('Indien het verzoekschrift in een vreemde taal is gesteld en een vertaling voor een goede behandeling van het verzoek noodzakelijk is, draagt de verzoeker zorg voor een vertaling.')
                      , ('Indien niet is voldaan aan de in dit artikel gestelde vereisten of indien het verzoekschrift geheel of gedeeltelijk is geweigerd op grond van [228]artikel 2:15, stelt de ombudsman de verzoeker in de gelegenheid het verzuim binnen een door hem daartoe gestelde termijn te herstellen.')
                      , ('Aan de behandeling van het verzoek wordt niet meegewerkt door een persoon die betrokken is geweest bij de gedraging waarop het verzoek betrekking heeft.')
                      , ('De ombudsman stelt het bestuursorgaan, degene op wiens gedraging het verzoek betrekking heeft, en de verzoeker in de gelegenheid hun standpunt toe te lichten.')
                      , ('De ombudsman beslist of de toelichting schriftelijk of mondeling en al dan niet in elkaars tegenwoordigheid wordt gegeven.')
                      , ('Het bestuursorgaan, onder zijn verantwoordelijkheid werkzame personen ? ook na het beëindigen van de werkzaamheden ?, getuigen alsmede de verzoeker verstrekken de ombudsman de benodigde inlichtingen en verschijnen op een daartoe strekkende uitnodiging voor hem. Gelijke verplichtingen rusten op ieder college, met dien verstande dat het college bepaalt wie van zijn leden aan de verplichtingen zal voldoen, tenzij de ombudsman één of meer bepaalde leden aanwijst. De ombudsman kan betrokkenen die zijn opgeroepen gelasten om in persoon te verschijnen.')
                      , ('Inlichtingen die betrekking hebben op het beleid, gevoerd onder de verantwoordelijkheid van een minister of een ander bestuursorgaan, kan de ombudsman bij de daarbij betrokken personen en colleges slechts inwinnen door tussenkomst van de minister onderscheidenlijk dat bestuursorgaan. Het orgaan door tussenkomst waarvan de inlichtingen worden ingewonnen, kan zich bij het horen van de ambtenaren doen vertegenwoordigen.')
                      , ('Binnen een door de ombudsman te bepalen termijn worden ten behoeve van een onderzoek de onder het bestuursorgaan, degene op wiens gedraging het verzoek betrekking heeft, en bij anderen berustende stukken aan hem overgelegd nadat hij hierom schriftelijk heeft verzocht.')
                      , ('De ingevolge het eerste par opgeroepen personen onderscheidenlijk degenen die ingevolge het derde par verplicht zijn stukken over te leggen kunnen, indien daarvoor gewichtige redenen zijn, het geven van inlichtingen onderscheidenlijk het overleggen van stukken weigeren of de ombudsman mededelen dat uitsluitend hij kennis zal mogen nemen van de inlichtingen onderscheidenlijk de stukken.')
                      , ('De ombudsman beslist of de in het vierde par bedoelde weigering onderscheidenlijk de beperking van de kennisneming gerechtvaardigd is.')
                      , ('Indien de ombudsman heeft beslist dat de weigering gerechtvaardigd is, vervalt de verplichting.')
                      , ('De ombudsman kan ten dienste van het onderzoek deskundigen werkzaamheden opdragen. Hij kan voorts in het belang van het onderzoek deskundigen en tolken oproepen.')
                      , ('Door de ombudsman opgeroepen deskundigen of tolken verschijnen voor hem, en verlenen onpartijdig en naar beste weten hun diensten als zodanig. Op deskundigen, tevens ambtenaren, is [229]artikel 9:31, tweede tot en met zesde lid, van overeenkomstige toepassing.')
                      , ('De ombudsman kan bepalen dat getuigen niet zullen worden gehoord en tolken niet tot de uitoefening van hun taak zullen worden toegelaten dan na het afleggen van de eed of de belofte. Getuigen leggen in dat geval de eed of de belofte af dat zij de gehele waarheid en niets dan de waarheid zullen zeggen en tolken dat zij hun plichten als tolk met nauwgezetheid zullen vervullen.')
                      , ('Aan de door de ombudsman opgeroepen verzoekers, getuigen, deskundigen en tolken wordt een vergoeding toegekend. Deze vergoeding vindt plaats ten laste van de rechtspersoon waartoe het bestuursorgaan behoort op wiens gedraging het verzoek betrekking heeft, indien het een gemeente, provincie, waterschap of gemeenschappelijke regeling betreft. In overige gevallen vindt de vergoeding plaats ten laste van het Rijk. Het bij en krachtens de Wet tarieven in strafzaken bepaalde is van overeenkomstige toepassing.')
                      , ('De in het eerste par bedoelde personen die in openbare dienst zijn, ontvangen geen vergoeding indien zij zijn opgeroepen in verband met hun taak als zodanig.')
                      , ('De ombudsman kan een onderzoek ter plaatse instellen. Hij heeft daarbij toegang tot elke plaats, met uitzondering van een woning zonder toestemming van de bewoner, voor zover dat redelijkerwijs voor de vervulling van zijn taak nodig is.')
                      , ('Bestuursorganen verlenen de medewerking die in het belang van het onderzoek, bedoeld in het eerste lid, is vereist.')
                      , ('Van het onderzoek wordt een proces-verbaal gemaakt.')
                      , ('De ombudsman deelt, alvorens het onderzoek te beëindigen, zijn bevindingen schriftelijk mee aan: a. het betrokken bestuursorgaan; b. degene op wiens gedraging het verzoek betrekking heeft; c. de verzoeker.')
                      , ('De ombudsman geeft hun de gelegenheid zich binnen een door hem te stellen termijn omtrent de bevindingen te uiten.')
                      , ('Wanneer een onderzoek is afgesloten, stelt de ombudsman een rapport op, waarin hij zijn bevindingen en zijn oordeel weergeeft. Hij neemt daarbij artikel 10 van de Wet openbaarheid van bestuur in acht.')
                      , ('Indien naar het oordeel van de ombudsman de gedraging niet behoorlijk is, vermeldt hij in het rapport welk vereiste van behoorlijkheid geschonden is.')
                      , ('De ombudsman zendt zijn rapport aan het betrokken bestuursorgaan, alsmede aan de verzoeker en aan degene op wiens gedraging het verzoek betrekking heeft.')
                      , ('Indien de ombudsman aan het bestuursorgaan een aanbeveling doet als bedoeld in [230]artikel 9:27, derde lid, deelt het bestuursorgaan binnen een redelijke termijn aan de ombudsman mee op welke wijze aan de aanbeveling gevolg zal worden gegeven. Indien het bestuursorgaan overweegt de aanbeveling niet op te volgen, deelt het dat met redenen omkleed aan de ombudsman mee.')
                      , ('De ombudsman geeft aan een ieder die daarom verzoekt, afschrift of uittreksel van een rapport als bedoeld in het eerste lid. Met betrekking tot de daarvoor in rekening te brengen vergoedingen en met betrekking tot kosteloze verstrekking is het bepaalde bij en krachtens de Wet tarieven in burgerlijke zaken van overeenkomstige toepassing. Tevens legt hij een zodanig rapport ter inzage op een door hem aan te wijzen plaats.')
                      , ('Onder mandaat wordt verstaan: de bevoegdheid om in naam van een bestuursorgaan besluiten te nemen.')
                      , ('Een door de gemandateerde binnen de grenzen van zijn bevoegdheid genomen besluit geldt als een besluit van de mandaatgever.')
                      , ('Een bestuursorgaan kan mandaat verlenen, tenzij bij wettelijk voorschrift anders is bepaald of de aard van de bevoegdheid zich tegen de mandaatverlening verzet.')
                      , ('Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: a. tot het vaststellen van algemeen verbindende voorschriften, tenzij bij de verlening van die bevoegdheid in mandaatverlening is voorzien.')
                      , ('Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: b. tot het nemen van een besluit ten aanzien waarvan is bepaald dat het met versterkte meerderheid moet worden genomen of waarvan de aard van de voorgeschreven besluitvormingsprocedure zich anderszins tegen de mandaatverlening verzet.')
                      , ('Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: c. tot het beslissen op een beroepschrift.')
                      , ('Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: d. tot het vernietigen van of tot het onthouden van goedkeuring aan een besluit van een ander bestuursorgaan.')
                      , ('Mandaat tot het beslissen op een bezwaarschrift of op een verzoek als bedoeld in [231]artikel 7:1a, eerste lid, wordt niet verleend aan degene die het besluit waartegen het bezwaar zich richt, krachtens mandaat heeft genomen.')
                      , ('Indien de gemandateerde niet werkzaam is onder verantwoordelijkheid van de mandaatgever, behoeft de mandaatverlening de instemming van de gemandateerde en in het voorkomende geval van degene onder wiens verantwoordelijkheid hij werkt.')
                      , ('Het eerste par is niet van toepassing indien bij wettelijk voorschrift in de bevoegdheid tot de mandaatverlening is voorzien.')
                      , ('Een bestuursorgaan kan hetzij een algemeen mandaat hetzij een mandaat voor een bepaald geval verlenen.')
                      , ('Een algemeen mandaat wordt schriftelijk verleend. Een mandaat voor een bepaald geval wordt in ieder geval schriftelijk verleend indien de gemandateerde niet werkzaam is onder verantwoordelijkheid van de mandaatgever.')
                      , ('De mandaatgever kan de gemandateerde per geval of in het algemeen instructies geven ter zake van de uitoefening van de gemandateerde bevoegdheid.')
                      , ('De gemandateerde verschaft de mandaatgever op diens verzoek inlichtingen over de uitoefening van de bevoegdheid.')
                      , ('De mandaatgever blijft bevoegd de gemandateerde bevoegdheid uit te oefenen.')
                      , ('De mandaatgever kan het mandaat te allen tijde intrekken.')
                      , ('Een algemeen mandaat wordt schriftelijk ingetrokken.')
                      , ('De mandaatgever kan toestaan dat ondermandaat wordt verleend.')
                      , ('Op ondermandaat zijn de overige artikelen van deze afdeling van overeenkomstige toepassing.')
                      , ('Een krachtens mandaat genomen besluit vermeldt namens welk bestuursorgaan het besluit is genomen.')
                      , ('Een bestuursorgaan kan bepalen dat door hem genomen besluiten namens hem kunnen worden ondertekend, tenzij bij wettelijk voorschrift anders is bepaald of de aard van de bevoegdheid zich hiertegen verzet.')
                      , ('In dat geval moet uit het besluit blijken, dat het door het bestuursorgaan zelf is genomen.')
                      , ('Deze afdeling is van overeenkomstige toepassing indien een bestuursorgaan aan een ander, werkzaam onder zijn verantwoordelijkheid, volmacht verleent tot het verrichten van privaatrechtelijke rechtshandelingen, of machtiging verleent tot het verrichten van handelingen die noch een besluit, noch een privaatrechtelijke rechtshandeling zijn.')
                      , ('Onder delegatie wordt verstaan: het overdragen door een bestuursorgaan van zijn bevoegdheid tot het nemen van besluiten aan een ander die deze onder eigen verantwoordelijkheid uitoefent.')
                      , ('Delegatie geschiedt niet aan ondergeschikten.')
                      , ('Delegatie geschiedt slechts indien in de bevoegdheid daartoe bij wettelijk voorschrift is voorzien.')
                      , ('Het bestuursorgaan kan ter zake van de uitoefening van de gedelegeerde bevoegdheid uitsluitend beleidsregels geven.')
                      , ('Degene aan wie de bevoegdheid is gedelegeerd, verschaft het bestuursorgaan op diens verzoek inlichtingen over de uitoefening van de bevoegdheid.')
                      , ('Het bestuursorgaan kan de gedelegeerde bevoegdheid niet meer zelf uitoefenen.')
                      , ('Het bestuursorgaan kan het delegatiebesluit te allen tijde intrekken.')
                      , ('Een besluit dat op grond van een gedelegeerde bevoegdheid wordt genomen, vermeldt het delegatiebesluit en de vindplaats daarvan.')
                      , ('Op de overdracht door een bestuursorgaan van een bevoegdheid van een ander bestuursorgaan tot het nemen van besluiten aan een derde is deze afdeling, met uitzondering van artikel 10:16, van overeenkomstige toepassing.')
                      , ('Bij wettelijk voorschrift of bij het besluit tot overdracht kan worden bepaald dat het bestuursorgaan wiens bevoegdheid is overgedragen beleidsregels over de uitoefening van die bevoegdheid kan geven.')
                      , ('Degene aan wie de bevoegdheid is overgedragen, verschaft het overdragende en het oorspronkelijk bevoegde bestuursorgaan op hun verzoek inlichtingen over de uitoefening van de bevoegdheid.')
                      , ('In deze wet wordt verstaan onder goedkeuring: de voor de inwerkingtreding van een besluit van een bestuursorgaan vereiste toestemming van een ander bestuursorgaan.')
                      , ('Besluiten kunnen slechts aan goedkeuring worden onderworpen in bij of krachtens de wet bepaalde gevallen.')
                      , ('De goedkeuring kan slechts worden onthouden wegens strijd met het recht of op een grond, neergelegd in de wet waarin of krachtens welke de goedkeuring is voorgeschreven.')
                      , ('Aan een besluit waarover een rechter uitspraak heeft gedaan of waarbij een in kracht van gewijsde gegane uitspraak van de rechter wordt uitgevoerd, kan geen goedkeuring worden onthouden op rechtsgronden welke in strijd zijn met die waarop de uitspraak steunt of mede steunt.')
                      , ('Een besluit kan alleen dan gedeeltelijk worden goedgekeurd, indien gedeeltelijke inwerkingtreding strookt met aard en inhoud van het besluit.')
                      , ('De goedkeuring kan noch voor bepaalde tijd of onder voorwaarden worden verleend, noch worden ingetrokken.')
                      , ('Gedeeltelijke goedkeuring of onthouding van goedkeuring vindt niet plaats dan nadat aan het bestuursorgaan dat het besluit heeft genomen, gelegenheid tot overleg is geboden.')
                      , ('De motivering van het goedkeuringsbesluit verwijst naar hetgeen in het overleg aan de orde is gekomen.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald, wordt het besluit omtrent goedkeuring binnen dertien weken na de verzending ter goedkeuring bekend gemaakt aan het bestuursorgaan dat het aan goedkeuring onderworpen besluit heeft genomen.')
                      , ('Het nemen van het besluit omtrent goedkeuring kan eenmaal voor ten hoogste dertien weken worden verdaagd.')
                      , ('In afwijking van het tweede par kan het nemen van het besluit omtrent goedkeuring eenmaal voor ten hoogste zes maanden worden verdaagd indien inzake dat besluit advies van een adviseur als bedoeld in [232]artikel 3:5 is vereist.')
                      , ('Tenzij bij wettelijk voorschrift anders is bepaald wordt een besluit tot goedkeuring geacht te zijn genomen, indien binnen de in het eerste par genoemde termijn geen besluit omtrent goedkeuring of geen besluit tot verdaging, dan wel binnen de termijn waarvoor het besluit is verdaagd, geen besluit omtrent goedkeuring is bekendgemaakt aan het bestuursorgaan dat het aan goedkeuring onderworpen besluit heeft genomen.')
                      , ('Deze afdeling is van overeenkomstige toepassing indien voor het nemen van een besluit door een bestuursorgaan de toestemming van een ander bestuursorgaan is vereist.')
                      , ('Bij de toestemming kan een termijn worden gesteld waarbinnen het besluit dient te worden genomen.')
                      , ('Deze afdeling is van toepassing indien een bestuursorgaan bevoegd is buiten administratief beroep een besluit van een ander bestuursorgaan te vernietigen.')
                      , ('De vernietigingsbevoegdheid kan slechts worden verleend bij de wet.')
                      , ('Vernietiging kan alleen geschieden wegens strijd met het recht of het algemeen belang.')
                      , ('Een besluit kan alleen dan gedeeltelijk worden vernietigd, indien gedeeltelijke instandhouding strookt met aard en inhoud van het besluit.')
                      , ('Een besluit waarover de rechter uitspraak heeft gedaan of waarbij een in kracht van gewijsde gegane uitspraak van de rechter wordt uitgevoerd, kan niet worden vernietigd op rechtsgronden welke in strijd zijn met die waarop de uitspraak steunt of mede steunt.')
                      , ('Een besluit dat nog goedkeuring behoeft, kan niet worden vernietigd.')
                      , ('Een besluit waartegen bezwaar of beroep openstaat of aanhangig is, kan niet worden vernietigd.')
                      , ('Een besluit tot het verrichten van een privaatrechtelijke rechtshandeling kan niet worden vernietigd, indien dertien weken zijn verstreken nadat het is bekendgemaakt.')
                      , ('Indien binnen de termijn genoemd in het eerste par overeenkomstig [233]artikel 10:43 schorsing heeft plaatsgevonden, blijft vernietiging binnen de duur van de schorsing mogelijk.')
                      , ('Indien een besluit als bedoeld in het eerste par aan goedkeuring is onderworpen, vangt de in het eerste par genoemde termijn aan nadat het goedkeuringsbesluit is bekendgemaakt. Op het goedkeuringsbesluit zijn het eerste en tweede par van overeenkomstige toepassing.')
                      , ('Een besluit dat overeenkomstig [234]artikel 10:43 is geschorst, kan, nadat de schorsing is geëindigd, niet meer worden vernietigd.')
                      , ('Vernietiging vindt niet plaats dan nadat aan het bestuursorgaan dat het besluit heeft genomen, gelegenheid tot overleg is geboden.')
                      , ('De motivering van het vernietigingsbesluit verwijst naar hetgeen in het overleg aan de orde is gekomen.')
                      , ('Vernietiging van een besluit strekt zich uit tot alle rechtsgevolgen waarop het was gericht.')
                      , ('In het vernietigingsbesluit kan worden bepaald dat de rechtsgevolgen van het vernietigde besluit geheel of ten dele in stand blijven.')
                      , ('Indien een besluit tot het aangaan van een overeenkomst wordt vernietigd, wordt de overeenkomst, zo zij reeds is aangegaan en voor zover bij het vernietigingsbesluit niet anders is bepaald, niet of niet verder uitgevoerd, onverminderd het recht van de wederpartij op schadevergoeding.')
                      , ('Hangende het onderzoek of er reden is tot vernietiging over te gaan, kan een besluit door het tot vernietiging bevoegde bestuursorgaan worden geschorst.')
                      , ('Het besluit tot schorsing bepaalt de duur hiervan.')
                      , ('De schorsing van een besluit kan eenmaal worden verlengd.')
                      , ('De schorsing kan ook na verlenging niet langer duren dan een jaar.')
                      , ('Indien bezwaar is gemaakt of beroep is ingesteld tegen het geschorste besluit, duurt de schorsing evenwel voort tot dertien weken nadat op het bezwaar of beroep onherroepelijk is beslist.')
                      , ('De schorsing kan worden opgeheven.')
                      , ('Op het besluit inzake schorsing zijn de [235]artikelen 10:36, [236]10:37, [237]10:38, eerste lid, [238]10:39, eerste en derde lid, en [239]10:42, derde lid, van overeenkomstige toepassing.')
                      , ('Onze Ministers van Justitie en van Binnenlandse Zaken zenden binnen drie jaren na de inwerkingtreding van deze wet en vervolgens om de vijf jaren aan de Staten-Generaal een verslag over de wijze waarop zij is toegepast.')
                      , ('Het eerste par is niet van toepassing ten aanzien van de voorschriften betreffende beroep bij een administratieve rechter.')
                      , ('Deze wet treedt in werking op een bij koninklijk besluit te bepalen tijdstip.')
                      , ('Voor de bekendmaking van deze wet stelt Onze Minister van Justitie de nummering van de artikelen, afdelingen, titels en hoofdstukken van deze wet opnieuw vast en brengt hij de in deze wet voorkomende aanhalingen van artikelen, afdelingen, titels en hoofdstukken daarmee in overeenstemming.')
                      , ('Deze wet wordt aangehaald als: Algemene wet bestuursrecht.')
                      , ('bezetting van enkelvoudige kamer bepalen')
                      , ('bezetting van meervoudige kamer bepalen')
                      , ('doc987384')
                      , ('2000/864821a')
                      , ('2000/860338e')
                      , ('doc763820')
                      , ('Vreugdenhil')
                      , ('2009/87743a')
                      , ('B. en W.-besluit van 27 februari 2009, Gemeenteblad van Utrecht 2009 Nr. 8')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug date                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `date`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `date` (`i` )
                VALUES ('23 januari 2009')
                      , ('15 september 2000')
                      , ('16 november 2000')
                      , ('2 mei 2009')
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
                VALUES ('District')
                      , ('Administrative law')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug courtofappeal                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `courtofappeal`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `courtofappeal` (`i` )
                VALUES ('Amsterdam court of appeal')
                      , ('Arnhem court of appeal')
                      , ('\'s-Gravenhage court of appeal')
                      , ('\'s-Hertogenbosch court of appeal')
                      , ('Leeuwarden court of appeal')
                      , ('Council of State')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug article                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `article`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `article` (`i` )
                VALUES ('Article 1:1 par 1 sub a Awb')
                      , ('Article 1:1 par 1 sub b Awb')
                      , ('Article 1:1 par 2 sub a Awb')
                      , ('Article 1:1 par 2 sub b Awb')
                      , ('Article 1:1 par 2 sub c Awb')
                      , ('Article 1:1 par 2 sub d Awb')
                      , ('Article 1:1 par 2 sub e Awb')
                      , ('Article 1:1 par 2 sub f Awb')
                      , ('Article 1:1 par 2 sub g Awb')
                      , ('Article 1:1 par 2 sub h Awb')
                      , ('Article 1:1 par 3 Awb')
                      , ('Article 1:2 par 1 Awb')
                      , ('Article 1:2 par 2 Awb')
                      , ('Article 1:2 par 3 Awb')
                      , ('Article 1:3 par 1 Awb')
                      , ('Article 1:3 par 2 Awb')
                      , ('Article 1:3 par 3 Awb')
                      , ('Article 1:3 par 4 Awb')
                      , ('Article 1:4 par 1 Awb')
                      , ('Article 1:4 par 2 Awb')
                      , ('Article 1:5 par 1 Awb')
                      , ('Article 1:5 par 2 Awb')
                      , ('Article 1:5 par 3 Awb')
                      , ('Article 1:6 sub a Awb')
                      , ('Article 1:6 sub b Awb')
                      , ('Article 1:6 sub c Awb')
                      , ('Article 1:6 sub d Awb')
                      , ('Article 1:6 sub e Awb')
                      , ('Article 1:7 par 1 Awb')
                      , ('Article 1:7 par 2 Awb')
                      , ('Article 1:8 par 1 Awb')
                      , ('Article 1:8 par 2 sub a Awb')
                      , ('Article 1:8 par 2 sub b Awb')
                      , ('Article 1:9 Awb')
                      , ('Article 2:1 par 1 Awb')
                      , ('Article 2:1 par 2 Awb')
                      , ('Article 2:2 par 1 Awb')
                      , ('Article 2:2 par 2 Awb')
                      , ('Article 2:2 par 3 Awb')
                      , ('Article 2:3 par 1 Awb')
                      , ('Article 2:3 par 2 Awb')
                      , ('Article 2:4 par 1 Awb')
                      , ('Article 2:4 par 2 Awb')
                      , ('Article 2:5 par 1 Awb')
                      , ('Article 2:5 par 2 Awb')
                      , ('Article 2:6 par 1 Awb')
                      , ('Article 2:6 par 2 Awb')
                      , ('Article 2:7 par 1 Awb')
                      , ('Article 2:7 par 2 Awb')
                      , ('Article 2:8 par 1 Awb')
                      , ('Article 2:8 par 2 Awb')
                      , ('Article 2:9 par 1 Awb')
                      , ('Article 2:9 par 2 Awb')
                      , ('Article 2:10 par 1 sub a Awb')
                      , ('Article 2:10 par 1 sub b Awb')
                      , ('Article 2:10 par 1 sub c Awb')
                      , ('Article 2:10 par 2 Awb')
                      , ('Article 2:11 par 1 Awb')
                      , ('Article 2:11 par 2 Awb')
                      , ('Article 2:11 par 3 sub a Awb')
                      , ('Article 2:11 par 3 sub b Awb')
                      , ('Article 2:12 par 1 Awb')
                      , ('Article 2:12 par 2 Awb')
                      , ('Article 2:13 par 1 Awb')
                      , ('Article 2:13 par 2 sub a Awb')
                      , ('Article 2:13 par 2 sub b Awb')
                      , ('Article 2:14 par 1 Awb')
                      , ('Article 2:14 par 2 Awb')
                      , ('Article 2:14 par 3 Awb')
                      , ('Article 2:15 par 1 Awb')
                      , ('Article 2:15 par 2 Awb')
                      , ('Article 2:15 par 3 Awb')
                      , ('Article 2:15 par 4 Awb')
                      , ('Article 2:16 Awb')
                      , ('Article 2:17 par 1 Awb')
                      , ('Article 2:17 par 2 Awb')
                      , ('Article 3:1 par 1 sub a Awb')
                      , ('Article 3:1 par 1 sub b Awb')
                      , ('Article 3:1 par 2 Awb')
                      , ('Article 3:2 Awb')
                      , ('Article 3:3 Awb')
                      , ('Article 3:4 par 1 Awb')
                      , ('Article 3:4 par 2 Awb')
                      , ('Article 3:5 par 1 Awb')
                      , ('Article 3:5 par 2 Awb')
                      , ('Article 3:6 par 1 Awb')
                      , ('Article 3:6 par 2 Awb')
                      , ('Article 3:7 par 1 Awb')
                      , ('Article 3:7 par 2 Awb')
                      , ('Article 3:8 Awb')
                      , ('Article 3:9 Awb')
                      , ('Article 3:9a Awb')
                      , ('Article 3:10 par 1 Awb')
                      , ('Article 3:10 par 2 Awb')
                      , ('Article 3:10 par 3 Awb')
                      , ('Article 3:11 par 1 Awb')
                      , ('Article 3:11 par 2 Awb')
                      , ('Article 3:11 par 3 Awb')
                      , ('Article 3:11 par 4 Awb')
                      , ('Article 3:12 par 1 Awb')
                      , ('Article 3:12 par 2 Awb')
                      , ('Article 3:12 par 3 sub a Awb')
                      , ('Article 3:12 par 3 sub b Awb')
                      , ('Article 3:12 par 3 sub c Awb')
                      , ('Article 3:12 par 3 sub d Awb')
                      , ('Article 3:13 par 1 Awb')
                      , ('Article 3:13 par 2 Awb')
                      , ('Article 3:14 par 1 Awb')
                      , ('Article 3:14 par 2 Awb')
                      , ('Article 3:15 par 1 Awb')
                      , ('Article 3:15 par 2 Awb')
                      , ('Article 3:15 par 3 Awb')
                      , ('Article 3:15 par 4 Awb')
                      , ('Article 3:16 par 1 Awb')
                      , ('Article 3:16 par 2 Awb')
                      , ('Article 3:16 par 3 Awb')
                      , ('Article 3:17 Awb')
                      , ('Article 3:18 par 1 Awb')
                      , ('Article 3:18 par 2 Awb')
                      , ('Article 3:18 par 3 sub a Awb')
                      , ('Article 3:18 par 3 sub b Awb')
                      , ('Article 3:18 par 4 Awb')
                      , ('Article 3:19 Awb')
                      , ('Article 3:20 par 1 Awb')
                      , ('Article 3:20 par 2 sub a Awb')
                      , ('Article 3:20 par 2 sub b Awb')
                      , ('Article 3:21 par 1 sub a Awb')
                      , ('Article 3:21 par 1 sub b Awb')
                      , ('Article 3:21 par 2 Awb')
                      , ('Article 3:22 Awb')
                      , ('Article 3:23 par 1 Awb')
                      , ('Article 3:23 par 2 Awb')
                      , ('Article 3:24 par 1 Awb')
                      , ('Article 3:24 par 2 Awb')
                      , ('Article 3:24 par 3 Awb')
                      , ('Article 3:24 par 4 Awb')
                      , ('Article 3:25 Awb')
                      , ('Article 3:26 par 1 sub a Awb')
                      , ('Article 3:26 par 1 sub b Awb')
                      , ('Article 3:26 par 1 sub c Awb')
                      , ('Article 3:26 par 1 sub d Awb')
                      , ('Article 3:26 par 1 sub e Awb')
                      , ('Article 3:26 par 1 sub f Awb')
                      , ('Article 3:26 par 1 sub g Awb')
                      , ('Article 3:26 par 2 Awb')
                      , ('Article 3:27 par 1 Awb')
                      , ('Article 3:27 par 2 Awb')
                      , ('Article 3:28 par 1 Awb')
                      , ('Article 3:28 par 2 Awb')
                      , ('Article 3:28 par 3 Awb')
                      , ('Article 3:29 par 1 Awb')
                      , ('Article 3:29 par 2 sub a Awb')
                      , ('Article 3:29 par 2 sub b Awb')
                      , ('Article 3:29 par 2 sub c Awb')
                      , ('Article 3:29 par 3 sub a Awb')
                      , ('Article 3:29 par 3 sub b Awb')
                      , ('Article 3:29 par 3 sub c Awb')
                      , ('Article 3:29 par 4 Awb')
                      , ('Article 3:40 Awb')
                      , ('Article 3:41 par 1 Awb')
                      , ('Article 3:41 par 2 Awb')
                      , ('Article 3:42 par 1 Awb')
                      , ('Article 3:42 par 2 Awb')
                      , ('Article 3:42 par 3 Awb')
                      , ('Article 3:43 par 1 Awb')
                      , ('Article 3:43 par 2 Awb')
                      , ('Article 3:44 par 1 sub a Awb')
                      , ('Article 3:44 par 2 sub a Awb')
                      , ('Article 3:44 par 2 sub b Awb')
                      , ('Article 3:44 par 2 sub c Awb')
                      , ('Article 3:44 par 2 sub d Awb')
                      , ('Article 3:45 par 1 Awb')
                      , ('Article 3:45 par 2 Awb')
                      , ('Article 3:46 Awb')
                      , ('Article 3:47 par 1 Awb')
                      , ('Article 3:47 par 2 Awb')
                      , ('Article 3:47 par 3 Awb')
                      , ('Article 3:47 par 4 Awb')
                      , ('Article 3:48 par 1 Awb')
                      , ('Article 3:48 par 2 Awb')
                      , ('Article 3:49 Awb')
                      , ('Article 3:50 Awb')
                      , ('Article 4:1 Awb')
                      , ('Article 4:2 par 1 sub a Awb')
                      , ('Article 4:2 par 1 sub b Awb')
                      , ('Article 4:2 par 1 sub c Awb')
                      , ('Article 4:2 par 2 Awb')
                      , ('Article 4:3 par 1 Awb')
                      , ('Article 4:3 par 2 Awb')
                      , ('Article 4:3a Awb')
                      , ('Article 4:4 Awb')
                      , ('Article 4:5 par 1 sub a Awb')
                      , ('Article 4:5 par 1 sub b Awb')
                      , ('Article 4:5 par 1 sub c Awb')
                      , ('Article 4:5 par 2 Awb')
                      , ('Article 4:5 par 3 Awb')
                      , ('Article 4:5 par 4 Awb')
                      , ('Article 4:6 par 1 Awb')
                      , ('Article 4:6 par 2 Awb')
                      , ('Article 4:7 par 1 Awb')
                      , ('Article 4:7 par 2 Awb')
                      , ('Article 4:8 par 1 Awb')
                      , ('Article 4:8 par 2 Awb')
                      , ('Article 4:9 Awb')
                      , ('Article 4:11 par a Awb')
                      , ('Article 4:11 par b Awb')
                      , ('Article 4:11 par c Awb')
                      , ('Article 4:12 par 1 Awb')
                      , ('Article 4:12 par 2 sub a Awb')
                      , ('Article 4:12 par 2 sub b Awb')
                      , ('Article 4:12 par 2 sub c Awb')
                      , ('Article 4:13 par 1 Awb')
                      , ('Article 4:13 par 2 Awb')
                      , ('Article 4:14 par 1 Awb')
                      , ('Article 4:14 par 2 Awb')
                      , ('Article 4:14 par 3 Awb')
                      , ('Article 4:15 Awb')
                      , ('Article 4:21 par 1 Awb')
                      , ('Article 4:21 par 2 sub a Awb')
                      , ('Article 4:21 par 2 sub b Awb')
                      , ('Article 4:21 par 2 sub c Awb')
                      , ('Article 4:21 par 3 Awb')
                      , ('Article 4:21 par 4 Awb')
                      , ('Article 4:22 Awb')
                      , ('Article 4:23 par 1 Awb')
                      , ('Article 4:23 par 2 Awb')
                      , ('Article 4:23 par 3 sub a Awb')
                      , ('Article 4:23 par 3 sub b Awb')
                      , ('Article 4:23 par 3 sub c Awb')
                      , ('Article 4:23 par 3 sub d Awb')
                      , ('Article 4:23 par 4 Awb')
                      , ('Article 4:24 Awb')
                      , ('Article 4:25 par 1 Awb')
                      , ('Article 4:25 par 2 Awb')
                      , ('Article 4:25 par 3 Awb')
                      , ('Article 4:26 par 1 Awb')
                      , ('Article 4:27 par 1 Awb')
                      , ('Article 4:27 par 2 Awb')
                      , ('Article 4:28 Awb')
                      , ('Article 4:29 Awb')
                      , ('Article 4:30 par 1 Awb')
                      , ('Article 4:30 par 2 Awb')
                      , ('Article 4:31 par 1 Awb')
                      , ('Article 4:31 par 2 Awb')
                      , ('Article 4:32 Awb')
                      , ('Article 4:33 sub a Awb')
                      , ('Article 4:33 sub b Awb')
                      , ('Article 4:34 par 1 Awb')
                      , ('Article 4:34 par 2 Awb')
                      , ('Article 4:34 par 3 Awb')
                      , ('Article 4:34 par 4 Awb')
                      , ('Article 4:34 par 5 Awb')
                      , ('Article 4:35 par 1 sub a Awb')
                      , ('Article 4:35 par 1 sub b Awb')
                      , ('Article 4:35 par 1 sub c Awb')
                      , ('Article 4:35 par 2 sub a Awb')
                      , ('Article 4:35 par 2 sub b Awb')
                      , ('Article 4:36 par 1 Awb')
                      , ('Article 4:37 par 1 sub a Awb')
                      , ('Article 4:37 par 1 sub b Awb')
                      , ('Article 4:37 par 1 sub c Awb')
                      , ('Article 4:37 par 1 sub d Awb')
                      , ('Article 4:37 par 1 sub e Awb')
                      , ('Article 4:37 par 1 sub f Awb')
                      , ('Article 4:37 par 1 sub g Awb')
                      , ('Article 4:37 par 1 sub h Awb')
                      , ('Article 4:37 par 2 Awb')
                      , ('Article 4:38 par 1 Awb')
                      , ('Article 4:38 par 2 Awb')
                      , ('Article 4:38 par 3 Awb')
                      , ('Article 4:39 par 1 Awb')
                      , ('Article 4:39 par 2 Awb')
                      , ('Article 4:40 Awb')
                      , ('Article 4:41 par 1 Awb')
                      , ('Article 4:41 par 2 sub a Awb')
                      , ('Article 4:41 par 2 sub b Awb')
                      , ('Article 4:41 par 2 sub c Awb')
                      , ('Article 4:41 par 2 sub d Awb')
                      , ('Article 4:41 par 2 sub e Awb')
                      , ('Article 4:41 par 3 Awb')
                      , ('Article 4:42 Awb')
                      , ('Article 4:43 par 1 Awb')
                      , ('Article 4:43 par 2 Awb')
                      , ('Article 4:44 par 1 sub a Awb')
                      , ('Article 4:44 par 1 sub b Awb')
                      , ('Article 4:44 par 1 sub c Awb')
                      , ('Article 4:44 par 2 Awb')
                      , ('Article 4:44 par 3 Awb')
                      , ('Article 4:44 par 4 Awb')
                      , ('Article 4:45 par 1 Awb')
                      , ('Article 4:45 par 2 Awb')
                      , ('Article 4:46 par 1 Awb')
                      , ('Article 4:46 par 2 sub a Awb')
                      , ('Article 4:46 par 2 sub b Awb')
                      , ('Article 4:46 par 2 sub c Awb')
                      , ('Article 4:46 par 2 sub d Awb')
                      , ('Article 4:46 par 3 Awb')
                      , ('Article 4:47 sub a Awb')
                      , ('Article 4:47 sub b Awb')
                      , ('Article 4:47 sub c Awb')
                      , ('Article 4:48 par 1 sub a Awb')
                      , ('Article 4:48 par 1 sub b Awb')
                      , ('Article 4:48 par 1 sub c Awb')
                      , ('Article 4:48 par 1 sub d Awb')
                      , ('Article 4:48 par 1 sub e Awb')
                      , ('Article 4:48 par 2 Awb')
                      , ('Article 4:49 par 1 sub a Awb')
                      , ('Article 4:49 par 1 sub b Awb')
                      , ('Article 4:49 par 1 sub c Awb')
                      , ('Article 4:49 par 2 Awb')
                      , ('Article 4:49 par 3 Awb')
                      , ('Article 4:50 par 1 sub a Awb')
                      , ('Article 4:50 par 1 sub b Awb')
                      , ('Article 4:50 par 1 sub c Awb')
                      , ('Article 4:50 par 2 Awb')
                      , ('Article 4:51 par 1 Awb')
                      , ('Article 4:51 par 2 Awb')
                      , ('Article 4:52 par 1 Awb')
                      , ('Article 4:52 par 2 Awb')
                      , ('Article 4:52 par 3 Awb')
                      , ('Article 4:53 par 1 Awb')
                      , ('Article 4:53 par 2 Awb')
                      , ('Article 4:54 par 1 Awb')
                      , ('Article 4:54 par 2 Awb')
                      , ('Article 4:55 par 1 Awb')
                      , ('Article 4:55 par 2 Awb')
                      , ('Article 4:56 Awb')
                      , ('Article 4:57 Awb')
                      , ('Article 4:58 par 1 Awb')
                      , ('Article 4:58 par 2 Awb')
                      , ('Article 4:59 par 1 Awb')
                      , ('Article 4:59 par 2 Awb')
                      , ('Article 4:60 Awb')
                      , ('Article 4:61 par 1 Awb')
                      , ('Article 4:61 par 2 Awb')
                      , ('Article 4:62 Awb')
                      , ('Article 4:63 par 1 Awb')
                      , ('Article 4:63 par 2 Awb')
                      , ('Article 4:63 par 3 Awb')
                      , ('Article 4:64 par 1 Awb')
                      , ('Article 4:64 par 2 Awb')
                      , ('Article 4:64 par 3 Awb')
                      , ('Article 4:65 Awb')
                      , ('Article 4:66 Awb')
                      , ('Article 4:67 par 1 Awb')
                      , ('Article 4:67 par 2 Awb')
                      , ('Article 4:67 par 3 Awb')
                      , ('Article 4:68 Awb')
                      , ('Article 4:69 par 1 Awb')
                      , ('Article 4:69 par 2 Awb')
                      , ('Article 4:70 Awb')
                      , ('Article 4:71 par 1 sub a Awb')
                      , ('Article 4:71 par 1 sub b Awb')
                      , ('Article 4:71 par 1 sub c Awb')
                      , ('Article 4:71 par 1 sub d Awb')
                      , ('Article 4:71 par 1 sub e Awb')
                      , ('Article 4:71 par 1 sub f Awb')
                      , ('Article 4:71 par 1 sub g Awb')
                      , ('Article 4:71 par 1 sub h Awb')
                      , ('Article 4:71 par 1 sub i Awb')
                      , ('Article 4:71 par 1 sub j Awb')
                      , ('Article 4:71 par 2 Awb')
                      , ('Article 4:71 par 3 Awb')
                      , ('Article 4:71 par 4 Awb')
                      , ('Article 4:72 par 1 Awb')
                      , ('Article 4:72 par 2 Awb')
                      , ('Article 4:72 par 3 Awb')
                      , ('Article 4:72 par 4 Awb')
                      , ('Article 4:72 par 5 Awb')
                      , ('Article 4:73 Awb')
                      , ('Article 4:74 Awb')
                      , ('Article 4:75 par 1 Awb')
                      , ('Article 4:75 par 2 Awb')
                      , ('Article 4:76 par 1 Awb')
                      , ('Article 4:76 par 2 Awb')
                      , ('Article 4:76 par 3 Awb')
                      , ('Article 4:76 par 4 Awb')
                      , ('Article 4:76 par 5 Awb')
                      , ('Article 4:77 Awb')
                      , ('Article 4:78 par 1 Awb')
                      , ('Article 4:78 par 2 Awb')
                      , ('Article 4:78 par 3 Awb')
                      , ('Article 4:78 par 4 Awb')
                      , ('Article 4:78 par 5 Awb')
                      , ('Article 4:79 par 1 Awb')
                      , ('Article 4:79 par 2 Awb')
                      , ('Article 4:79 par 3 Awb')
                      , ('Article 4:80 Awb')
                      , ('Article 4:81 par 1 Awb')
                      , ('Article 4:81 par 2 Awb')
                      , ('Article 4:82 Awb')
                      , ('Article 4:83 Awb')
                      , ('Article 4:84 Awb')
                      , ('Article 5:11 Awb')
                      , ('Article 5:12 par 1 Awb')
                      , ('Article 5:12 par 2 Awb')
                      , ('Article 5:12 par 3 Awb')
                      , ('Article 5:13 Awb')
                      , ('Article 5:14 Awb')
                      , ('Article 5:15 par 1 Awb')
                      , ('Article 5:15 par 2 Awb')
                      , ('Article 5:15 par 3 Awb')
                      , ('Article 5:16 Awb')
                      , ('Article 5:16a Awb')
                      , ('Article 5:17 par 1 Awb')
                      , ('Article 5:17 par 2 Awb')
                      , ('Article 5:17 par 3 Awb')
                      , ('Article 5:18 par 1 Awb')
                      , ('Article 5:18 par 2 Awb')
                      , ('Article 5:18 par 3 Awb')
                      , ('Article 5:18 par 4 Awb')
                      , ('Article 5:18 par 5 Awb')
                      , ('Article 5:18 par 6 Awb')
                      , ('Article 5:19 par 1 Awb')
                      , ('Article 5:19 par 2 Awb')
                      , ('Article 5:19 par 3 Awb')
                      , ('Article 5:19 par 4 Awb')
                      , ('Article 5:19 par 5 Awb')
                      , ('Article 5:20 par 1 Awb')
                      , ('Article 5:20 par 2 Awb')
                      , ('Article 5:21 Awb')
                      , ('Article 5:22 Awb')
                      , ('Article 5:23 Awb')
                      , ('Article 5:24 par 1 Awb')
                      , ('Article 5:24 par 2 Awb')
                      , ('Article 5:24 par 3 Awb')
                      , ('Article 5:24 par 4 Awb')
                      , ('Article 5:24 par 5 Awb')
                      , ('Article 5:24 par 6 Awb')
                      , ('Article 5:25 par 1 Awb')
                      , ('Article 5:25 par 2 Awb')
                      , ('Article 5:25 par 3 Awb')
                      , ('Article 5:25 par 4 Awb')
                      , ('Article 5:25 par 5 Awb')
                      , ('Article 5:25 par 6 Awb')
                      , ('Article 5:26 par 1 Awb')
                      , ('Article 5:26 par 2 Awb')
                      , ('Article 5:26 par 3 Awb')
                      , ('Article 5:26 par 4 Awb')
                      , ('Article 5:27 par 1 Awb')
                      , ('Article 5:27 par 2 Awb')
                      , ('Article 5:27 par 3 Awb')
                      , ('Article 5:27 par 4 Awb')
                      , ('Article 5:27 par 5 Awb')
                      , ('Article 5:27 par 6 Awb')
                      , ('Article 5:28 Awb')
                      , ('Article 5:29 par 1 Awb')
                      , ('Article 5:29 par 2 Awb')
                      , ('Article 5:29 par 3 Awb')
                      , ('Article 5:29 par 4 Awb')
                      , ('Article 5:30 par 1 Awb')
                      , ('Article 5:30 par 2 Awb')
                      , ('Article 5:30 par 3 Awb')
                      , ('Article 5:30 par 4 Awb')
                      , ('Article 5:31 Awb')
                      , ('Article 5:32 par 1 Awb')
                      , ('Article 5:32 par 2 Awb')
                      , ('Article 5:32 par 3 Awb')
                      , ('Article 5:32 par 4 Awb')
                      , ('Article 5:32 par 5 Awb')
                      , ('Article 5:33 par 1 Awb')
                      , ('Article 5:33 par 2 Awb')
                      , ('Article 5:34 par 1 Awb')
                      , ('Article 5:34 par 2 Awb')
                      , ('Article 5:35 par 1 Awb')
                      , ('Article 5:35 par 2 Awb')
                      , ('Article 5:36 Awb')
                      , ('Article 6:1 Awb')
                      , ('Article 6:2 Awb')
                      , ('Article 6:3 Awb')
                      , ('Article 6:4 par 1 Awb')
                      , ('Article 6:4 par 2 Awb')
                      , ('Article 6:4 par 3 Awb')
                      , ('Article 6:5 par 1 Awb')
                      , ('Article 6:5 par 2 Awb')
                      , ('Article 6:5 par 3 Awb')
                      , ('Article 6:6 sub a Awb')
                      , ('Article 6:6 sub b Awb')
                      , ('Article 6:7 Awb')
                      , ('Article 6:8 par 1 Awb')
                      , ('Article 6:8 par 2 Awb')
                      , ('Article 6:8 par 3 Awb')
                      , ('Article 6:8 par 4 Awb')
                      , ('Article 6:9 par 1 Awb')
                      , ('Article 6:9 par 2 Awb')
                      , ('Article 6:10 par 1 sub a Awb')
                      , ('Article 6:10 par 1 sub b Awb')
                      , ('Article 6:10 par 2 Awb')
                      , ('Article 6:11 Awb')
                      , ('Article 6:12 par 1 Awb')
                      , ('Article 6:12 par 2 Awb')
                      , ('Article 6:12 par 3 Awb')
                      , ('Article 6:13 Awb')
                      , ('Article 6:14 par 1 Awb')
                      , ('Article 6:14 par 2 Awb')
                      , ('Article 6:15 par 1 Awb')
                      , ('Article 6:15 par 2 Awb')
                      , ('Article 6:15 par 3 Awb')
                      , ('Article 6:16 Awb')
                      , ('Article 6:17 Awb')
                      , ('Article 6:18 par 1 Awb')
                      , ('Article 6:18 par 2 Awb')
                      , ('Article 6:18 par 3 Awb')
                      , ('Article 6:18 par 4 Awb')
                      , ('Article 6:19 par 1 Awb')
                      , ('Article 6:19 par 2 Awb')
                      , ('Article 6:19 par 3 Awb')
                      , ('Article 6:20 par 1 Awb')
                      , ('Article 6:20 par 2 sub a Awb')
                      , ('Article 6:20 par 2 sub b Awb')
                      , ('Article 6:20 par 3 Awb')
                      , ('Article 6:20 par 4 Awb')
                      , ('Article 6:20 par 5 Awb')
                      , ('Article 6:20 par 6 Awb')
                      , ('Article 6:21 par 1 Awb')
                      , ('Article 6:21 par 2 Awb')
                      , ('Article 6:22 Awb')
                      , ('Article 6:23 par 1 Awb')
                      , ('Article 6:23 par 2 Awb')
                      , ('Article 6:24 Awb')
                      , ('Article 7:1 par 1 sub a Awb')
                      , ('Article 7:1 par 1 sub b Awb')
                      , ('Article 7:1 par 1 sub c Awb')
                      , ('Article 7:1 par 1 sub d Awb')
                      , ('Article 7:1 par 2 Awb')
                      , ('Article 7:1a par 1 Awb')
                      , ('Article 7:1a par 2 sub a Awb')
                      , ('Article 7:1a par 2 sub b Awb')
                      , ('Article 7:1a par 3 Awb')
                      , ('Article 7:1a par 4 Awb')
                      , ('Article 7:1a par 5 Awb')
                      , ('Article 7:1a par 6 Awb')
                      , ('Article 7:2 par 1 Awb')
                      , ('Article 7:2 par 2 Awb')
                      , ('Article 7:3 sub a Awb')
                      , ('Article 7:3 sub b Awb')
                      , ('Article 7:3 sub c Awb')
                      , ('Article 7:3 sub d Awb')
                      , ('Article 7:4 par 1 Awb')
                      , ('Article 7:4 par 2 Awb')
                      , ('Article 7:4 par 3 Awb')
                      , ('Article 7:4 par 4 Awb')
                      , ('Article 7:4 par 5 Awb')
                      , ('Article 7:4 par 6 Awb')
                      , ('Article 7:4 par 7 Awb')
                      , ('Article 7:4 par 8 Awb')
                      , ('Article 7:5 par 1 sub a Awb')
                      , ('Article 7:5 par 1 sub b Awb')
                      , ('Article 7:5 par 2 Awb')
                      , ('Article 7:6 par 1 Awb')
                      , ('Article 7:6 par 2 Awb')
                      , ('Article 7:6 par 3 Awb')
                      , ('Article 7:6 par 4 Awb')
                      , ('Article 7:7 Awb')
                      , ('Article 7:8 Awb')
                      , ('Article 7:9 Awb')
                      , ('Article 7:10 par 1 Awb')
                      , ('Article 7:10 par 2 Awb')
                      , ('Article 7:10 par 3 Awb')
                      , ('Article 7:10 par 4 Awb')
                      , ('Article 7:11 par 1 Awb')
                      , ('Article 7:11 par 2 Awb')
                      , ('Article 7:12 par 1 Awb')
                      , ('Article 7:12 par 2 Awb')
                      , ('Article 7:12 par 3 Awb')
                      , ('Article 7:12 par 4 Awb')
                      , ('Article 7:13 par 1 Awb')
                      , ('Article 7:13 par 2 Awb')
                      , ('Article 7:13 par 3 Awb')
                      , ('Article 7:13 par 4 Awb')
                      , ('Article 7:13 par 5 Awb')
                      , ('Article 7:13 par 6 Awb')
                      , ('Article 7:13 par 7 Awb')
                      , ('Article 7:14 Awb')
                      , ('Article 7:15 par 1 Awb')
                      , ('Article 7:15 par 2 Awb')
                      , ('Article 7:15 par 3 Awb')
                      , ('Article 7:15 par 4 Awb')
                      , ('Article 7:16 par 1 Awb')
                      , ('Article 7:16 par 2 Awb')
                      , ('Article 7:17 sub a Awb')
                      , ('Article 7:17 sub b Awb')
                      , ('Article 7:17 sub c Awb')
                      , ('Article 7:18 par 1 Awb')
                      , ('Article 7:18 par 2 Awb')
                      , ('Article 7:18 par 3 Awb')
                      , ('Article 7:18 par 4 Awb')
                      , ('Article 7:18 par 5 Awb')
                      , ('Article 7:18 par 6 Awb')
                      , ('Article 7:18 par 7 Awb')
                      , ('Article 7:18 par 8 Awb')
                      , ('Article 7:19 par 1 Awb')
                      , ('Article 7:19 par 2 Awb')
                      , ('Article 7:19 par 3 Awb')
                      , ('Article 7:20 par 1 Awb')
                      , ('Article 7:20 par 2 Awb')
                      , ('Article 7:20 par 3 Awb')
                      , ('Article 7:20 par 4 Awb')
                      , ('Article 7:21 Awb')
                      , ('Article 7:22 Awb')
                      , ('Article 7:23 Awb')
                      , ('Article 7:24 par 1 Awb')
                      , ('Article 7:24 par 2 Awb')
                      , ('Article 7:24 par 3 Awb')
                      , ('Article 7:24 par 4 Awb')
                      , ('Article 7:24 par 5 Awb')
                      , ('Article 7:24 par 6 Awb')
                      , ('Article 7:24 par 7 Awb')
                      , ('Article 7:25 Awb')
                      , ('Article 7:26 par 1 Awb')
                      , ('Article 7:26 par 2 Awb')
                      , ('Article 7:26 par 3 Awb')
                      , ('Article 7:26 par 4 Awb')
                      , ('Article 7:26 par 5 Awb')
                      , ('Article 7:27 Awb')
                      , ('Article 7:28 par 1 Awb')
                      , ('Article 7:28 par 2 Awb')
                      , ('Article 7:28 par 3 Awb')
                      , ('Article 7:28 par 4')
                      , ('Article 7:29 Awb')
                      , ('Article 8:1 par 1 Awb')
                      , ('Article 8:1 par 2 Awb')
                      , ('Article 8:1 par 3 Awb')
                      , ('Article 8:2 sub a Awb')
                      , ('Article 8:2 sub b Awb')
                      , ('Article 8:2 sub c Awb')
                      , ('Article 8:3 Awb')
                      , ('Article 8:4 sub a Awb')
                      , ('Article 8:4 sub b Awb')
                      , ('Article 8:4 sub c Awb')
                      , ('Article 8:4 sub d Awb')
                      , ('Article 8:4 sub e Awb')
                      , ('Article 8:4 sub f Awb')
                      , ('Article 8:4 sub g Awb')
                      , ('Article 8:4 sub h Awb')
                      , ('Article 8:4 sub i Awb')
                      , ('Article 8:4 sub j Awb')
                      , ('Article 8:4 sub k Awb')
                      , ('Article 8:4 sub l Awb')
                      , ('Article 8:5 par 1 Awb')
                      , ('Article 8:5 par 2 Awb')
                      , ('Article 8:6 par 1 Awb')
                      , ('Article 8:6 par 2 Awb')
                      , ('Article 8:7 par 1 Awb')
                      , ('Article 8:7 par 2 Awb')
                      , ('Article 8:8 par 1 Awb')
                      , ('Article 8:8 par 2 Awb')
                      , ('Article 8:8 par 3 Awb')
                      , ('Article 8:8 par 4 Awb')
                      , ('Article 8:9 Awb')
                      , ('Article 8:10 par 1 Awb')
                      , ('Article 8:10 par 2 Awb')
                      , ('Article 8:10 par 3 Awb')
                      , ('Article 8:10 par 4 Awb')
                      , ('Article 8:11 par 1 Awb')
                      , ('Article 8:11 par 2 Awb')
                      , ('Article 8:12 Awb')
                      , ('Article 8:13 par 1 Awb')
                      , ('Article 8:13 par 2 Awb')
                      , ('Article 8:13 par 3 Awb')
                      , ('Article 8:14 par 1 Awb')
                      , ('Article 8:14 par 2 Awb')
                      , ('Article 8:15 Awb')
                      , ('Article 8:16 par 1 Awb')
                      , ('Article 8:16 par 2 Awb')
                      , ('Article 8:16 par 3 Awb')
                      , ('Article 8:16 par 4 Awb')
                      , ('Article 8:16 par 5 Awb')
                      , ('Article 8:17 Awb')
                      , ('Article 8:18 par 1 Awb')
                      , ('Article 8:18 par 2 Awb')
                      , ('Article 8:18 par 3 Awb')
                      , ('Article 8:18 par 4 Awb')
                      , ('Article 8:18 par 5 Awb')
                      , ('Article 8:19 par 1 Awb')
                      , ('Article 8:19 par 2 Awb')
                      , ('Article 8:19 par 3 Awb')
                      , ('Article 8:20 par 1 Awb')
                      , ('Article 8:20 par 2 Awb')
                      , ('Article 8:20 par 3 Awb')
                      , ('Article 8:21 par 1 Awb')
                      , ('Article 8:21 par 2 Awb')
                      , ('Article 8:21 par 3 Awb')
                      , ('Article 8:22 par 1 Awb')
                      , ('Article 8:22 par 2 Awb')
                      , ('Article 8:23 par 1 Awb')
                      , ('Article 8:23 par 2 Awb')
                      , ('Article 8:24 par 1 Awb')
                      , ('Article 8:24 par 2 Awb')
                      , ('Article 8:24 par 3 Awb')
                      , ('Article 8:25 par 1 Awb')
                      , ('Article 8:25 par 2 Awb')
                      , ('Article 8:25 par 3 Awb')
                      , ('Article 8:26 par 1 Awb')
                      , ('Article 8:26 par 2 Awb')
                      , ('Article 8:27 par 1 Awb')
                      , ('Article 8:27 par 2 Awb')
                      , ('Article 8:28 Awb')
                      , ('Article 8:29 par 1 Awb')
                      , ('Article 8:29 par 2 Awb')
                      , ('Article 8:29 par 3 Awb')
                      , ('Article 8:29 par 4 Awb')
                      , ('Article 8:29 par 5 Awb')
                      , ('Article 8:30 Awb')
                      , ('Article 8:31 Awb')
                      , ('Article 8:32 par 1 Awb')
                      , ('Article 8:32 par 2 Awb')
                      , ('Article 8:33 par 1 Awb')
                      , ('Article 8:33 par 2 Awb')
                      , ('Article 8:33 par 3 Awb')
                      , ('Article 8:33 par 4 Awb')
                      , ('Article 8:34 par 1 Awb')
                      , ('Article 8:34 par 2 Awb')
                      , ('Article 8:35 par 1 Awb')
                      , ('Article 8:35 par 2 Awb')
                      , ('Article 8:36 par 1 Awb')
                      , ('Article 8:36 par 2 Awb')
                      , ('Article 8:37 par 1 Awb')
                      , ('Article 8:37 par 2 Awb')
                      , ('Article 8:37 par 3 Awb')
                      , ('Article 8:38 par 1 Awb')
                      , ('Article 8:38 par 2 Awb')
                      , ('Article 8:39 par 1 Awb')
                      , ('Article 8:39 par 2 Awb')
                      , ('Article 8:39 par 3 Awb')
                      , ('Article 8:40 Awb')
                      , ('Article 8:41 par 1 Awb')
                      , ('Article 8:41 par 2 Awb')
                      , ('Article 8:41 par 3 sub a-1 Awb')
                      , ('Article 8:41 par 3 sub a-2 Awb')
                      , ('Article 8:41 par 3 sub a-3 Awb')
                      , ('Article 8:41 par 3 sub a-4 Awb')
                      , ('Article 8:41 par 3 sub b Awb')
                      , ('Article 8:41 par 3 sub c Awb')
                      , ('Article 8:41 par 4 Awb')
                      , ('Article 8:41 par 5 Awb')
                      , ('Article 8:42 par 1 Awb')
                      , ('Article 8:42 par 2 Awb')
                      , ('Article 8:43 par 1 Awb')
                      , ('Article 8:43 par 2 Awb')
                      , ('Article 8:44 par 1 Awb')
                      , ('Article 8:44 par 2 Awb')
                      , ('Article 8:44 par 3 Awb')
                      , ('Article 8:45 par 1 Awb')
                      , ('Article 8:45 par 2 Awb')
                      , ('Article 8:45 par 3 Awb')
                      , ('Article 8:46 par 1 Awb')
                      , ('Article 8:46 par 2 Awb')
                      , ('Article 8:46 par 3 Awb')
                      , ('Article 8:47 par 1 Awb')
                      , ('Article 8:47 par 2 Awb')
                      , ('Article 8:47 par 3 Awb')
                      , ('Article 8:47 par 4 Awb')
                      , ('Article 8:47 par 5 Awb')
                      , ('Article 8:47 par 6 Awb')
                      , ('Article 8:48 par 1 Awb')
                      , ('Article 8:48 par 2 Awb')
                      , ('Article 8:49 Awb')
                      , ('Article 8:50 par 1 Awb')
                      , ('Article 8:50 par 2 Awb')
                      , ('Article 8:50 par 3 Awb')
                      , ('Article 8:50 par 4 Awb')
                      , ('Article 8:50 par 5 Awb')
                      , ('Article 8:51 par 1 Awb')
                      , ('Article 8:51 par 2 Awb')
                      , ('Article 8:51 par 3 Awb')
                      , ('Article 8:52 par 1 Awb')
                      , ('Article 8:52 par 2 sub a Awb')
                      , ('Article 8:52 par 2 sub b Awb')
                      , ('Article 8:52 par 2 sub c Awb')
                      , ('Article 8:52 par 2 sub d Awb')
                      , ('Article 8:52 par 2 sub e Awb')
                      , ('Article 8:52 par 3 Awb')
                      , ('Article 8:53 Awb')
                      , ('Article 8:54 par 1 sub a Awb')
                      , ('Article 8:54 par 1 sub b Awb')
                      , ('Article 8:54 par 1 sub c Awb')
                      , ('Article 8:54 par 1 sub d Awb')
                      , ('Article 8:54 par 2 Awb')
                      , ('Article 8:54a par 1 Awb')
                      , ('Article 8:54a par 2 Awb')
                      , ('Article 8:55 par 1 Awb')
                      , ('Article 8:55 par 2 Awb')
                      , ('Article 8:55 par 3 Awb')
                      , ('Article 8:55 par 4 Awb')
                      , ('Article 8:55 par 5 sub a Awb')
                      , ('Article 8:55 par 5 sub b Awb')
                      , ('Article 8:55 par 5 sub c Awb')
                      , ('Article 8:55 par 6 Awb')
                      , ('Article 8:55 par 7 Awb')
                      , ('Article 8:56 Awb')
                      , ('Article 8:57 Awb')
                      , ('Article 8:58 par 1 Awb')
                      , ('Article 8:58 par 2 Awb')
                      , ('Article 8:59 Awb')
                      , ('Article 8:60 par 1 Awb')
                      , ('Article 8:60 par 2 Awb')
                      , ('Article 8:60 par 3 Awb')
                      , ('Article 8:60 par 4 Awb')
                      , ('Article 8:61 par 1 Awb')
                      , ('Article 8:61 par 2 Awb')
                      , ('Article 8:61 par 3 Awb')
                      , ('Article 8:61 par 4 Awb')
                      , ('Article 8:61 par 5 Awb')
                      , ('Article 8:61 par 6 Awb')
                      , ('Article 8:61 par 7 Awb')
                      , ('Article 8:61 par 8 Awb')
                      , ('Article 8:62 par 1 Awb')
                      , ('Article 8:62 par 2 sub a Awb')
                      , ('Article 8:62 par 2 sub b Awb')
                      , ('Article 8:62 par 2 sub c Awb')
                      , ('Article 8:62 par 2 sub d Awb')
                      , ('Article 8:63 par 1 Awb')
                      , ('Article 8:63 par 2 Awb')
                      , ('Article 8:63 par 3 Awb')
                      , ('Article 8:64 par 1 Awb')
                      , ('Article 8:64 par 2 Awb')
                      , ('Article 8:64 par 3 Awb')
                      , ('Article 8:64 par 4 Awb')
                      , ('Article 8:64 par 5 Awb')
                      , ('Article 8:65 par 1 Awb')
                      , ('Article 8:65 par 2 Awb')
                      , ('Article 8:65 par 3 Awb')
                      , ('Article 8:66 par 1 Awb')
                      , ('Article 8:66 par 2 Awb')
                      , ('Article 8:66 par 3 Awb')
                      , ('Article 8:67 par 1 Awb')
                      , ('Article 8:67 par 2 Awb')
                      , ('Article 8:67 par 3 Awb')
                      , ('Article 8:67 par 4 Awb')
                      , ('Article 8:67 par 5 Awb')
                      , ('Article 8:67 par 6 Awb')
                      , ('Article 8:68 par 1 Awb')
                      , ('Article 8:68 par 2 Awb')
                      , ('Article 8:69 par 1 Awb')
                      , ('Article 8:69 par 2 Awb')
                      , ('Article 8:69 par 3 Awb')
                      , ('Article 8:70 sub a Awb')
                      , ('Article 8:70 sub b Awb')
                      , ('Article 8:70 sub c Awb')
                      , ('Article 8:70 sub d Awb')
                      , ('Article 8:71 Awb')
                      , ('Article 8:72 par 1 Awb')
                      , ('Article 8:72 par 2 Awb')
                      , ('Article 8:72 par 3 Awb')
                      , ('Article 8:72 par 4 Awb')
                      , ('Article 8:72 par 5 Awb')
                      , ('Article 8:72 par 6 Awb')
                      , ('Article 8:72 par 7 Awb')
                      , ('Article 8:73 par 1 Awb')
                      , ('Article 8:73 par 2 Awb')
                      , ('Article 8:73a par 1 Awb')
                      , ('Article 8:73a par 2 Awb')
                      , ('Article 8:73a par 3 Awb')
                      , ('Article 8:74 par 1 Awb')
                      , ('Article 8:74 par 2 Awb')
                      , ('Article 8:75 par 1 Awb')
                      , ('Article 8:75 par 2 Awb')
                      , ('Article 8:75 par 3 Awb')
                      , ('Article 8:75a par 1 Awb')
                      , ('Article 8:75a par 2 Awb')
                      , ('Article 8:76 Awb')
                      , ('Article 8:77 par 1 Awb')
                      , ('Article 8:77 par 2 Awb')
                      , ('Article 8:77 par 3 Awb')
                      , ('Article 8:78 Awb')
                      , ('Article 8:79 par 1 Awb')
                      , ('Article 8:79 par 2 Awb')
                      , ('Article 8:80 Awb')
                      , ('Article 8:81 par 1 Awb')
                      , ('Article 8:81 par 2 Awb')
                      , ('Article 8:81 par 3 Awb')
                      , ('Article 8:81 par 4 Awb')
                      , ('Article 8:81 par 5 Awb')
                      , ('Article 8:82 par 1 Awb')
                      , ('Article 8:82 par 2 Awb')
                      , ('Article 8:82 par 3 Awb')
                      , ('Article 8:82 par 4 Awb')
                      , ('Article 8:83 par 1 Awb')
                      , ('Article 8:83 par 2 Awb')
                      , ('Article 8:83 par 3 Awb')
                      , ('Article 8:83 par 4 Awb')
                      , ('Article 8:84 par 1 Awb')
                      , ('Article 8:84 par 2 sub a Awb')
                      , ('Article 8:84 par 2 sub b Awb')
                      , ('Article 8:84 par 2 sub c Awb')
                      , ('Article 8:84 par 2 sub d Awb')
                      , ('Article 8:84 par 3 Awb')
                      , ('Article 8:84 par 4 Awb')
                      , ('Article 8:85 par 1 Awb')
                      , ('Article 8:85 par 2 sub a Awb')
                      , ('Article 8:85 par 2 sub b Awb')
                      , ('Article 8:85 par 2 sub c Awb')
                      , ('Article 8:86 par 1 Awb')
                      , ('Article 8:86 par 2 Awb')
                      , ('Article 8:87 par 1 Awb')
                      , ('Article 8:87 par 2 Awb')
                      , ('Article 8:87 par 3 Awb')
                      , ('Article 8:88 par 1 Awb')
                      , ('Article 9:1 par 1 Awb')
                      , ('Article 9:1 par 2 Awb')
                      , ('Article 9:2 Awb')
                      , ('Article 9:3 Awb')
                      , ('Article 9:4 par 1 Awb')
                      , ('Article 9:4 par 2 Awb')
                      , ('Article 9:4 par 3 Awb')
                      , ('Article 9:5 Awb')
                      , ('Article 9:6 Awb')
                      , ('Article 9:7 par 1 Awb')
                      , ('Article 9:7 par 2 Awb')
                      , ('Article 9:8 par 1 sub a Awb')
                      , ('Article 9:8 par 1 sub b Awb')
                      , ('Article 9:8 par 1 sub c Awb')
                      , ('Article 9:8 par 1 sub d Awb')
                      , ('Article 9:8 par 1 sub e Awb')
                      , ('Article 9:8 par 1 sub f Awb')
                      , ('Article 9:8 par 2 Awb')
                      , ('Article 9:8 par 3 Awb')
                      , ('Article 9:9 Awb')
                      , ('Article 9:10 par 1 Awb')
                      , ('Article 9:10 par 2 Awb')
                      , ('Article 9:10 par 3 Awb')
                      , ('Article 9:11 par 1 Awb')
                      , ('Article 9:11 par 2 Awb')
                      , ('Article 9:12 par 1 Awb')
                      , ('Article 9:12 par 2 Awb')
                      , ('Article 9:12a Awb')
                      , ('Article 9:13 Awb')
                      , ('Article 9:14 par 1 Awb')
                      , ('Article 9:14 par 2 Awb')
                      , ('Article 9:15 par 1 Awb')
                      , ('Article 9:15 par 2 Awb')
                      , ('Article 9:15 par 3 Awb')
                      , ('Article 9:15 par 4 Awb')
                      , ('Article 9:16 Awb')
                      , ('Article 9:17 sub a Awb')
                      , ('Article 9:17 sub b Awb')
                      , ('Article 9:18 par 1 Awb')
                      , ('Article 9:18 par 2 Awb')
                      , ('Article 9:18 par 3 Awb')
                      , ('Article 9:19 par 1 Awb')
                      , ('Article 9:19 par 2 Awb')
                      , ('Article 9:20 par 1 Awb')
                      , ('Article 9:20 par 2 Awb')
                      , ('Article 9:21 Awb')
                      , ('Article 9:22 sub a Awb')
                      , ('Article 9:22 sub b Awb')
                      , ('Article 9:22 sub c Awb')
                      , ('Article 9:22 sub d Awb')
                      , ('Article 9:22 sub e Awb')
                      , ('Article 9:22 sub f Awb')
                      , ('Article 9:23 sub a Awb')
                      , ('Article 9:23 sub b Awb')
                      , ('Article 9:23 sub c Awb')
                      , ('Article 9:23 sub d Awb')
                      , ('Article 9:23 sub e Awb')
                      , ('Article 9:23 sub f Awb')
                      , ('Article 9:23 sub g Awb')
                      , ('Article 9:23 sub h Awb')
                      , ('Article 9:23 sub i Awb')
                      , ('Article 9:23 sub j Awb')
                      , ('Article 9:23 sub k Awb')
                      , ('Article 9:23 sub l Awb')
                      , ('Article 9:23 sub m Awb')
                      , ('Article 9:24 par 1 sub a Awb')
                      , ('Article 9:24 par 1 sub b Awb')
                      , ('Article 9:24 par 2 sub a Awb')
                      , ('Article 9:24 par 2 sub b Awb')
                      , ('Article 9:25 par 1 Awb')
                      , ('Article 9:25 par 2 Awb')
                      , ('Article 9:26 Awb')
                      , ('Article 9:27 par 1 Awb')
                      , ('Article 9:27 par 2 Awb')
                      , ('Article 9:27 par 3 Awb')
                      , ('Article 9:28 par 1 Awb')
                      , ('Article 9:28 par 2 Awb')
                      , ('Article 9:28 par 3 Awb')
                      , ('Article 9:29 Awb')
                      , ('Article 9:30 par 1 Awb')
                      , ('Article 9:30 par 2 Awb')
                      , ('Article 9:31 par 1 Awb')
                      , ('Article 9:31 par 2 Awb')
                      , ('Article 9:31 par 3 Awb')
                      , ('Article 9:31 par 4 Awb')
                      , ('Article 9:31 par 5 Awb')
                      , ('Article 9:31 par 6 Awb')
                      , ('Article 9:32 par 1 Awb')
                      , ('Article 9:32 par 2 Awb')
                      , ('Article 9:32 par 3 Awb')
                      , ('Article 9:33 par 1 Awb')
                      , ('Article 9:33 par 2 Awb')
                      , ('Article 9:34 par 1 Awb')
                      , ('Article 9:34 par 2 Awb')
                      , ('Article 9:34 par 3 Awb')
                      , ('Article 9:35 par 1 Awb')
                      , ('Article 9:35 par 2 Awb')
                      , ('Article 9:36 par 1 Awb')
                      , ('Article 9:36 par 2 Awb')
                      , ('Article 9:36 par 3 Awb')
                      , ('Article 9:36 par 4 Awb')
                      , ('Article 9:36 par 5 Awb')
                      , ('Article 10:1 Awb')
                      , ('Article 10:2 Awb')
                      , ('Article 10:3 par 1 Awb')
                      , ('Article 10:3 par 2 sub a Awb')
                      , ('Article 10:3 par 2 sub b Awb')
                      , ('Article 10:3 par 2 sub c Awb')
                      , ('Article 10:3 par 2 sub d Awb')
                      , ('Article 10:3 par 3 Awb')
                      , ('Article 10:4 par 1 Awb')
                      , ('Article 10:4 par 2 Awb')
                      , ('Article 10:5 par 1 Awb')
                      , ('Article 10:5 par 2 Awb')
                      , ('Article 10:6 par 1 Awb')
                      , ('Article 10:6 par 2 Awb')
                      , ('Article 10:7 Awb')
                      , ('Article 10:8 par 1 Awb')
                      , ('Article 10:8 par 2 Awb')
                      , ('Article 10:9 par 1 Awb')
                      , ('Article 10:9 par 2 Awb')
                      , ('Article 10:10 Awb')
                      , ('Article 10:11 par 1 Awb')
                      , ('Article 10:11 par 2 Awb')
                      , ('Article 10:12 Awb')
                      , ('Article 10:13 Awb')
                      , ('Article 10:14 Awb')
                      , ('Article 10:15 Awb')
                      , ('Article 10:16 par 1 Awb')
                      , ('Article 10:16 par 2 Awb')
                      , ('Article 10:17 Awb')
                      , ('Article 10:18 Awb')
                      , ('Article 10:19 Awb')
                      , ('Article 10:20 par 1 Awb')
                      , ('Article 10:20 par 2 Awb')
                      , ('Article 10:20 par 3 Awb')
                      , ('Article 10:25 Awb')
                      , ('Article 10:26 Awb')
                      , ('Article 10:27 Awb')
                      , ('Article 10:28 Awb')
                      , ('Article 10:29 par 1 Awb')
                      , ('Article 10:29 par 2 Awb')
                      , ('Article 10:30 par 1 Awb')
                      , ('Article 10:30 par 2 Awb')
                      , ('Article 10:31 par 1 Awb')
                      , ('Article 10:31 par 2 Awb')
                      , ('Article 10:31 par 3 Awb')
                      , ('Article 10:31 par 4 Awb')
                      , ('Article 10:32 par 1 Awb')
                      , ('Article 10:32 par 2 Awb')
                      , ('Article 10:33 Awb')
                      , ('Article 10:34 Awb')
                      , ('Article 10:35 Awb')
                      , ('Article 10:36 Awb')
                      , ('Article 10:37 Awb')
                      , ('Article 10:38 par 1 Awb')
                      , ('Article 10:38 par 2 Awb')
                      , ('Article 10:39 par 1 Awb')
                      , ('Article 10:39 par 2 Awb')
                      , ('Article 10:39 par 3 Awb')
                      , ('Article 10:40 Awb')
                      , ('Article 10:41 par 1 Awb')
                      , ('Article 10:41 par 2 Awb')
                      , ('Article 10:42 par 1 Awb')
                      , ('Article 10:42 par 2 Awb')
                      , ('Article 10:42 par 3 Awb')
                      , ('Article 10:43 Awb')
                      , ('Article 10:44 par 1 Awb')
                      , ('Article 10:44 par 2 Awb')
                      , ('Article 10:44 par 3 Awb')
                      , ('Article 10:44 par 4 Awb')
                      , ('Article 10:44 par 5 Awb')
                      , ('Article 10:45 Awb')
                      , ('Article 11:1 par 1 Awb')
                      , ('Article 11:1 par 2 Awb')
                      , ('Article 11:2 Awb')
                      , ('Article 11:3 Awb')
                      , ('Article 11:4 Awb')
                      , ('Article 48 par 1 RO')
                      , ('Article 6 par 1 RO')
                      , ('Article 6:6 Awb')
                      , ('Article 6:6 Awb; 8:70 par b Awb')
                      , ('Article 1:3 par. 3 Awb')
                      , ('Article 4:1 Awb')
                      , ('Article 1:5 par. 1 Awb')
                      , ('Article 1:5 par. 2 Awb')
                      , ('Article 1:5 par. 3 Awb')
                      , ('Article 6:6 Awb')
                      , ('Article 6:6 Awb; 8:70 par. b Awb')
                      , ('Article 8:55 par. 5 sub a Awb')
                      , ('Article 8:70 sub a Awb')
                      , ('Article 8:70 sub c Awb')
                      , ('Article 8:70 sub d Awb')
                      , ('Article 8:82 par. 3 Awb')
                      , ('Article 8:84 par. 2 sub a Awb')
                      , ('Article 8:84 par. 2 sub b Awb')
                      , ('Article 8:84 par. 2 sub c Awb')
                      , ('Article 8:84 par. 2 sub d Awb')
                      , ('Article 8:87 par. 3 Awb')
                      , ('Article 48 par. 1 RO')
                      , ('Article 6 par. 1 RO')
                      , ('Article 7:1a par. 6 Awb')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug act                             *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `act`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `act` (`i` )
                VALUES ('beslissen op aanvraag')
                      , ('aanvraag in behandeling nemen')
                      , ('maken van bezwaar')
                      , ('instellen van administratief beroep')
                      , ('instellen van beroep')
                      , ('bezwaar in behandeling nemen')
                      , ('beroep in behandeling nemen')
                      , ('bezwaar niet-ontvankelijk verklaren')
                      , ('beroep niet-ontvankelijk verklaren')
                      , ('griffierecht heffen')
                      , ('verzet niet-ontvankelijk verklaren')
                      , ('rechtbank onbevoegd verklaren')
                      , ('beroep ongegrond verklaren')
                      , ('beroep gegrond verklaren')
                      , ('Terugboeken griffierecht')
                      , ('voorzieningenrechter onbevoegd verklaren')
                      , ('verzoek niet-ontvankelijk verklaren')
                      , ('verzoek afwijzen')
                      , ('verzoek geheel of gedeeltelijk toewijzen')
                      , ('bezetting van enkelvoudige kamer bepalen')
                      , ('bezetting van meervoudige kamer bepalen')
                ");
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
    else
    mysql_query("INSERT IGNORE INTO `objecttype` (`i` )
                VALUES ('Aanvraag')
                      , ('Bezwaar')
                      , ('Administratief beroep')
                      , ('Beroep')
                      , ('Griffierecht')
                      , ('Verzet')
                      , ('Rechtbank')
                      , ('Rechter')
                      , ('Verzoek')
                      , ('Bezetting van enkelvoudige kamer')
                      , ('Bezetting van meervoudige kamer')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug verb                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `verb`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `verb` (`i` )
                VALUES ('Registreren')
                      , ('Beslissen')
                      , ('Bezwaar maken')
                      , ('Aanmaken')
                      , ('Niet-ontvankelijk verklaren')
                      , ('Heffen')
                      , ('Onbevoegd verklaren')
                      , ('Ongegrond verklaren')
                      , ('Gegrond verklaren')
                      , ('Terugboeken')
                      , ('Afwijzen')
                      , ('Toewijzen')
                      , ('Toekennen')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug object                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `object`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug role                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `role`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `role` (`i` )
                VALUES ('Plaintiff')
                      , ('Defendant')
                      , ('Joined')
                      , ('Nobody')
                      , ('Representative')
                      , ('Local official')
                      , ('Lawyer')
                      , ('InterestedParty')
                      , ('Secretary')
                      , ('Judge')
                      , ('Clerk')
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
    * Plug timestamp                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `timestamp`
                     ( `i` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `timestamp` (`i` )
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
    /***************************\
    * Plug casefile             *
    *                           *
    * fields:                   *
    * I/\caseFile;caseFile~  [] *
    * caseFile  []              *
    \***************************/
    mysql_query("CREATE TABLE `casefile`
                     ( `document` VARCHAR(255) NOT NULL
                     , `case` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `casefile` (`document` ,`case` )
                VALUES ('doc987384', '199902238')
                      , ('doc763820', 'AWB 07/2481 WRO')
                      , ('letter 2009/87743', 'SBR 02/74331')
                      , ('letter 2009/87743a', 'SBR 02/74331')
                      , ('schedule 2009/87743.1', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug plaintiff                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * plaintiff~  [TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `plaintiff`
                     ( `case` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `plaintiff` (`case` ,`party` )
                VALUES ('199902238', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('AWB 07/2481 WRO', 'Jan met de Vilten Hoed')
                      , ('SBR 02/74331', 'Mevr. El Amrani')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug defendant              *
    *                             *
    * fields:                     *
    * I/\defendant;defendant~  [] *
    * defendant  []               *
    \*****************************/
    mysql_query("CREATE TABLE `defendant`
                     ( `party` VARCHAR(255) NOT NULL
                     , `case` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `defendant` (`party` ,`case` )
                VALUES ('de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen', '199902238')
                      , ('het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam', 'AWB 07/2481 WRO')
                      , ('Gemeente Utrecht', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************************************\
    * Plug joinedinterestedparty                          *
    *                                                     *
    * fields:                                             *
    * I/\joinedInterestedParty;joinedInterestedParty~  [] *
    * joinedInterestedParty  []                           *
    \*****************************************************/
    mysql_query("CREATE TABLE `joinedinterestedparty`
                     ( `party` VARCHAR(255) NOT NULL
                     , `case` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `joinedinterestedparty` (`party` ,`case` )
                VALUES ('de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam', 'AWB 07/2481 WRO')
                      , ('Dhr. Klaas Vreugdenhil', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug authorizedrepresentative        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * authorizedRepresentative~  [TOT]     *
    \**************************************/
    mysql_query("CREATE TABLE `authorizedrepresentative`
                     ( `authorization` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `authorizedrepresentative` (`authorization` ,`party` )
                VALUES ('letter 2000/864821a', 'mr. M.R.A. Dekker')
                      , ('letter 2000/864821a', 'drs. D. de Rooij')
                      , ('letter 2000/860338e', 'mr. S.M. Klein')
                      , ('letter 2007/33-9887', 'mr. G.L.M. Teeuwen')
                      , ('letter 2007/33-9854', 'mr. J.H.A. van der Grinten')
                      , ('letter 2007/33-9910', 'mr. M.L.M. Lohman')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug for        *
    *                 *
    * fields:         *
    * I/\for;for~  [] *
    * for  []         *
    \*****************/
    mysql_query("CREATE TABLE `for`
                     ( `authorization` VARCHAR(255) NOT NULL
                     , `case` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `for` (`authorization` ,`case` )
                VALUES ('letter 2000/864821a', '199902238')
                      , ('letter 2000/860338e', '199902238')
                      , ('letter 2007/33-9887', 'AWB 07/2481 WRO')
                      , ('letter 2007/33-9854', 'AWB 07/2481 WRO')
                      , ('letter 2007/33-9910', 'AWB 07/2481 WRO')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************************\
    * Plug authorizationdocument          *
    *                                     *
    * fields:                             *
    * I/\authorization;authorization~  [] *
    * authorization  []                   *
    \*************************************/
    mysql_query("CREATE TABLE `authorizationdocument`
                     ( `document` VARCHAR(255) NOT NULL
                     , `authorization` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug clustercase        *
    *                         *
    * fields:                 *
    * I/\cluster;cluster~  [] *
    * cluster  []             *
    \*************************/
    mysql_query("CREATE TABLE `clustercase`
                     ( `case` VARCHAR(255) NOT NULL
                     , `cluster` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug base                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * base  [TOT]                          *
    \**************************************/
    mysql_query("CREATE TABLE `base`
                     ( `cluster` VARCHAR(255) NOT NULL
                     , `text` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug judge                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * judge  [TOT]                         *
    \**************************************/
    mysql_query("CREATE TABLE `judge`
                     ( `session` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `judge` (`session` ,`party` )
                VALUES ('Session RbAms 1094', 'mr. N.M. van Waterschoot')
                      , ('Session RvS 83', 'mr. J.H.B. van der Meer')
                      , ('Session RvS 84', 'mr. Ph.Q. van Otterloo-Pannerden')
                      , ('SBR 2009/05/02', 'mr. J. Ebbens')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*********************\
    * Plug clerk          *
    *                     *
    * fields:             *
    * I/\clerk;clerk~  [] *
    * clerk  []           *
    \*********************/
    mysql_query("CREATE TABLE `clerk`
                     ( `court` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `clerk` (`court` ,`party` )
                VALUES ('Amsterdam district court', 'mr. V.M. Behrens')
                      , ('Council of State', 'mr. J.J. Schuurman')
                      , ('Utrecht district court', 'mr. K.F. van Dam')
                      , ('Utrecht district court', 'mr. Ch. Dequaistenit')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug authorized               *
    *                               *
    * fields:                       *
    * I/\authorized;authorized~  [] *
    * authorized  []                *
    \*******************************/
    mysql_query("CREATE TABLE `authorized`
                     ( `case` VARCHAR(255) NOT NULL
                     , `court` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `authorized` (`case` ,`court` )
                VALUES ('199902238', 'Council of State')
                      , ('AWB 07/2481 WRO', 'Amsterdam district court')
                      , ('SBR 02/74331', 'Utrecht district court')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug members            *
    *                         *
    * fields:                 *
    * I/\members;members~  [] *
    * members  []             *
    \*************************/
    mysql_query("CREATE TABLE `members`
                     ( `party` VARCHAR(255) NOT NULL
                     , `panel` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `members` (`party` ,`panel` )
                VALUES ('mr. T.M.A. van Löben Sels', 'Amsterdam district court fourth single-judge panel')
                      , ('mr. G.M.P. Brouns', 'Roermond district court single-judge panel')
                      , ('mr. N.M. van Waterschoot', 'Amsterdam district court single-judge panel for cases of administrative law')
                      , ('mr. J.H.B. van der Meer', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('mr. Ph.Q. van Otterloo-Pannerden', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('mr. H.P. Kijlstra', 'Amsterdam district court single-judge panel for cases of administrative law')
                      , ('M. Vtodrager', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('mr. J. Sap', 'Three-judge panel to process judicial disqualifications of Utrecht district court')
                      , ('mr. M. ter Brugge', 'Three-judge panel to process judicial disqualifications of Utrecht district court')
                      , ('mr. L.E. Verschoor-Bergsma', 'Three-judge panel to process judicial disqualifications of Utrecht district court')
                      , ('mr. J. Ebbens', 'Utrecht district court single-judge panel for cases of administrative law')
                      , ('mr. B.J. van Ettekoven', 'Utrecht district court three-judge panel for cases of administrative law')
                      , ('mr. G.J. van Binsbergen', 'Utrecht district court three-judge panel for cases of administrative law')
                      , ('mr. J. Struiksma', 'Utrecht district court three-judge panel for cases of administrative law')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug lawtext            *
    *                         *
    * fields:                 *
    * I/\lawText;lawText~  [] *
    * lawText  []             *
    \*************************/
    mysql_query("CREATE TABLE `lawtext`
                     ( `article` VARCHAR(255) NOT NULL
                     , `text` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `lawtext` (`article` ,`text` )
                VALUES ('Article 1:1 par 1 sub a Awb', 'Onder bestuursorgaan wordt verstaan: a. een orgaan van een rechtspersoon die krachtens publiekrecht is ingesteld.')
                      , ('Article 1:1 par 1 sub b Awb', 'Onder bestuursorgaan wordt verstaan: b. een ander persoon of college, met enig openbaar gezag bekleed.')
                      , ('Article 1:1 par 2 sub a Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: a. de wetgevende macht.')
                      , ('Article 1:1 par 2 sub b Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: b. de kamers en de verenigde vergadering der Staten-Generaal.')
                      , ('Article 1:1 par 2 sub c Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: c. onafhankelijke, bij de wet ingestelde organen die met rechtspraak zijn belast, alsmede de Raad voor de rechtspraak en het College van afgevaardigden.')
                      , ('Article 1:1 par 2 sub d Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: d. de Raad van State en zijn afdelingen.')
                      , ('Article 1:1 par 2 sub e Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: e. de Algemene Rekenkamer.')
                      , ('Article 1:1 par 2 sub f Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: f. de Nationale ombudsman en de substituut-ombudsmannen als bedoeld in artikel 9, eerste lid, van de Wet Nationale ombudsman, en ombudsmannen en ombudscommissies als bedoeld in [1]artikel 9:17, onderdeel b.')
                      , ('Article 1:1 par 2 sub g Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: g. de voorzitters, leden, griffiers en secretarissen van de in de onderdelen b tot en met f bedoelde organen, de procureur-generaal, de plaatsvervangend procureur-generaal en de advocaten-generaal bij de Hoge Raad, de besturen van de in onderdeel c bedoelde organen alsmede de voorzitters van die besturen, alsmede de commissies uit het midden van de in de onderdelen b tot en met f bedoelde organen.')
                      , ('Article 1:1 par 2 sub h Awb', 'De volgende organen, personen en colleges worden niet als bestuursorgaan aangemerkt: h. de commissie van toezicht betreffende de inlichtingen- en veiligheidsdiensten, bedoeld in artikel 64 van de Wet op de inlichtingen- en veiligheidsdiensten 2002.')
                      , ('Article 1:1 par 3 Awb', 'Een ingevolge het tweede par uitgezonderd orgaan, persoon of college wordt wel als bestuursorgaan aangemerkt voor zover het orgaan, de persoon of het college besluiten neemt of handelingen verricht ten aanzien van een niet voor het leven benoemde ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig, zijn nagelaten betrekkingen of zijn rechtverkrijgenden.')
                      , ('Article 1:2 par 1 Awb', 'Onder belanghebbende wordt verstaan: degene wiens belang rechtstreeks bij een besluit is betrokken.')
                      , ('Article 1:2 par 2 Awb', 'Ten aanzien van bestuursorganen worden de hun toevertrouwde belangen als hun belangen beschouwd.')
                      , ('Article 1:2 par 3 Awb', 'Ten aanzien van rechtspersonen worden als hun belangen mede beschouwd de algemene en collectieve belangen die zij krachtens hun doelstellingen en blijkens hun feitelijke werkzaamheden in het bijzonder behartigen.')
                      , ('Article 1:3 par 1 Awb', 'Onder besluit wordt verstaan: een schriftelijke beslissing van een bestuursorgaan, inhoudende een publiekrechtelijke rechtshandeling.')
                      , ('Article 1:3 par 2 Awb', 'Onder beschikking wordt verstaan: een besluit dat niet van algemene strekking is, met inbegrip van de afwijzing van een aanvraag daarvan.')
                      , ('Article 1:3 par 3 Awb', 'Onder aanvraag wordt verstaan: een verzoek van een belanghebbende, een besluit te nemen.')
                      , ('Article 1:3 par 4 Awb', 'Onder beleidsregel wordt verstaan: een bij besluit vastgestelde algemene regel, niet zijnde een algemeen verbindend voorschrift, omtrent de afweging van belangen, de vaststelling van feiten of de uitleg van wettelijke voorschriften bij het gebruik van een bevoegdheid van een bestuursorgaan.')
                      , ('Article 1:4 par 1 Awb', 'Onder administratieve rechter wordt verstaan: een onafhankelijk, bij de wet ingesteld orgaan dat met administratieve rechtspraak is belast.')
                      , ('Article 1:4 par 2 Awb', 'Een tot de rechterlijke macht behorend gerecht wordt als administratieve rechter aangemerkt voor zover [2]hoofdstuk 8 of de Wet administratiefrechtelijke handhaving verkeersvoorschriften - met uitzondering van hoofdstuk VIII - van toepassing of van overeenkomstige toepassing is.')
                      , ('Article 1:5 par 1 Awb', 'Onder het maken van bezwaar wordt verstaan: het gebruik maken van de ingevolge een wettelijk voorschrift bestaande bevoegdheid, voorziening tegen een besluit te vragen bij het bestuursorgaan dat het besluit heeft genomen.')
                      , ('Article 1:5 par 2 Awb', 'Onder het instellen van administratief beroep wordt verstaan: het gebruik maken van de ingevolge een wettelijk voorschrift bestaande bevoegdheid, voorziening tegen een besluit te vragen bij een ander bestuursorgaan dan hetwelk het besluit heeft genomen.')
                      , ('Article 1:5 par 3 Awb', 'Onder het instellen van beroep wordt verstaan: het instellen van administratief beroep, dan wel van beroep bij een administratieve rechter.')
                      , ('Article 1:6 sub a Awb', 'De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: a. de opsporing en vervolging van strafbare feiten, alsmede de tenuitvoerlegging van strafrechtelijke beslissingen.')
                      , ('Article 1:6 sub b Awb', 'De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: b. de tenuitvoerlegging van vrijheidsbenemende maatregelen op grond van de Vreemdelingenwet 2000.')
                      , ('Article 1:6 sub c Awb', 'De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: c. de tenuitvoerlegging van andere vrijheidsbenemende maatregelen in een inrichting die in hoofdzaak bestemd is voor de tenuitvoerlegging van strafrechtelijke beslissingen.')
                      , ('Article 1:6 sub d Awb', 'De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: d. besluiten en handelingen ter uitvoering van de Wet militair tuchtrecht.')
                      , ('Article 1:6 sub e Awb', 'De hoofdstukken 2 tot en met 8 en 10 van deze wet zijn niet van toepassing op: e. besluiten en handelingen ter uitvoering van de Wet toetsing levensbeëindiging op verzoek en hulp bij zelfdoding.')
                      , ('Article 1:7 par 1 Awb', 'Indien door een bestuursorgaan ingevolge enig wettelijk voorschrift advies moet worden gevraagd of extern overleg moet worden gevoerd inzake een besluit alvorens een zodanig besluit kan worden genomen, geldt dat voorschrift niet indien het voorgenomen besluit uitsluitend strekt tot uitvoering van een bindend besluit van de Raad van de Europese Unie, van het Europees Parlement en de Raad gezamenlijk of van de Commissie van de Europese Gemeenschappen.')
                      , ('Article 1:7 par 2 Awb', 'Het eerste par is niet van toepassing op het horen van de Raad van State.')
                      , ('Article 1:8 par 1 Awb', 'Indien door een bestuursorgaan ingevolge enig wettelijk voorschrift van het ontwerp van een besluit kennis moet worden gegeven alvorens een zodanig besluit kan worden genomen, geldt dat voorschrift niet indien het voorgenomen besluit uitsluitend strekt tot uitvoering van een bindend besluit van de Raad van de Europese Unie, van het Europees Parlement en de Raad gezamenlijk of van de Commissie van de Europese Gemeenschappen.')
                      , ('Article 1:8 par 2 sub a Awb', 'Het eerste par is niet van toepassing op de overlegging van het ontwerp van een algemene maatregel van bestuur of ministeriële regeling aan de Staten-Generaal, indien: a. bij de wet is bepaald dat door of namens een der Kamers der Staten-Generaal of door een aantal leden daarvan de wens te kennen kan worden gegeven dat het onderwerp of de inwerkingtreding van die algemene maatregel van bestuur of ministeriële regeling bij de wet wordt geregeld.')
                      , ('Article 1:8 par 2 sub b Awb', 'Het eerste par is niet van toepassing op de overlegging van het ontwerp van een algemene maatregel van bestuur of ministeriële regeling aan de Staten-Generaal, indien: b. artikel 21.6, zesde lid, van de Wet milieubeheer of artikel 33 van de Wet verontreiniging oppervlaktewateren van toepassing is.')
                      , ('Article 1:9 Awb', 'Deze titel is van overeenkomstige toepassing op voorstellen van wet.')
                      , ('Article 2:1 par 1 Awb', 'Een ieder kan zich ter behartiging van zijn belangen in het verkeer met bestuursorganen laten bijstaan of door een gemachtigde laten vertegenwoordigen.')
                      , ('Article 2:1 par 2 Awb', 'Het bestuursorgaan kan van een gemachtigde een schriftelijke machtiging verlangen.')
                      , ('Article 2:2 par 1 Awb', 'Het bestuursorgaan kan bijstand of vertegenwoordiging door een persoon tegen wie ernstige bezwaren bestaan, weigeren.')
                      , ('Article 2:2 par 2 Awb', 'De belanghebbende en de in het eerste par bedoelde persoon worden van de weigering onverwijld schriftelijk in kennis gesteld.')
                      , ('Article 2:2 par 3 Awb', 'Het eerste par is niet van toepassing ten aanzien van advocaten.')
                      , ('Article 2:3 par 1 Awb', 'Het bestuursorgaan zendt geschriften tot behandeling waarvan kennelijk een ander bestuursorgaan bevoegd is, onverwijld door naar dat orgaan, onder gelijktijdige mededeling daarvan aan de afzender.')
                      , ('Article 2:3 par 2 Awb', 'Het bestuursorgaan zendt geschriften die niet voor hem bestemd zijn en die ook niet worden doorgezonden, zo spoedig mogelijk terug aan de afzender.')
                      , ('Article 2:4 par 1 Awb', 'Het bestuursorgaan vervult zijn taak zonder vooringenomenheid.')
                      , ('Article 2:4 par 2 Awb', 'Het bestuursorgaan waakt ertegen dat tot het bestuursorgaan behorende of daarvoor werkzame personen die een persoonlijk belang bij een besluit hebben, de besluitvorming beïnvloeden.')
                      , ('Article 2:5 par 1 Awb', 'Een ieder die is betrokken bij de uitvoering van de taak van een bestuursorgaan en daarbij de beschikking krijgt over gegevens waarvan hij het vertrouwelijke karakter kent of redelijkerwijs moet vermoeden, en voor wie niet reeds uit hoofde van ambt, beroep of wettelijk voorschrift ter zake van die gegevens een geheimhoudingsplicht geldt, is verplicht tot geheimhouding van die gegevens, behoudens voor zover enig wettelijk voorschrift hem tot mededeling verplicht of uit zijn taak de noodzaak tot mededeling voortvloeit.')
                      , ('Article 2:5 par 2 Awb', 'Het eerste par is mede van toepassing op instellingen en daartoe behorende of daarvoor werkzame personen die door een bestuursorgaan worden betrokken bij de uitvoering van zijn taak, en op instellingen en daartoe behorende of daarvoor werkzame personen die een bij of krachtens de wet toegekende taak uitoefenen.')
                      , ('Article 2:6 par 1 Awb', 'Bestuursorganen en onder hun verantwoordelijkheid werkzame personen gebruiken de Nederlandse taal, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Article 2:6 par 2 Awb', 'In afwijking van het eerste par kan een andere taal worden gebruikt indien het gebruik daarvan doelmatiger is en de belangen van derden daardoor niet onevenredig worden geschaad.')
                      , ('Article 2:7 par 1 Awb', 'Een ieder kan de Friese taal gebruiken in het verkeer met bestuursorganen, voor zover deze in de provincie Fryslân zijn gevestigd.')
                      , ('Article 2:7 par 2 Awb', 'Het eerste par geldt niet, indien het bestuursorgaan heeft verzocht de Nederlandse taal te gebruiken op de grond, dat het gebruik van de Friese taal tot een onevenredige belasting van het bestuurlijk verkeer zou leiden.')
                      , ('Article 2:8 par 1 Awb', 'Bestuursorganen kunnen in het mondeling verkeer binnen de provincie Fryslân de Friese taal gebruiken.')
                      , ('Article 2:8 par 2 Awb', 'Het eerste par geldt niet, indien de wederpartij heeft verzocht de Nederlandse taal te gebruiken op de grond, dat het gebruik van de Friese taal tot een onbevredigend verloop van het mondeling verkeer zou leiden.')
                      , ('Article 2:9 par 1 Awb', 'In de provincie Fryslân gevestigde bestuursorganen die niet tot de centrale overheid behoren, kunnen regels stellen over het gebruik van de Friese taal in schriftelijke stukken.')
                      , ('Article 2:9 par 2 Awb', 'Onze Minister wie het aangaat kan voor onderdelen van de centrale overheid waarvan het werkterrein zich uitstrekt tot de provincie Fryslân of een deel daarvan, regels stellen over het gebruik van de Friese taal in schriftelijke stukken.')
                      , ('Article 2:10 par 1 sub a Awb', 'Een schriftelijk stuk in de Friese taal wordt tevens in de Nederlandse taal opgesteld, indien het: a. bestemd of mede bestemd is voor buiten de provincie Fryslân gevestigde bestuursorganen of bestuursorganen van de centrale overheid.')
                      , ('Article 2:10 par 1 sub b Awb', 'Een schriftelijk stuk in de Friese taal wordt tevens in de Nederlandse taal opgesteld, indien het: b. algemeen verbindende voorschriften of beleidsregels inhoudt.')
                      , ('Article 2:10 par 1 sub c Awb', 'Een schriftelijk stuk in de Friese taal wordt tevens in de Nederlandse taal opgesteld, indien het: c. is opgesteld ter directe voorbereiding van de onder b genoemde voorschriften of regels.')
                      , ('Article 2:10 par 2 Awb', 'De bekendmaking, mededeling of terinzagelegging van een schriftelijk stuk als bedoeld in het eerste par geschiedt in ieder geval ook in de Nederlandse taal, tenzij redelijkerwijs kan worden aangenomen dat daaraan geen behoefte bestaat.')
                      , ('Article 2:11 par 1 Awb', 'Indien een schriftelijk stuk in de Friese taal is opgesteld, verstrekt het bestuursorgaan daarvan op verzoek een vertaling in de Nederlandse taal.')
                      , ('Article 2:11 par 2 Awb', 'Het bestuursorgaan kan voor het vertalen een vergoeding van ten hoogste de kosten verlangen.')
                      , ('Article 2:11 par 3 sub a Awb', 'Voor het vertalen kan geen vergoeding worden verlangd, indien het schriftelijk stuk: a. de notulen van de vergadering van een vertegenwoordigend orgaan inhoudt, en het belang van de verzoeker rechtstreeks bij het genotuleerde is betrokken, dan wel de notulen van de vergadering van een vertegenwoordigend orgaan inhoudt, en de vaststelling van algemeen verbindende voorschriften of beleidsregels betreft.')
                      , ('Article 2:11 par 3 sub b Awb', 'Voor het vertalen kan geen vergoeding worden verlangd, indien het schriftelijk stuk: b. een besluit of andere handeling inhoudt waarbij de verzoeker belanghebbende is.')
                      , ('Article 2:12 par 1 Awb', 'Een ieder kan in vergaderingen van in de provincie Fryslân gevestigde vertegenwoordigende organen de Friese taal gebruiken.')
                      , ('Article 2:12 par 2 Awb', 'Hetgeen in de Friese taal is gezegd, wordt in de Friese taal genotuleerd.')
                      , ('Article 2:13 par 1 Awb', 'In het verkeer tussen burgers en bestuursorganen kan een bericht elektronisch worden verzonden, mits de bepalingen van deze afdeling in acht worden genomen.')
                      , ('Article 2:13 par 2 sub a Awb', 'Het eerste par geldt niet, indien: a. dit bij of krachtens wettelijk voorschrift is bepaald.')
                      , ('Article 2:13 par 2 sub b Awb', 'Het eerste par geldt niet, indien: b. een vormvoorschrift zich tegen elektronische verzending verzet.')
                      , ('Article 2:14 par 1 Awb', 'Een bestuursorgaan kan een bericht dat tot een of meer geadresseerden is gericht, elektronisch verzenden voor zover de geadresseerde kenbaar heeft gemaakt dat hij langs deze weg voldoende bereikbaar is.')
                      , ('Article 2:14 par 2 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald, geschiedt de verzending van berichten die niet tot een of meer geadresseerden zijn gericht, niet uitsluitend elektronisch.')
                      , ('Article 2:14 par 3 Awb', 'Indien een bestuursorgaan een bericht elektronisch verzendt, geschiedt dit op een voldoende betrouwbare en vertrouwelijke manier, gelet op de aard en de inhoud van het bericht en het doel waarvoor het wordt gebruikt.')
                      , ('Article 2:15 par 1 Awb', 'Een bericht kan elektronisch naar een bestuursorgaan worden verzonden voor zover het bestuursorgaan kenbaar heeft gemaakt dat deze weg is geopend. Het bestuursorgaan kan nadere eisen stellen aan het gebruik van de elektronische weg.')
                      , ('Article 2:15 par 2 Awb', 'Een bestuursorgaan kan elektronisch verschafte gegevens en bescheiden weigeren voor zover de aanvaarding daarvan tot een onevenredige belasting voor het bestuursorgaan zou leiden.')
                      , ('Article 2:15 par 3 Awb', 'Een bestuursorgaan kan een elektronisch verzonden bericht weigeren voor zover de betrouwbaarheid of vertrouwelijkheid van dit bericht onvoldoende is gewaarborgd, gelet op de aard en de inhoud van het bericht en het doel waarvoor het wordt gebruikt.')
                      , ('Article 2:15 par 4 Awb', 'Het bestuursorgaan deelt een weigering op grond van dit artikel zo spoedig mogelijk aan de afzender mede.')
                      , ('Article 2:16 Awb', 'Aan het vereiste van ondertekening is voldaan door een elektronische handtekening, indien de methode die daarbij voor authentificatie is gebruikt voldoende betrouwbaar is, gelet op de aard en de inhoud van het elektronische bericht en het doel waarvoor het wordt gebruikt. De artikelen 15a, tweede tot en met zesde lid, en 15b van Boek 3 van het Burgerlijk Wetboek zijn van overeenkomstige toepassing, voor zover de aard van het bericht zich daartegen niet verzet. Bij wettelijk voorschrift kunnen aanvullende eisen worden gesteld.')
                      , ('Article 2:17 par 1 Awb', 'Als tijdstip waarop een bericht door een bestuursorgaan elektronisch is verzonden, geldt het tijdstip waarop het bericht een systeem voor gegevensverwerking bereikt waarover het bestuursorgaan geen controle heeft of, indien het bestuursorgaan en de geadresseerde gebruik maken van hetzelfde systeem voor gegevensverwerking, het tijdstip waarop het bericht toegankelijk wordt voor de geadresseerde.')
                      , ('Article 2:17 par 2 Awb', 'Als tijdstip waarop een bericht door een bestuursorgaan elektronisch is ontvangen, geldt het tijdstip waarop het bericht zijn systeem voor gegevensverwerking heeft bereikt.')
                      , ('Article 3:1 par 1 sub a Awb', 'Op besluiten, inhoudende algemeen verbindende voorschriften: a. is [5]afdeling 3.2 slechts van toepassing, voor zover de aard van de besluiten zich daartegen niet verzet.')
                      , ('Article 3:1 par 1 sub b Awb', 'Op besluiten, inhoudende algemeen verbindende voorschriften: b. zijn de [6]afdelingen 3.6 en [7]3.7 niet van toepassing.')
                      , ('Article 3:1 par 2 Awb', 'Op andere handelingen van bestuursorganen dan besluiten zijn de [8]afdelingen 3.2 tot en met 3.4 van overeenkomstige toepassing, voor zover de aard van de handelingen zich daartegen niet verzet.')
                      , ('Article 3:2 Awb', 'Bij de voorbereiding van een besluit vergaart het bestuursorgaan de nodige kennis omtrent de relevante feiten en de af te wegen belangen.')
                      , ('Article 3:3 Awb', 'Het bestuursorgaan gebruikt de bevoegdheid tot het nemen van een besluit niet voor een ander doel dan waarvoor die bevoegdheid is verleend.')
                      , ('Article 3:4 par 1 Awb', 'Het bestuursorgaan weegt de rechtstreeks bij het besluit betrokken belangen af, voor zover niet uit een wettelijk voorschrift of uit de aard van de uit te oefenen bevoegdheid een beperking voortvloeit.')
                      , ('Article 3:4 par 2 Awb', 'De voor een of meer belanghebbenden nadelige gevolgen van een besluit mogen niet onevenredig zijn in verhouding tot de met het besluit te dienen doelen.')
                      , ('Article 3:5 par 1 Awb', 'In deze afdeling wordt verstaan onder adviseur: een persoon of college, bij of krachtens wettelijk voorschrift belast met het adviseren inzake door een bestuursorgaan te nemen besluiten en niet werkzaam onder verantwoordelijkheid van dat bestuursorgaan.')
                      , ('Article 3:5 par 2 Awb', 'Deze afdeling is niet van toepassing op het horen van de Raad van State.')
                      , ('Article 3:6 par 1 Awb', 'Indien aan de adviseur niet reeds bij wettelijk voorschrift een termijn is gesteld, kan het bestuursorgaan aangeven binnen welke termijn een advies wordt verwacht. Deze termijn mag niet zodanig kort zijn, dat de adviseur zijn taak niet naar behoren kan vervullen.')
                      , ('Article 3:6 par 2 Awb', 'Indien het advies niet tijdig wordt uitgebracht staat het enkele ontbreken daarvan niet in de weg aan het nemen van het besluit.')
                      , ('Article 3:7 par 1 Awb', 'Het bestuursorgaan waaraan advies wordt uitgebracht, stelt aan de adviseur, al dan niet op verzoek, de gegevens ter beschikking die nodig zijn voor een goede vervulling van diens taak.')
                      , ('Article 3:7 par 2 Awb', 'Artikel 10 van de Wet openbaarheid van bestuur is van overeenkomstige toepassing.')
                      , ('Article 3:8 Awb', 'In of bij het besluit wordt de adviseur vermeld die advies heeft uitgebracht.')
                      , ('Article 3:9 Awb', 'Indien een besluit berust op een onderzoek naar feiten en gedragingen dat door een adviseur is verricht, dient het bestuursorgaan zich ervan te vergewissen dat dit onderzoek op zorgvuldige wijze heeft plaatsgevonden.')
                      , ('Article 3:9a Awb', 'Deze afdeling is van overeenkomstige toepassing op voorstellen van wet.')
                      , ('Article 3:10 par 1 Awb', 'Deze afdeling is van toepassing op de voorbereiding van besluiten indien dat bij wettelijk voorschrift of bij besluit van het bestuursorgaan is bepaald.')
                      , ('Article 3:10 par 2 Awb', 'Tenzij bij wettelijk voorschrift of bij besluit van het bestuursorgaan anders is bepaald, is deze afdeling niet van toepassing op de voorbereiding van een besluit inhoudende de afwijzing van een aanvraag tot intrekking of wijziging van een besluit.')
                      , ('Article 3:10 par 3 Awb', '[9]Afdeling 4.1.1 is mede van toepassing op andere besluiten dan beschikkingen, indien deze op aanvraag worden genomen en voorbereid overeenkomstig deze afdeling.')
                      , ('Article 3:11 par 1 Awb', 'Het bestuursorgaan legt het ontwerp van het te nemen besluit, met de daarop betrekking hebbende stukken die redelijkerwijs nodig zijn voor een beoordeling van het ontwerp, ter inzage.')
                      , ('Article 3:11 par 2 Awb', 'Artikel 10 van de Wet openbaarheid van bestuur is van overeenkomstige toepassing. Indien op grond daarvan bepaalde stukken niet ter inzage worden gelegd, wordt daarvan mededeling gedaan.')
                      , ('Article 3:11 par 3 Awb', 'Tegen vergoeding van ten hoogste de kosten verstrekt het bestuursorgaan afschrift van de ter inzage gelegde stukken.')
                      , ('Article 3:11 par 4 Awb', 'De stukken liggen ter inzage gedurende de in [10]artikel 3:16, eerste lid, bedoelde termijn.')
                      , ('Article 3:12 par 1 Awb', 'Voorafgaand aan de terinzagelegging geeft het bestuursorgaan in een of meer dag-, nieuws-, of huis-aan-huisbladen of op een andere geschikte wijze kennis van het ontwerp. Volstaan kan worden met het vermelden van de zakelijke inhoud.')
                      , ('Article 3:12 par 2 Awb', 'Indien het een besluit van een tot de centrale overheid behorend bestuursorgaan betreft, wordt de kennisgeving in ieder geval in de Staatscourant geplaatst, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Article 3:12 par 3 sub a Awb', 'In de kennisgeving wordt vermeld: a. waar en wanneer de stukken ter inzage zullen liggen.')
                      , ('Article 3:12 par 3 sub b Awb', 'In de kennisgeving wordt vermeld: b. wie in de gelegenheid worden gesteld om zienswijzen naar voren te brengen.')
                      , ('Article 3:12 par 3 sub c Awb', 'In de kennisgeving wordt vermeld: c. op welke wijze dit kan geschieden.')
                      , ('Article 3:12 par 3 sub d Awb', 'In de kennisgeving wordt vermeld: d. indien toepassing is gegeven aan [11]artikel 3:18, tweede lid: de termijn waarbinnen het besluit zal worden genomen.')
                      , ('Article 3:13 par 1 Awb', 'Indien het besluit tot een of meer belanghebbenden zal zijn gericht, zendt het bestuursorgaan voorafgaand aan de terinzagelegging het ontwerp toe aan hen, onder wie begrepen de aanvrager.')
                      , ('Article 3:13 par 2 Awb', '[12]Artikel 3:12, derde lid, is van overeenkomstige toepassing.')
                      , ('Article 3:14 par 1 Awb', 'Het bestuursorgaan vult de ter inzage gelegde stukken aan met nieuwe relevante stukken en gegevens.')
                      , ('Article 3:14 par 2 Awb', '[13]Artikel 3:11, tweede tot en met vierde lid, is van toepassing.')
                      , ('Article 3:15 par 1 Awb', 'Belanghebbenden kunnen bij het bestuursorgaan naar keuze schriftelijk of mondeling hun zienswijze over het ontwerp naar voren brengen.')
                      , ('Article 3:15 par 2 Awb', 'Bij wettelijk voorschrift of door het bestuursorgaan kan worden bepaald dat ook aan anderen de gelegenheid moet worden geboden hun zienswijze naar voren te brengen.')
                      , ('Article 3:15 par 3 Awb', 'Indien het een besluit op aanvraag betreft, stelt het bestuursorgaan de aanvrager zo nodig in de gelegenheid te reageren op de naar voren gebrachte zienswijzen.')
                      , ('Article 3:15 par 4 Awb', 'Indien het een besluit tot wijziging of intrekking van een besluit betreft, stelt het bestuursorgaan degene tot wie het te wijzigen of in te trekken besluit is gericht zo nodig in de gelegenheid te reageren op de naar voren gebrachte zienswijzen.')
                      , ('Article 3:16 par 1 Awb', 'De termijn voor het naar voren brengen van zienswijzen en het uitbrengen van adviezen als bedoeld in [14]afdeling 3.3, bedraagt zes weken, tenzij bij wettelijk voorschrift een langere termijn is bepaald.')
                      , ('Article 3:16 par 2 Awb', 'De termijn vangt aan met ingang van de dag waarop het ontwerp ter inzage is gelegd.')
                      , ('Article 3:16 par 3 Awb', 'Op schriftelijk naar voren gebrachte zienswijzen zijn de [15]artikelen 6:9 en [16]6:10 van overeenkomstige toepassing.')
                      , ('Article 3:17 Awb', 'Van hetgeen overeenkomstig [17]artikel 3:15 mondeling naar voren is gebracht, wordt een verslag gemaakt.')
                      , ('Article 3:18 par 1 Awb', 'Indien het een besluit op aanvraag betreft, neemt het bestuursorgaan het besluit zo spoedig mogelijk, doch uiterlijk zes maanden na ontvangst van de aanvraag.')
                      , ('Article 3:18 par 2 Awb', 'Indien de aanvraag een zeer ingewikkeld of omstreden onderwerp betreft, kan het bestuursorgaan, alvorens een ontwerp ter inzage te leggen, binnen acht weken na ontvangst van de aanvraag de in het eerste par bedoelde termijn met een redelijke termijn verlengen. Voordat het bestuursorgaan een besluit tot verlenging neemt, stelt het de aanvrager in de gelegenheid zijn zienswijze daarover naar voren te brengen.')
                      , ('Article 3:18 par 3 sub a Awb', 'In afwijking van het eerste par neemt het bestuursorgaan het besluit uiterlijk twaalf weken na de terinzagelegging van het ontwerp, indien het een besluit betreft: a. inzake intrekking van een besluit.')
                      , ('Article 3:18 par 3 sub b Awb', 'In afwijking van het eerste par neemt het bestuursorgaan het besluit uiterlijk twaalf weken na de terinzagelegging van het ontwerp, indien het een besluit betreft: b. inzake wijziging van een besluit en de aanvraag is gedaan door een ander dan degene tot wie het te wijzigen besluit is gericht.')
                      , ('Article 3:18 par 4 Awb', 'Indien geen zienswijzen naar voren zijn gebracht, doet het bestuursorgaan daarvan zo spoedig mogelijk nadat de termijn voor het naar voren brengen van zienswijzen is verstreken, mededeling op de wijze, bedoeld in [18]artikel 3:12, eerste en tweede lid. In afwijking van het eerste of derde par neemt het bestuursorgaan het besluit in dat geval binnen vier weken nadat de termijn voor het naar voren brengen van zienswijzen is verstreken.')
                      , ('Article 3:19 Awb', 'Deze afdeling is van toepassing op besluiten die nodig zijn om een bepaalde activiteit te mogen verrichten en op besluiten die strekken tot het vaststellen van een financiële aanspraak met het oog op die activiteit.')
                      , ('Article 3:20 par 1 Awb', 'Het bestuursorgaan bevordert dat een aanvrager in kennis wordt gesteld van andere op aanvraag te nemen besluiten waarvan het bestuursorgaan redelijkerwijs kan aannemen dat deze nodig zijn voor de door de aanvrager te verrichten activiteit.')
                      , ('Article 3:20 par 2 sub a Awb', 'Bij de kennisgeving wordt per besluit in ieder geval vermeld: a. naam en adres van het bestuursorgaan, bevoegd tot het nemen van het besluit.')
                      , ('Article 3:20 par 2 sub b Awb', 'Bij de kennisgeving wordt per besluit in ieder geval vermeld: b. krachtens welk wettelijk voorschrift het besluit wordt genomen.')
                      , ('Article 3:21 par 1 sub a Awb', 'Deze paragraaf is van toepassing op besluiten ten aanzien waarvan dit is bepaald: a. bij wettelijk voorschrift.')
                      , ('Article 3:21 par 1 sub b Awb', 'Deze paragraaf is van toepassing op besluiten ten aanzien waarvan dit is bepaald: b. bij besluit van de tot het nemen van die besluiten bevoegde bestuursorganen.')
                      , ('Article 3:21 par 2 Awb', 'Deze paragraaf is niet van toepassing op besluiten als bedoeld in [19]artikel 4:21, tweede lid, of ten aanzien waarvan bij of krachtens wettelijk voorschrift een periode is vastgesteld, na afloop waarvan wordt beslist op aanvragen die in die periode zijn ingediend.')
                      , ('Article 3:22 Awb', 'Bij of krachtens het in [20]artikel 3:21, eerste lid, onderdeel a, bedoelde wettelijk voorschrift of bij het in [21]artikel 3:21, eerste lid, onderdeel b, bedoelde besluit wordt een van de betrokken bestuursorganen aangewezen als coördinerend bestuursorgaan.')
                      , ('Article 3:23 par 1 Awb', 'Het coördinerend bestuursorgaan bevordert een doelmatige en samenhangende besluitvorming, waarbij de bestuursorganen bij de beoordeling van de aanvragen in ieder geval rekening houden met de onderlinge samenhang daartussen en tevens letten op de samenhang tussen de te nemen besluiten.')
                      , ('Article 3:23 par 2 Awb', 'De andere betrokken bestuursorganen verlenen de medewerking die voor het welslagen van een doelmatige en samenhangende besluitvorming nodig is.')
                      , ('Article 3:24 par 1 Awb', 'De besluiten worden zoveel mogelijk gelijktijdig aangevraagd, met dien verstande dat de laatste aanvraag niet later wordt ingediend dan zes weken na ontvangst van de eerste aanvraag.')
                      , ('Article 3:24 par 2 Awb', 'De aanvragen worden ingediend bij het coördinerend bestuursorgaan. Het coördinerend bestuursorgaan zendt terstond na ontvangst van de aanvragen een afschrift daarvan aan de bevoegde bestuursorganen.')
                      , ('Article 3:24 par 3 Awb', 'Indien een aanvraag voor een van de besluiten ontbreekt, stelt het coördinerend bestuursorgaan de aanvrager in de gelegenheid de ontbrekende aanvraag binnen een door het coördinerend bestuursorgaan te bepalen termijn in te dienen. Indien de ontbrekende aanvraag niet tijdig wordt ingediend, is het coördinerend bestuursorgaan bevoegd om deze paragraaf ten aanzien van bepaalde besluiten buiten toepassing te laten. In dat geval wordt voor de toepassing van bij wettelijk voorschrift geregelde termijnen het tijdstip waarop tot het buiten toepassing laten wordt beslist, gelijkgesteld met het tijdstip van ontvangst van de aanvraag.')
                      , ('Article 3:24 par 4 Awb', 'Bij het in [22]artikel 3:21, eerste lid, onderdeel a, bedoelde wettelijk voorschrift kan worden bepaald dat de aanvraag voor een besluit niet wordt behandeld indien niet tevens de aanvraag voor een ander besluit is ingediend.')
                      , ('Article 3:25 Awb', 'Onverminderd [23]artikel 3:24, derde en vierde lid, vangt de termijn voor het nemen van de besluiten aan met ingang van de dag waarop de laatste aanvraag is ontvangen.')
                      , ('Article 3:26 par 1 sub a Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: a. de ingevolge de [25]artikelen 3:11 en [26]3:44, eerste lid, onderdeel a, vereiste terinzagelegging geschiedt in ieder geval ten kantore van het coördinerend bestuursorgaan.')
                      , ('Article 3:26 par 1 sub b Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: b. het coördinerend bestuursorgaan draagt er zorg voor dat de gelegenheid tot het mondeling naar voren brengen van zienswijzen wordt gegeven met betrekking tot de ontwerpen van alle besluiten gezamenlijk.')
                      , ('Article 3:26 par 1 sub c Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: c. zienswijzen kunnen in ieder geval bij het coördinerend bestuursorgaan naar voren worden gebracht.')
                      , ('Article 3:26 par 1 sub d Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: d. indien over het ontwerp van een van de besluiten zienswijzen naar voren kunnen worden gebracht door een ieder, geldt dit eveneens met betrekking tot de ontwerpen van de andere besluiten.')
                      , ('Article 3:26 par 1 sub e Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: e. de ingevolge die afdeling en [27]afdeling 3.6 vereiste mededelingen, kennisgevingen en toezendingen geschieden door het coördinerend bestuursorgaan.')
                      , ('Article 3:26 par 1 sub f Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: f. alle besluiten worden genomen binnen de termijn die geldt voor het besluit met de langste beslistermijn.')
                      , ('Article 3:26 par 1 sub g Awb', 'Indien op de voorbereiding van een van de besluiten [24]afdeling 3.4 van toepassing is, is die afdeling van toepassing op de voorbereiding van alle besluiten, met inachtneming van het volgende: g. de dag van terinzagelegging bij het coördinerend bestuursorgaan is bepalend voor de aanvang van de beroepstermijn ingevolge [28]artikel 6:8, vierde lid.')
                      , ('Article 3:26 par 2 Awb', 'Indien [29]afdeling 3.4 niet van toepassing is, geschiedt de voorbereiding met toepassing of overeenkomstige toepassing van [30]afdeling 4.1.2 en de onderdelen b tot en met f van het eerste par van dit artikel.')
                      , ('Article 3:27 par 1 Awb', 'De bevoegde bestuursorganen zenden de door hen genomen besluiten toe aan het coördinerend bestuursorgaan.')
                      , ('Article 3:27 par 2 Awb', 'Het coördinerend bestuursorgaan maakt de besluiten gelijktijdig bekend en legt deze gelijktijdig ter inzage.')
                      , ('Article 3:28 par 1 Awb', 'Indien tegen een van de besluiten bezwaar kan worden gemaakt of administratief beroep kan worden ingesteld, geschiedt dit door het indienen van het bezwaar- of beroepschrift bij het coördinerend bestuursorgaan. Het coördinerend bestuursorgaan zendt terstond na ontvangst van het bezwaar- of beroepschrift een afschrift daarvan aan het bevoegde bestuursorgaan.')
                      , ('Article 3:28 par 2 Awb', 'De bevoegde bestuursorganen zenden de door hen genomen beslissingen op bezwaar of beroep toe aan het coördinerend bestuursorgaan. Het coördinerend bestuursorgaan maakt de beslissingen gelijktijdig bekend en doet de ingevolge [31]artikel 7:12, derde lid, of [32]7:26, vierde lid, vereiste mededelingen.')
                      , ('Article 3:28 par 3 Awb', 'Een beslissing op een verzoek in te stemmen met rechtstreeks beroep bij de administratieve rechter als bedoeld in [33]artikel 7:1a, vierde lid, wordt genomen door het coördinerend bestuursorgaan. Onverminderd [34]artikel 7:1a, tweede lid, wijst het coördinerend bestuursorgaan het verzoek in ieder geval af, indien tegen een van de andere besluiten een bezwaarschrift is ingediend waarin eenzelfde verzoek ontbreekt.')
                      , ('Article 3:29 par 1 Awb', 'Indien tegen een of meer van de besluiten beroep kan worden ingesteld bij de rechtbank, staat tegen alle besluiten beroep open bij de rechtbank binnen het rechtsgebied waarvan het coördinerend bestuursorgaan zijn zetel heeft.')
                      , ('Article 3:29 par 2 sub a Awb', 'Indien tegen alle besluiten beroep kan worden ingesteld bij een andere administratieve rechter dan de rechtbank, staat tegen alle besluiten beroep open bij: a. de Afdeling bestuursrechtspraak van de Raad van State, indien tegen een of meer van de besluiten bij de Afdeling beroep kan worden ingesteld.')
                      , ('Article 3:29 par 2 sub b Awb', 'Indien tegen alle besluiten beroep kan worden ingesteld bij een andere administratieve rechter dan de rechtbank, staat tegen alle besluiten beroep open bij: b. het College van Beroep voor het bedrijfsleven, indien tegen een of meer van de besluiten beroep kan worden ingesteld bij het College en onderdeel a niet van toepassing is.')
                      , ('Article 3:29 par 2 sub c Awb', 'Indien tegen alle besluiten beroep kan worden ingesteld bij een andere administratieve rechter dan de rechtbank, staat tegen alle besluiten beroep open bij: c. de Centrale Raad van Beroep, indien tegen een of meer van de besluiten beroep kan worden ingesteld bij de Centrale Raad van Beroep en de onderdelen a en b niet van toepassing zijn.')
                      , ('Article 3:29 par 3 sub a Awb', 'Indien tegen de uitspraak van de rechtbank inzake een of meer besluiten hoger beroep kan worden ingesteld bij: a. de Afdeling bestuursrechtspraak van de Raad van State, staat inzake alle besluiten hoger beroep open bij de Afdeling.')
                      , ('Article 3:29 par 3 sub b Awb', 'Indien tegen de uitspraak van de rechtbank inzake een of meer besluiten hoger beroep kan worden ingesteld bij: b. het College van Beroep voor het bedrijfsleven en onderdeel a niet van toepassing is, staat inzake alle besluiten hoger beroep open bij het College.')
                      , ('Article 3:29 par 3 sub c Awb', 'Indien tegen de uitspraak van de rechtbank inzake een of meer besluiten hoger beroep kan worden ingesteld bij: c. de Centrale Raad van Beroep en de onderdelen b en c niet van toepassing zijn, staat inzake alle besluiten hoger beroep open bij de Centrale Raad van Beroep.')
                      , ('Article 3:29 par 4 Awb', 'De ingevolge het eerste par bevoegde rechtbank of de ingevolge het tweede of derde par bevoegde administratieve rechter kan de behandeling van de beroepen in eerste aanleg dan wel de hoger beroepen verwijzen naar een andere rechtbank onderscheidenlijk een andere administratieve rechter die voor de behandeling ervan meer geschikt wordt geacht. [35]Artikel 8:13, tweede en derde lid, is van overeenkomstige toepassing.')
                      , ('Article 3:40 Awb', 'Een besluit treedt niet in werking voordat het is bekendgemaakt.')
                      , ('Article 3:41 par 1 Awb', 'De bekendmaking van besluiten die tot een of meer belanghebbenden zijn gericht, geschiedt door toezending of uitreiking aan hen, onder wie begrepen de aanvrager.')
                      , ('Article 3:41 par 2 Awb', 'Indien de bekendmaking van het besluit niet kan geschieden op de wijze als voorzien in het eerste lid, geschiedt zij op een andere geschikte wijze.')
                      , ('Article 3:42 par 1 Awb', 'De bekendmaking van besluiten die niet tot een of meer belanghebbenden zijn gericht, geschiedt door kennisgeving van het besluit of van de zakelijke inhoud ervan in een van overheidswege uitgegeven blad of een dag-, nieuws- of huis-aan-huisblad, dan wel op een andere geschikte wijze.')
                      , ('Article 3:42 par 2 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald, geschiedt de bekendmaking niet elektronisch.')
                      , ('Article 3:42 par 3 Awb', 'Indien alleen van de zakelijke inhoud wordt kennisgegeven, wordt het besluit tegelijkertijd ter inzage gelegd. In de kennisgeving wordt vermeld waar en wanneer het besluit ter inzage ligt.')
                      , ('Article 3:43 par 1 Awb', 'Tegelijkertijd met of zo spoedig mogelijk na de bekendmaking wordt van het besluit mededeling gedaan aan degenen die bij de voorbereiding ervan hun zienswijze naar voren hebben gebracht. Aan een adviseur als bedoeld in [36]artikel 3:5 wordt in ieder geval mededeling gedaan indien van het advies wordt afgeweken.')
                      , ('Article 3:43 par 2 Awb', 'Bij de mededeling van een besluit wordt tevens vermeld wanneer en hoe de bekendmaking ervan heeft plaatsgevonden.')
                      , ('Article 3:44 par 1 sub a Awb', 'Indien bij de voorbereiding van het besluit toepassing is gegeven aan [37]afdeling 3.4, geschiedt de mededeling, bedoeld in [38]artikel 3:43, eerste lid: a. met overeenkomstige toepassing van de [39]artikelen 3:11 en [40]3:12, eerste of tweede lid, en derde lid, onderdeel a, met dien verstande dat de stukken ter inzage liggen totdat de beroepstermijn is verstreken, en b. door toezending van een exemplaar van het besluit aan degenen die over het ontwerp van het besluit zienswijzen naar voren hebben gebracht.')
                      , ('Article 3:44 par 2 sub a Awb', 'In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: a. indien de omvang van het besluit daartoe aanleiding geeft, volstaan met een ieder van de daar bedoelde personen de strekking van het besluit mee te delen.')
                      , ('Article 3:44 par 2 sub b Awb', 'In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: b. indien een zienswijze door meer dan vijf personen naar voren is gebracht bij hetzelfde geschrift, volstaan met toezending van een exemplaar aan de vijf personen wier namen en adressen als eerste in dat geschrift zijn vermeld.')
                      , ('Article 3:44 par 2 sub c Awb', 'In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: c. indien een zienswijze naar voren is gebracht door meer dan vijf personen bij hetzelfde geschrift en de omvang van het besluit daartoe aanleiding geeft, volstaan met het meedelen aan de vijf personen wier namen en adressen als eerste in dat geschrift zijn vermeld, van de strekking van het besluit.')
                      , ('Article 3:44 par 2 sub d Awb', 'In afwijking van het eerste lid, onderdeel b, kan het bestuursorgaan: d. indien toezending zou moeten geschieden aan meer dan 250 personen, die toezending achterwege laten.')
                      , ('Article 3:45 par 1 Awb', 'Indien tegen een besluit bezwaar kan worden gemaakt of beroep kan worden ingesteld, wordt daarvan bij de bekendmaking en bij de mededeling van het besluit melding gemaakt.')
                      , ('Article 3:45 par 2 Awb', 'Hierbij wordt vermeld door wie, binnen welke termijn en bij welk orgaan bezwaar kan worden gemaakt of beroep kan worden ingesteld.')
                      , ('Article 3:46 Awb', 'Een besluit dient te berusten op een deugdelijke motivering.')
                      , ('Article 3:47 par 1 Awb', 'De motivering wordt vermeld bij de bekendmaking van het besluit.')
                      , ('Article 3:47 par 2 Awb', 'Daarbij wordt zo mogelijk vermeld krachtens welk wettelijk voorschrift het besluit wordt genomen.')
                      , ('Article 3:47 par 3 Awb', 'Indien de motivering in verband met de vereiste spoed niet aanstonds bij de bekendmaking van het besluit kan worden vermeld, verstrekt het bestuursorgaan deze binnen een week na de bekendmaking.')
                      , ('Article 3:47 par 4 Awb', 'In dat geval zijn de [41]artikelen 3:41 tot en met 3:43 van overeenkomstige toepassing.')
                      , ('Article 3:48 par 1 Awb', 'De vermelding van de motivering kan achterwege blijven indien redelijkerwijs kan worden aangenomen dat daaraan geen behoefte bestaat.')
                      , ('Article 3:48 par 2 Awb', 'Verzoekt een belanghebbende binnen een redelijke termijn om de motivering, dan wordt deze zo spoedig mogelijk verstrekt.')
                      , ('Article 3:49 Awb', 'Ter motivering van een besluit of een onderdeel daarvan kan worden volstaan met een verwijzing naar een met het oog daarop uitgebracht advies, indien het advies zelf de motivering bevat en van het advies kennis is of wordt gegeven.')
                      , ('Article 3:50 Awb', 'Indien het bestuursorgaan een besluit neemt dat afwijkt van een met het oog daarop krachtens wettelijk voorschrift uitgebracht advies, wordt zulks met de redenen voor de afwijking in de motivering vermeld.')
                      , ('Article 4:1 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald, wordt de aanvraag tot het geven van een beschikking schriftelijk ingediend bij het bestuursorgaan dat bevoegd is op de aanvraag te beslissen.')
                      , ('Article 4:2 par 1 sub a Awb', 'De aanvraag wordt ondertekend en bevat ten minste: a. de naam en het adres van de aanvrager.')
                      , ('Article 4:2 par 1 sub b Awb', 'De aanvraag wordt ondertekend en bevat ten minste: b. de dagtekening.')
                      , ('Article 4:2 par 1 sub c Awb', 'De aanvraag wordt ondertekend en bevat ten minste: c. een aanduiding van de beschikking die wordt gevraagd.')
                      , ('Article 4:2 par 2 Awb', 'De aanvrager verschaft voorts de gegevens en bescheiden die voor de beslissing op de aanvraag nodig zijn en waarover hij redelijkerwijs de beschikking kan krijgen.')
                      , ('Article 4:3 par 1 Awb', 'De aanvrager kan weigeren gegevens en bescheiden te verschaffen voor zover het belang daarvan voor de beslissing van het bestuursorgaan niet opweegt tegen het belang van de eerbiediging van de persoonlijke levenssfeer, met inbegrip van de bescherming van medische en psychologische onderzoeksresultaten, of tegen het belang van de bescherming van bedrijfs- en fabricagegegevens.')
                      , ('Article 4:3 par 2 Awb', 'Het eerste par is niet van toepassing op bij wettelijk voorschrift aangewezen gegevens en bescheiden waarvan is bepaald dat deze dienen te worden overgelegd.')
                      , ('Article 4:3a Awb', 'Het bestuursorgaan bevestigt de ontvangst van een elektronisch ingediende aanvraag.')
                      , ('Article 4:4 Awb', 'Het bestuursorgaan dat bevoegd is op de aanvraag te beslissen, kan voor het indienen van aanvragen en het verstrekken van gegevens een formulier vaststellen, voor zover daarin niet is voorzien bij wettelijk voorschrift.')
                      , ('Article 4:5 par 1 sub a Awb', 'Het bestuursorgaan kan besluiten de aanvraag niet te behandelen, indien: a. de aanvrager niet heeft voldaan aan enig wettelijk voorschrift voor het in behandeling nemen van de aanvraag, mits de aanvrager de gelegenheid heeft gehad de aanvraag binnen een door het bestuursorgaan gestelde termijn aan te vullen.')
                      , ('Article 4:5 par 1 sub b Awb', 'Het bestuursorgaan kan besluiten de aanvraag niet te behandelen, indien: b. de aanvraag geheel of gedeeltelijk is geweigerd op grond van [42]artikel 2:15, mits de aanvrager de gelegenheid heeft gehad de aanvraag binnen een door het bestuursorgaan gestelde termijn aan te vullen.')
                      , ('Article 4:5 par 1 sub c Awb', 'Het bestuursorgaan kan besluiten de aanvraag niet te behandelen, indien: c. de verstrekte gegevens en bescheiden onvoldoende zijn voor de beoordeling van de aanvraag of voor de voorbereiding van de beschikking, mits de aanvrager de gelegenheid heeft gehad de aanvraag binnen een door het bestuursorgaan gestelde termijn aan te vullen.')
                      , ('Article 4:5 par 2 Awb', 'Indien de aanvraag of een van de daarbij behorende gegevens of bescheiden in een vreemde taal is gesteld en een vertaling daarvan voor de beoordeling van de aanvraag of voor de voorbereiding van de beschikking noodzakelijk is, kan het bestuursorgaan besluiten de aanvraag niet te behandelen, mits de aanvrager de gelegenheid heeft gehad binnen een door het bestuursorgaan gestelde termijn de aanvraag met een vertaling aan te vullen.')
                      , ('Article 4:5 par 3 Awb', 'Indien de aanvraag of een van de daarbij behorende gegevens of bescheiden omvangrijk of ingewikkeld is en een samenvatting voor de beoordeling van de aanvraag of voor de voorbereiding van de beschikking noodzakelijk is, kan het bestuursorgaan besluiten de aanvraag niet te behandelen, mits de aanvrager de gelegenheid heeft gehad binnen een door het bestuursorgaan gestelde termijn de aanvraag met een samenvatting aan te vullen.')
                      , ('Article 4:5 par 4 Awb', 'Een besluit om de aanvraag niet te behandelen wordt aan de aanvrager bekendgemaakt binnen vier weken nadat de aanvraag is aangevuld of nadat de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Article 4:6 par 1 Awb', 'Indien na een geheel of gedeeltelijk afwijzende beschikking een nieuwe aanvraag wordt gedaan, is de aanvrager gehouden nieuw gebleken feiten of veranderde omstandigheden te vermelden.')
                      , ('Article 4:6 par 2 Awb', 'Wanneer geen nieuw gebleken feiten of veranderde omstandigheden worden vermeld, kan het bestuursorgaan zonder toepassing te geven aan [43]artikel 4:5 de aanvraag afwijzen onder verwijzing naar zijn eerdere afwijzende beschikking.')
                      , ('Article 4:7 par 1 Awb', 'Voordat een bestuursorgaan een aanvraag tot het geven van een beschikking geheel of gedeeltelijk afwijst, stelt het de aanvrager in de gelegenheid zijn zienswijze naar voren te brengen indien: a. de afwijzing zou steunen op gegevens over feiten en belangen, en b. die gegevens afwijken van gegevens die de aanvrager ter zake zelf heeft verstrekt.')
                      , ('Article 4:7 par 2 Awb', 'Het eerste par geldt niet indien sprake is van een afwijking van de aanvraag die slechts van geringe betekenis voor de aanvrager kan zijn.')
                      , ('Article 4:8 par 1 Awb', 'Voordat een bestuursorgaan een beschikking geeft waartegen een belanghebbende die de beschikking niet heeft aangevraagd naar verwachting bedenkingen zal hebben, stelt het die belanghebbende in de gelegenheid zijn zienswijze naar voren te brengen indien: a. de beschikking zou steunen op gegevens over feiten en belangen die de belanghebbende betreffen, en b. die gegevens niet door de belanghebbende zelf ter zake zijn verstrekt.')
                      , ('Article 4:8 par 2 Awb', 'Het eerste par geldt niet indien de belanghebbende niet heeft voldaan aan een wettelijke verplichting gegevens te verstrekken.')
                      , ('Article 4:9 Awb', 'Bij toepassing van de [44]artikelen 4:7 en [45]4:8 kan de belanghebbende naar keuze schriftelijk of mondeling zijn zienswijze naar voren brengen.')
                      , ('Article 4:11 par a Awb', 'Het bestuursorgaan kan toepassing van de [46]artikelen 4:7 en [47]4:8 achterwege laten voor zover: a. de vereiste spoed zich daartegen verzet.')
                      , ('Article 4:11 par b Awb', 'Het bestuursorgaan kan toepassing van de [46]artikelen 4:7 en [47]4:8 achterwege laten voor zover: b. de belanghebbende reeds eerder in de gelegenheid is gesteld zijn zienswijze naar voren te brengen en zich sindsdien geen nieuwe feiten of omstandigheden hebben voorgedaan.')
                      , ('Article 4:11 par c Awb', 'Het bestuursorgaan kan toepassing van de [46]artikelen 4:7 en [47]4:8 achterwege laten voor zover: c. het met de beschikking beoogde doel slechts kan worden bereikt indien de belanghebbende daarvan niet reeds tevoren in kennis is gesteld.')
                      , ('Article 4:12 par 1 Awb', 'Het bestuursorgaan kan toepassing van de [48]artikelen 4:7 en [49]4:8 voorts achterwege laten bij een beschikking die strekt tot het vaststellen van een financiële verplichting of aanspraak indien: a. tegen die beschikking bezwaar kan worden gemaakt of administratief beroep kan worden ingesteld, en b. de nadelige gevolgen na bezwaar of administratief beroep volledig ongedaan kunnen worden gemaakt.')
                      , ('Article 4:12 par 2 sub a Awb', 'Het eerste par geldt niet bij een beschikking die strekt tot: a. het op grond van [50]artikel 4:35 of met toepassing van [51]artikel 4:51 weigeren van een subsidie.')
                      , ('Article 4:12 par 2 sub b Awb', 'Het eerste par geldt niet bij een beschikking die strekt tot: b. het op grond van [52]artikel 4:46, tweede lid, lager vaststellen van een subsidie.')
                      , ('Article 4:12 par 2 sub c Awb', 'Het eerste par geldt niet bij een beschikking die strekt tot: c. het intrekken of ten nadele van de ontvanger wijzigen van een subsidieverlening of een subsidievaststelling.')
                      , ('Article 4:13 par 1 Awb', 'Een beschikking dient te worden gegeven binnen de bij wettelijk voorschrift bepaalde termijn of, bij het ontbreken van zulk een termijn, binnen een redelijke termijn na ontvangst van de aanvraag.')
                      , ('Article 4:13 par 2 Awb', 'De in het eerste par bedoelde redelijke termijn is in ieder geval verstreken wanneer het bestuursorgaan binnen acht weken na ontvangst van de aanvraag geen beschikking heeft gegeven, noch een kennisgeving als bedoeld in [53]artikel 4:14, derde lid, heeft gedaan.')
                      , ('Article 4:14 par 1 Awb', 'Indien een beschikking niet binnen de bij wettelijk voorschrift bepaalde termijn kan worden gegeven, deelt het bestuursorgaan dit aan de aanvrager mede en noemt het daarbij een zo kort mogelijke termijn waarbinnen de beschikking wel tegemoet kan worden gezien.')
                      , ('Article 4:14 par 2 Awb', 'Het eerste par is niet van toepassing indien het bestuursorgaan na het verstrijken van de bij wettelijk voorschrift bepaalde termijn niet langer bevoegd is.')
                      , ('Article 4:14 par 3 Awb', 'Indien, bij het ontbreken van een bij wettelijk voorschrift bepaalde termijn, een beschikking niet binnen acht weken kan worden gegeven, stelt het bestuursorgaan de aanvrager daarvan in kennis en noemt het daarbij een redelijke termijn waarbinnen de beschikking wel tegemoet kan worden gezien.')
                      , ('Article 4:15 Awb', 'De termijn voor het geven van een beschikking wordt opgeschort met ingang van de dag waarop het bestuursorgaan krachtens [54]artikel 4:5 de aanvrager uitnodigt de aanvraag aan te vullen, tot de dag waarop de aanvraag is aangevuld of de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Article 4:21 par 1 Awb', 'Onder subsidie wordt verstaan: de aanspraak op financiële middelen, door een bestuursorgaan verstrekt met het oog op bepaalde activiteiten van de aanvrager, anders dan als betaling voor aan het bestuursorgaan geleverde goederen of diensten.')
                      , ('Article 4:21 par 2 sub a Awb', 'Deze titel is niet van toepassing op aanspraken of verplichtingen die voortvloeien uit een wettelijk voorschrift inzake: a. belastingen.')
                      , ('Article 4:21 par 2 sub b Awb', 'Deze titel is niet van toepassing op aanspraken of verplichtingen die voortvloeien uit een wettelijk voorschrift inzake: b. de heffing van een premie dan wel een premievervangende belasting ingevolge de Wet financiering sociale verzekeringen.')
                      , ('Article 4:21 par 2 sub c Awb', 'Deze titel is niet van toepassing op aanspraken of verplichtingen die voortvloeien uit een wettelijk voorschrift inzake: c. de heffing van een inkomensafhankelijke bijdrage dan wel een bijdragevervangende belasting ingevolge de Zorgverzekeringswet.')
                      , ('Article 4:21 par 3 Awb', 'Deze titel is niet van toepassing op de aanspraak op financiële middelen die wordt verstrekt op grond van een wettelijk voorschrift dat uitsluitend voorziet in verstrekking aan rechtspersonen die krachtens publiekrecht zijn ingesteld.')
                      , ('Article 4:21 par 4 Awb', 'Deze titel is van overeenkomstige toepassing op de bekostiging van het onderwijs en onderzoek.')
                      , ('Article 4:22 Awb', 'Onder subsidieplafond wordt verstaan: het bedrag dat gedurende een bepaald tijdvak ten hoogste beschikbaar is voor de verstrekking van subsidies krachtens een bepaald wettelijk voorschrift.')
                      , ('Article 4:23 par 1 Awb', 'Een bestuursorgaan verstrekt slechts subsidie op grond van een wettelijk voorschrift dat regelt voor welke activiteiten subsidie kan worden verstrekt.')
                      , ('Article 4:23 par 2 Awb', 'Indien een zodanig wettelijk voorschrift is opgenomen in een niet op een wet berustende algemene maatregel van bestuur, vervalt dat voorschrift vier jaren nadat het in werking is getreden, tenzij voor dat tijdstip een voorstel van wet bij de Staten-Generaal is ingediend waarin de subsidie wordt geregeld.')
                      , ('Article 4:23 par 3 sub a Awb', 'Het eerste par is niet van toepassing: a. in afwachting van de totstandkoming van een wettelijk voorschrift gedurende ten hoogste een jaar of totdat een binnen dat jaar bij de Staten-Generaal ingediend wetsvoorstel is verworpen of tot wet is verheven en in werking is getreden.')
                      , ('Article 4:23 par 3 sub b Awb', 'Het eerste par is niet van toepassing: b. indien de subsidie rechtstreeks op grond van een door de Raad van de Europese Unie, het Europees Parlement en de Raad gezamenlijk of de Commissie van de Europese Gemeenschappen vastgesteld programma wordt verstrekt.')
                      , ('Article 4:23 par 3 sub c Awb', 'Het eerste par is niet van toepassing: c. indien de begroting de subsidie-ontvanger en het bedrag waarop de subsidie ten hoogste kan worden vastgesteld, vermeldt')
                      , ('Article 4:23 par 3 sub d Awb', 'Het eerste par is niet van toepassing: d. in incidentele gevallen, mits de subsidie voor ten hoogste vier jaren wordt verstrekt.')
                      , ('Article 4:23 par 4 Awb', 'Het bestuursorgaan publiceert jaarlijks een verslag van de verstrekking van subsidies met toepassing van het derde lid, onderdelen a en d.')
                      , ('Article 4:24 Awb', 'Indien een subsidie op een wettelijk voorschrift berust, wordt ten minste eenmaal in de vijf jaren een verslag gepubliceerd over de doeltreffendheid en de effecten van de subsidie in de praktijk, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Article 4:25 par 1 Awb', 'Een subsidieplafond kan slechts bij of krachtens wettelijk voorschrift worden vastgesteld.')
                      , ('Article 4:25 par 2 Awb', 'Een subsidie wordt geweigerd voor zover door verstrekking van de subsidie het subsidieplafond zou worden overschreden.')
                      , ('Article 4:25 par 3 Awb', 'Indien niet tijdig, dan wel in bezwaar of beroep of ter uitvoering van een rechterlijke uitspraak omtrent verstrekking wordt beslist, geldt de verplichting van het tweede par slechts voor zover zij ook gold op het tijdstip, waarop de beslissing in eerste aanleg werd genomen of had moeten worden genomen.')
                      , ('Article 4:26 par 1 Awb', 'Bij of krachtens wettelijk voorschrift wordt bepaald hoe het beschikbare bedrag wordt verdeeld.')
                      , ('Article 4:25 par 2 Awb', 'Bij de bekendmaking van het subsidieplafond wordt de wijze van verdeling vermeld.')
                      , ('Article 4:27 par 1 Awb', 'Het subsidieplafond wordt bekendgemaakt voor de aanvang van het tijdvak waarvoor het is vastgesteld.')
                      , ('Article 4:27 par 2 Awb', 'Indien het subsidieplafond of een verlaging daarvan later wordt bekendgemaakt, heeft deze bekendmaking geen gevolgen voor voordien ingediende aanvragen.')
                      , ('Article 4:28 Awb', '[55]Artikel 4:27, tweede lid, is niet van toepassing, indien: a. de aanvragen voor het tijdvak waarvoor het subsidieplafond is vastgesteld ingevolge wettelijk voorschrift moeten worden ingediend op een tijdstip waarop de begroting nog niet is vastgesteld of goedgekeurd; b. het een verlaging betreft die voortvloeit uit de vaststelling of goedkeuring van de begroting, en c. bij de bekendmaking van het subsidieplafond is gewezen op de mogelijkheid van verlaging en de gevolgen daarvan voor reeds ingediende aanvragen.')
                      , ('Article 4:29 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald kan voorafgaand aan een subsidievaststelling een beschikking omtrent subsidieverlening worden gegeven, indien een aanvraag daartoe is ingediend voor de afloop van de activiteit of het tijdvak waarvoor de subsidie wordt gevraagd.')
                      , ('Article 4:30 par 1 Awb', 'De beschikking tot subsidieverlening bevat een omschrijving van de activiteiten waarvoor subsidie wordt verleend.')
                      , ('Article 4:30 par 2 Awb', 'De omschrijving kan later worden uitgewerkt, voor zover de beschikking tot subsidieverlening dit vermeldt.')
                      , ('Article 4:31 par 1 Awb', 'De beschikking tot subsidieverlening vermeldt het bedrag van de subsidie, dan wel de wijze waarop dit bedrag wordt bepaald.')
                      , ('Article 4:31 par 2 Awb', 'Indien de beschikking tot subsidieverlening het bedrag van de subsidie niet vermeldt, vermeldt zij het bedrag waarop de subsidie ten hoogste kan worden vastgesteld, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Article 4:32 Awb', 'Een subsidie in de vorm van een periodieke aanspraak op financiële middelen wordt verleend voor een bepaald tijdvak, dat in de beschikking tot subsidieverlening wordt vermeld.')
                      , ('Article 4:33 sub a Awb', 'Een subsidie kan niet worden verleend onder de voorwaarde dat uitsluitend het bestuursorgaan of uitsluitend de subsidie-ontvanger een bepaalde handeling verricht, tenzij het betreft de voorwaarde dat: a. de subsidie-ontvanger medewerkt aan de totstandkoming van een overeenkomst ter uitvoering van de beschikking tot subsidieverlening.')
                      , ('Article 4:33 sub b Awb', 'Een subsidie kan niet worden verleend onder de voorwaarde dat uitsluitend het bestuursorgaan of uitsluitend de subsidie-ontvanger een bepaalde handeling verricht, tenzij het betreft de voorwaarde dat: b. de subsidie-ontvanger aantoont dat een gebeurtenis, niet zijnde een handeling van het bestuursorgaan of van de subsidie-ontvanger, heeft plaatsgevonden.')
                      , ('Article 4:34 par 1 Awb', 'Voor zover een subsidie wordt verleend ten laste van een begroting die nog niet is vastgesteld of goedgekeurd, kan zij worden verleend onder de voorwaarde dat voldoende gelden ter beschikking worden gesteld.')
                      , ('Article 4:34 par 2 Awb', 'De voorwaarde kan niet worden gesteld, voor zover zulks voortvloeit uit het wettelijk voorschrift waarop de subsidie berust.')
                      , ('Article 4:34 par 3 Awb', 'De voorwaarde vervalt, indien het bestuursorgaan daarop niet binnen vier weken na de vaststelling of goedkeuring van de begroting een beroep heeft gedaan.')
                      , ('Article 4:34 par 4 Awb', 'Het beroep op de voorwaarde geschiedt bij een subsidie voor een activiteit die door het bestuursorgaan ook in het voorafgaande begrotingsjaar werd gesubsidieerd door een intrekking wegens veranderde omstandigheden overeenkomstig [56]artikel 4:50.')
                      , ('Article 4:34 par 5 Awb', 'In andere gevallen geschiedt het beroep op de voorwaarde door een intrekking overeenkomstig [57]artikel 4:48, eerste lid.')
                      , ('Article 4:35 par 1 sub a Awb', 'De subsidieverlening kan in ieder geval worden geweigerd indien een gegronde reden bestaat om aan te nemen dat: a. de activiteiten niet of niet geheel zullen plaatsvinden.')
                      , ('Article 4:35 par 1 sub b Awb', 'De subsidieverlening kan in ieder geval worden geweigerd indien een gegronde reden bestaat om aan te nemen dat: b. de aanvrager niet zal voldoen aan de aan de subsidie verbonden verplichtingen.')
                      , ('Article 4:35 par 1 sub c Awb', 'De subsidieverlening kan in ieder geval worden geweigerd indien een gegronde reden bestaat om aan te nemen dat: c. de aanvrager niet op een behoorlijke wijze rekening en verantwoording zal afleggen omtrent de verrichte activiteiten en de daaraan verbonden uitgaven en inkomsten, voor zover deze voor de vaststelling van de subsidie van belang zijn.')
                      , ('Article 4:35 par 2 sub a Awb', 'De subsidieverlening kan voorts in ieder geval worden geweigerd indien de aanvrager: a. in het kader van de aanvraag onjuiste of onvolledige gegevens heeft verstrekt en de verstrekking van deze gegevens tot een onjuiste beschikking op de aanvraag zou hebben geleid.')
                      , ('Article 4:35 par 2 sub b Awb', 'De subsidieverlening kan voorts in ieder geval worden geweigerd indien de aanvrager: b. failliet is verklaard of aan hem surséance van betaling is verleend of ten aanzien van hem de schuldsaneringsregeling natuurlijke personen van toepassing is verklaard, dan wel een verzoek daartoe bij de rechtbank is ingediend.')
                      , ('Article 4:36 par 1 Awb', 'Ter uitvoering van de beschikking tot subsidieverlening kan een overeenkomst worden gesloten.')
                      , ('Article 4:34 par 2 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald of de aard van de subsidie zich daartegen verzet, kan in de overeenkomst worden bepaald dat de subsidie-ontvanger verplicht is de activiteiten te verrichten waarvoor de subsidie is verleend.')
                      , ('Article 4:37 par 1 sub a Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: a. aard en omvang van de activiteiten waarvoor subsidie wordt verleend.')
                      , ('Article 4:37 par 1 sub b Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: b. de administratie van aan de activiteiten verbonden uitgaven en inkomsten.')
                      , ('Article 4:37 par 1 sub c Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: c. het vóór de subsidievaststelling verstrekken van gegevens en bescheiden die nodig zijn voor een beslissing omtrent de subsidie.')
                      , ('Article 4:37 par 1 sub d Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: d. de te verzekeren risico?s.')
                      , ('Article 4:37 par 1 sub e Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: e. het stellen van zekerheid voor verleende voorschotten.')
                      , ('Article 4:37 par 1 sub f Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: f. het afleggen van rekening en verantwoording omtrent de verrichte activiteiten en de daaraan verbonden uitgaven en inkomsten, voor zover deze voor de vaststelling van de subsidie van belang zijn.')
                      , ('Article 4:37 par 1 sub g Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: g. het beperken of wegnemen van de nadelige gevolgen van de subsidie voor derden.')
                      , ('Article 4:37 par 1 sub h Awb', 'Het bestuursorgaan kan de subsidie-ontvanger verplichtingen opleggen met betrekking tot: h. het uitoefenen van controle door een accountant als bedoeld in artikel 393, eerste lid, van Boek 2 van het Burgerlijk Wetboek op het door het bestuursorgaan gevoerde financiële beheer en de financiële verantwoording daarover.')
                      , ('Article 4:37 par 2 Awb', 'Indien een verplichting als bedoeld in het eerste lid, onderdeel c, wordt opgelegd, zijn de [58]artikelen 4:3 en [59]4:4 van overeenkomstige toepassing.')
                      , ('Article 4:38 par 1 Awb', 'Het bestuursorgaan kan de subsidie-ontvanger ook andere verplichtingen opleggen die strekken tot verwezenlijking van het doel van de subsidie.')
                      , ('Article 4:38 par 2 Awb', 'Indien de subsidie op een wettelijk voorschrift berust, worden de verplichtingen opgelegd bij wettelijk voorschrift of krachtens wettelijk voorschrift bij de subsidieverlening.')
                      , ('Article 4:38 par 3 Awb', 'Indien de subsidie niet op een wettelijk voorschrift berust, kunnen de verplichtingen worden opgelegd bij de subsidieverlening.')
                      , ('Article 4:39 par 1 Awb', 'Verplichtingen die niet strekken tot verwezenlijking van het doel van de subsidie kunnen slechts aan de subsidie worden verbonden voor zover dit bij wettelijk voorschrift is bepaald.')
                      , ('Article 4:39 par 2 Awb', 'Verplichtingen als bedoeld in het eerste par kunnen slechts betrekking hebben op de wijze waarop of de middelen waarmee de gesubsidieerde activiteit wordt verricht.')
                      , ('Article 4:40 Awb', 'De verplichtingen kunnen na de subsidieverlening worden uitgewerkt, voor zover de beschikking tot subsidieverlening dit vermeldt.')
                      , ('Article 4:41 par 1 Awb', 'In de gevallen, genoemd in het tweede lid, is de subsidie-ontvanger, voor zover het verstrekken van de subsidie heeft geleid tot vermogensvorming, daarvoor een vergoeding verschuldigd aan het bestuursorgaan, mits: a. dit bij wettelijk voorschrift of, indien de subsidie niet op een wettelijk voorschrift berust, bij de subsidieverlening is bepaald, en b. daarbij is aangegeven hoe de hoogte van de vergoeding wordt bepaald.')
                      , ('Article 4:41 par 2 sub a Awb', 'De vergoeding is slechts verschuldigd indien: a. de subsidie-ontvanger voor de gesubsidieerde activiteiten gebruikte of bestemde goederen vervreemdt of bezwaart of de bestemming daarvan wijzigt.')
                      , ('Article 4:41 par 2 sub b Awb', 'De vergoeding is slechts verschuldigd indien: b. de subsidie-ontvanger een schadevergoeding ontvangt voor verlies of beschadiging van voor de gesubsidieerde activiteiten gebruikte of bestemde goederen.')
                      , ('Article 4:41 par 2 sub c Awb', 'De vergoeding is slechts verschuldigd indien: c. de gesubsidieerde activiteiten geheel of gedeeltelijk worden beëindigd.')
                      , ('Article 4:41 par 2 sub d Awb', 'De vergoeding is slechts verschuldigd indien: d. de subsidieverlening of de subsidievaststelling wordt ingetrokken of de subsidie wordt beëindigd.')
                      , ('Article 4:41 par 2 sub e Awb', 'De vergoeding is slechts verschuldigd indien: e. de rechtspersoon die de subsidie ontving wordt ontbonden.')
                      , ('Article 4:41 par 3 Awb', 'De vergoeding wordt vastgesteld binnen een jaar nadat het bestuursorgaan op de hoogte is gekomen of kon zijn van de gebeurtenis die het recht op vergoeding deed ontstaan, doch in ieder geval binnen vijf jaren na de bekendmaking van de laatste beschikking tot subsidievaststelling.')
                      , ('Article 4:42 Awb', 'De beschikking tot subsidievaststelling stelt het bedrag van de subsidie vast en geeft aanspraak op betaling van het vastgestelde bedrag overeenkomstig [60]afdeling 4.2.7.')
                      , ('Article 4:43 par 1 Awb', 'Indien geen beschikking tot subsidieverlening is gegeven, bevat de beschikking tot subsidievaststelling een aanduiding van de activiteiten waarvoor subsidie wordt verstrekt.')
                      , ('Article 4:43 par 2 Awb', 'De [61]artikelen 4:32, [62]4:35, tweede lid, [63]4:38 en [64]4:39 zijn van overeenkomstige toepassing.')
                      , ('Article 4:44 par 1 sub a Awb', 'Indien een beschikking tot subsidieverlening is gegeven, dient de subsidie-ontvanger na afloop van de activiteiten of het tijdvak waarvoor de subsidie is verleend een aanvraag tot vaststelling van de subsidie in, tenzij: a. de subsidie met toepassing van [65]artikel 4:47, onderdeel a , ambtshalve wordt vastgesteld.')
                      , ('Article 4:44 par 1 sub b Awb', 'Indien een beschikking tot subsidieverlening is gegeven, dient de subsidie-ontvanger na afloop van de activiteiten of het tijdvak waarvoor de subsidie is verleend een aanvraag tot vaststelling van de subsidie in, tenzij: b. bij wettelijk voorschrift of bij de subsidieverlening is bepaald dat de aanvraag wordt inged iend telkens na afloop van een gedeelte van het tijdvak waarvoor de subsidie is verleend.')
                      , ('Article 4:44 par 1 sub c Awb', 'Indien een beschikking tot subsidieverlening is gegeven, dient de subsidie-ontvanger na afloop van de activiteiten of het tijdvak waarvoor de subsidie is verleend een aanvraag tot vaststelling van de subsidie in, tenzij: c. de vaststelling van de subsidie bij een overeenkomst als bedoeld in [66]artikel 4:36, eerste lid, anders is geregeld.')
                      , ('Article 4:44 par 2 Awb', 'Indien bij wettelijk voorschrift geen termijn is bepaald, wordt de aanvraag tot vaststelling ingediend binnen een bij de subsidieverlening te bepalen termijn.')
                      , ('Article 4:44 par 3 Awb', 'Indien voor de indiening van de aanvraag tot vaststelling geen termijn is bepaald of de aanvraag na afloop van de daarvoor bepaalde termijn niet is ingediend kan het bestuursorgaan de subsidie-ontvanger een termijn stellen binnen welke de aanvraag moet zijn ingediend.')
                      , ('Article 4:44 par 4 Awb', 'Indien na afloop van deze termijn geen aanvraag is ingediend, kan de subsidie ambtshalve worden vastgesteld.')
                      , ('Article 4:45 par 1 Awb', 'Bij de aanvraag tot subsidievaststelling toont de aanvrager aan dat de activiteiten hebben plaatsgevonden overeenkomstig de aan de subsidie verbonden verplichtingen, tenzij de subsidie voor de aanvang van de activiteiten wordt vastgesteld.')
                      , ('Article 4:45 par 2 Awb', 'Bij de aanvraag tot subsidievaststelling legt de aanvrager rekening en verantwoording af omtrent de aan de activiteiten verbonden uitgaven en inkomsten, voor zover deze voor de vaststelling van de subsidie van belang zijn.')
                      , ('Article 4:46 par 1 Awb', 'Indien een beschikking tot subsidieverlening is gegeven, stelt het bestuursorgaan de subsidie overeenkomstig de subsidieverlening vast.')
                      , ('Article 4:46 par 2 sub a Awb', 'De subsidie kan lager worden vastgesteld indien: a. de activiteiten waarvoor subsidie is verleend niet of niet geheel hebben plaatsgevonden.')
                      , ('Article 4:46 par 2 sub b Awb', 'De subsidie kan lager worden vastgesteld indien: b. de subsidie-ontvanger niet heeft voldaan aan de aan de subsidie verbonden verplichtingen.')
                      , ('Article 4:46 par 2 sub c Awb', 'De subsidie kan lager worden vastgesteld indien: c. de subsidie-ontvanger onjuiste of onvolledige gegevens heeft verstrekt en de verstrekking van juiste of volledige gegevens tot een andere beschikking op de aanvraag tot subsidieverlening zou hebben geleid.')
                      , ('Article 4:46 par 2 sub d Awb', 'De subsidie kan lager worden vastgesteld indien: d. de subsidieverlening anderszins onjuist was en de subsidie-ontvanger dit wist of behoorde te weten.')
                      , ('Article 4:46 par 3 Awb', 'Voor zover het bedrag van de subsidie afhankelijk is van de werkelijke kosten van de activiteiten waarvoor subsidie is verleend, worden kosten die in redelijkheid niet als noodzakelijk kunnen worden beschouwd bij de vaststelling van de subsidie niet in aanmerking genomen.')
                      , ('Article 4:47 sub a Awb', 'Het bestuursorgaan kan de subsidie geheel of gedeeltelijk ambtshalve vaststellen, indien: a. bij wettelijk voorschrift of bij de subsidieverlening een termijn is bepaald binnen welke de subsidie ambtshalve wordt vastgesteld.')
                      , ('Article 4:47 sub b Awb', 'Het bestuursorgaan kan de subsidie geheel of gedeeltelijk ambtshalve vaststellen, indien: b. toepassing wordt gegeven aan [67]artikel 4:44, vierde lid.')
                      , ('Article 4:47 sub c Awb', 'Het bestuursorgaan kan de subsidie geheel of gedeeltelijk ambtshalve vaststellen, indien: c. de beschikking tot subsidieverlening of de beschikking tot subsidievaststelling wordt ingetrokken of ten nadele van de ontvanger wordt gewijzigd.')
                      , ('Article 4:48 par 1 sub a Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: a. de activiteiten waarvoor subsidie is verleend niet of niet geheel hebben plaatsgevonden of zullen plaatsvinden.')
                      , ('Article 4:48 par 1 sub b Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: b. de subsidie-ontvanger niet heeft voldaan aan de aan de subsidie verbonden verplichtingen.')
                      , ('Article 4:48 par 1 sub c Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: c. de subsidie-ontvanger onjuiste of onvolledige gegevens heeft verstrekt en de verstrekking van juiste of volledige gegevens tot een andere beschikking op de aanvraag tot subsidieverlening zou hebben geleid.')
                      , ('Article 4:48 par 1 sub d Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: d. de subsidieverlening anderszins onjuist was en de subsidie-ontvanger dit wist of behoorde te weten.')
                      , ('Article 4:48 par 1 sub e Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening intrekken of ten nadele van de subsidie-ontvanger wijzigen, indien: e. met toepassing van [68]artikel 4:34, vijfde lid, een beroep wordt gedaan op de voorwaarde dat voldoende gelden ter beschikking worden gesteld.')
                      , ('Article 4:48 par 2 Awb', 'De intrekking of wijziging werkt terug tot en met het tijdstip waarop de subsidie is verleend, tenzij bij de intrekking of wijziging anders is bepaald.')
                      , ('Article 4:49 par 1 sub a Awb', 'Het bestuursorgaan kan de subsidievaststelling intrekken of ten nadele van de ontvanger wijzigen: a. op grond van feiten of omstandigheden waarvan het bij de subsidievaststelling redelijkerwijs niet op de hoogte kon zijn en op grond waarvan de subsidie lager dan overeenkomstig de subsidieverlening zou zijn vastgesteld.')
                      , ('Article 4:49 par 1 sub b Awb', 'Het bestuursorgaan kan de subsidievaststelling intrekken of ten nadele van de ontvanger wijzigen: b. indien de subsidievaststelling onjuist was en de subsidie-ontvanger dit wist of behoorde te weten.')
                      , ('Article 4:49 par 1 sub c Awb', 'Het bestuursorgaan kan de subsidievaststelling intrekken of ten nadele van de ontvanger wijzigen: c. indien de subsidie-ontvanger na de subsidievaststelling niet heeft voldaan aan aan de subsidie verbonden verplichtingen.')
                      , ('Article 4:49 par 2 Awb', 'De intrekking of wijziging werkt terug tot en met het tijdstip waarop de subsidie is vastgesteld, tenzij bij de intrekking of wijziging anders is bepaald.')
                      , ('Article 4:49 par 3 Awb', 'De subsidievaststelling kan niet meer worden ingetrokken of ten nadele van de ontvanger worden gewijzigd indien vijf jaren zijn verstreken sedert de dag waarop zij is bekendgemaakt dan wel, in het geval, bedoeld in het eerste lid, onderdeel c, sedert de dag waarop de handeling in strijd met de verplichting is verricht of de dag waarop aan de verplichting had moeten zijn voldaan.')
                      , ('Article 4:50 par 1 sub a Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening met inachtneming van een redelijke termijn intrekken of ten nadele van de subsidie-ontvanger wijzigen: a. voor zover de subsidieverlening onjuist is.')
                      , ('Article 4:50 par 1 sub b Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening met inachtneming van een redelijke termijn intrekken of ten nadele van de subsidie-ontvanger wijzigen: b. voor zover veranderde omstandigheden of gewijzigde inzichten zich in overwegende mate tegen voortzetting of ongewijzigde voortzetting van de subsidie verzetten.')
                      , ('Article 4:50 par 1 sub c Awb', 'Zolang de subsidie niet is vastgesteld kan het bestuursorgaan de subsidieverlening met inachtneming van een redelijke termijn intrekken of ten nadele van de subsidie-ontvanger wijzigen: c. in andere bij wettelijk voorschrift geregelde gevallen.')
                      , ('Article 4:50 par 2 Awb', 'Bij intrekking of wijziging op grond van het eerste lid, onderdeel a of b, vergoedt het bestuursorgaan de schade die de subsidie-ontvanger lijdt doordat hij in vertrouwen op de subsidie anders heeft gehandeld dan hij zonder subsidie zou hebben gedaan.')
                      , ('Article 4:51 par 1 Awb', 'Indien aan een subsidie-ontvanger voor drie of meer achtereenvolgende jaren subsidie is verstrekt voor dezelfde of in hoofdzaak dezelfde voortdurende activiteiten, geschiedt gehele of gedeeltelijke weigering van de subsidie voor een daarop aansluitend tijdvak op de grond, dat veranderde omstandigheden of gewijzigde inzichten zich tegen voortzetting of ongewijzigde voortzetting van de subsidie verzetten, slechts met inachtneming van een redelijke termijn.')
                      , ('Article 4:51 par 2 Awb', 'Voor zover aan het einde van het tijdvak waarvoor subsidie is verleend sedert de bekendmaking van het voornemen tot weigering voor een daarop aansluitend tijdvak nog geen redelijke termijn is verstreken, wordt de subsidie voor het resterende deel van die termijn verleend, zo nodig in afwijking van [69]artikel 4:25, tweede lid.')
                      , ('Article 4:52 par 1 Awb', 'Het subsidiebedrag wordt overeenkomstig de subsidievaststelling betaald, onder verrekening van de betaalde voorschotten.')
                      , ('Article 4:52 par 2 Awb', 'Het subsidiebedrag wordt binnen vier weken na de subsidievaststelling betaald, tenzij bij wettelijk voorschrift anders is bepaald.')
                      , ('Article 4:52 par 3 Awb', 'Indien de subsidie niet op een wettelijk voorschrift berust, kan bij de subsidieverlening, of, indien geen beschikking tot subsidieverlening is gegeven, bij de subsidievaststelling, een andere termijn worden bepaald waarbinnen het subsidiebedrag wordt betaald.')
                      , ('Article 4:53 par 1 Awb', 'Het subsidiebedrag kan in gedeelten worden betaald, mits bij wettelijk voorschrift is bepaald hoe de gedeelten worden berekend en op welke tijdstippen zij worden betaald.')
                      , ('Article 4:53 par 2 Awb', 'Indien de subsidie niet op een wettelijk voorschrift berust, kan het subsidiebedrag in gedeelten worden betaald, mits bij de subsidieverlening, of indien geen beschikking tot subsidieverlening is gegeven, bij de subsidievaststelling, is bepaald hoe de gedeelten worden berekend en op welke tijdstippen zij worden betaald.')
                      , ('Article 4:54 par 1 Awb', 'Het bestuursorgaan kan de subsidie-ontvanger voorschotten verlenen, voor zover dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald.')
                      , ('Article 4:54 par 2 Awb', 'De beschikking tot voorschotverlening vermeldt het bedrag van het voorschot, dan wel de wijze waarop dit bedrag wordt bepaald.')
                      , ('Article 4:55 par 1 Awb', 'Voorschotten worden overeenkomstig de voorschotverlening betaald.')
                      , ('Article 4:55 par 2 Awb', 'De voorschotten worden binnen vier weken na de voorschotverlening betaald, tenzij bij wettelijk voorschrift of bij de voorschotverlening anders is bepaald.')
                      , ('Article 4:56 Awb', 'De verplichting tot betaling van een subsidiebedrag of een voorschot wordt opgeschort met ingang van de dag waarop het bestuursorgaan aan de subsidie-ontvanger schriftelijk kennis geeft van het ernstige vermoeden dat er grond bestaat om toepassing te geven aan [70]artikel 4:48 of [71]4:49, tot en met de dag waarop de beschikking omtrent de intrekking of wijziging is bekendgemaakt of de dag waarop sedert de kennisgeving van het ernstige vermoeden dertien weken zijn verstreken.')
                      , ('Article 4:57 Awb', 'Onverschuldigd betaalde subsidiebedragen en voorschotten kunnen worden teruggevorderd voor zover na de dag waarop de subsidie is vastgesteld, dan wel de handeling als bedoeld in [72]artikel 4:49, eerste lid, onderdeel c, heeft plaatsgevonden, nog geen vijf jaren zijn verstreken.')
                      , ('Article 4:58 par 1 Awb', 'Deze afdeling is van toepassing op per boekjaar verstrekte subsidies, indien dat bij wettelijk voorschrift of bij besluit van het bestuursorgaan is bepaald.')
                      , ('Article 4:58 par 2 Awb', 'Bij algemene maatregel van bestuur kan worden bepaald dat deze afdeling van toepassing is op daarbij aangewezen subsidies.')
                      , ('Article 4:59 par 1 Awb', 'Het bestuursorgaan dat met toepassing van deze afdeling een subsidie verleent kan een of meer toezichthouders aanwijzen die zijn belast met het toezicht op de naleving van de aan de ontvanger van die subsidie opgelegde verplichtingen.')
                      , ('Article 4:59 par 2 Awb', 'De toezichthouder beschikt niet over de bevoegdheden, vermeld in de [73]artikelen 5:18 en [74]5:19.')
                      , ('Article 4:60 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald, wordt de aanvraag van de subsidie uiterlijk dertien weken voor de aanvang van het boekjaar ingediend.')
                      , ('Article 4:61 par 1 Awb', 'De aanvraag van de subsidie gaat in ieder geval vergezeld van: a. een activiteitenplan, tenzij redelijkerwijs kan worden aangenomen dat daaraan geen behoefte is, en b. een begroting, tenzij deze voor de berekening van het bedrag van de subsidie niet van belang is.')
                      , ('Article 4:61 par 2 Awb', 'Indien de aanvrager beschikt over een egalisatiereserve als bedoeld in [75]artikel 4:72, vermeldt de aanvraag de omvang daarvan.')
                      , ('Article 4:62 Awb', 'Het activiteitenplan behelst een overzicht van de activiteiten waarvoor subsidie wordt gevraagd en de daarmee nagestreefde doelstellingen en vermeldt per activiteit de daarvoor benodigde personele en materiële middelen.')
                      , ('Article 4:63 par 1 Awb', 'De begroting behelst een overzicht van de voor het boekjaar geraamde inkomsten en uitgaven van de aanvrager, voor zover deze betrekking hebben op de activiteiten waarvoor subsidie wordt gevraagd.')
                      , ('Article 4:63 par 2 Awb', 'De begrotingsposten worden ieder afzonderlijk van een toelichting voorzien.')
                      , ('Article 4:63 par 3 Awb', 'Tenzij voor de activiteiten waarop de aanvraag betrekking heeft nog niet eerder subsidie werd verstrekt, behelst de begroting een vergelijking met de begroting van het lopende boekjaar en de gerealiseerde inkomsten en uitgaven van het jaar, voorafgaand aan het lopende boekjaar.')
                      , ('Article 4:64 par 1 Awb', 'Tenzij de aanvraag wordt ingediend door een krachtens publiekrecht ingestelde rechtspersoon, gaat deze, indien voor het jaar voorafgaand aan het subsidiejaar geen subsidie werd aangevraagd, voorts vergezeld van: a. een afschrift van de oprichtingsakte van de rechtspersoon dan wel van de statuten zoals deze laatstelijk zijn gewijzigd, en b. de laatst opgemaakte jaarrekening als bedoeld in artikel 361 van Boek 2 van het Burgerlijk Wetboek dan wel de balans en de staat van baten en lasten en de toelichting daarop of, indien deze bescheiden ontbreken, een verslag over de financiële positie van de aanvrager op het moment van de aanvraag.')
                      , ('Article 4:64 par 2 Awb', 'De in het eerste lid, onderdeel b, bedoelde bescheiden dan wel het verslag over de financiële positie zijn voorzien van een van een accountant als bedoeld in artikel 393, eerste lid, van Boek 2 van het Burgerlijk Wetboek afkomstige schriftelijke verklaring omtrent de getrouwheid onderscheidenlijk een mededeling, inhoudende dat van onjuistheden niet is gebleken.')
                      , ('Article 4:64 par 3 Awb', 'Bij wettelijk voorschrift of bij besluit van het bestuursorgaan kan vrijstelling of ontheffing worden verleend van het in het tweede par bepaalde.')
                      , ('Article 4:65 Awb', 'Voor zover de aanvrager voor dezelfde begrote uitgaven tevens subsidie heeft aangevraagd bij een of meer andere bestuursorganen, doet hij daarvan mededeling in de aanvraag, onder vermelding van de stand van zaken met betrekking tot de beoordeling van die aanvraag of aanvragen.')
                      , ('Article 4:66 Awb', 'De subsidie wordt slechts verleend aan een rechtspersoon met volledige rechtsbevoegdheid.')
                      , ('Article 4:67 par 1 Awb', 'De subsidie wordt voor een boekjaar of voor een bepaald aantal boekjaren verleend.')
                      , ('Article 4:67 par 2 Awb', 'Indien de subsidie voor twee of meer boekjaren wordt verleend, wordt aan de subsidie de verplichting verbonden tot het periodiek aan het bestuursorgaan verstrekken van de gegevens die voor de vaststelling van de subsidie van belang zijn.')
                      , ('Article 4:67 par 3 Awb', 'De beschikking tot subsidieverlening vermeldt welke gegevens de subsidie-ontvanger krachtens het tweede par moet verstrekken, alsmede op welke tijdstippen de gegevens moeten worden verstrekt.')
                      , ('Article 4:68 Awb', 'Tenzij bij wettelijk voorschrift of bij de subsidieverlening anders is bepaald, stelt de subsidie-ontvanger het boekjaar gelijk aan het kalenderjaar.')
                      , ('Article 4:69 par 1 Awb', 'De subsidie-ontvanger voert een zodanig ingerichte administratie, dat daaruit te allen tijde de voor de vaststelling van de subsidie van belang zijnde rechten en verplichtingen alsmede de betalingen en de ontvangsten kunnen worden nagegaan.')
                      , ('Article 4:69 par 2 Awb', 'De administratie en de daartoe behorende bescheiden worden gedurende zeven jaren bewaard.')
                      , ('Article 4:70 Awb', 'Indien gedurende het boekjaar aanmerkelijke verschillen ontstaan of dreigen te ontstaan tussen de werkelijke uitgaven en inkomsten en de begrote uitgaven en inkomsten doet de subsidie-ontvanger daarvan onverwijld mededeling aan het bestuursorgaan onder vermelding van de oorzaak van de verschillen.')
                      , ('Article 4:71 par 1 sub a Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: a. het oprichten van dan wel deelnemen in een rechtspersoon.')
                      , ('Article 4:71 par 1 sub b Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: b. het wijzigen van de statuten.')
                      , ('Article 4:71 par 1 sub c Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: c. het in eigendom verwerven, het vervreemden of het bezwaren van registergoederen, indien zij mede zijn verworven door middel van de subsidiegelden, dan wel de lasten daarvoor mede worden bekostigd uit de subsidiegelden.')
                      , ('Article 4:71 par 1 sub d Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: d. het aangaan en beëindigen van overeenkomsten tot verkrijging, vervreemding of bezwaring van registergoederen of tot huur, verhuur of pacht daarvan, indien deze goederen geheel of gedeeltelijk zijn verworven door middel van de subsidie dan wel de uitgaven daarvoor mede zijn bekostigd uit de subsidie.')
                      , ('Article 4:71 par 1 sub e Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: e. het aangaan van kredietovereenkomsten en van overeenkomsten van geldlening.')
                      , ('Article 4:71 par 1 sub f Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: f. het aangaan van overeenkomsten waarbij de subsidie-ontvanger zich verbindt tot zekerheidsstelling met inbegrip van zekerheidsstelling voor schulden van derden of waarbij hij zich als borg of hoofdelijk medeschuldenaar verbindt of zich voor een derde sterk maakt.')
                      , ('Article 4:71 par 1 sub g Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: g. het vormen van fondsen en reserveringen.')
                      , ('Article 4:71 par 1 sub h Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: h. het vaststellen of wijzigen van tarieven voor door de subsidie-ontvanger in de gewone uitoefening van zijn gesubsidieerde activiteiten te verrichten prestaties.')
                      , ('Article 4:71 par 1 sub i Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: i. het ontbinden van de rechtspersoon.')
                      , ('Article 4:71 par 1 sub j Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, behoeft de subsidie-ontvanger de toestemming van het bestuursorgaan voor: j. het doen van aangifte tot zijn faillissement of het aanvragen van zijn surséance van betaling.')
                      , ('Article 4:71 par 2 Awb', 'Het bestuursorgaan beslist binnen vier weken omtrent de toestemming.')
                      , ('Article 4:71 par 3 Awb', 'De beslissing kan eenmaal voor ten hoogste vier weken worden verdaagd.')
                      , ('Article 4:71 par 4 Awb', 'Indien omtrent de toestemming niet tijdig is beslist, wordt de toestemming geacht te zijn verleend.')
                      , ('Article 4:72 par 1 Awb', 'Indien dit bij wettelijk voorschrift of bij de subsidieverlening is bepaald, vormt de ontvanger een egalisatiereserve.')
                      , ('Article 4:72 par 2 Awb', 'Het verschil tussen de vastgestelde subsidie en de werkelijke kosten van de activiteiten waarvoor subsidie werd verleend komt ten gunste onderscheidenlijk ten laste van de egalisatiereserve.')
                      , ('Article 4:72 par 3 Awb', 'De egalisatiereserve wordt zo hoog rentend en zo veilig als redelijkerwijs mogelijk is belegd.')
                      , ('Article 4:72 par 4 Awb', 'De van de egalisatiereserve genoten rente wordt aan de egalisatiereserve toegevoegd.')
                      , ('Article 4:72 par 5 Awb', 'In de gevallen bedoeld in [76]artikel 4:41, tweede lid, onderdelen c, d en e, is de subsidie-ontvanger ter zake van de egalisatiereserve vergoedingsplichtig naar evenredigheid van de mate waarin de subsidie aan de egalisatiereserve heeft bijgedragen.')
                      , ('Article 4:73 Awb', 'De subsidie wordt per boekjaar vastgesteld.')
                      , ('Article 4:74 Awb', 'De subsidie-ontvanger dient binnen zes maanden na afloop van het boekjaar een aanvraag tot vaststelling van de subsidie in, tenzij bij wettelijk voorschrift anders is bepaald of de subsidie met toepassing van [77]artikel 4:67, tweede lid, voor twee of meer boekjaren is verleend.')
                      , ('Article 4:75 par 1 Awb', 'De aanvraag tot vaststelling gaat in ieder geval vergezeld van een financieel verslag en een activiteitenverslag.')
                      , ('Article 4:75 par 2 Awb', 'Indien de subsidie-ontvanger ingevolge wettelijk voorschrift verplicht is tot het opstellen van een jaarrekening als bedoeld in artikel 361 van Boek 2 van het Burgerlijk Wetboek, of indien dit bij de subsidieverlening is bepaald, legt hij in plaats van het financieel verslag de jaarrekening over, onverminderd [78]artikel 4:45, tweede lid.')
                      , ('Article 4:76 par 1 Awb', 'Indien de subsidie-ontvanger zijn inkomsten geheel ontleent aan de subsidie omvat het financiële verslag de balans en de exploitatierekening met de toelichting en zijn het tweede tot en met vijfde par van toepassing.')
                      , ('Article 4:76 par 2 Awb', 'Het financiële verslag geeft volgens normen die in het maatschappelijk verkeer als aanvaardbaar worden beschouwd, een zodanig inzicht dat een verantwoord oordeel kan worden gevormd omtrent: a. het vermogen en het exploitatiesaldo, en b. voor zover de aard van het financiële verslag dat toelaat, omtrent de solvabiliteit en de liquiditeit van de subsidie-ontvanger.')
                      , ('Article 4:76 par 3 Awb', 'De balans met de toelichting geeft getrouw, duidelijk en stelselmatig de grootte en de samenstelling in actief- en passiefposten van het vermogen op het einde van het boekjaar weer.')
                      , ('Article 4:76 par 4 Awb', 'De exploitatierekening met de toelichting geeft getrouw, duidelijk en stelselmatig de grootte van het exploitatiesaldo van het boekjaar weer.')
                      , ('Article 4:76 par 5 Awb', 'Het financiële verslag sluit aan op de begroting waarvoor subsidie is verleend en behelst een vergelijking met de gerealiseerde inkomsten en uitgaven van het jaar, voorafgaand aan het boekjaar.')
                      , ('Article 4:77 Awb', 'Indien de subsidie-ontvanger zijn inkomsten in overwegende mate ontleent aan de subsidie kan bij wettelijk voorschrift of bij de subsidieverlening worden bepaald dat [79]artikel 4:76 van overeenkomstige toepassing is.')
                      , ('Article 4:78 par 1 Awb', 'De subsidie-ontvanger geeft opdracht tot onderzoek van het financiële verslag aan een accountant als bedoeld in artikel 393, eerste lid, van Boek 2 van het Burgerlijk Wetboek.')
                      , ('Article 4:78 par 2 Awb', 'De accountant onderzoekt of het financiële verslag voldoet aan de bij of krachtens de wet gestelde voorschriften en of het activiteitenverslag, voor zover hij dat verslag kan beoordelen, met het financiële verslag verenigbaar is.')
                      , ('Article 4:78 par 3 Awb', 'De accountant geeft de uitslag van zijn onderzoek weer in een schriftelijke verklaring omtrent de getrouwheid van het financiële verslag.')
                      , ('Article 4:78 par 4 Awb', 'De aanvraag tot vaststelling van de subsidie gaat vergezeld van de in het derde par bedoelde verklaring.')
                      , ('Article 4:78 par 5 Awb', 'Bij wettelijk voorschrift of bij de subsidieverlening kan vrijstelling of ontheffing worden verleend van het eerste tot en met het vierde lid.')
                      , ('Article 4:79 par 1 Awb', 'Bij wettelijk voorschrift of bij de subsidieverlening kan worden bepaald dat de in [80]artikel 4:78, eerste lid, bedoelde opdracht tevens strekt tot onderzoek van de naleving van aan de subsidie verbonden verplichtingen.')
                      , ('Article 4:79 par 2 Awb', 'Bij toepassing van het eerste par gaat de opdracht vergezeld van een bij of krachtens wettelijk voorschrift of bij de subsidieverlening vast te stellen aanwijzing over de reikwijdte en de intensiteit van de controle.')
                      , ('Article 4:79 par 3 Awb', 'Bij toepassing van het eerste lid, gaat het financiële verslag tevens vergezeld van een schriftelijke verklaring van de accountant over de naleving door de subsidie-ontvanger van de aan de subsidie verbonden verplichtingen.')
                      , ('Article 4:80 Awb', 'Het activiteitenverslag beschrijft de aard en omvang van de activiteiten waarvoor subsidie werd verleend en bevat een vergelijking tussen de nagestreefde en de gerealiseerde doelstellingen en een toelichting op de verschillen.')
                      , ('Article 4:81 par 1 Awb', 'Een bestuursorgaan kan beleidsregels vaststellen met betrekking tot een hem toekomende of onder zijn verantwoordelijkheid uitgeoefende, dan wel door hem gedelegeerde bevoegdheid.')
                      , ('Article 4:81 par 2 Awb', 'In andere gevallen kan een bestuursorgaan slechts beleidsregels vaststellen, voor zover dit bij wettelijk voorschrift is bepaald.')
                      , ('Article 4:82 Awb', 'Ter motivering van een besluit kan slechts worden volstaan met een verwijzing naar een vaste gedragslijn voor zover deze is neergelegd in een beleidsregel.')
                      , ('Article 4:83 Awb', 'Bij de bekendmaking van het besluit, inhoudende een beleidsregel, wordt zo mogelijk het wettelijk voorschrift vermeld waaruit de bevoegdheid waarop het besluit, inhoudende een beleidsregel, betrekking heeft voortvloeit.')
                      , ('Article 4:84 Awb', 'Het bestuursorgaan handelt overeenkomstig de beleidsregel, tenzij dat voor een of meer belanghebbenden gevolgen zou hebben die wegens bijzondere omstandigheden onevenredig zijn in verhouding tot de met de beleidsregel te dienen doelen.')
                      , ('Article 5:11 Awb', 'Onder toezichthouder wordt verstaan: een persoon, bij of krachtens wettelijk voorschrift belast met het houden van toezicht op de naleving van het bepaalde bij of krachtens enig wettelijk voorschrift.')
                      , ('Article 5:12 par 1 Awb', 'Bij de uitoefening van zijn taak draagt een toezichthouder een legitimatiebewijs bij zich, dat is uitgegeven door het bestuursorgaan onder verantwoordelijkheid waarvan de toezichthouder werkzaam is.')
                      , ('Article 5:12 par 2 Awb', 'Een toezichthouder toont zijn legitimatiebewijs desgevraagd aanstonds.')
                      , ('Article 5:12 par 3 Awb', 'Het legitimatiebewijs bevat een foto van de toezichthouder en vermeldt in ieder geval diens naam en hoedanigheid. Het model van het legitimatiebewijs wordt vastgesteld bij regeling van Onze Minister van Justitie.')
                      , ('Article 5:13 Awb', 'Een toezichthouder maakt van zijn bevoegdheden slechts gebruik voor zover dat redelijkerwijs voor de vervulling van zijn taak nodig is.')
                      , ('Article 5:14 Awb', 'Bij wettelijk voorschrift of bij besluit van het bestuursorgaan dat de toezichthouder als zodanig aanwijst, kunnen de aan de toezichthouder toekomende bevoegdheden worden beperkt.')
                      , ('Article 5:15 par 1 Awb', 'Een toezichthouder is bevoegd, met medeneming van de benodigde apparatuur, elke plaats te betreden met uitzondering van een woning zonder toestemming van de bewoner.')
                      , ('Article 5:15 par 2 Awb', 'Zo nodig verschaft hij zich toegang met behulp van de sterke arm.')
                      , ('Article 5:15 par 3 Awb', 'Hij is bevoegd zich te doen vergezellen door personen die daartoe door hem zijn aangewezen.')
                      , ('Article 5:16 Awb', 'Een toezichthouder is bevoegd inlichtingen te vorderen.')
                      , ('Article 5:16a Awb', 'Een toezichthouder is bevoegd van personen inzage te vorderen van een identiteitsbewijs als bedoeld in artikel 1 van de Wet op de identificatieplicht.')
                      , ('Article 5:17 par 1 Awb', 'Een toezichthouder is bevoegd inzage te vorderen van zakelijke gegevens en bescheiden.')
                      , ('Article 5:17 par 2 Awb', 'Hij is bevoegd van de gegevens en bescheiden kopieën te maken.')
                      , ('Article 5:17 par 3 Awb', 'Indien het maken van kopieën niet ter plaatse kan geschieden, is hij bevoegd de gegevens en bescheiden voor dat doel voor korte tijd mee te nemen tegen een door hem af te geven schriftelijk bewijs.')
                      , ('Article 5:18 par 1 Awb', 'Een toezichthouder is bevoegd zaken te onderzoeken, aan opneming te onderwerpen en daarvan monsters te nemen.')
                      , ('Article 5:18 par 2 Awb', 'Hij is bevoegd daartoe verpakkingen te openen.')
                      , ('Article 5:18 par 3 Awb', 'De toezichthouder neemt op verzoek van de belanghebbende indien mogelijk een tweede monster, tenzij bij of krachtens wettelijk voorschrift anders is bepaald.')
                      , ('Article 5:18 par 4 Awb', 'Indien het onderzoek, de opneming of de monsterneming niet ter plaatse kan geschieden, is hij bevoegd de zaken voor dat doel voor korte tijd mee te nemen tegen een door hem af te geven schriftelijk bewijs.')
                      , ('Article 5:18 par 5 Awb', 'De genomen monsters worden voor zover mogelijk teruggegeven.')
                      , ('Article 5:18 par 6 Awb', 'De belanghebbende wordt op zijn verzoek zo spoedig mogelijk in kennis gesteld van de resultaten van het onderzoek, de opneming of de monsterneming.')
                      , ('Article 5:19 par 1 Awb', 'Een toezichthouder is bevoegd vervoermiddelen te onderzoeken met betrekking waartoe hij een toezichthoudende taak heeft.')
                      , ('Article 5:19 par 2 Awb', 'Hij is bevoegd vervoermiddelen waarmee naar zijn redelijk oordeel zaken worden vervoerd met betrekking waartoe hij een toezichthoudende taak heeft, op hun lading te onderzoeken.')
                      , ('Article 5:19 par 3 Awb', 'Hij is bevoegd van de bestuurder van een vervoermiddel inzage te vorderen van de wettelijk voorgeschreven bescheiden met betrekking waartoe hij een toezichthoudende taak heeft.')
                      , ('Article 5:19 par 4 Awb', 'Hij is bevoegd met het oog op de uitoefening van deze bevoegdheden van de bestuurder van een voertuig of van de schipper van een vaartuig te vorderen dat deze zijn vervoermiddel stilhoudt en naar een door hem aangewezen plaats overbrengt.')
                      , ('Article 5:19 par 5 Awb', 'Bij regeling van Onze Minister van Justitie wordt bepaald op welke wijze de vordering tot stilhouden wordt gedaan.')
                      , ('Article 5:20 par 1 Awb', 'Een ieder is verplicht aan een toezichthouder binnen de door hem gestelde redelijke termijn alle medewerking te verlenen die deze redelijkerwijs kan vorderen bij de uitoefening van zijn bevoegdheden.')
                      , ('Article 5:20 par 2 Awb', 'Zij die uit hoofde van ambt, beroep of wettelijk voorschrift verplicht zijn tot geheimhouding, kunnen het verlenen van medewerking weigeren, voor zover dit uit hun geheimhoudingsplicht voortvloeit.')
                      , ('Article 5:21 Awb', 'Onder bestuursdwang wordt verstaan: het door feitelijk handelen door of vanwege een bestuursorgaan optreden tegen hetgeen in strijd met bij of krachtens enig wettelijk voorschrift gestelde verplichtingen is of wordt gedaan, gehouden of nagelaten.')
                      , ('Article 5:22 Awb', 'De bevoegdheid tot toepassing van bestuursdwang bestaat slechts indien zij bij of krachtens de wet is toegekend.')
                      , ('Article 5:23 Awb', 'Deze afdeling is niet van toepassing indien wordt opgetreden ter onmiddellijke handhaving van de openbare orde.')
                      , ('Article 5:24 par 1 Awb', 'Een beslissing tot toepassing van bestuursdwang wordt op schrift gesteld. De schriftelijke beslissing is een beschikking.')
                      , ('Article 5:24 par 2 Awb', 'De beschikking vermeldt welk voorschrift is of wordt overtreden.')
                      , ('Article 5:24 par 3 Awb', 'De bekendmaking geschiedt aan de overtreder, aan de rechthebbenden op het gebruik van de zaak ten aanzien waarvan bestuursdwang zal worden toegepast en aan de aanvrager.')
                      , ('Article 5:24 par 4 Awb', 'In de beschikking wordt een termijn gesteld waarbinnen de belanghebbenden de tenuitvoerlegging kunnen voorkomen door zelf maatregelen te treffen. Het bestuursorgaan omschrijft de te nemen maatregelen.')
                      , ('Article 5:24 par 5 Awb', 'Geen termijn behoeft te worden gegund, indien de vereiste spoed zich daartegen verzet.')
                      , ('Article 5:24 par 6 Awb', 'Indien de situatie dermate spoedeisend is dat het bestuursorgaan de beslissing tot toepassing van bestuursdwang niet tevoren op schrift kan stellen, zorgt het alsnog zo spoedig mogelijk voor de opschriftstelling en voor de bekendmaking.')
                      , ('Article 5:25 par 1 Awb', 'De overtreder is de kosten verbonden aan de toepassing van bestuursdwang verschuldigd, tenzij de kosten redelijkerwijze niet of niet geheel te zijnen laste behoren te komen.')
                      , ('Article 5:25 par 2 Awb', 'De beschikking vermeldt dat de toepassing van bestuursdwang op kosten van de overtreder plaatsvindt.')
                      , ('Article 5:25 par 3 Awb', 'Indien echter de kosten geheel of gedeeltelijk niet ten laste van de overtreder zullen worden gebracht, wordt zulks in de beschikking vermeld.')
                      , ('Article 5:25 par 4 Awb', 'Onder de kosten, bedoeld in het eerste lid, worden begrepen de kosten verbonden aan de voorbereiding van bestuursdwang, voor zover deze kosten zijn gemaakt na het tijdstip waarop de termijn, bedoeld in [81]artikel 5:24, vierde lid, is verstreken.')
                      , ('Article 5:25 par 5 Awb', 'De kosten zijn ook verschuldigd indien de bestuursdwang door opheffing van de onwettige situatie niet of niet volledig is uitgevoerd.')
                      , ('Article 5:25 par 6 Awb', 'Onder de kosten, bedoeld in het eerste lid, worden tevens begrepen de kosten voortvloeiende uit de vergoeding van schade ingevolge [82]artikel 5:27, zesde lid.')
                      , ('Article 5:26 par 1 Awb', 'Het bestuursorgaan dat bestuursdwang heeft toegepast, kan van de overtreder bij dwangbevel de ingevolge [83]artikel 5:25 verschuldigde kosten, verhoogd met de op de invordering vallende kosten, invorderen.')
                      , ('Article 5:26 par 2 Awb', 'Het dwangbevel wordt op kosten van de overtreder bij deurwaardersexploit betekend en levert een executoriale titel op in de zin van het Tweede Boek van het Wetboek van Burgerlijke Rechtsvordering.')
                      , ('Article 5:26 par 3 Awb', 'Gedurende zes weken na de dag van betekening staat verzet tegen het dwangbevel open door dagvaarding van de rechtspersoon waartoe het bestuursorgaan behoort.')
                      , ('Article 5:26 par 4 Awb', 'Het verzet schorst de tenuitvoerlegging. Op verzoek van de rechtspersoon kan de rechter de schorsing van de tenuitvoerlegging opheffen.')
                      , ('Article 5:27 par 1 Awb', 'Om aan een beslissing tot toepassing van bestuursdwang uitvoering te geven, hebben personen die daartoe zijn aangewezen door het bestuursorgaan dat bestuursdwang toepast, toegang tot elke plaats, voor zover dat redelijkerwijs voor de vervulling van hun taak nodig is.')
                      , ('Article 5:27 par 2 Awb', 'Voor het binnentreden in een woning zonder toestemming van de bewoner is het bestuursorgaan dat bestuursdwang toepast bevoegd tot het geven van een machtiging als bedoeld in artikel 2 van de Algemene wet op het binnentreden.')
                      , ('Article 5:27 par 3 Awb', 'Een plaats die niet bij de overtreding is betrokken, wordt niet betreden dan nadat het bestuursorgaan dat bestuursdwang toepast dit de rechthebbende ten minste achtenveertig uren tevoren schriftelijk heeft aangezegd.')
                      , ('Article 5:27 par 4 Awb', 'Het derde par geldt niet, indien tijdige aanzegging wegens de vereiste spoed niet mogelijk is. De aanzegging geschiedt dan zo spoedig mogelijk.')
                      , ('Article 5:27 par 5 Awb', 'De aanzegging omschrijft de wijze waarop het betreden zal plaatsvinden.')
                      , ('Article 5:27 par 6 Awb', 'De rechtspersoon waartoe het bestuursorgaan behoort, vergoedt de schade die door het betreden van een plaats als bedoeld in het derde par wordt veroorzaakt, voor zover deze redelijkerwijs niet ten laste van de rechthebbende behoort te komen, onverminderd het recht tot verhaal van deze schade op de overtreder ingevolge [84]artikel 5:25, zesde lid.')
                      , ('Article 5:28 Awb', 'Tot de bevoegdheid tot toepassing van bestuursdwang behoort het verzegelen van gebouwen, terreinen en hetgeen zich daarin of daarop bevindt.')
                      , ('Article 5:29 par 1 Awb', 'Tot de bevoegdheid tot toepassing van bestuursdwang behoort het meevoeren en opslaan van daarvoor vatbare zaken voor zover de toepassing van bestuursdwang dit vereist.')
                      , ('Article 5:29 par 2 Awb', 'Indien zaken zijn meegevoerd en opgeslagen, doet het bestuursorgaan dat bestuursdwang heeft toegepast daarvan proces-verbaal opmaken, waarvan afschrift wordt verstrekt aan degene die de zaken onder zijn beheer had.')
                      , ('Article 5:29 par 3 Awb', 'Het bestuursorgaan draagt zorg voor de bewaring van de opgeslagen zaken en geeft deze zaken terug aan de rechthebbende.')
                      , ('Article 5:29 par 4 Awb', 'Het bestuursorgaan is bevoegd de afgifte op te schorten totdat de ingevolge [85]artikel 5:25 verschuldigde kosten zijn voldaan. Indien de rechthebbende niet tevens de overtreder is, is het bestuursorgaan bevoegd de afgifte op te schorten totdat de kosten van bewaring zijn voldaan.')
                      , ('Article 5:30 par 1 Awb', 'Het bestuursorgaan dat bestuursdwang heeft toegepast, is bevoegd, indien een ingevolge [86]artikel 5:29, eerste lid, meegevoerde en opgeslagen zaak niet binnen dertien weken na de meevoering kan worden teruggegeven, deze te verkopen of, indien verkoop naar zijn oordeel niet mogelijk is, de zaak om niet aan een derde in eigendom over te dragen of te laten vernietigen.')
                      , ('Article 5:30 par 2 Awb', 'Gelijke bevoegdheid heeft het bestuursorgaan ook binnen die termijn, zodra de ingevolge [87]artikel 5:25 verschuldigde kosten, vermeerderd met de voor de verkoop, de eigendomsoverdracht om niet of de vernietiging geraamde kosten, in verhouding tot de waarde van de zaak onevenredig hoog worden.')
                      , ('Article 5:30 par 3 Awb', 'Verkoop, eigendomsoverdracht of vernietiging vindt niet plaats binnen twee weken na de verstrekking van het afschrift, bedoeld in [88]artikel 5:29, tweede lid, tenzij het gevaarlijke stoffen of eerder aan bederf onderhevige stoffen betreft.')
                      , ('Article 5:30 par 4 Awb', 'Gedurende drie jaren na het tijdstip van verkoop heeft degene die op dat tijdstip eigenaar was, recht op de opbrengst van de zaak onder aftrek van de ingevolge [89]artikel 5:25 verschuldigde kosten en de kosten van de verkoop. Na het verstrijken van die termijn vervalt het eventuele batige saldo aan de rechtspersoon waartoe het bestuursorgaan behoort.')
                      , ('Article 5:31 Awb', 'Een beslissing tot toepassing van bestuursdwang wordt niet genomen zolang een ter zake van de betrokken overtreding reeds gegeven beschikking tot oplegging van een last onder dwangsom niet is ingetrokken.')
                      , ('Article 5:32 par 1 Awb', 'Een bestuursorgaan dat bevoegd is bestuursdwang toe te passen, kan in plaats daarvan aan de overtreder een last onder dwangsom opleggen.')
                      , ('Article 5:32 par 2 Awb', 'Een last onder dwangsom strekt ertoe de overtreding ongedaan te maken of verdere overtreding dan wel een herhaling van de overtreding te voorkomen.')
                      , ('Article 5:32 par 3 Awb', 'Voor het opleggen van een last onder dwangsom wordt niet gekozen, indien het belang dat het betrokken voorschrift beoogt te beschermen, zich daartegen verzet.')
                      , ('Article 5:32 par 4 Awb', 'Het bestuursorgaan stelt de dwangsom vast hetzij op een bedrag ineens, hetzij op een bedrag per tijdseenheid waarin de last niet is uitgevoerd, dan wel per overtreding van de last. Het bestuursorgaan stelt tevens een bedrag vast waarboven geen dwangsom meer wordt verbeurd. Het vastgestelde bedrag staat in redelijke verhouding tot de zwaarte van het geschonden belang en de beoogde werking van de dwangsomoplegging.')
                      , ('Article 5:32 par 5 Awb', 'In de beschikking tot oplegging van een last onder dwangsom die strekt tot het ongedaan maken van een overtreding of het voorkomen van verdere overtreding, wordt een termijn gesteld gedurende welke de overtreder de last kan uitvoeren zonder dat een dwangsom wordt verbeurd.')
                      , ('Article 5:33 par 1 Awb', 'Verbeurde dwangsommen komen toe aan de rechtspersoon waartoe het bestuursorgaan behoort dat de dwangsom heeft vastgesteld. Het bestuursorgaan kan bij dwangbevel het verschuldigde bedrag, verhoogd met de op de invordering vallende kosten, invorderen.')
                      , ('Article 5:33 par 2 Awb', '[90]Artikel 5:26, tweede tot en met vierde lid, is van toepassing.')
                      , ('Article 5:34 par 1 Awb', 'Het bestuursorgaan dat een last onder dwangsom heeft opgelegd, kan op verzoek van de overtreder de last opheffen, de looptijd ervan opschorten voor een bepaalde termijn of de dwangsom verminderen ingeval van blijvende of tijdelijke gehele of gedeeltelijke onmogelijkheid voor de overtreder om aan zijn verplichtingen te voldoen.')
                      , ('Article 5:34 par 2 Awb', 'Het bestuursorgaan dat de last onder dwangsom heeft opgelegd, kan op verzoek van de overtreder de last opheffen indien de beschikking een jaar van kracht is geweest zonder dat de dwangsom is verbeurd.')
                      , ('Article 5:35 par 1 Awb', 'De bevoegdheid tot invordering van verbeurde bedragen verjaart door verloop van zes maanden na de dag waarop zij zijn verbeurd.')
                      , ('Article 5:35 par 2 Awb', 'De verjaring wordt geschorst door faillissement, toepassing van de schuldsaneringsregeling natuurlijke personen en ieder wettelijk beletsel voor invordering van de dwangsom.')
                      , ('Article 5:36 Awb', 'Een last onder dwangsom wordt niet opgelegd zolang een ter zake van de betrokken overtreding reeds genomen beslissing tot toepassing van bestuursdwang niet is ingetrokken.')
                      , ('Article 6:1 Awb', 'De [91]hoofdstukken 6 en [92]7 zijn van overeenkomstige toepassing indien is voorzien in de mogelijkheid van bezwaar of beroep tegen andere handelingen van bestuursorganen dan besluiten.')
                      , ('Article 6:2 Awb', 'Voor de toepassing van wettelijke voorschriften over bezwaar en beroep worden met een besluit gelijkgesteld: a. de schriftelijke weigering een besluit te nemen, en b. het niet tijdig nemen van een besluit.')
                      , ('Article 6:3 Awb', 'Een beslissing inzake de procedure ter voorbereiding van een besluit is niet vatbaar voor bezwaar of beroep, tenzij deze beslissing de belanghebbende los van het voor te bereiden besluit rechtstreeks in zijn belang treft.')
                      , ('Article 6:4 par 1 Awb', 'Het maken van bezwaar geschiedt door het indienen van een bezwaarschrift bij het bestuursorgaan dat het besluit heeft genomen.')
                      , ('Article 6:4 par 2 Awb', 'Het instellen van administratief beroep geschiedt door het indienen van een beroepschrift bij het beroepsorgaan.')
                      , ('Article 6:4 par 3 Awb', 'Het instellen van beroep op een administratieve rechter geschiedt door het indienen van een beroepschrift bij die rechter.')
                      , ('Article 6:5 par 1 Awb', 'Het bezwaar- of beroepschrift wordt ondertekend en bevat ten minste: a. de naam en het adres van de indiener; b. de dagtekening; c. een omschrijving van het besluit waartegen het bezwaar of beroep is gericht; d. de gronden van het bezwaar of beroep.')
                      , ('Article 6:5 par 2 Awb', 'Bij het beroepschrift wordt zo mogelijk een afschrift van het besluit waarop het geschil betrekking heeft, overgelegd.')
                      , ('Article 6:5 par 3 Awb', 'Indien het bezwaar- of beroepschrift in een vreemde taal is gesteld en een vertaling voor een goede behandeling van het bezwaar of beroep noodzakelijk is, dient de indiener zorg te dragen voor een vertaling.')
                      , ('Article 6:6 sub a Awb', 'Het bezwaar of beroep kan niet-ontvankelijk worden verklaard, indien: a. niet is voldaan aan [93]artikel 6:5 of aan enig ander bij de wet gesteld vereiste voor het in behandeling nemen van het bezwaar of beroep,  mits de indiener de gelegenheid heeft gehad het verzuim te herstellen binnen een hem daartoe gestelde termijn.')
                      , ('Article 6:6 sub b Awb', 'Het bezwaar of beroep kan niet-ontvankelijk worden verklaard, indien: b. het bezwaar- of beroepschrift geheel of gedeeltelijk is geweigerd op grond van [94]artikel 2:15, mits de indiener de gelegenheid heeft gehad het verzuim te herstellen binnen een hem daartoe gestelde termijn.')
                      , ('Article 6:7 Awb', 'De termijn voor het indienen van een bezwaar- of beroepschrift bedraagt zes weken.')
                      , ('Article 6:8 par 1 Awb', 'De termijn vangt aan met ingang van de dag na die waarop het besluit op de voorgeschreven wijze is bekendgemaakt.')
                      , ('Article 6:8 par 2 Awb', 'De termijn voor het indienen van een bezwaarschrift tegen een besluit waartegen alleen door een of meer bepaalde belanghebbenden administratief beroep kon worden ingesteld, vangt aan met ingang van de dag na die waarop de beroepstermijn ongebruikt is verstreken.')
                      , ('Article 6:8 par 3 Awb', 'De termijn voor het indienen van een beroepschrift tegen een besluit dat aan goedkeuring is onderworpen, vangt aan met ingang van de dag na die waarop het besluit, inhoudende de goedkeuring van dat besluit, op de voorgeschreven wijze is bekendgemaakt.')
                      , ('Article 6:8 par 4 Awb', 'De termijn voor het indienen van een beroepschrift tegen een besluit dat is voorbereid met toepassing van [95]afdeling 3.4 vangt aan met ingang van de dag na die waarop het besluit overeenkomstig [96]artikel 3:44, eerste lid, onderdeel a, ter inzage is gelegd.')
                      , ('Article 6:9 par 1 Awb', 'Een bezwaar- of beroepschrift is tijdig ingediend indien het voor het einde van de termijn is ontvangen.')
                      , ('Article 6:9 par 2 Awb', 'Bij verzending per post is een bezwaar- of beroepschrift tijdig ingediend indien het voor het einde van de termijn ter post is bezorgd, mits het niet later dan een week na afloop van de termijn is ontvangen.')
                      , ('Article 6:10 par 1 sub a Awb', 'Ten aanzien van een voor het begin van de termijn ingediend bezwaar- of beroepschrift blijft niet-ontvankelijkverklaring op grond daarvan achterwege indien het besluit ten tijde van de indiening: a. wel reeds tot stand was gekomen.')
                      , ('Article 6:10 par 1 sub b Awb', 'Ten aanzien van een voor het begin van de termijn ingediend bezwaar- of beroepschrift blijft niet-ontvankelijkverklaring op grond daarvan achterwege indien het besluit ten tijde van de indiening: b. nog niet tot stand was gekomen, maar de indiener redelijkerwijs kon menen dat dit wel reeds het geval was.')
                      , ('Article 6:10 par 2 Awb', 'De behandeling van het bezwaar of beroep kan worden aangehouden tot het begin van de termijn.')
                      , ('Article 6:11 Awb', 'Ten aanzien van een na afloop van de termijn ingediend bezwaar- of beroepschrift blijft niet-ontvankelijkverklaring op grond daarvan achterwege indien redelijkerwijs niet kan worden geoordeeld dat de indiener in verzuim is geweest.')
                      , ('Article 6:12 par 1 Awb', 'Indien het bezwaar of beroep is gericht tegen het niet tijdig nemen van een besluit, is het niet aan een termijn gebonden.')
                      , ('Article 6:12 par 2 Awb', 'Het bezwaar- of beroepschrift kan worden ingediend zodra het bestuursorgaan in gebreke is tijdig een besluit te nemen.')
                      , ('Article 6:12 par 3 Awb', 'Het bezwaar of beroep wordt niet-ontvankelijk verklaard indien het bezwaar- of beroepschrift onredelijk laat is ingediend.')
                      , ('Article 6:13 Awb', 'Geen beroep bij de administratieve rechter kan worden ingesteld door een belanghebbende aan wie redelijkerwijs kan worden verweten dat hij geen zienswijzen als bedoeld in [97]artikel 3:15 naar voren heeft gebracht, geen bezwaar heeft gemaakt of geen administratief beroep heeft ingesteld.')
                      , ('Article 6:14 par 1 Awb', 'Het orgaan waarbij het bezwaar- of beroepschrift is ingediend, bevestigt de ontvangst daarvan schriftelijk.')
                      , ('Article 6:14 par 2 Awb', 'Het orgaan waarbij het beroepschrift is ingediend, geeft daarvan zo spoedig mogelijk kennis aan het bestuursorgaan dat het bestreden besluit heeft genomen.')
                      , ('Article 6:15 par 1 Awb', 'Indien het bezwaar- of beroepschrift wordt ingediend bij een onbevoegd bestuursorgaan of bij een onbevoegde administratieve rechter, wordt het, nadat daarop de datum van ontvangst is aangetekend, zo spoedig mogelijk doorgezonden aan het bevoegde orgaan, onder gelijktijdige mededeling hiervan aan de afzender.')
                      , ('Article 6:15 par 2 Awb', 'Het eerste par is van overeenkomstige toepassing indien in plaats van een bezwaarschrift een beroepschrift is ingediend of omgekeerd.')
                      , ('Article 6:15 par 3 Awb', 'Het tijdstip van indiening bij het onbevoegde orgaan is bepalend voor de vraag of het bezwaar- of beroepschrift tijdig is ingediend, behoudens in geval van kennelijk onredelijk gebruik van procesrecht.')
                      , ('Article 6:16 Awb', 'Het bezwaar of beroep schorst niet de werking van het besluit waartegen het is gericht, tenzij bij of krachtens wettelijk voorschrift anders is bepaald.')
                      , ('Article 6:17 Awb', 'Indien iemand zich laat vertegenwoordigen, zendt het orgaan dat bevoegd is op het bezwaar of beroep te beslissen, de op de zaak betrekking hebbende stukken in ieder geval aan de gemachtigde.')
                      , ('Article 6:18 par 1 Awb', 'Het aanhangig zijn van bezwaar of beroep tegen een besluit brengt geen verandering in een los van het bezwaar of beroep reeds bestaande bevoegdheid tot intrekking of wijziging van dat besluit.')
                      , ('Article 6:18 par 2 Awb', 'Gaat het bestuursorgaan tot intrekking of wijziging van het bestreden besluit over, dan doet het daarvan onverwijld mededeling aan het orgaan waarbij het bezwaar of beroep aanhangig is.')
                      , ('Article 6:18 par 3 Awb', 'Na de intrekking of wijziging mag het bestuursorgaan, zolang het bezwaar of beroep aanhangig blijft, geen besluit nemen waarvan de inhoud of strekking met het oorspronkelijke besluit overeenstemt, tenzij: a. gewijzigde omstandigheden dit rechtvaardigen en b. het bestuursorgaan daartoe los van het bezwaar of beroep ook bevoegd zou zijn geweest.')
                      , ('Article 6:18 par 4 Awb', 'Een bestuursorgaan doet van een besluit als bedoeld in het derde par onverwijld mededeling aan het orgaan waarbij het bezwaar of beroep aanhangig is.')
                      , ('Article 6:19 par 1 Awb', 'Indien een bestuursorgaan een besluit heeft genomen als bedoeld in [98]artikel 6:18, wordt het bezwaar of beroep geacht mede te zijn gericht tegen het nieuwe besluit, tenzij dat besluit aan het bezwaar of beroep geheel tegemoet komt.')
                      , ('Article 6:19 par 2 Awb', 'De beslissing op het bezwaar of beroep tegen het nieuwe besluit kan echter worden verwezen naar een ander orgaan waarbij bezwaar of beroep tegen dat nieuwe besluit aanhangig is, dan wel kan of kon worden gemaakt.')
                      , ('Article 6:19 par 3 Awb', 'Intrekking van het bestreden besluit staat niet in de weg aan vernietiging van dat besluit indien de indiener van het bezwaar- of beroepschrift daarbij belang heeft.')
                      , ('Article 6:20 par 1 Awb', 'Indien het bezwaar of beroep is gericht tegen het niet tijdig nemen van een besluit, blijft het bestuursorgaan verplicht een besluit op de aanvraag te nemen.')
                      , ('Article 6:20 par 2 sub a Awb', 'Het in het eerste par bepaalde geldt niet: a. gedurende de periode dat het bezwaar aanhangig is.')
                      , ('Article 6:20 par 2 sub b Awb', 'Het in het eerste par bepaalde geldt niet: b. na de beslissing op het bezwaar of beroep indien de indiener van de aanvraag als gevolg daarvan geen belang meer heeft bij een besluit op de aanvraag.')
                      , ('Article 6:20 par 3 Awb', 'Indien het bestuursorgaan een besluit op de aanvraag neemt, doet het daarvan onverwijld mededeling aan het orgaan waarbij het bezwaar of beroep tegen het niet tijdig beslissen aanhangig is.')
                      , ('Article 6:20 par 4 Awb', 'Het bezwaar of beroep wordt geacht mede te zijn gericht tegen het besluit op de aanvraag, tenzij dat besluit aan het bezwaar of beroep geheel tegemoet komt.')
                      , ('Article 6:20 par 5 Awb', 'De beslissing op het bezwaar of beroep tegen het besluit op de aanvraag kan echter worden verwezen naar een ander orgaan waarbij bezwaar of beroep tegen het besluit op de aanvraag aanhangig is, kan of kon worden gemaakt.')
                      , ('Article 6:20 par 6 Awb', 'Het bezwaar of beroep tegen het niet tijdig beslissen op de aanvraag kan alsnog gegrond worden verklaard, indien de indiener van het bezwaar- of beroepschrift daarbij belang heeft.')
                      , ('Article 6:21 par 1 Awb', 'Het bezwaar of beroep kan schriftelijk worden ingetrokken.')
                      , ('Article 6:21 par 2 Awb', 'Tijdens het horen kan de intrekking ook mondeling geschieden.')
                      , ('Article 6:22 Awb', 'Een besluit waartegen bezwaar is gemaakt of beroep is ingesteld, kan, ondanks schending van een vormvoorschrift, door het orgaan dat op het bezwaar of beroep beslist, in stand worden gelaten indien blijkt dat de belanghebbenden daardoor niet zijn benadeeld.')
                      , ('Article 6:23 par 1 Awb', 'Indien beroep kan worden ingesteld tegen de beslissing op het bezwaar of beroep, wordt daarvan bij de bekendmaking van de beslissing melding gemaakt.')
                      , ('Article 6:23 par 2 Awb', 'Hierbij wordt vermeld door wie, binnen welke termijn en bij welk orgaan beroep kan worden ingesteld.')
                      , ('Article 6:24 Awb', 'Deze afdeling is met uitzondering van [99]artikel 6:12 van overeenkomstige toepassing indien hoger beroep of beroep in cassatie kan worden ingesteld.')
                      , ('Article 7:1 par 1 sub a Awb', 'Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: a. op bezwaar of in administratief beroep is genomen.')
                      , ('Article 7:1 par 1 sub b Awb', 'Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: b. aan goedkeuring is onderworpen.')
                      , ('Article 7:1 par 1 sub c Awb', 'Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: c. de goedkeuring van een ander besluit of de weigering van die goedkeuring inhoudt.')
                      , ('Article 7:1 par 1 sub d Awb', 'Degene aan wie het recht is toegekend tegen een besluit beroep op een administratieve rechter in te stellen, dient alvorens beroep in te stellen tegen dat besluit bezwaar te maken, tenzij het besluit: d. is voorbereid met toepassing van [100]afdeling 3.4.')
                      , ('Article 7:1 par 2 Awb', 'Tegen de beslissing op het bezwaar kan beroep worden ingesteld met toepassing van de voorschriften die gelden voor het instellen van beroep tegen het besluit waartegen bezwaar is gemaakt.')
                      , ('Article 7:1a par 1 Awb', 'In het bezwaarschrift kan de indiener het bestuursorgaan verzoeken in te stemmen met rechtstreeks beroep bij de administratieve rechter, zulks in afwijking van [101]artikel 7:1.')
                      , ('Article 7:1a par 2 sub a Awb', 'Het bestuursorgaan wijst het verzoek in ieder geval af, indien: a. het bezwaarschrift is gericht tegen het niet tijdig nemen van een besluit.')
                      , ('Article 7:1a par 2 sub b Awb', 'Het bestuursorgaan wijst het verzoek in ieder geval af, indien: b. tegen het besluit een ander bezwaarschrift is ingediend waarin eenzelfde verzoek ontbreekt, tenzij dat andere bezwaarschrift kennelijk niet-ontvankelijk is.')
                      , ('Article 7:1a par 3 Awb', 'Het bestuursorgaan kan instemmen met het verzoek indien de zaak daarvoor geschikt is.')
                      , ('Article 7:1a par 4 Awb', 'Het bestuursorgaan beslist zo spoedig mogelijk op het verzoek. Een beslissing tot instemming wordt genomen zodra redelijkerwijs kan worden aangenomen dat geen nieuwe bezwaarschriften zullen worden ingediend. De [102]artikelen 4:7 en [103]4:8 zijn niet van toepassing.')
                      , ('Article 7:1a par 5 Awb', 'Indien het bestuursorgaan instemt met het verzoek zendt het het bezwaarschrift, nadat daarop de datum van ontvangst is aangetekend, onverwijld door aan de bevoegde rechter.')
                      , ('Article 7:1a par 6 Awb', 'Een na de instemming ontvangen bezwaarschrift wordt eveneens onverwijld doorgezonden aan de bevoegde rechter. Indien dit bezwaarschrift geen verzoek als bedoeld in het eerste par bevat, wordt, in afwijking van [104]artikel 8:41, eerste lid, geen griffierecht geheven.')
                      , ('Article 7:2 par 1 Awb', 'Voordat een bestuursorgaan op het bezwaar beslist, stelt het belanghebbenden in de gelegenheid te worden gehoord.')
                      , ('Article 7:2 par 2 Awb', 'Het bestuursorgaan stelt daarvan in ieder geval de indiener van het bezwaarschrift op de hoogte alsmede de belanghebbenden die bij de voorbereiding van het besluit hun zienswijze naar voren hebben gebracht.')
                      , ('Article 7:3 sub a Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: a. het bezwaar kennelijk niet-ontvankelijk is.')
                      , ('Article 7:3 sub b Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: b. het bezwaar kennelijk ongegrond is.')
                      , ('Article 7:3 sub c Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: c. de belanghebbenden hebben verklaard geen gebruik te willen maken van het recht te worden gehoord.')
                      , ('Article 7:3 sub d Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: d. aan het bezwaar volledig tegemoet wordt gekomen en andere belanghebbenden daardoor niet in hun belangen kunnen worden geschaad.')
                      , ('Article 7:4 par 1 Awb', 'Tot tien dagen voor het horen kunnen belanghebbenden nadere stukken indienen.')
                      , ('Article 7:4 par 2 Awb', 'Het bestuursorgaan legt het bezwaarschrift en alle verder op de zaak betrekking hebbende stukken voorafgaand aan het horen gedurende ten minste een week voor belanghebbenden ter inzage.')
                      , ('Article 7:4 par 3 Awb', 'Bij de oproeping voor het horen worden belanghebbenden gewezen op het eerste par en wordt vermeld waar en wanneer de stukken ter inzage zullen liggen.')
                      , ('Article 7:4 par 4 Awb', 'Belanghebbenden kunnen van deze stukken tegen vergoeding van ten hoogste de kosten afschriften verkrijgen.')
                      , ('Article 7:4 par 5 Awb', 'Voor zover de belanghebbenden daarmee instemmen, kan toepassing van het tweede par achterwege worden gelaten.')
                      , ('Article 7:4 par 6 Awb', 'Het bestuursorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het tweede par voorts achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. Van de toepassing van deze bepaling wordt mededeling gedaan.')
                      , ('Article 7:4 par 7 Awb', 'Gewichtige redenen zijn in ieder geval niet aanwezig, voor zover ingevolge de Wet openbaarheid van bestuur de verplichting bestaat een verzoek om informatie, vervat in deze stukken, in te willigen.')
                      , ('Article 7:4 par 8 Awb', 'Indien een gewichtige reden is gelegen in de vrees voor schade aan de lichamelijke of geestelijke gezondheid van een belanghebbende, kan inzage van de desbetreffende stukken worden voorbehouden aan een gemachtigde die hetzij advocaat hetzij arts is.')
                      , ('Article 7:5 par 1 sub a Awb', 'Tenzij het horen geschiedt door of mede door het bestuursorgaan zelf dan wel de voorzitter of een par ervan, geschiedt het horen door: a. een persoon die niet bij de voorbereiding van het bestreden besluit betrokken is geweest.')
                      , ('Article 7:5 par 1 sub b Awb', 'Tenzij het horen geschiedt door of mede door het bestuursorgaan zelf dan wel de voorzitter of een par ervan, geschiedt het horen door: b. meer dan een persoon van wie de meerderheid, onder wie degene die het horen leidt, niet bij de voorbereiding van het besluit betrokken is geweest.')
                      , ('Article 7:5 par 2 Awb', 'Voor zover niet bij wettelijk voorschrift anders is bepaald, besluit het bestuursorgaan of het horen in het openbaar plaatsvindt.')
                      , ('Article 7:6 par 1 Awb', 'Belanghebbenden worden in elkaars aanwezigheid gehoord.')
                      , ('Article 7:6 par 2 Awb', 'Ambtshalve of op verzoek kunnen belanghebbenden afzonderlijk worden gehoord, indien aannemelijk is dat gezamenlijk horen een zorgvuldige behandeling zal belemmeren of dat tijdens het horen feiten of omstandigheden bekend zullen worden waarvan geheimhouding om gewichtige redenen is geboden.')
                      , ('Article 7:6 par 3 Awb', 'Wanneer belanghebbenden afzonderlijk zijn gehoord, wordt ieder van hen op de hoogte gesteld van het verhandelde tijdens het horen buiten zijn aanwezigheid.')
                      , ('Article 7:6 par 4 Awb', 'Het bestuursorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het derde par achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. [105]Artikel 7:4, zesde lid, tweede volzin, zevende en achtste lid, is van overeenkomstige toepassing.')
                      , ('Article 7:7 Awb', 'Van het horen wordt een verslag gemaakt.')
                      , ('Article 7:8 Awb', 'Op verzoek van de belanghebbende kunnen door hem meegebrachte getuigen en deskundigen worden gehoord.')
                      , ('Article 7:9 Awb', 'Wanneer na het horen aan het bestuursorgaan feiten of omstandigheden bekend worden die voor de op het bezwaar te nemen beslissing van aanmerkelijk belang kunnen zijn, wordt dit aan belanghebbenden meegedeeld en worden zij in de gelegenheid gesteld daarover te worden gehoord.')
                      , ('Article 7:10 par 1 Awb', 'Het bestuursorgaan beslist binnen zes weken of - indien een commissie als bedoeld in [106]artikel 7:13 is ingesteld - binnen tien weken na ontvangst van het bezwaarschrift.')
                      , ('Article 7:10 par 2 Awb', 'De termijn wordt opgeschort met ingang van de dag waarop de indiener is verzocht een verzuim als bedoeld in [107]artikel 6:6 te herstellen, tot de dag waarop het verzuim is hersteld of de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Article 7:10 par 3 Awb', 'Het bestuursorgaan kan de beslissing voor ten hoogste vier weken verdagen. Van de verdaging wordt schriftelijk mededeling gedaan.')
                      , ('Article 7:10 par 4 Awb', 'Verder uitstel is mogelijk voor zover de indiener van het bezwaarschrift daarmee instemt en andere belanghebbenden daardoor niet in hun belangen kunnen worden geschaad of ermee instemmen.')
                      , ('Article 7:11 par 1 Awb', 'Indien het bezwaar ontvankelijk is, vindt op grondslag daarvan een heroverweging van het bestreden besluit plaats.')
                      , ('Article 7:11 par 2 Awb', 'Voor zover de heroverweging daartoe aanleiding geeft, herroept het bestuursorgaan het bestreden besluit en neemt het voor zover nodig in de plaats daarvan een nieuw besluit.')
                      , ('Article 7:12 par 1 Awb', 'De beslissing op het bezwaar dient te berusten op een deugdelijke motivering, die bij de bekendmaking van de beslissing wordt vermeld. Daarbij wordt, indien ingevolge [108]artikel 7:3 van het horen is afgezien, tevens aangegeven op welke grond dat is geschied.')
                      , ('Article 7:12 par 2 Awb', 'De beslissing wordt bekendgemaakt door toezending of uitreiking aan degenen tot wie zij is gericht. Betreft het een besluit dat niet tot een of meer belanghebbenden was gericht, dan wordt de beslissing bekendgemaakt op dezelfde wijze als waarop dat besluit bekendgemaakt is.')
                      , ('Article 7:12 par 3 Awb', 'Zo spoedig mogelijk na de bekendmaking van de beslissing wordt hiervan mededeling gedaan aan de belanghebbenden die in bezwaar of bij de voorbereiding van het bestreden besluit hun zienswijze naar voren hebben gebracht.')
                      , ('Article 7:12 par 4 Awb', 'Bij de mededeling, bedoeld in het derde lid, is [109]artikel 6:23 van overeenkomstige toepassing en wordt met het oog op de aanvang van de beroepstermijn zo duidelijk mogelijk aangegeven wanneer de bekendmaking van de beslissing overeenkomstig het tweede par heeft plaatsgevonden.')
                      , ('Article 7:13 par 1 Awb', 'Dit artikel is van toepassing indien ten behoeve van de beslissing op het bezwaar een adviescommissie is ingesteld: a. die bestaat uit een voorzitter en ten minste twee leden, b. waarvan de voorzitter geen deel uitmaakt van en niet werkzaam is onder verantwoordelijkheid van het bestuursorgaan en c. die voldoet aan eventueel bij wettelijk voorschrift gestelde andere eisen.')
                      , ('Article 7:13 par 2 Awb', 'Indien een commissie over het bezwaar zal adviseren, deelt het bestuursorgaan dit zo spoedig mogelijk mede aan de indiener van het bezwaarschrift.')
                      , ('Article 7:13 par 3 Awb', 'Het horen geschiedt door de commissie. De commissie kan het horen opdragen aan de voorzitter of een par dat geen deel uitmaakt van en niet werkzaam is onder verantwoordelijkheid van het bestuursorgaan.')
                      , ('Article 7:13 par 4 Awb', 'De commissie beslist over de toepassing van artikel 7:4, zesde lid, van [110]artikel 7:5, tweede lid, en, voor zover bij wettelijk voorschrift niet anders is bepaald, van [111]artikel 7:3.')
                      , ('Article 7:13 par 5 Awb', 'Een vertegenwoordiger van het bestuursorgaan wordt voor het horen uitgenodigd en wordt in de gelegenheid gesteld een toelichting op het standpunt van het bestuursorgaan te geven.')
                      , ('Article 7:13 par 6 Awb', 'Het advies van de commissie wordt schriftelijk uitgebracht en bevat een verslag van het horen.')
                      , ('Article 7:13 par 7 Awb', 'Indien de beslissing op het bezwaar afwijkt van het advies van de commissie, wordt in de beslissing de reden voor die afwijking vermeld en wordt het advies met de beslissing meegezonden.')
                      , ('Article 7:14 Awb', '[112]Artikel 3:6, tweede lid, [113]afdeling 3.4, de [114]artikelen 3:41 tot en met 3:45, [115]afdeling 3.7, met uitzondering van [116]artikel 3:49, en [117]hoofdstuk 4 zijn niet van toepassing op besluiten op grond van deze afdeling.')
                      , ('Article 7:15 par 1 Awb', 'Voor de behandeling van het bezwaar is geen recht verschuldigd.')
                      , ('Article 7:15 par 2 Awb', 'De kosten, die de belanghebbende in verband met de behandeling van het bezwaar redelijkerwijs heeft moeten maken, worden door het bestuursorgaan uitsluitend vergoed op verzoek van de belanghebbende voorzover het bestreden besluit wordt herroepen wegens aan het bestuursorgaan te wijten onrechtmatigheid. Art. 243, tweede lid, van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Article 7:15 par 3 Awb', 'Het verzoek wordt gedaan voordat het bestuursorgaan op het bezwaar heeft beslist. Het bestuursorgaan beslist op het verzoek bij de beslissing op het bezwaar.')
                      , ('Article 7:15 par 4 Awb', 'Bij algemene maatregel van bestuur worden nadere regels gesteld over de kosten waarop de vergoeding uitsluitend betrekking kan hebben en over de wijze waarop het bedrag van de kosten wordt vastgesteld.')
                      , ('Article 7:16 par 1 Awb', 'Voordat een beroepsorgaan op het beroep beslist, stelt het belanghebbenden in de gelegenheid te worden gehoord.')
                      , ('Article 7:16 par 2 Awb', 'Het beroepsorgaan stelt daarvan in ieder geval de indiener van het beroepschrift op de hoogte, alsmede het bestuursorgaan dat het besluit heeft genomen en de belanghebbenden die bij de voorbereiding van het besluit of bij de behandeling van het bezwaarschrift hun zienswijze naar voren hebben gebracht.')
                      , ('Article 7:17 sub a Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: a. het beroep kennelijk niet-ontvankelijk is.')
                      , ('Article 7:17 sub b Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: b. het beroep kennelijk ongegrond is.')
                      , ('Article 7:17 sub c Awb', 'Van het horen van belanghebbenden kan worden afgezien indien: c. de belanghebbenden hebben verklaard geen gebruik te willen maken van het recht te worden gehoord.')
                      , ('Article 7:18 par 1 Awb', 'Tot tien dagen voor het horen kunnen belanghebbenden nadere stukken indienen.')
                      , ('Article 7:18 par 2 Awb', 'Het beroepsorgaan legt het beroepschrift en alle verder op de zaak betrekking hebbende stukken voorafgaand aan het horen gedurende ten minste een week voor belanghebbenden ter inzage.')
                      , ('Article 7:18 par 3 Awb', 'Bij de oproeping voor het horen worden belanghebbenden gewezen op het eerste par en wordt vermeld waar en wanneer de stukken ter inzage zullen liggen.')
                      , ('Article 7:18 par 4 Awb', 'Belanghebbenden kunnen van deze stukken tegen vergoeding van ten hoogste de kosten afschriften verkrijgen.')
                      , ('Article 7:18 par 5 Awb', 'Voor zover de belanghebbenden daarmee instemmen, kan toepassing van het tweede par achterwege worden gelaten.')
                      , ('Article 7:18 par 6 Awb', 'Het beroepsorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het tweede par voorts achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. Van de toepassing van deze bepaling wordt mededeling gedaan.')
                      , ('Article 7:18 par 7 Awb', 'Gewichtige redenen zijn in ieder geval niet aanwezig, voor zover ingevolge de Wet openbaarheid van bestuur de verplichting bestaat een verzoek om informatie, vervat in deze stukken, in te willigen.')
                      , ('Article 7:18 par 8 Awb', 'Indien een gewichtige reden is gelegen in de vrees voor schade aan de lichamelijke of geestelijke gezondheid van een belanghebbende, kan inzage van de desbetreffende stukken worden voorbehouden aan een gemachtigde die hetzij advocaat hetzij arts is.')
                      , ('Article 7:19 par 1 Awb', 'Het horen geschiedt door het beroepsorgaan.')
                      , ('Article 7:19 par 2 Awb', 'Bij of krachtens de wet kan het horen worden opgedragen aan een adviescommissie waarin een of meer leden zitting hebben die geen deel uitmaken van en niet werkzaam zijn onder verantwoordelijkheid van het beroepsorgaan.')
                      , ('Article 7:19 par 3 Awb', 'Het horen geschiedt in het openbaar, tenzij het beroepsorgaan op verzoek van een belanghebbende of om gewichtige redenen ambtshalve anders beslist.')
                      , ('Article 7:20 par 1 Awb', 'Belanghebbenden worden in elkaars aanwezigheid gehoord.')
                      , ('Article 7:20 par 2 Awb', 'Ambtshalve of op verzoek kunnen belanghebbenden afzonderlijk worden gehoord, indien aannemelijk is dat gezamenlijk horen een zorgvuldige behandeling zal belemmeren of dat tijdens het horen feiten of omstandigheden bekend zullen worden waarvan geheimhouding om gewichtige redenen is geboden.')
                      , ('Article 7:20 par 3 Awb', 'Wanneer belanghebbenden afzonderlijk zijn gehoord, wordt ieder van hen op de hoogte gesteld van het verhandelde tijdens het horen buiten zijn aanwezigheid.')
                      , ('Article 7:20 par 4 Awb', 'Het beroepsorgaan kan, al dan niet op verzoek van een belanghebbende, toepassing van het derde par achterwege laten, voor zover geheimhouding om gewichtige redenen is geboden. [118]Artikel 7:18, zesde lid, tweede volzin, zevende en achtste lid, is van overeenkomstige toepassing.')
                      , ('Article 7:21 Awb', 'Van het horen wordt een verslag gemaakt.')
                      , ('Article 7:22 Awb', 'Op verzoek van de belanghebbende kunnen door hem meegebrachte getuigen en deskundigen worden gehoord.')
                      , ('Article 7:23 Awb', 'Wanneer na het horen aan het beroepsorgaan feiten of omstandigheden bekend worden die voor de op het beroep te nemen beslissing van aanmerkelijk belang kunnen zijn, wordt dit aan belanghebbenden meegedeeld en worden zij in de gelegenheid gesteld daarover te worden gehoord.')
                      , ('Article 7:24 par 1 Awb', 'Het beroepsorgaan beslist binnen zestien weken na ontvangst van het beroepschrift.')
                      , ('Article 7:24 par 2 Awb', 'Indien het beroepsorgaan evenwel behoort tot dezelfde rechtspersoon als het bestuursorgaan tegen welks besluit het beroep is gericht, beslist het binnen zes weken of, indien een commissie als bedoeld in [119]artikel 7:19, tweede lid, is ingesteld, binnen tien weken na ontvangst van het beroepschrift.')
                      , ('Article 7:24 par 3 Awb', 'De termijn wordt opgeschort met ingang van de dag waarop de indiener is verzocht een verzuim als bedoeld in [120]artikel 6:6 te herstellen, tot de dag waarop het verzuim is hersteld of de daarvoor gestelde termijn ongebruikt is verstreken.')
                      , ('Article 7:24 par 4 Awb', 'Het beroepsorgaan kan de beslissing voor ten hoogste acht weken verdagen.')
                      , ('Article 7:24 par 5 Awb', 'In het geval, bedoeld in het tweede lid, kan het beroepsorgaan de beslissing echter voor ten hoogste vier weken verdagen.')
                      , ('Article 7:24 par 6 Awb', 'Van de verdaging wordt schriftelijk mededeling gedaan.')
                      , ('Article 7:24 par 7 Awb', 'Verder uitstel is mogelijk voor zover de indiener daarmee instemt en andere belanghebbenden daardoor niet in hun belangen kunnen worden geschaad of ermee instemmen.')
                      , ('Article 7:25 Awb', 'Voor zover het beroepsorgaan het beroep ontvankelijk en gegrond acht, vernietigt het het bestreden besluit en neemt het voor zover nodig in de plaats daarvan een nieuw besluit.')
                      , ('Article 7:26 par 1 Awb', 'De beslissing op het beroep dient te berusten op een deugdelijke motivering, die bij de bekendmaking van de beslissing wordt vermeld. Daarbij wordt, indien ingevolge [121]artikel 7:17 van het horen is afgezien, tevens aangegeven op welke grond dat is geschied.')
                      , ('Article 7:26 par 2 Awb', 'Indien de beslissing afwijkt van het advies van een commissie als bedoeld in [122]artikel 7:19, tweede lid, worden in de beslissing de redenen voor die afwijking vermeld en wordt het advies met de beslissing meegezonden.')
                      , ('Article 7:26 par 3 Awb', 'De beslissing wordt bekendgemaakt door toezending of uitreiking aan degenen tot wie zij is gericht. Betreft het een besluit dat niet tot een of meer belanghebbenden was gericht, dan wordt de beslissing bekendgemaakt op dezelfde wijze als waarop dat besluit bekendgemaakt is.')
                      , ('Article 7:26 par 4 Awb', 'Zo spoedig mogelijk na de bekendmaking van de beslissing wordt hiervan mededeling gedaan aan het bestuursorgaan tegen welks besluit het beroep was gericht, aan degenen tot wie het bestreden besluit was gericht en aan de belanghebbenden die in beroep hun zienswijze naar voren hebben gebracht.')
                      , ('Article 7:26 par 5 Awb', 'Bij de mededeling, bedoeld in het vierde lid, is [123]artikel 6:23 van overeenkomstige toepassing en wordt met het oog op de aanvang van de beroepstermijn zo duidelijk mogelijk aangegeven wanneer de bekendmaking van de beslissing overeenkomstig het derde par heeft plaatsgevonden.')
                      , ('Article 7:27 Awb', '[124]Artikel 3:6, tweede lid, [125]afdeling 3.4, de [126]artikelen 3:41 tot en met 3:45, [127]afdeling 3.7, met uitzondering van [128]artikel 3:49, en [129]hoofdstuk 4 zijn niet van toepassing op besluiten op grond van deze afdeling.')
                      , ('Article 7:28 par 1 Awb', 'Voor de behandeling van het beroep is geen recht verschuldigd.')
                      , ('Article 7:28 par 2 Awb', 'De kosten, die de belanghebbende in verband met de behandeling van het beroep redelijkerwijs heeft moeten maken, worden door het bestuursorgaan uitsluitend vergoed op verzoek van de belanghebbende voorzover het bestreden besluit wordt herroepen wegens aan het bestuursorgaan te wijten onrechtmatigheid. In dat geval stelt het beroepsorgaan de vergoeding vast die het bestuursorgaan verschuldigd is. Artikel 243, tweede lid, van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Article 7:28 par 3 Awb', 'Het verzoek wordt gedaan voordat het beroepsorgaan op het beroep heeft beslist. Het beroepsorgaan beslist op het verzoek bij de beslissing op het beroep.')
                      , ('Article 7:28 par 4', 'Bij algemene maatregel van bestuur worden nadere regels gesteld over de kosten waarop de vergoeding uitsluitend betrekking kan hebben en over de wijze waarop het bedrag van de kosten wordt vastgesteld.')
                      , ('Article 7:29 Awb', '[Vervallen per 01-01-1994]')
                      , ('Article 8:1 par 1 Awb', 'Een belanghebbende kan tegen een besluit beroep instellen bij de rechtbank.')
                      , ('Article 8:1 par 2 Awb', 'Met een besluit wordt gelijkgesteld een andere handeling van een bestuursorgaan waarbij een ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig of een dienstplichtige als bedoeld in hoofdstuk 2 van de Kaderwet dienstplicht als zodanig, hun nagelaten betrekkingen of hun rechtverkrijgenden belanghebbende zijn.')
                      , ('Article 8:1 par 3 Awb', 'Met een besluit worden gelijkgesteld: a. de schriftelijke beslissing, inhoudende de weigering van de goedkeuring van een besluit, inhoudende een algemeen verbindend voorschrift of een beleidsregel of de intrekking of de vaststelling van de inwerkingtreding van een algemeen verbindend voorschrift of een beleidsregel, en b. de schriftelijke beslissing, inhoudende de weigering van de goedkeuring van een besluit ter voorbereiding van een privaatrechtelijke rechtshandeling.')
                      , ('Article 8:2 sub a Awb', 'Geen beroep kan worden ingesteld tegen: a. een besluit, inhoudende een algemeen verbindend voorschrift of een beleidsregel.')
                      , ('Article 8:2 sub b Awb', 'Geen beroep kan worden ingesteld tegen: b. een besluit, inhoudende de intrekking of de vaststelling van de inwerkingtreding van een algemeen verbindend voorschrift of een beleidsregel.')
                      , ('Article 8:2 sub c Awb', 'Geen beroep kan worden ingesteld tegen: c. een besluit, inhoudende de goedkeuring van een besluit, inhoudende een algemeen verbindend voorschrift of een beleidsregel of de intrekking of de vaststelling van de inwerkingtreding van een algemeen verbindend voorschrift of een beleidsregel.')
                      , ('Article 8:3 Awb', 'Geen beroep kan worden ingesteld tegen een besluit ter voorbereiding van een privaatrechtelijke rechtshandeling.')
                      , ('Article 8:4 sub a Awb', 'Geen beroep kan worden ingesteld tegen een besluit: a. inhoudende schorsing of vernietiging van een besluit van een ander bestuursorgaan.')
                      , ('Article 8:4 sub b Awb', 'Geen beroep kan worden ingesteld tegen een besluit: b. op grond van een in enig wettelijk voorschrift voor het geval van buitengewone omstandigheden toegekende bevoegdheid of opgelegde verplichting in deze omstandigheden genomen.')
                      , ('Article 8:4 sub c Awb', 'Geen beroep kan worden ingesteld tegen een besluit: c. genomen op grond van een wettelijk voorschrift ter beveiliging van de militaire belangen van het Koninkrijk of zijn bondgenoten.')
                      , ('Article 8:4 sub d Awb', 'Geen beroep kan worden ingesteld tegen een besluit: d. tot benoeming of aanstelling, tenzij beroep wordt ingesteld door een ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig of een dienstplichtige als bedoeld in hoofdstuk 2 van de Kaderwet dienstplicht als zodanig, hun nagelaten betrekkingen of hun rechtverkrijgenden.')
                      , ('Article 8:4 sub e Awb', 'Geen beroep kan worden ingesteld tegen een besluit: e. inhoudende een beoordeling van het kennen of kunnen van een kandidaat of leerling die ter zake is geëxamineerd of op enigerlei andere wijze is getoetst, dan wel inhoudende de vaststelling van opgaven, beoordelingsnormen of nadere regels voor die examinering of toetsing.')
                      , ('Article 8:4 sub f Awb', 'Geen beroep kan worden ingesteld tegen een besluit: f. inhoudende een technische beoordeling van een voertuig of een luchtvaartuig, dan wel een meetmiddel, een onderdeel daarvan of een hulpinrichting daarvoor.')
                      , ('Article 8:4 sub g Awb', 'Geen beroep kan worden ingesteld tegen een besluit: g. inzake de nummering van kandidatenlijsten, de geldigheid van lijstverbindingen, het verloop van de stemming, de stemopneming, de vaststelling van de stemwaarden en de vaststelling van de uitslag bij verkiezingen van de leden van vertegenwoordigende organen, de benoemdverklaring in opengevallen plaatsen, de toelating van nieuwe leden van provinciale staten, van de gemeenteraad en van het algemeen bestuur van een waterschap, alsmede de verlening van tijdelijk ontslag wegens zwangerschap en bevalling of ziekte.')
                      , ('Article 8:4 sub h Awb', 'Geen beroep kan worden ingesteld tegen een besluit: h. genomen op grond van een wettelijk voorschrift inzake de verplichte krijgsdienst, voor zover het keuring, herkeuring, werkelijke dienst, groot verlof of diensteindiging betreft, tenzij het besluit betrekking heeft op verlenging van werkelijke dienst of kostwinnersvergoeding, of het besluit is genomen op grond van de Wet voor het reservepersoneel der krijgsmacht 1985.')
                      , ('Article 8:4 sub i Awb', 'Geen beroep kan worden ingesteld tegen een besluit: i. houdende een ambtshandeling van een gerechtsdeurwaarder of notaris.')
                      , ('Article 8:4 sub j Awb', 'Geen beroep kan worden ingesteld tegen een besluit: j. als bedoeld in [130]artikel 7:1a, vierde lid.')
                      , ('Article 8:4 sub k Awb', 'Geen beroep kan worden ingesteld tegen een besluit: k. inhoudende een weigering op grond van [131]artikel 2:15.')
                      , ('Article 8:4 sub l Awb', 'Geen beroep kan worden ingesteld tegen een besluit: l. een besluit als bedoeld in [132]artikel 3:21, eerste lid, onderdeel b.')
                      , ('Article 8:5 par 1 Awb', 'Geen beroep kan worden ingesteld tegen een besluit, genomen op grond van een wettelijk voorschrift dat is opgenomen in de bijlage die bij deze wet behoort.')
                      , ('Article 8:5 par 2 Awb', 'Bij een wijziging van de bijlage blijft de bijlage zoals deze luidde voor het tijdstip van inwerkingtreding van de wijziging van toepassing ten aanzien van de mogelijkheid om beroep in te stellen tegen een besluit dat voor dat tijdstip is bekendgemaakt.')
                      , ('Article 8:6 par 1 Awb', 'Geen beroep kan worden ingesteld tegen een besluit waartegen beroep bij een andere administratieve rechter kan of kon worden ingesteld.')
                      , ('Article 8:6 par 2 Awb', 'Geen beroep kan worden ingesteld tegen een besluit waartegen administratief beroep kan worden ingesteld of door de belanghebbende kon worden ingesteld.')
                      , ('Article 8:7 par 1 Awb', 'Indien beroep wordt ingesteld tegen een besluit van een bestuursorgaan van een provincie, een gemeente, een waterschap of een regio als bedoeld in artikel 21 van de Politiewet 1993 dan wel tegen een besluit van een gemeenschappelijk orgaan of een bestuursorgaan van een openbaar lichaam dat is ingesteld met toepassing van de Wet gemeenschappelijke regelingen, is de rechtbank binnen het rechtsgebied waarvan het bestuursorgaan zijn zetel heeft bevoegd.')
                      , ('Article 8:7 par 2 Awb', 'Indien beroep wordt ingesteld tegen een besluit van een ander bestuursorgaan, is de rechtbank binnen het rechtsgebied waarvan de indiener van het beroepschrift zijn woonplaats in Nederland heeft bevoegd. Indien de indiener van het beroepschrift geen woonplaats in Nederland heeft, is de rechtbank binnen het rechtsgebied waarvan het bestuursorgaan zijn zetel heeft bevoegd.')
                      , ('Article 8:8 par 1 Awb', 'Indien tegen hetzelfde besluit bij meer dan één bevoegde rechtbank beroep is ingesteld, worden de zaken verder behandeld door de bevoegde rechtbank waarbij als eerste beroep is ingesteld. Indien gelijktijdig bij meer dan één bevoegde rechtbank als eerste beroep is ingesteld, worden de zaken verder behandeld door de bevoegde rechtbank die als eerste wordt genoemd in de Wet op de rechterlijke indeling.')
                      , ('Article 8:8 par 2 Awb', 'De andere rechtbank verwijst onderscheidenlijk de andere rechtbanken verwijzen de daar aanhangig gemaakte zaak of zaken naar de rechtbank die de zaken verder behandelt. De op de zaak of zaken betrekking hebbende stukken worden toegezonden aan de rechtbank die de zaken verder behandelt.')
                      , ('Article 8:8 par 3 Awb', 'Indien tegen hetzelfde besluit bij meer dan één rechtbank beroep is ingesteld, doet het bestuursorgaan daarvan onverwijld mededeling aan die rechtbanken.')
                      , ('Article 8:8 par 4 Awb', 'Indien het bestuursorgaan ingevolge [133]artikel 7:1a, vijfde of zesde lid, verschillende bezwaarschriften doorzendt, zendt het bestuursorgaan deze door aan de rechtbank die ingevolge de tweede volzin van het eerste par de zaak zal behandelen.')
                      , ('Article 8:9 Awb', 'De Afdeling bestuursrechtspraak van de Raad van State onderscheidenlijk de Centrale Raad van Beroep oordelen in hoogste ressort over geschillen tussen de rechtbanken over de toepassing van [134]artikel 8:7 in zaken tot de kennisneming waarvan zij in hoger beroep bevoegd zijn.')
                      , ('Article 8:10 par 1 Awb', 'De zaken die bij de rechtbank aanhangig worden gemaakt, worden in behandeling genomen door een enkelvoudige kamer.')
                      , ('Article 8:10 par 2 Awb', 'Indien een zaak naar het oordeel van de enkelvoudige kamer ongeschikt is voor behandeling door één rechter, verwijst zij deze naar een meervoudige kamer. De enkelvoudige kamer kan ook in andere gevallen een zaak naar een meervoudige kamer verwijzen.')
                      , ('Article 8:10 par 3 Awb', 'Indien een zaak naar het oordeel van de meervoudige kamer geschikt is voor verdere behandeling door één rechter, kan zij deze verwijzen naar een enkelvoudige kamer.')
                      , ('Article 8:10 par 4 Awb', 'Verwijzing kan geschieden in elke stand van het geding. Een verwezen zaak wordt voortgezet in de stand waarin zij zich bevindt.')
                      , ('Article 8:11 par 1 Awb', 'De voorschriften omtrent de behandeling van het beroep zijn op de behandeling zowel door een enkelvoudige als door een meervoudige kamer van toepassing.')
                      , ('Article 8:11 par 2 Awb', 'Degene die zitting heeft in een enkelvoudige kamer heeft tevens de bevoegdheden en de verplichtingen die de voorzitter van een meervoudige kamer heeft.')
                      , ('Article 8:12 Awb', 'De rechtbank kan aan een rechter-commissaris opdragen het vooronderzoek of een gedeelte daarvan te verrichten.')
                      , ('Article 8:13 par 1 Awb', 'De rechtbank kan een bij haar aanhangig gemaakte zaak ter verdere behandeling verwijzen naar de rechtbank waar een andere zaak aanhangig is gemaakt, indien naar haar oordeel behandeling van die zaken door één rechtbank gewenst is. Zij kan een bij haar aanhangig gemaakte zaak ter verdere behandeling verwijzen naar een andere rechtbank, indien naar haar oordeel door betrokkenheid van de rechtbank behandeling van die zaak door een andere rechtbank gewenst is.')
                      , ('Article 8:13 par 2 Awb', 'Een verzoek tot verwijzing kan worden gedaan tot de aanvang van het onderzoek ter zitting.')
                      , ('Article 8:13 par 3 Awb', 'Indien de rechtbank waarnaar een zaak is verwezen, instemt met de verwijzing, worden de op de zaak betrekking hebbende stukken aan haar toegezonden.')
                      , ('Article 8:14 par 1 Awb', 'De rechtbank kan zaken over hetzelfde of een verwant onderwerp ter behandeling voegen en de behandeling van gevoegde zaken splitsen.')
                      , ('Article 8:14 par 2 Awb', 'Een verzoek daartoe kan worden gedaan tot de sluiting van het onderzoek ter zitting.')
                      , ('Article 8:15 Awb', 'Op verzoek van een partij kan elk van de rechters die een zaak behandelen, worden gewraakt op grond van feiten of omstandigheden waardoor de rechterlijke onpartijdigheid schade zou kunnen lijden.')
                      , ('Article 8:16 par 1 Awb', 'Het verzoek wordt gedaan zodra de feiten of omstandigheden aan de verzoeker bekend zijn geworden.')
                      , ('Article 8:16 par 2 Awb', 'Het verzoek geschiedt schriftelijk en is gemotiveerd. Na de aanvang van het onderzoek ter zitting onderscheidenlijk na de aanvang van het horen van partijen of getuigen in het vooronderzoek kan het ook mondeling geschieden.')
                      , ('Article 8:16 par 3 Awb', 'Alle feiten of omstandigheden moeten tegelijk worden voorgedragen.')
                      , ('Article 8:16 par 4 Awb', 'Een volgend verzoek om wraking van dezelfde rechter wordt niet in behandeling genomen, tenzij feiten of omstandigheden worden voorgedragen die pas na het eerdere verzoek aan de verzoeker bekend zijn geworden.')
                      , ('Article 8:16 par 5 Awb', 'Geschiedt het verzoek ter zitting, dan wordt het onderzoek ter zitting geschorst.')
                      , ('Article 8:17 Awb', 'Een rechter wiens wraking is verzocht, kan in de wraking berusten.')
                      , ('Article 8:18 par 1 Awb', 'Het verzoek om wraking wordt zo spoedig mogelijk ter zitting behandeld door een meervoudige kamer waarin de rechter wiens wraking is verzocht, geen zitting heeft.')
                      , ('Article 8:18 par 2 Awb', 'De verzoeker en de rechter wiens wraking is verzocht, worden in de gelegenheid gesteld te worden gehoord. De rechtbank kan ambtshalve of op verzoek van de verzoeker of de rechter wiens wraking is verzocht, bepalen dat zij niet in elkaars aanwezigheid zullen worden gehoord.')
                      , ('Article 8:18 par 3 Awb', 'De rechtbank beslist zo spoedig mogelijk. De rechtbank spreekt de beslissing in het openbaar uit. De beslissing is gemotiveerd en wordt onverwijld aan de verzoeker, de andere partijen en de rechter wiens wraking was verzocht medegedeeld.')
                      , ('Article 8:18 par 4 Awb', 'In geval van misbruik kan de rechtbank bepalen dat een volgend verzoek niet in behandeling wordt genomen. Hiervan wordt in de beslissing melding gemaakt.')
                      , ('Article 8:18 par 5 Awb', 'Tegen de beslissing staat geen rechtsmiddel open.')
                      , ('Article 8:19 par 1 Awb', 'Op grond van feiten of omstandigheden als bedoeld in [135]artikel 8:15 kan elk van de rechters die een zaak behandelen, verzoeken zich te mogen verschonen.')
                      , ('Article 8:19 par 2 Awb', 'Het verzoek geschiedt schriftelijk en is gemotiveerd. Na de aanvang van het onderzoek ter zitting, onderscheidenlijk na de aanvang van het horen van partijen of getuigen in het vooronderzoek kan het ook mondeling geschieden.')
                      , ('Article 8:19 par 3 Awb', 'Geschiedt het verzoek ter zitting, dan wordt het onderzoek ter zitting geschorst.')
                      , ('Article 8:20 par 1 Awb', 'Het verzoek om verschoning wordt zo spoedig mogelijk behandeld door een meervoudige kamer waarin de rechter die om verschoning heeft verzocht, geen zitting heeft.')
                      , ('Article 8:20 par 2 Awb', 'De rechtbank beslist zo spoedig mogelijk. De beslissing is gemotiveerd en wordt onverwijld aan partijen en de rechter die om verschoning had verzocht medegedeeld.')
                      , ('Article 8:20 par 3 Awb', 'Tegen de beslissing staat geen rechtsmiddel open.')
                      , ('Article 8:21 par 1 Awb', 'Natuurlijke personen, onbekwaam om in rechte te staan, worden in het geding vertegenwoordigd door hun vertegenwoordigers naar burgerlijk recht. De wettelijke vertegenwoordiger behoeft niet de machtiging van de kantonrechter, bedoeld in artikel 349 van Boek 1 van het Burgerlijk Wetboek.')
                      , ('Article 8:21 par 2 Awb', 'De in het eerste par bedoelde personen kunnen zelf in het geding optreden, indien zij tot redelijke waardering van hun belangen in staat kunnen worden geacht.')
                      , ('Article 8:21 par 3 Awb', 'Indien geen wettelijke vertegenwoordiger aanwezig is, of deze niet beschikbaar is en de zaak spoedeisend is, kan de rechtbank een voorlopige vertegenwoordiger benoemen. De benoeming vervalt zodra een wettelijke vertegenwoordiger aanwezig is of de wettelijke vertegenwoordiger weer beschikbaar is.')
                      , ('Article 8:22 par 1 Awb', 'In geval van faillissement of surséance van betaling of toepassing van de schuldsaneringsregeling natuurlijke personen zijn de artikelen 25, 27 en 31 van de Faillissementswet van overeenkomstige toepassing.')
                      , ('Article 8:22 par 2 Awb', 'De artikelen 25, tweede lid, en 27 vinden geen toepassing, indien partijen vóór de faillietverklaring zijn uitgenodigd om op een zitting van de rechtbank te verschijnen.')
                      , ('Article 8:23 par 1 Awb', 'Een bestuursorgaan dat een college is, wordt in het geding vertegenwoordigd door een of meer door het bestuursorgaan aangewezen leden.')
                      , ('Article 8:23 par 2 Awb', 'De Kroon wordt in het geding vertegenwoordigd door Onze Minister wie het aangaat onderscheidenlijk door een of meer van Onze Ministers wie het aangaat.')
                      , ('Article 8:24 par 1 Awb', 'Partijen kunnen zich laten bijstaan of door een gemachtigde laten vertegenwoordigen.')
                      , ('Article 8:24 par 2 Awb', 'De rechtbank kan van een gemachtigde een schriftelijke machtiging verlangen.')
                      , ('Article 8:24 par 3 Awb', 'Het tweede par is niet van toepassing ten aanzien van advocaten.')
                      , ('Article 8:25 par 1 Awb', 'De rechtbank kan bijstand of vertegenwoordiging door een persoon tegen wie ernstige bezwaren bestaan, weigeren.')
                      , ('Article 8:25 par 2 Awb', 'De betrokken partij en de in het eerste par bedoelde persoon worden onverwijld in kennis gesteld van de weigering en de reden daarvoor.')
                      , ('Article 8:25 par 3 Awb', 'Het eerste par is niet van toepassing ten aanzien van advocaten.')
                      , ('Article 8:26 par 1 Awb', 'De rechtbank kan tot de sluiting van het onderzoek ter zitting ambtshalve, op verzoek van een partij of op hun eigen verzoek, belanghebbenden in de gelegenheid stellen als partij aan het geding deel te nemen.')
                      , ('Article 8:26 par 2 Awb', 'Indien de rechtbank vermoedt dat er onbekende belanghebbenden zijn, kan zij in de Staatscourant doen aankondigen dat een zaak bij haar aanhangig is. Naast de aankondiging in de Staatscourant kan ook een ander middel voor de aankondiging worden gebruikt.')
                      , ('Article 8:27 par 1 Awb', 'Partijen die door de rechtbank zijn opgeroepen om in persoon dan wel in persoon of bij gemachtigde te verschijnen, al dan niet voor het geven van inlichtingen, zijn verplicht te verschijnen en de verlangde inlichtingen te geven. Partijen worden hierop gewezen, alsmede op [136]artikel 8:31.')
                      , ('Article 8:27 par 2 Awb', 'Indien het een rechtspersoon betreft of een bestuursorgaan dat een college is, kan de rechtbank een of meer bepaalde bestuurders onderscheidenlijk een of meer bepaalde leden oproepen.')
                      , ('Article 8:28 Awb', 'Partijen aan wie door de rechtbank is verzocht schriftelijk inlichtingen te geven, zijn verplicht de verlangde inlichtingen te geven. Partijen worden hierop gewezen, alsmede op [137]artikel 8:31.')
                      , ('Article 8:29 par 1 Awb', 'Partijen die verplicht zijn inlichtingen te geven dan wel stukken over te leggen, kunnen, indien daarvoor gewichtige redenen zijn, het geven van inlichtingen dan wel het overleggen van stukken weigeren of de rechtbank mededelen dat uitsluitend zij kennis zal mogen nemen van de inlichtingen onderscheidenlijk de stukken.')
                      , ('Article 8:29 par 2 Awb', 'Gewichtige redenen zijn voor een bestuursorgaan in ieder geval niet aanwezig, voor zover ingevolge de Wet openbaarheid van bestuur de verplichting zou bestaan een verzoek om informatie, vervat in de over te leggen stukken, in te willigen.')
                      , ('Article 8:29 par 3 Awb', 'De rechtbank beslist of de in het eerste par bedoelde weigering onderscheidenlijk de beperking van de kennisneming gerechtvaardigd is.')
                      , ('Article 8:29 par 4 Awb', 'Indien de rechtbank heeft beslist dat de weigering gerechtvaardigd is, vervalt de verplichting.')
                      , ('Article 8:29 par 5 Awb', 'Indien de rechtbank heeft beslist dat de beperking van de kennisneming gerechtvaardigd is, kan zij slechts met toestemming van de andere partijen mede op de grondslag van die inlichtingen onderscheidenlijk die stukken uitspraak doen. Indien de toestemming wordt geweigerd, wordt de zaak verwezen naar een andere kamer.')
                      , ('Article 8:30 Awb', 'Partijen zijn verplicht mee te werken aan een onderzoek als bedoeld in [138]artikel 8:47, eerste lid. Partijen worden hierop gewezen, alsmede op [139]artikel 8:31.')
                      , ('Article 8:31 Awb', 'Indien een partij niet voldoet aan de verplichting te verschijnen, inlichtingen te geven, stukken over te leggen of mee te werken aan een onderzoek als bedoeld in [140]artikel 8:47, eerste lid, kan de rechtbank daaruit de gevolgtrekkingen maken die haar geraden voorkomen.')
                      , ('Article 8:32 par 1 Awb', 'De rechtbank kan, indien de vrees bestaat dat kennisneming van stukken door een partij haar lichamelijke of geestelijke gezondheid zou schaden, bepalen dat deze kennisneming is voorbehouden aan een gemachtigde die advocaat of arts is dan wel daarvoor van de rechtbank bijzondere toestemming heeft gekregen.')
                      , ('Article 8:32 par 2 Awb', 'De rechtbank kan, indien kennisneming van stukken door een partij de persoonlijke levenssfeer van een ander onevenredig zou schaden, bepalen dat deze kennisneming is voorbehouden aan een gemachtigde die advocaat of arts is dan wel daarvoor van de rechtbank bijzondere toestemming heeft gekregen.')
                      , ('Article 8:33 par 1 Awb', 'Ieder die door de rechtbank als getuige wordt opgeroepen, is verplicht aan de oproeping gevolg te geven en getuigenis af te leggen.')
                      , ('Article 8:33 par 2 Awb', 'In de oproeping worden vermeld de plaats en het tijdstip waarop de getuige zal worden gehoord, de feiten waarop het horen betrekking zal hebben en de gevolgen die zijn verbonden aan het niet verschijnen.')
                      , ('Article 8:33 par 3 Awb', 'De artikelen 165, tweede en derde lid, 172, 173, eerste lid, eerste volzin, tweede en derde lid, 174, eerste lid, 175, 176, eerste en derde lid, 177, eerste par en 178 van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing')
                      , ('Article 8:33 par 4 Awb', 'De rechtbank kan bepalen dat getuigen niet zullen worden gehoord dan na het afleggen van de eed of de belofte. Zij leggen in dat geval de eed of de belofte af dat zij zullen zeggen de gehele waarheid en niets dan de waarheid.')
                      , ('Article 8:34 par 1 Awb', 'De deskundige die zijn benoeming heeft aanvaard, is verplicht zijn opdracht onpartijdig en naar beste weten te vervullen.')
                      , ('Article 8:34 par 2 Awb', 'Artikel 165, tweede lid, onderdeel b, en derde lid, van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Article 8:35 par 1 Awb', 'De tolk die zijn benoeming heeft aanvaard en die door de rechtbank wordt opgeroepen, is verplicht aan de oproeping gevolg te geven en zijn opdracht onpartijdig en naar beste weten te vervullen. De artikelen 172 en 178 van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing.')
                      , ('Article 8:35 par 2 Awb', 'In de oproeping worden vermeld de plaats en het tijdstip waarop de opdracht moet worden vervuld en de gevolgen die zijn verbonden aan het niet verschijnen.')
                      , ('Article 8:36 par 1 Awb', 'Aan de door de rechtbank opgeroepen getuigen, deskundigen en tolken en de deskundigen die een onderzoek als bedoeld in [141]artikel 8:47, eerste lid, hebben ingesteld, wordt ten laste van het Rijk een vergoeding toegekend. Het bij en krachtens de Wet tarieven in strafzaken bepaalde is van overeenkomstige toepassing.')
                      , ('Article 8:36 par 2 Awb', 'De partij die een getuige of deskundige heeft meegebracht of opgeroepen, dan wel aan wie een verslag van een deskundige is uitgebracht, is aan deze een vergoeding verschuldigd. Het bij en krachtens de Wet tarieven in strafzaken bepaalde is van overeenkomstige toepassing.')
                      , ('Article 8:37 par 1 Awb', 'Oproepingen, de uitnodiging om op een zitting van de rechtbank te verschijnen, alsmede de verzending van een afschrift van de uitspraak en van het proces-verbaal van de mondelinge uitspraak geschieden door de griffier bij aangetekende brief of bij brief met ontvangstbevestiging, tenzij de rechtbank anders bepaalt.')
                      , ('Article 8:37 par 2 Awb', 'Voor het overige geschiedt de verzending van stukken door de griffier bij gewone brief, tenzij de rechtbank anders bepaalt.')
                      , ('Article 8:37 par 3 Awb', 'In een brief wordt de datum van verzending vermeld.')
                      , ('Article 8:38 par 1 Awb', 'Indien de griffier een bij aangetekende brief of bij brief met ontvangstbevestiging verzonden stuk terug ontvangt en hem blijkt dat de geadresseerde op de dag van verzending of uiterlijk een week daarna in de gemeentelijke basisadministratie persoonsgegevens stond ingeschreven op het op het stuk vermelde adres, dan verzendt hij het stuk zo spoedig mogelijk bij gewone brief.')
                      , ('Article 8:38 par 2 Awb', 'In de overige gevallen waarin de griffier een bij aangetekende brief of bij brief met ontvangstbevestiging verzonden stuk terug ontvangt, verbetert hij, indien mogelijk, het op het stuk vermelde adres en verzendt hij het stuk opnieuw bij aangetekende brief of bij brief met ontvangstbevestiging.')
                      , ('Article 8:39 par 1 Awb', 'De griffier zendt de op de zaak betrekking hebbende stukken zo spoedig mogelijk aan partijen, voor zover de rechtbank niet op grond van de [142]artikelen 8:29 of [143]8:32 anders heeft beslist.')
                      , ('Article 8:39 par 2 Awb', 'De griffier kan de toezending van zeer omvangrijke stukken of van stukken die bezwaarlijk kunnen worden vermenigvuldigd, achterwege laten. Hij stelt partijen daarvan in kennis en vermeldt daarbij dat deze stukken gedurende een door hem te bepalen termijn van ten minste een week ter griffie ter inzage worden gelegd.')
                      , ('Article 8:39 par 3 Awb', 'Partijen kunnen afschriften van of uittreksels uit de in het tweede par bedoelde stukken verkrijgen. Met betrekking tot de kosten is het bij en krachtens de Wet tarieven in strafzaken bepaalde van overeenkomstige toepassing.')
                      , ('Article 8:40 Awb', 'Indien het beroepschrift is ingediend door twee of meer personen, kan worden volstaan met verzending van de oproeping, de uitnodiging om op een zitting van de rechtbank te verschijnen, de op de zaak betrekking hebbende stukken en een afschrift van de uitspraak of van het proces-verbaal van de mondelinge uitspraak aan de persoon die als eerste in het beroepschrift is vermeld.')
                      , ('Article 8:41 par 1 Awb', 'Van de indiener van het beroepschrift wordt door de griffier een griffierecht geheven. Indien het een beroepschrift ter zake van twee of meer samenhangende besluiten of van twee of meer indieners ter zake van hetzelfde besluit betreft, is eenmaal griffierecht verschuldigd. In die gevallen bedraagt het griffierecht het hoogste op grond van het derde par ter zake van een van de besluiten onderscheidenlijk door een van de indieners verschuldigde bedrag.')
                      , ('Article 8:41 par 2 Awb', 'De griffier wijst de indiener van het beroepschrift op de verschuldigdheid van het griffierecht en deelt hem mee dat het verschuldigde bedrag binnen vier weken na de dag van verzending van zijn mededeling dient te zijn bijgeschreven op de rekening van de rechtbank dan wel ter griffie dient te zijn gestort. Indien het bedrag niet binnen deze termijn is bijgeschreven of gestort, wordt het beroep niet-ontvankelijk verklaard, tenzij redelijkerwijs niet kan worden geoordeeld dat de indiener in verzuim is geweest.')
                      , ('Article 8:41 par 3 sub a-1 Awb', 'Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 1°. een besluit, genomen op grond van een wettelijk voorschrift dat is opgenomen in de onderdelen B en C, onder 1 tot en met 25, 29 en 33, dit laatste voor zover het een besluit betreft dat is genomen op grond van artikel 30d van de Wet structuur uitvoeringsorganisatie werk en inkomen, van de bijlage die bij de Beroepswet behoort.')
                      , ('Article 8:41 par 3 sub a-2 Awb', 'Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 2°. een besluit inzake een uitkering bij werkloosheid of ziekte, genomen ten aanzien van een ambtenaar als bedoeld in artikel 1 van de Ambtenarenwet als zodanig of een dienstplichtige als bedoeld in hoofdstuk 2 van de Kaderwet dienstplicht als zodanig, hun nagelaten betrekkingen of hun rechtverkrijgenden.')
                      , ('Article 8:41 par 3 sub a-3 Awb', 'Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 3°. een besluit inzake een uitkering op grond van blijvende arbeidsongeschiktheid op grond van een wettelijk voorschrift waarbij de natuurlijke persoon ter zake van zijn arbeidsongeschiktheid vanwege het Rijk invaliditeitspensioen is verzekerd of een besluit, genomen op grond van artikel P 9 van de Algemene burgerlijke pensioenwet.')
                      , ('Article 8:41 par 3 sub a-4 Awb', 'Het griffierecht bedraagt: a. EUR 41 indien door een natuurlijke persoon beroep is ingesteld tegen: 4e een besluit genomen op grond van de Wet op de huurtoeslag.')
                      , ('Article 8:41 par 3 sub b Awb', 'Het griffierecht bedraagt: b. EUR 150 indien door een natuurlijke persoon beroep is ingesteld tegen een ander besluit dan een besluit als bedoeld in onderdeel a, tenzij bij wet anders is bepaald.')
                      , ('Article 8:41 par 3 sub c Awb', 'Het griffierecht bedraagt: c. EUR 297 indien anders dan door een natuurlijke persoon beroep is ingesteld.')
                      , ('Article 8:41 par 4 Awb', 'Indien het beroep wordt ingetrokken omdat het bestuursorgaan geheel of gedeeltelijk aan de indiener van het beroepschrift is tegemoetgekomen, wordt het door de indiener betaalde griffierecht aan hem vergoed door de desbetreffende rechtspersoon. In de overige gevallen kan de desbetreffende rechtspersoon, indien het beroep wordt ingetrokken, het betaalde griffierecht geheel of gedeeltelijk vergoeden.')
                      , ('Article 8:41 par 5 Awb', 'De in het derde par genoemde bedragen kunnen bij algemene maatregel van bestuur worden gewijzigd voor zover de consumentenprijsindex daartoe aanleiding geeft.')
                      , ('Article 8:42 par 1 Awb', 'Binnen vier weken na de dag van verzending van het beroepschrift aan het bestuursorgaan zendt dit de op de zaak betrekking hebbende stukken aan de rechtbank en dient het een verweerschrift in.')
                      , ('Article 8:42 par 2 Awb', 'De rechtbank kan de in het eerste par bedoelde termijn verlengen.')
                      , ('Article 8:43 par 1 Awb', 'De rechtbank kan de indiener van het beroepschrift in de gelegenheid stellen schriftelijk te repliceren. In dat geval wordt het bestuursorgaan in de gelegenheid gesteld schriftelijk te dupliceren. De rechtbank stelt de termijnen voor repliek en dupliek vast.')
                      , ('Article 8:43 par 2 Awb', 'De rechtbank stelt andere partijen dan de in het eerste par bedoelde in de gelegenheid om ten minste eenmaal een schriftelijke uiteenzetting over de zaak te geven. Zij stelt hiervoor een termijn vast.')
                      , ('Article 8:44 par 1 Awb', 'De rechtbank kan partijen oproepen om in persoon dan wel in persoon of bij gemachtigde te verschijnen om te worden gehoord, al dan niet voor het geven van inlichtingen. Indien niet alle partijen worden opgeroepen, worden de niet opgeroepen partijen in de gelegenheid gesteld het horen bij te wonen en een uiteenzetting over de zaak te geven.')
                      , ('Article 8:44 par 2 Awb', 'Van het geven van inlichtingen wordt door de griffier een proces-verbaal opgemaakt.')
                      , ('Article 8:44 par 3 Awb', 'Het wordt door de voorzitter van de meervoudige kamer en de griffier ondertekend. Bij verhindering van de voorzitter of de griffier wordt dit in het proces-verbaal vermeld.')
                      , ('Article 8:45 par 1 Awb', 'De rechtbank kan partijen en anderen verzoeken binnen een door haar te bepalen termijn schriftelijk inlichtingen te geven en onder hen berustende stukken in te zenden.')
                      , ('Article 8:45 par 2 Awb', 'Bestuursorganen zijn, ook als zij geen partij zijn, verplicht aan het verzoek, bedoeld in het eerste lid, te voldoen. [144]Artikel 8:29 is van overeenkomstige toepassing.')
                      , ('Article 8:45 par 3 Awb', 'Werkgevers van partijen zijn, ook als zij geen partij zijn, verplicht aan het verzoek, bedoeld in het eerste lid, te voldoen. [145]Artikel 8:29 is van overeenkomstige toepassing.')
                      , ('Article 8:46 par 1 Awb', 'De rechtbank kan getuigen oproepen.')
                      , ('Article 8:46 par 2 Awb', 'De rechtbank deelt de namen en woonplaatsen van de getuigen, de plaats en het tijdstip waarop dezen zullen worden gehoord en de feiten waarop het horen betrekking zal hebben, ten minste een week tevoren aan partijen mee.')
                      , ('Article 8:46 par 3 Awb', 'De artikelen 179, eerste, tweede en derde lid, eerste volzin, en 180, eerste tot en met derde en vijfde lid, van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing.')
                      , ('Article 8:47 par 1 Awb', 'De rechtbank kan een deskundige benoemen voor het instellen van een onderzoek.')
                      , ('Article 8:47 par 2 Awb', 'Bij de benoeming worden vermeld de opdracht die moet worden vervuld en de termijn, bedoeld in het vierde lid.')
                      , ('Article 8:47 par 3 Awb', 'Van het voornemen tot het benoemen van een deskundige als bedoeld in het eerste par wordt aan partijen mededeling gedaan. De rechtbank kan partijen in de gelegenheid stellen om hun wensen omtrent het onderzoek binnen een door haar te bepalen termijn schriftelijk aan haar kenbaar te maken.')
                      , ('Article 8:47 par 4 Awb', 'De rechtbank stelt een termijn binnen welke de deskundige aan haar een schriftelijk verslag van het onderzoek uitbrengt.')
                      , ('Article 8:47 par 5 Awb', 'Partijen kunnen binnen vier weken na de dag van verzending van het verslag aan hen schriftelijk hun zienswijze met betrekking tot het verslag naar voren brengen.')
                      , ('Article 8:47 par 6 Awb', 'De rechtbank kan de in het vijfde par bedoelde termijn verlengen.')
                      , ('Article 8:48 par 1 Awb', 'De arts die voor het instellen van een onderzoek als bedoeld in [146]artikel 8:47, eerste lid, een persoon moet onderzoeken, kan de voor het onderzoek van belang zijnde inlichtingen over deze persoon inwinnen bij de behandelend arts of de behandelende artsen, de verzekeringsarts en de adviserend arts van het bestuursorgaan.')
                      , ('Article 8:48 par 2 Awb', 'Zij verstrekken de gevraagde inlichtingen voor zover daardoor de persoonlijke levenssfeer van de betrokken persoon niet onevenredig wordt geschaad.')
                      , ('Article 8:49 Awb', 'De rechtbank kan tolken benoemen.')
                      , ('Article 8:50 par 1 Awb', 'De rechtbank kan een onderzoek ter plaatse instellen. Zij heeft daarbij toegang tot elke plaats voor zover dat redelijkerwijs voor de vervulling van haar taak nodig is.')
                      , ('Article 8:50 par 2 Awb', 'Bestuursorganen verlenen de medewerking die in het belang van het onderzoek is vereist.')
                      , ('Article 8:50 par 3 Awb', 'Van plaats en tijdstip van het onderzoek wordt aan partijen mededeling gedaan. Zij kunnen bij het onderzoek aanwezig zijn.')
                      , ('Article 8:50 par 4 Awb', 'Van het onderzoek wordt door de griffier een proces-verbaal opgemaakt.')
                      , ('Article 8:50 par 5 Awb', 'Het wordt door de voorzitter van de meervoudige kamer en de griffier ondertekend. Bij verhindering van de voorzitter of de griffier wordt dit in het proces-verbaal vermeld.')
                      , ('Article 8:51 par 1 Awb', 'De rechtbank kan aan een door haar aangewezen gerechtsauditeur of aan de griffier opdragen een onderzoek ter plaatse in te stellen. Deze heeft daarbij toegang tot elke plaats voor zover dat redelijkerwijs voor de vervulling van de hem opgedragen taak nodig is. De rechtbank is bevoegd tot het geven van een machtiging tot binnentreden.')
                      , ('Article 8:51 par 2 Awb', '[147]Artikel 8:50, tweede en derde lid, is van overeenkomstige toepassing.')
                      , ('Article 8:51 par 3 Awb', 'Van het onderzoek wordt door de gerechtsauditeur of de griffier een proces-verbaal opgemaakt, dat door hem wordt ondertekend.')
                      , ('Article 8:52 par 1 Awb', 'De rechtbank kan, indien de zaak spoedeisend is, bepalen dat deze versneld wordt behandeld.')
                      , ('Article 8:52 par 2 sub a Awb', 'In dat geval kan de rechtbank: a. de in [148]artikel 8:41, tweede lid, bedoelde termijn verkorten.')
                      , ('Article 8:52 par 2 sub b Awb', 'In dat geval kan de rechtbank: b. de in [149]artikel 8:42, eerste lid, bedoelde termijn verkorten.')
                      , ('Article 8:52 par 2 sub c Awb', 'In dat geval kan de rechtbank: c. [150]artikel 8:43, tweede lid, geheel of gedeeltelijk buiten toepassing laten.')
                      , ('Article 8:52 par 2 sub d Awb', 'In dat geval kan de rechtbank: d. [151]artikel 8:47, derde lid, geheel of gedeeltelijk buiten toepassing laten.')
                      , ('Article 8:52 par 2 sub e Awb', 'In dat geval kan de rechtbank: e. de in [152]artikel 8:47, vijfde lid, bedoelde termijn verkorten.')
                      , ('Article 8:52 par 3 Awb', 'Indien de rechtbank bepaalt dat de zaak versneld wordt behandeld, bepaalt zij tevens zo spoedig mogelijk het tijdstip waarop de zitting zal plaatsvinden en doet zij daarvan onverwijld mededeling aan partijen. [153]Artikel 8:56 is niet van toepassing.')
                      , ('Article 8:53 Awb', 'Blijkt aan de rechtbank bij de behandeling dat de zaak niet voldoende spoedeisend is om een versnelde behandeling te rechtvaardigen of dat de zaak een gewone behandeling vordert, dan bepaalt zij dat de zaak verder op de gewone wijze wordt behandeld.')
                      , ('Article 8:54 par 1 sub a Awb', 'Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: a. zij kennelijk onbevoegd is.')
                      , ('Article 8:54 par 1 sub b Awb', 'Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: b. het beroep kennelijk niet-ontvankelijk is.')
                      , ('Article 8:54 par 1 sub c Awb', 'Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: c. het beroep kennelijk ongegrond is.')
                      , ('Article 8:54 par 1 sub d Awb', 'Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat: d. het beroep kennelijk gegrond is.')
                      , ('Article 8:54 par 2 Awb', 'In de uitspraak na toepassing van het eerste par worden partijen gewezen op [154]artikel 8:55, eerste lid.')
                      , ('Article 8:54a par 1 Awb', 'Totdat partijen zijn uitgenodigd om op een zitting van de rechtbank te verschijnen, kan de rechtbank het onderzoek sluiten, indien voortzetting van het onderzoek niet nodig is, omdat het bestuursorgaan kennelijk ten onrechte heeft ingestemd met rechtstreeks beroep bij de rechtbank.')
                      , ('Article 8:54a par 2 Awb', 'In dat geval strekt de uitspraak ertoe dat het bestuursorgaan het beroepschrift als bezwaarschrift behandelt. [155]Artikel 7:10 is van overeenkomstige toepassing.')
                      , ('Article 8:55 par 1 Awb', 'Tegen de uitspraak, bedoeld in [156]artikel 8:54, tweede lid, kunnen een belanghebbende en het bestuursorgaan verzet doen bij de rechtbank. De indiener van het verzetschrift kan daarbij vragen in de gelegenheid te worden gesteld over het verzet te worden gehoord. De [157]artikelen 6:4, derde lid, [158]6:5 tot en met 6:9, [159]6:11, [160]6:14, [161]6:15, [162]6:17 en [163]6:21 zijn van overeenkomstige toepassing.')
                      , ('Article 8:55 par 2 Awb', 'Indien bij wet de werking van een uitspraak wordt opgeschort totdat de termijn voor het instellen van hoger beroep is verstreken of, indien hoger beroep is ingesteld, op het hoger beroep is beslist, wordt de werking van de uitspraak, bedoeld in [164]artikel 8:54, tweede lid, op overeenkomstige wijze opgeschort.')
                      , ('Article 8:55 par 3 Awb', 'Alvorens uitspraak te doen op het verzet, stelt de rechtbank de indiener van het verzetschrift die daarom heeft gevraagd, in de gelegenheid op een zitting te worden gehoord, tenzij zij van oordeel is dat het verzet gegrond is. Indien de indiener van het verzetschrift daarom niet heeft gevraagd, kan de rechtbank hem in de gelegenheid stellen op een zitting te worden gehoord.')
                      , ('Article 8:55 par 4 Awb', 'Indien de uitspraak waartegen verzet is gedaan, is gedaan door een meervoudige kamer, wordt uitspraak op het verzet gedaan door een meervoudige kamer. Van de kamer die uitspraak doet op het verzet maakt geen deel uit degene die zitting heeft gehad in de kamer die de uitspraak heeft gedaan waartegen verzet is gedaan.')
                      , ('Article 8:55 par 5 sub a Awb', 'De uitspraak strekt tot: a. niet-ontvankelijkverklaring van het verzet.')
                      , ('Article 8:55 par 5 sub b Awb', 'De uitspraak strekt tot: b. ongegrondverklaring van het verzet.')
                      , ('Article 8:55 par 5 sub c Awb', 'De uitspraak strekt tot: c. gegrondverklaring van het verzet.')
                      , ('Article 8:55 par 6 Awb', 'Indien de rechtbank het verzet niet-ontvankelijk of ongegrond verklaart, blijft de uitspraak waartegen verzet was gedaan in stand.')
                      , ('Article 8:55 par 7 Awb', 'Indien de rechtbank het verzet gegrond verklaart, vervalt de uitspraak waartegen verzet was gedaan en wordt het onderzoek voortgezet in de stand waarin het zich bevond.')
                      , ('Article 8:56 Awb', 'Na afloop van het vooronderzoek worden partijen ten minste drie weken tevoren uitgenodigd om op een in de uitnodiging te vermelden plaats en tijdstip op een zitting van de rechtbank te verschijnen.')
                      , ('Article 8:57 Awb', 'Indien partijen daarvoor toestemming hebben gegeven, kan de rechtbank bepalen dat het onderzoek ter zitting achterwege blijft. In dat geval sluit de rechtbank het onderzoek.')
                      , ('Article 8:58 par 1 Awb', 'Tot tien dagen voor de zitting kunnen partijen nadere stukken indienen.')
                      , ('Article 8:58 par 2 Awb', 'Op deze bevoegdheid worden partijen in de uitnodiging, bedoeld in [165]artikel 8:56, gewezen.')
                      , ('Article 8:59 Awb', 'De rechtbank kan een partij oproepen om in persoon dan wel in persoon of bij gemachtigde te verschijnen, al dan niet voor het geven van inlichtingen.')
                      , ('Article 8:60 par 1 Awb', 'De rechtbank kan getuigen oproepen en deskundigen en tolken benoemen.')
                      , ('Article 8:60 par 2 Awb', 'De opgeroepen getuige en de deskundige of de tolk die zijn benoeming heeft aanvaard en door de rechtbank wordt opgeroepen, zijn verplicht aan de oproeping gevolg te geven. De artikelen 172 en 178 van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing. In de oproeping van de deskundige worden vermeld de opdracht die moet worden vervuld, de plaats en het tijdstip waarop de opdracht moet worden vervuld en de gevolgen die zijn verbonden aan het niet verschijnen.')
                      , ('Article 8:60 par 3 Awb', 'Namen en woonplaatsen van de opgeroepen getuigen en deskundigen en de feiten waarop het horen betrekking zal hebben onderscheidenlijk de opdracht die moet worden vervuld, worden bij de uitnodiging, bedoeld in [166]artikel 8:56, aan partijen zoveel mogelijk medegedeeld.')
                      , ('Article 8:60 par 4 Awb', 'Partijen kunnen getuigen en deskundigen meebrengen of bij aangetekende brief of deurwaardersexploit oproepen, mits daarvan uiterlijk een week voor de dag van de zitting aan de rechtbank en aan de andere partijen mededeling is gedaan, met vermelding van namen en woonplaatsen. Op deze bevoegdheid worden partijen in de uitnodiging, bedoeld in [167]artikel 8:56, gewezen.')
                      , ('Article 8:61 par 1 Awb', 'De voorzitter van de meervoudige kamer heeft de leiding van de zitting.')
                      , ('Article 8:61 par 2 Awb', 'De griffier houdt aantekening van het verhandelde ter zitting.')
                      , ('Article 8:61 par 3 Awb', 'De griffier maakt een proces-verbaal op van de zitting, indien de rechtbank dit ambtshalve of op verzoek van een partij die daarbij belang heeft, bepaalt en indien hoger beroep wordt ingesteld.')
                      , ('Article 8:61 par 4 Awb', 'Het bevat de namen van de rechter of de rechters die de zaak behandelt onderscheidenlijk behandelen, die van partijen en van hun vertegenwoordigers of gemachtigden die op de zitting zijn verschenen en van degenen die hen hebben bijgestaan, en die van de getuigen, deskundigen en tolken die op de zitting zijn verschenen.')
                      , ('Article 8:61 par 5 Awb', 'Het houdt een vermelding in van hetgeen op de zitting met betrekking tot de zaak is voorgevallen.')
                      , ('Article 8:61 par 6 Awb', 'Het wordt door de voorzitter van de meervoudige kamer en de griffier ondertekend. Bij verhindering van de voorzitter of de griffier wordt dit in het proces-verbaal vermeld.')
                      , ('Article 8:61 par 7 Awb', 'Aan het proces-verbaal kunnen overgelegde pleitnotities worden gehecht.')
                      , ('Article 8:61 par 8 Awb', 'De rechtbank kan bepalen dat de verklaring van een partij, getuige of deskundige geheel in het proces-verbaal zal worden opgenomen. In dat geval wordt de verklaring onverwijld op schrift gesteld en aan de partij, getuige of deskundige voorgelezen. Deze mag daarin wijzigingen aanbrengen, die op schrift worden gesteld en aan de partij, getuige of deskundige worden voorgelezen. De verklaring wordt door de partij, getuige of deskundige ondertekend. Heeft ondertekening niet plaats, dan wordt de reden daarvan in het proces-verbaal vermeld.')
                      , ('Article 8:62 par 1 Awb', 'De zitting is openbaar.')
                      , ('Article 8:62 par 2 sub a Awb', 'De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: a. in het belang van de openbare orde of de goede zeden.')
                      , ('Article 8:62 par 2 sub b Awb', 'De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: b. in het belang van de veiligheid van de Staat.')
                      , ('Article 8:62 par 2 sub c Awb', 'De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: c. indien de belangen van minderjarigen of de eerbiediging van de persoonlijke levenssfeer van partijen dit eisen.')
                      , ('Article 8:62 par 2 sub d Awb', 'De rechtbank kan bepalen dat het onderzoek ter zitting geheel of gedeeltelijk zal plaatshebben met gesloten deuren: d. indien openbaarheid het belang van een goede rechtspleging ernstig zou schaden.')
                      , ('Article 8:63 par 1 Awb', 'Op het horen van getuigen en deskundigen is artikel 179, tweede en derde lid, eerste volzin, van het Wetboek van Burgerlijke Rechtsvordering van overeenkomstige toepassing. Op het horen van getuigen is artikel 179, eerste lid, van het Wetboek van Burgerlijke Rechtsvordering van overeenkomstige toepassing.')
                      , ('Article 8:63 par 2 Awb', 'De rechtbank kan afzien van het horen van door een partij meegebrachte of opgeroepen getuigen en deskundigen indien zij van oordeel is dat dit redelijkerwijs niet kan bijdragen aan de beoordeling van de zaak.')
                      , ('Article 8:63 par 3 Awb', 'Indien een door een partij opgeroepen getuige of deskundige niet is verschenen, kan de rechtbank deze oproepen. In dat geval schorst de rechtbank het onderzoek ter zitting.')
                      , ('Article 8:64 par 1 Awb', 'De rechtbank kan het onderzoek ter zitting schorsen. Zij kan daarbij bepalen dat het vooronderzoek wordt hervat.')
                      , ('Article 8:64 par 2 Awb', 'Indien bij de schorsing geen tijdstip van de nadere zitting is bepaald, bepaalt de rechtbank dit zo spoedig mogelijk. De griffier doet zo spoedig mogelijk mededeling aan partijen van het tijdstip van de nadere zitting.')
                      , ('Article 8:64 par 3 Awb', 'In de gevallen waarin schorsing van het onderzoek ter zitting heeft plaatsgevonden, wordt de zaak op de nadere zitting hervat in de stand waarin zij zich bevond.')
                      , ('Article 8:64 par 4 Awb', 'De rechtbank kan bepalen dat het onderzoek ter zitting opnieuw wordt aangevangen.')
                      , ('Article 8:64 par 5 Awb', 'Indien partijen daarvoor toestemming hebben gegeven, kan de rechtbank bepalen dat de nadere zitting achterwege blijft. In dat geval sluit de rechtbank het onderzoek.')
                      , ('Article 8:65 par 1 Awb', 'De rechtbank sluit het onderzoek ter zitting, wanneer zij van oordeel is dat het is voltooid.')
                      , ('Article 8:65 par 2 Awb', 'Voordat het onderzoek ter zitting wordt gesloten, hebben partijen het recht voor het laatst het woord te voeren.')
                      , ('Article 8:65 par 3 Awb', 'Zodra het onderzoek ter zitting is gesloten, deelt de voorzitter mee wanneer uitspraak zal worden gedaan.')
                      , ('Article 8:66 par 1 Awb', 'Tenzij mondeling uitspraak wordt gedaan, doet de rechtbank binnen zes weken na de sluiting van het onderzoek schriftelijk uitspraak.')
                      , ('Article 8:66 par 2 Awb', 'In bijzondere omstandigheden kan de rechtbank deze termijn met ten hoogste zes weken verlengen.')
                      , ('Article 8:66 par 3 Awb', 'Van deze verlenging wordt aan partijen mededeling gedaan.')
                      , ('Article 8:67 par 1 Awb', 'De rechtbank kan na de sluiting van het onderzoek ter zitting onmiddellijk mondeling uitspraak doen. De uitspraak kan voor ten hoogste een week worden verdaagd onder aanzegging aan partijen van het tijdstip van de uitspraak.')
                      , ('Article 8:67 par 2 Awb', 'De mondelinge uitspraak bestaat uit de beslissing en de gronden van de beslissing.')
                      , ('Article 8:67 par 3 Awb', 'Van de mondelinge uitspraak wordt door de griffier een proces-verbaal opgemaakt.')
                      , ('Article 8:67 par 4 Awb', 'Het wordt door de voorzitter van de meervoudige kamer en de griffier ondertekend. Bij verhindering van de voorzitter of de griffier wordt dit in het proces-verbaal vermeld.')
                      , ('Article 8:67 par 5 Awb', 'De rechtbank spreekt de beslissing, bedoeld in het tweede lid, in het openbaar uit, in tegenwoordigheid van de griffier. Daarbij wordt vermeld door wie, binnen welke termijn en bij welke administratieve rechter welk rechtsmiddel kan worden aangewend.')
                      , ('Article 8:67 par 6 Awb', 'De mededeling, bedoeld in het vijfde lid, tweede volzin, wordt in het proces-verbaal vermeld.')
                      , ('Article 8:68 par 1 Awb', 'Indien de rechtbank van oordeel is dat het onderzoek niet volledig is geweest, kan zij het heropenen. De rechtbank bepaalt daarbij op welke wijze het onderzoek wordt voortgezet.')
                      , ('Article 8:68 par 2 Awb', 'De griffier doet zo spoedig mogelijk mededeling daarvan aan partijen.')
                      , ('Article 8:69 par 1 Awb', 'De rechtbank doet uitspraak op de grondslag van het beroepschrift, de overgelegde stukken, het verhandelde tijdens het vooronderzoek en het onderzoek ter zitting.')
                      , ('Article 8:69 par 2 Awb', 'De rechtbank vult ambtshalve de rechtsgronden aan.')
                      , ('Article 8:69 par 3 Awb', 'De rechtbank kan ambtshalve de feiten aanvullen.')
                      , ('Article 8:70 sub a Awb', 'De uitspraak strekt tot: a. onbevoegdverklaring van de rechtbank.')
                      , ('Article 8:70 sub b Awb', 'De uitspraak strekt tot: b. niet-ontvankelijkverklaring van het beroep.')
                      , ('Article 8:70 sub c Awb', 'De uitspraak strekt tot: c. ongegrondverklaring van het beroep.')
                      , ('Article 8:70 sub d Awb', 'De uitspraak strekt tot: d. gegrondverklaring van het beroep.')
                      , ('Article 8:71 Awb', 'Voor zover uitsluitend een vordering bij de burgerlijke rechter kan worden ingesteld, wordt dit in de uitspraak vermeld. De burgerlijke rechter is aan die beslissing gebonden.')
                      , ('Article 8:72 par 1 Awb', 'Indien de rechtbank het beroep gegrond verklaart, vernietigt zij het bestreden besluit geheel of gedeeltelijk.')
                      , ('Article 8:72 par 2 Awb', 'Vernietiging van een besluit of een gedeelte van een besluit brengt vernietiging van de rechtsgevolgen van dat besluit of van het vernietigde gedeelte daarvan mee.')
                      , ('Article 8:72 par 3 Awb', 'De rechtbank kan bepalen dat de rechtsgevolgen van het vernietigde besluit of het vernietigde gedeelte daarvan geheel of gedeeltelijk in stand blijven.')
                      , ('Article 8:72 par 4 Awb', 'Indien de rechtbank het beroep gegrond verklaart, kan zij het bestuursorgaan opdragen een nieuw besluit te nemen of een andere handeling te verrichten met inachtneming van haar uitspraak, dan wel kan zij bepalen dat haar uitspraak in de plaats treedt van het vernietigde besluit of het vernietigde gedeelte daarvan.')
                      , ('Article 8:72 par 5 Awb', 'De rechtbank kan het bestuursorgaan een termijn stellen voor het nemen van een nieuw besluit of het verrichten van een andere handeling, alsmede zo nodig een voorlopige voorziening treffen. In het laatste geval bepaalt de rechtbank het tijdstip waarop de voorlopige voorziening vervalt.')
                      , ('Article 8:72 par 6 Awb', 'De rechtbank kan bepalen dat een voorlopige voorziening vervalt op een later tijdstip dan het tijdstip waarop zij uitspraak heeft gedaan.')
                      , ('Article 8:72 par 7 Awb', 'De rechtbank kan bepalen dat, indien of zolang het bestuursorgaan niet voldoet aan een uitspraak, de door haar aangewezen rechtspersoon aan een door haar aangewezen partij een in de uitspraak vast te stellen dwangsom verbeurt. De artikelen 611a tot en met 611i van het Wetboek van Burgerlijke Rechtsvordering zijn van overeenkomstige toepassing.')
                      , ('Article 8:73 par 1 Awb', 'Indien de rechtbank het beroep gegrond verklaart, kan zij, indien daarvoor gronden zijn, op verzoek van een partij de door haar aangewezen rechtspersoon veroordelen tot vergoeding van de schade die die partij lijdt.')
                      , ('Article 8:73 par 2 Awb', 'Indien de rechtbank de omvang van de schadevergoeding bij haar uitspraak niet of niet volledig kan vaststellen, bepaalt zij in haar uitspraak dat ter voorbereiding van een nadere uitspraak daarover het onderzoek wordt heropend. De rechtbank bepaalt daarbij op welke wijze het onderzoek wordt voortgezet.')
                      , ('Article 8:73a par 1 Awb', 'Ingeval van intrekking van het beroep omdat het bestuursorgaan geheel of gedeeltelijk aan de indiener van het beroepschrift is tegemoetgekomen, kan de rechtbank, op verzoek van de indiener de door haar aangewezen rechtspersoon bij afzonderlijke uitspraak met toepassing van [168]artikel 8:73 veroordelen tot vergoeding van de schade die de verzoeker lijdt. Het verzoek wordt gedaan tegelijk met de intrekking van het beroep. Indien aan dit vereiste niet is voldaan, wordt het verzoek niet-ontvankelijk verklaard.')
                      , ('Article 8:73a par 2 Awb', 'De rechtbank stelt de verzoeker zo nodig in de gelegenheid het verzoek schriftelijk toe te lichten en stelt het bestuursorgaan in de gelegenheid een verweerschrift in te dienen. Zij stelt hiervoor termijnen vast. Indien het verzoek mondeling wordt gedaan, kan de rechtbank bepalen dat het toelichten van het verzoek en het voeren van verweer onmiddellijk mondeling geschieden.')
                      , ('Article 8:73a par 3 Awb', 'Indien het toelichten van het verzoek en het voeren van verweer mondeling zijn geschied, sluit de rechtbank het onderzoek. In de overige gevallen zijn de [169]afdelingen 8.2.4 en [170]8.2.5 van overeenkomstige toepassing.')
                      , ('Article 8:74 par 1 Awb', 'Indien de rechtbank het beroep gegrond verklaart, houdt de uitspraak tevens in dat aan de indiener van het beroepschrift het door hem betaalde griffierecht wordt vergoed door de door de rechtbank aangewezen rechtspersoon.')
                      , ('Article 8:74 par 2 Awb', 'In de overige gevallen kan de uitspraak inhouden dat het betaalde griffierecht door de door de rechtbank aangewezen rechtspersoon geheel of gedeeltelijk wordt vergoed.')
                      , ('Article 8:75 par 1 Awb', 'De rechtbank is bij uitsluiting bevoegd een partij te veroordelen in de kosten die een andere partij in verband met de behandeling van het beroep bij de rechtbank, en van het bezwaar of van het administratief beroep redelijkerwijs heeft moeten maken. De [171]artikelen 7:15, tweede tot en met vierde lid, en [172]7:28, tweede lid, eerste volzin, derde en vierde lid, zijn van toepassing. Een natuurlijke persoon kan slechts in de kosten worden veroordeeld in geval van kennelijk onredelijk gebruik van procesrecht. Bij algemene maatregel van bestuur worden nadere regels gesteld over de kosten waarop een veroordeling als bedoeld in de eerste volzin uitsluitend betrekking kan hebben en over de wijze waarop bij de uitspraak het bedrag van de kosten wordt vastgesteld.')
                      , ('Article 8:75 par 2 Awb', 'In geval van een veroordeling in de kosten ten behoeve van een partij aan wie ter zake van het beroep op de rechtbank, het bezwaar of het administratief beroep een toevoeging is verleend krachtens de Wet op de rechtsbijstand, wordt het bedrag van de kosten betaald aan de griffier. Artikel 243 van het Wetboek van Burgerlijke Rechtsvordering is van overeenkomstige toepassing.')
                      , ('Article 8:75 par 3 Awb', 'Indien een bestuursorgaan in de kosten wordt veroordeeld, wijst de rechtbank de rechtspersoon aan die de kosten moet vergoeden.')
                      , ('Article 8:75a par 1 Awb', 'In geval van intrekking van het beroep omdat het bestuursorgaan geheel of gedeeltelijk aan de indiener van het beroepschrift is tegemoetgekomen, kan het bestuursorgaan op verzoek van de indiener bij afzonderlijke uitspraak met toepassing van [173]artikel 8:75 in de kosten worden veroordeeld. Het verzoek wordt gedaan tegelijk met de intrekking van het beroep. Indien aan dit vereiste niet is voldaan, wordt het verzoek niet-ontvankelijk verklaard.')
                      , ('Article 8:75a par 2 Awb', '[174]Artikel 8:73a, tweede en derde lid, is van overeenkomstige toepassing.')
                      , ('Article 8:76 Awb', 'Voor zover een uitspraak strekt tot betaling van een bepaald geldbedrag kan zij ten uitvoer worden gelegd overeenkomstig de bepalingen van het Tweede Boek van het Wetboek van Burgerlijke Rechtsvordering.')
                      , ('Article 8:77 par 1 Awb', 'De schriftelijke uitspraak vermeldt: a. de namen van partijen en van hun vertegenwoordigers of gemachtigden, b. de gronden van de beslissing, c. de beslissing, d. de naam van de rechter of de namen van de rechters die de zaak heeft onderscheidenlijk hebben behandeld, e. de dag waarop de beslissing is uitgesproken, en f. door wie, binnen welke termijn en bij welke administratieve rechter welk rechtsmiddel kan worden aangewend.')
                      , ('Article 8:77 par 2 Awb', 'Indien de uitspraak strekt tot gegrondverklaring van het beroep, wordt in de uitspraak vermeld welke geschreven of ongeschreven rechtsregel of welk algemeen rechtsbeginsel geschonden wordt geoordeeld.')
                      , ('Article 8:77 par 3 Awb', 'De uitspraak wordt ondertekend door de voorzitter van de meervoudige kamer en de griffier. Bij verhindering van de voorzitter of de griffier wordt dit in de uitspraak vermeld.')
                      , ('Article 8:78 Awb', 'De rechtbank spreekt de beslissing, bedoeld in [175]artikel 8:77, eerste lid, onderdeel c, in het openbaar uit, in tegenwoordigheid van de griffier.')
                      , ('Article 8:79 par 1 Awb', 'Binnen twee weken na de dagtekening van de uitspraak zendt de griffier kosteloos een afschrift van de uitspraak of van het proces-verbaal van de mondelinge uitspraak aan partijen.')
                      , ('Article 8:79 par 2 Awb', 'Anderen dan partijen kunnen afschriften of uittreksels van de uitspraak of van het proces-verbaal van de mondelinge uitspraak verkrijgen. Met betrekking tot de kosten is het bij en krachtens de Wet tarieven in strafzaken bepaalde van overeenkomstige toepassing.')
                      , ('Article 8:80 Awb', 'Indien de rechtbank bepaalt dat haar uitspraak in de plaats treedt van het vernietigde besluit, wordt de uitspraak bovendien overeenkomstig de voor dat besluit voorgeschreven wijze bekendgemaakt door het bevoegde bestuursorgaan.')
                      , ('Article 8:81 par 1 Awb', 'Indien tegen een besluit bij de rechtbank beroep is ingesteld dan wel, voorafgaand aan een mogelijk beroep bij de rechtbank, bezwaar is gemaakt of administratief beroep is ingesteld, kan de voorzieningenrechter van de rechtbank die bevoegd is of kan worden in de hoofdzaak, op verzoek een voorlopige voorziening treffen indien onverwijlde spoed, gelet op de betrokken belangen, dat vereist.')
                      , ('Article 8:81 par 2 Awb', 'Indien bij de rechtbank beroep is ingesteld, kan een verzoek om voorlopige voorziening worden gedaan door een partij in de hoofdzaak.')
                      , ('Article 8:81 par 3 Awb', 'Indien voorafgaand aan een mogelijk beroep bij de rechtbank bezwaar is gemaakt of administratief beroep is ingesteld, kan een verzoek om voorlopige voorziening worden gedaan door de indiener van het bezwaarschrift, onderscheidenlijk door de indiener van het beroepschrift of door de belanghebbende die geen recht heeft tot het instellen van administratief beroep.')
                      , ('Article 8:81 par 4 Awb', 'De [176]artikelen 6:4, derde lid, [177]6:5, [178]6:6, [179]6:14, [180]6:15, [181]6:17 en [182]6:21 zijn van overeenkomstige toepassing. De indiener van het verzoekschrift die bezwaar heeft gemaakt dan wel beroep heeft ingesteld, legt daarbij een afschrift van het bezwaar- of beroepschrift over.')
                      , ('Article 8:81 par 5 Awb', 'Indien een verzoek om voorlopige voorziening is gedaan nadat bezwaar is gemaakt of administratief beroep is ingesteld en op dit bezwaar of beroep wordt beslist voordat de zitting heeft plaatsgevonden, wordt de verzoeker in de gelegenheid gesteld beroep bij de rechtbank in te stellen. Het verzoek om voorlopige voorziening wordt gelijkgesteld met een verzoek dat wordt gedaan hangende het beroep bij de rechtbank.')
                      , ('Article 8:82 par 1 Awb', 'Van de verzoeker wordt door de griffier een griffierecht geheven. [183]Artikel 8:41, eerste lid, tweede en derde volzin, derde en vijfde lid, is van overeenkomstige toepassing.')
                      , ('Article 8:82 par 2 Awb', '[184]Artikel 8:41, tweede lid, is van overeenkomstige toepassing, met dien verstande dat de termijn binnen welke de bijschrijving of storting van het verschuldigde bedrag dient plaats te vinden, twee weken bedraagt. De voorzieningenrechter kan een kortere termijn stellen.')
                      , ('Article 8:82 par 3 Awb', 'Indien een verzoek om opheffing of wijziging is gedaan door het bestuursorgaan of het beroepsorgaan en het verzoek geheel of gedeeltelijk wordt toegewezen, kan de uitspraak inhouden dat het betaalde griffierecht door de griffier aan de desbetreffende rechtspersoon wordt terugbetaald.')
                      , ('Article 8:82 par 4 Awb', 'De uitspraak kan inhouden dat het betaalde griffierecht door de door de voorzieningenrechter aangewezen rechtspersoon geheel of gedeeltelijk wordt vergoed.')
                      , ('Article 8:83 par 1 Awb', 'Partijen worden zo spoedig mogelijk uitgenodigd om op een in de uitnodiging te vermelden plaats en tijdstip op een zitting te verschijnen. Binnen een door de voorzieningenrechter te bepalen termijn zendt het bestuursorgaan de op de zaak betrekking hebbende stukken aan hem. [185]Artikel 8:58 is van overeenkomstige toepassing, met dien verstande dat tot één dag voor de zitting nadere stukken kunnen worden ingediend. De [186]artikelen 8:59 tot en met 8:65 zijn van overeenkomstige toepassing, met dien verstande dat getuigen en deskundigen kunnen worden meegebracht of opgeroepen zonder dat de in [187]artikel 8:60, vierde lid, eerste volzin, bedoelde mededeling is gedaan.')
                      , ('Article 8:83 par 2 Awb', 'Indien administratief beroep is ingesteld, wordt het beroepsorgaan eveneens uitgenodigd om op de zitting te verschijnen. Het beroepsorgaan wordt in de gelegenheid gesteld ter zitting een uiteenzetting over de zaak te geven.')
                      , ('Article 8:83 par 3 Awb', 'Indien de voorzieningenrechter kennelijk onbevoegd is of het verzoek kennelijk niet-ontvankelijk, kennelijk ongegrond of kennelijk gegrond is, kan de voorzieningenrechter uitspraak doen zonder toepassing van het eerste lid.')
                      , ('Article 8:83 par 4 Awb', 'Indien onverwijlde spoed dat vereist en partijen daardoor niet in hun belangen worden geschaad, kan de voorzieningenrechter ook in andere gevallen uitspraak doen zonder toepassing van het eerste lid.')
                      , ('Article 8:84 par 1 Awb', 'De voorzieningenrechter doet zo spoedig mogelijk schriftelijk of mondeling uitspraak.')
                      , ('Article 8:84 par 2 sub a Awb', 'De uitspraak strekt tot: a. onbevoegdverklaring van de voorzieningenrechter.')
                      , ('Article 8:84 par 2 sub b Awb', 'De uitspraak strekt tot: b. niet-ontvankelijkverklaring van het verzoek.')
                      , ('Article 8:84 par 2 sub c Awb', 'De uitspraak strekt tot: c. afwijzing van het verzoek.')
                      , ('Article 8:84 par 2 sub d Awb', 'De uitspraak strekt tot: d. gehele of gedeeltelijke toewijzing van het verzoek.')
                      , ('Article 8:84 par 3 Awb', 'De griffier zendt onverwijld een afschrift van de uitspraak of van het proces-verbaal van de mondelinge uitspraak kosteloos aan partijen.')
                      , ('Article 8:84 par 4 Awb', 'De [188]artikelen 8:67, tweede tot en met vijfde lid, [189]8:68, [190]8:69, [191]8:72, vijfde en zevende lid, [192]8:75, [193]8:75a, [194]8:76, [195]8:77, eerste en derde lid, [196]8:78, [197]8:79, tweede lid, en [198]8:80 zijn van overeenkomstige toepassing.')
                      , ('Article 8:85 par 1 Awb', 'De voorzieningenrechter kan in zijn uitspraak bepalen wanneer de voorlopige voorziening vervalt.')
                      , ('Article 8:85 par 2 sub a Awb', 'De voorlopige voorziening vervalt in ieder geval zodra: a. de termijn voor het instellen van beroep bij de rechtbank tegen het besluit dat op bezwaar of in administratief beroep is genomen, ongebruikt is verstreken.')
                      , ('Article 8:85 par 2 sub b Awb', 'De voorlopige voorziening vervalt in ieder geval zodra: b. het bezwaar of het beroep is ingetrokken.')
                      , ('Article 8:85 par 2 sub c Awb', 'De voorlopige voorziening vervalt in ieder geval zodra: c. de rechtbank uitspraak heeft gedaan, tenzij bij de uitspraak een later tijdstip is bepaald.')
                      , ('Article 8:86 par 1 Awb', 'Indien het verzoek wordt gedaan indien beroep bij de rechtbank is ingesteld en de voorzieningenrechter van oordeel is dat na de zitting, bedoeld in [199]artikel 8:83, eerste lid, nader onderzoek redelijkerwijs niet kan bijdragen aan de beoordeling van de zaak, kan hij onmiddellijk uitspraak doen in de hoofdzaak.')
                      , ('Article 8:86 par 2 Awb', 'Op deze bevoegdheid van de voorzieningenrechter worden partijen in de uitnodiging, bedoeld in [200]artikel 8:83, eerste lid, gewezen.')
                      , ('Article 8:87 par 1 Awb', 'De voorzieningenrechter kan, ook ambtshalve, een voorlopige voorziening opheffen of wijzigen.')
                      , ('Article 8:87 par 2 Awb', 'De [201]artikelen 8:81, tweede, derde en vierde lid, en [202]8:82 tot en met [203]8:86 zijn van overeenkomstige toepassing. Indien voorafgaand aan een mogelijk beroep bij de rechtbank bezwaar is gemaakt of administratief beroep is ingesteld, kan een verzoek om opheffing of wijziging eveneens worden gedaan door een belanghebbende die door de voorlopige voorziening rechtstreeks in zijn belang wordt getroffen, door het bestuursorgaan of door het beroepsorgaan.')
                      , ('Article 8:87 par 3 Awb', 'Indien een verzoek om opheffing of wijziging is gedaan door het bestuursorgaan of het beroepsorgaan en het verzoek geheel of gedeeltelijk wordt toegewezen, kan de uitspraak inhouden dat het betaalde griffierecht door de griffier aan de desbetreffende rechtspersoon wordt terugbetaald.')
                      , ('Article 8:88 par 1 Awb', 'De rechtbank kan op verzoek van een partij een onherroepelijk geworden uitspraak herzien op grond van feiten of omstandigheden die: a. hebben plaatsgevonden vóór de uitspraak, b. bij de indiener van het verzoekschrift vóór de uitspraak niet bekend waren en redelijkerwijs niet bekend konden zijn, en c. waren zij bij de rechtbank eerder bekend geweest, tot een andere uitspraak zouden hebben kunnen leiden.')
                      , ('Article 8:8 par 2 Awb', '[204]Hoofdstuk 6 en de titels 8.2 en 8.3 zijn voor zover nodig van overeenkomstige toepassing.')
                      , ('Article 9:1 par 1 Awb', 'Een ieder heeft het recht om over de wijze waarop een bestuursorgaan zich in een bepaalde aangelegenheid jegens hem of een ander heeft gedragen, een klacht in te dienen bij dat bestuursorgaan.')
                      , ('Article 9:1 par 2 Awb', 'Een gedraging van een persoon, werkzaam onder de verantwoordelijkheid van een bestuursorgaan, wordt aangemerkt als een gedraging van dat bestuursorgaan.')
                      , ('Article 9:2 Awb', 'Het bestuursorgaan draagt zorg voor een behoorlijke behandeling van mondelinge en schriftelijke klachten over zijn gedragingen en over gedragingen van bestuursorganen die onder zijn verantwoordelijkheid werkzaam zijn.')
                      , ('Article 9:3 Awb', 'Tegen een besluit inzake de behandeling van een klacht over een gedraging van een bestuursorgaan kan geen beroep worden ingesteld.')
                      , ('Article 9:4 par 1 Awb', 'Indien een schriftelijke klacht betrekking heeft op een gedraging jegens de klager en voldoet aan de vereisten van het tweede lid, zijn de [205]artikelen 9:5 tot en met 9:12 van toepassing.')
                      , ('Article 9:4 par 2 Awb', 'Het klaagschrift wordt ondertekend en bevat ten minste: a. de naam en het adres van de indiener; b. de dagtekening; c. een omschrijving van de gedraging waartegen de klacht is gericht.')
                      , ('Article 9:4 par 3 Awb', '[206]Artikel 6:5, derde lid, is van overeenkomstige toepassing.')
                      , ('Article 9:5 Awb', 'Zodra het bestuursorgaan naar tevredenheid van de klager aan diens klacht tegemoet is gekomen, vervalt de verplichting tot het verder toepassen van dit hoofdstuk.')
                      , ('Article 9:6 Awb', 'Het bestuursorgaan bevestigt de ontvangst van het klaagschrift schriftelijk.')
                      , ('Article 9:7 par 1 Awb', 'De behandeling van de klacht geschiedt door een persoon die niet bij de gedraging waarop de klacht betrekking heeft, betrokken is geweest.')
                      , ('Article 9:7 par 2 Awb', 'Het eerste par is niet van toepassing indien de klacht betrekking heeft op een gedraging van het bestuursorgaan zelf dan wel de voorzitter of een par ervan.')
                      , ('Article 9:8 par 1 sub a Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: a. waarover reeds eerder een klacht is ingediend die met inachtneming van de [207]artikelen 9:4 en volgende is behandeld.')
                      , ('Article 9:8 par 1 sub b Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: b. die langer dan een jaar voor indiening van de klacht heeft plaatsgevonden.')
                      , ('Article 9:8 par 1 sub c Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: c. waartegen door de klager bezwaar gemaakt had kunnen worden.')
                      , ('Article 9:8 par 1 sub d Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: d. waartegen door de klager beroep kan worden ingesteld, tenzij die gedraging bestaat uit het niet tijdig nemen van een besluit, of beroep kon worden ingesteld.')
                      , ('Article 9:8 par 1 sub e Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: e. die door het instellen van een procedure aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen is, dan wel onderworpen is geweest.')
                      , ('Article 9:8 par 1 sub f Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien zij betrekking heeft op een gedraging: f. zolang terzake daarvan een opsporingsonderzoek op bevel van de officier van justitie of een vervolging gaande is, dan wel indien de gedraging deel uitmaakt van de opsporing of vervolging van een strafbaar feit en terzake van dat feit een opsporingsonderzoek op bevel van de officier van justitie of een vervolging gaande is.')
                      , ('Article 9:8 par 2 Awb', 'Het bestuursorgaan is niet verplicht de klacht te behandelen indien het belang van de klager dan wel het gewicht van de gedraging kennelijk onvoldoende is.')
                      , ('Article 9:8 par 3 Awb', 'Van het niet in behandeling nemen van de klacht wordt de klager zo spoedig mogelijk doch uiterlijk binnen vier weken na ontvangst van het klaagschrift schriftelijk in kennis gesteld. [208]Artikel 9:12, tweede lid, is van overeenkomstige toepassing.')
                      , ('Article 9:9 Awb', 'Aan degene op wiens gedraging de klacht betrekking heeft, wordt een afschrift van het klaagschrift alsmede van de daarbij meegezonden stukken toegezonden.')
                      , ('Article 9:10 par 1 Awb', 'Het bestuursorgaan stelt de klager en degene op wiens gedraging de klacht betrekking heeft, in de gelegenheid te worden gehoord.')
                      , ('Article 9:10 par 2 Awb', 'Van het horen van de klager kan worden afgezien indien de klacht kennelijk ongegrond is dan wel indien de klager heeft verklaard geen gebruik te willen maken van het recht te worden gehoord.')
                      , ('Article 9:10 par 3 Awb', 'Van het horen wordt een verslag gemaakt.')
                      , ('Article 9:11 par 1 Awb', 'Het bestuursorgaan handelt de klacht af binnen zes weken of ? indien [209]afdeling 9.1.3 van toepassing is ? binnen tien weken na ontvangst van het klaagschrift.')
                      , ('Article 9:11 par 2 Awb', 'Het bestuursorgaan kan de afhandeling voor ten hoogste vier weken verdagen. Van de verdaging wordt schriftelijk mededeling gedaan aan de klager en aan degene op wiens gedraging de klacht betrekking heeft.')
                      , ('Article 9:12 par 1 Awb', 'Het bestuursorgaan stelt de klager schriftelijk en gemotiveerd in kennis van de bevindingen van het onderzoek naar de klacht, zijn oordeel daarover alsmede van de eventuele conclusies die het daaraan verbindt.')
                      , ('Article 9:12 par 2 Awb', 'Bij de kennisgeving wordt vermeld bij welke ombudsman en binnen welke termijn de klager vervolgens een verzoekschrift kan indienen.')
                      , ('Article 9:12a Awb', 'Het bestuursorgaan draagt zorg voor registratie van de bij hem ingediende schriftelijke klachten. De geregistreerde klachten worden jaarlijks gepubliceerd.')
                      , ('Article 9:13 Awb', 'De in deze afdeling geregelde procedure voor de behandeling van klachten wordt in aanvulling op [210]afdeling 9.1.2 gevolgd indien dat bij wettelijk voorschrift of bij besluit van het bestuursorgaan is bepaald.')
                      , ('Article 9:14 par 1 Awb', 'Bij wettelijk voorschrift of bij besluit van het bestuursorgaan wordt een persoon of commissie belast met de behandeling van en de advisering over klachten.')
                      , ('Article 9:14 par 2 Awb', 'Het bestuursorgaan kan de persoon of commissie slechts in het algemeen instructies geven.')
                      , ('Article 9:15 par 1 Awb', 'Bij het bericht van ontvangst, bedoeld in [211]artikel 9:6, wordt vermeld dat een persoon of commissie over de klacht zal adviseren.')
                      , ('Article 9:15 par 2 Awb', 'Het horen geschiedt door de in [212]artikel 9:14 bedoelde persoon of commissie. Indien een commissie is ingesteld, kan deze het horen opdragen aan de voorzitter of een par van de commissie.')
                      , ('Article 9:15 par 3 Awb', 'De persoon of commissie beslist over de toepassing van [213]artikel 9:10, tweede lid.')
                      , ('Article 9:15 par 4 Awb', 'De persoon of commissie zendt een rapport van bevindingen, vergezeld van het advies en eventuele aanbevelingen, aan het bestuursorgaan. Het rapport bevat het verslag van het horen.')
                      , ('Article 9:16 Awb', 'Indien de conclusies van het bestuursorgaan afwijken van het advies, wordt in de conclusies de reden voor die afwijking vermeld en wordt het advies meegezonden met de kennisgeving, bedoeld in [214]artikel 9:12.')
                      , ('Article 9:17 sub a Awb', 'Onder ombudsman wordt verstaan: a. de Nationale ombudsman.')
                      , ('Article 9:17 sub b Awb', 'Onder ombudsman wordt verstaan: b. een ombudsman of ombudscommissie ingesteld krachtens de Gemeentewet, de Provinciewet, de Waterschapswet of de Wet gemeenschappelijke regelingen.')
                      , ('Article 9:18 par 1 Awb', 'Een ieder heeft het recht de ombudsman schriftelijk te verzoeken een onderzoek in te stellen naar de wijze waarop een bestuursorgaan zich in een bepaalde aangelegenheid jegens hem of een ander heeft gedragen.')
                      , ('Article 9:18 par 2 Awb', 'Indien het verzoekschrift bij een onbevoegde ombudsman wordt ingediend, wordt het, nadat daarop de datum van ontvangst is aangetekend, zo spoedig mogelijk doorgezonden aan de bevoegde ombudsman, onder gelijktijdige mededeling hiervan aan de verzoeker.')
                      , ('Article 9:18 par 3 Awb', 'De ombudsman is verplicht aan een verzoek als bedoeld in het eerste par gevolg te geven, tenzij [215]artikel 9:22, [216]9:23 of [217]9:24 van toepassing is.')
                      , ('Article 9:19 par 1 Awb', 'Indien naar het oordeel van de ombudsman ten aanzien van de in het verzoekschrift bedoelde gedraging voor de verzoeker de mogelijkheid van bezwaar, beroep of beklag openstaat, wijst hij de verzoeker zo spoedig mogelijk op deze mogelijkheid en draagt hij het verzoekschrift, nadat daarop de datum van ontvangst is aangetekend, aan de bevoegde instantie over, tenzij de verzoeker kenbaar heeft gemaakt dat het verzoekschrift aan hem moet worden teruggezonden.')
                      , ('Article 9:19 par 2 Awb', '[218]Artikel 6:15, derde lid, is van overeenkomstige toepassing.')
                      , ('Article 9:20 par 1 Awb', 'Alvorens het verzoek aan een ombudsman te doen, dient de verzoeker over de gedraging een klacht in bij het betrokken bestuursorgaan, tenzij dit redelijkerwijs niet van hem kan worden gevergd.')
                      , ('Article 9:20 par 2 Awb', 'Het eerste par geldt niet indien het verzoek betrekking heeft op de wijze van klachtbehandeling door het betrokken bestuursorgaan.')
                      , ('Article 9:21 Awb', 'Op het verkeer met de ombudsman is [219]hoofdstuk 2 van overeenkomstige toepassing, met uitzondering van [220]artikel 2:3, eerste lid.')
                      , ('Article 9:22 sub a Awb', 'De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: a. een aangelegenheid die behoort tot het algemeen regeringsbeleid, daaronder begrepen het algemeen beleid ter handhaving van de rechtsorde, of tot het algemeen beleid van het betrokken bestuursorgaan.')
                      , ('Article 9:22 sub b Awb', 'De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: b. een algemeen verbindend voorschrift.')
                      , ('Article 9:22 sub c Awb', 'De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: c. een gedraging waartegen beklag kan worden gedaan of beroep kan worden ingesteld, tenzij die gedraging bestaat uit het niet tijdig nemen van een besluit, of waartegen een beklag- of beroepsprocedure aanhangig is.')
                      , ('Article 9:22 sub d Awb', 'De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: d. een gedraging ten aanzien waarvan door een administratieve rechter uitspraak is gedaan.')
                      , ('Article 9:22 sub e Awb', 'De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: e. een gedraging ten aanzien waarvan een procedure bij een andere rechterlijke instantie dan een administratieve rechter aanhangig is, dan wel beroep openstaat tegen een uitspraak die in een zodanige procedure is gedaan.')
                      , ('Article 9:22 sub f Awb', 'De ombudsman is niet bevoegd een onderzoek in te stellen of voort te zetten indien het verzoek betrekking heeft op: f. een gedraging waarop de rechterlijke macht toeziet.')
                      , ('Article 9:23 sub a Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: a. het verzoekschrift niet voldoet aan de vereisten, bedoeld in [221]artikel 9:28, eerste en tweede lid.')
                      , ('Article 9:23 sub b Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: b. het verzoek kennelijk ongegrond is.')
                      , ('Article 9:23 sub c Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: c. het belang van de verzoeker bij een onderzoek door de ombudsman dan wel het gewicht van de gedraging kennelijk onvoldoende is.')
                      , ('Article 9:23 sub d Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: d. de verzoeker een ander is dan degene jegens wie de gedraging heeft plaatsgevonden.')
                      , ('Article 9:23 sub e Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: e. het verzoek betrekking heeft op een gedraging waartegen bezwaar kan worden gemaakt, tenzij die gedraging bestaat uit het niet tijdig nemen van een besluit, of waartegen een bezwaarprocedure aanhangig is.')
                      , ('Article 9:23 sub f Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: f. het verzoek betrekking heeft op een gedraging waartegen door de verzoeker bezwaar had kunnen worden gemaakt, beroep had kunnen worden ingesteld of beklag had kunnen worden gedaan.')
                      , ('Article 9:23 sub g Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: g. het verzoek betrekking heeft op een gedraging ten aanzien waarvan door een andere rechterlijke instantie dan een administratieve rechter uitspraak is gedaan.')
                      , ('Article 9:23 sub h Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: h. niet is voldaan aan het vereiste van [222]artikel 9:20, eerste lid.')
                      , ('Article 9:23 sub i Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: i. een verzoek, dezelfde gedraging betreffende, bij hem in behandeling is of ? behoudens indien een nieuw feit of een nieuwe omstandigheid bekend is geworden en zulks tot een ander oordeel over de bedoelde gedraging zou hebben kunnen leiden ? door hem is afgedaan.')
                      , ('Article 9:23 sub j Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: j. ten aanzien van een gedraging van het bestuursorgaan die nauw samenhangt met het onderwerp van het verzoekschrift een procedure aanhangig is bij een rechterlijke instantie, dan wel ingevolge bezwaar, administratief beroep of beklag bij een andere instantie.')
                      , ('Article 9:23 sub k Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: k. het verzoek betrekking heeft op een gedraging die nauw samenhangt met een onderwerp, dat door het instellen van een procedure aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen is.')
                      , ('Article 9:23 sub l Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: l. na tussenkomst van de ombudsman naar diens oordeel alsnog naar behoren aan de grieven van de verzoeker tegemoet is gekomen.')
                      , ('Article 9:23 sub m Awb', 'De ombudsman is niet verplicht een onderzoek in te stellen of voort te zetten indien: m. het verzoek, dezelfde gedraging betreffende, ingevolge een wettelijk geregelde klachtvoorziening bij een onafhankelijke klachtinstantie niet zijnde een ombudsman in behandeling is of daardoor is afgedaan.')
                      , ('Article 9:24 par 1 sub a Awb', 'Voorts is de ombudsman niet verplicht een onderzoek in te stellen of voort te zetten, indien het verzoek wordt ingediend later dan een jaar: a. na de kennisgeving door het bestuursorgaan van de bevindingen van het onderzoek.')
                      , ('Article 9:24 par 1 sub b Awb', 'Voorts is de ombudsman niet verplicht een onderzoek in te stellen of voort te zetten, indien het verzoek wordt ingediend later dan een jaar: b. nadat de klachtbehandeling door het bestuursorgaan op andere wijze is geëindigd, dan wel ingevolge [223]artikel 9:11 beëindigd had moeten zijn.')
                      , ('Article 9:24 par 2 sub a Awb', 'In afwijking van het eerste par eindigt de termijn een jaar nadat de gedraging heeft plaatsgevonden, indien redelijkerwijs niet van verzoeker kan worden gevergd dat hij eerst een klacht bij het bestuursorgaan indient. Is de gedraging binnen een jaar nadat zij plaatsvond, aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen, of is daartegen bezwaar gemaakt, administratief beroep ingesteld dan wel beklag gedaan, dan eindigt de termijn een jaar na de datum waarop: a. in die procedure een uitspraak is gedaan waartegen geen beroep meer openstaat.')
                      , ('Article 9:24 par 2 sub b Awb', 'In afwijking van het eerste par eindigt de termijn een jaar nadat de gedraging heeft plaatsgevonden, indien redelijkerwijs niet van verzoeker kan worden gevergd dat hij eerst een klacht bij het bestuursorgaan indient. Is de gedraging binnen een jaar nadat zij plaatsvond, aan het oordeel van een andere rechterlijke instantie dan een administratieve rechter onderworpen, of is daartegen bezwaar gemaakt, administratief beroep ingesteld dan wel beklag gedaan, dan eindigt de termijn een jaar na de datum waarop: b. de procedure op een andere wijze is geëindigd.')
                      , ('Article 9:25 par 1 Awb', 'Indien de ombudsman op grond van [224]artikel 9:22, [225]9:23 of [226]9:24 geen onderzoek instelt of dit niet voortzet, deelt hij dit onder vermelding van de redenen zo spoedig mogelijk schriftelijk aan de verzoeker mede.')
                      , ('Article 9:25 par 2 Awb', 'In het geval dat hij een onderzoek niet voortzet, doet hij de in het eerste par bedoelde mededeling tevens aan het bestuursorgaan en, in voorkomend geval, aan degene op wiens gedraging het onderzoek betrekking heeft.')
                      , ('Article 9:26 Awb', 'Tenzij [227]artikel 9:22 van toepassing is, is de ombudsman bevoegd uit eigen beweging een onderzoek in te stellen naar de wijze waarop een bestuursorgaan zich in een bepaalde aangelegenheid heeft gedragen.')
                      , ('Article 9:27 par 1 Awb', 'De ombudsman beoordeelt of het bestuursorgaan zich in de door hem onderzochte aangelegenheid al dan niet behoorlijk heeft gedragen.')
                      , ('Article 9:27 par 2 Awb', 'Indien ten aanzien van de gedraging waarop het onderzoek van de ombudsman betrekking heeft door een rechterlijke instantie uitspraak is gedaan, neemt de ombudsman de rechtsgronden in acht waarop die uitspraak steunt of mede steunt.')
                      , ('Article 9:27 par 3 Awb', 'De ombudsman kan naar aanleiding van het door hem verrichte onderzoek aan het bestuursorgaan aanbevelingen doen.')
                      , ('Article 9:28 par 1 Awb', 'Het verzoekschrift wordt ondertekend en bevat ten minste: a. de naam en het adres van de verzoeker; b. de dagtekening; c. een omschrijving van de gedraging waartegen het verzoek is gericht, een aanduiding van degene die zich aldus heeft gedragen en een aanduiding van degene jegens wie de gedraging heeft plaatsgevonden, indien deze niet de verzoeker is; d. de gronden van het verzoek; e. de wijze waarop een klacht bij het bestuursorgaan is ingediend, en zo mogelijk de bevindingen van het onderzoek naar de klacht door het bestuursorgaan, zijn oordeel daarover alsmede de eventuele conclusies die het bestuursorgaan hieraan verbonden heeft.')
                      , ('Article 9:28 par 2 Awb', 'Indien het verzoekschrift in een vreemde taal is gesteld en een vertaling voor een goede behandeling van het verzoek noodzakelijk is, draagt de verzoeker zorg voor een vertaling.')
                      , ('Article 9:28 par 3 Awb', 'Indien niet is voldaan aan de in dit artikel gestelde vereisten of indien het verzoekschrift geheel of gedeeltelijk is geweigerd op grond van [228]artikel 2:15, stelt de ombudsman de verzoeker in de gelegenheid het verzuim binnen een door hem daartoe gestelde termijn te herstellen.')
                      , ('Article 9:29 Awb', 'Aan de behandeling van het verzoek wordt niet meegewerkt door een persoon die betrokken is geweest bij de gedraging waarop het verzoek betrekking heeft.')
                      , ('Article 9:30 par 1 Awb', 'De ombudsman stelt het bestuursorgaan, degene op wiens gedraging het verzoek betrekking heeft, en de verzoeker in de gelegenheid hun standpunt toe te lichten.')
                      , ('Article 9:30 par 2 Awb', 'De ombudsman beslist of de toelichting schriftelijk of mondeling en al dan niet in elkaars tegenwoordigheid wordt gegeven.')
                      , ('Article 9:31 par 1 Awb', 'Het bestuursorgaan, onder zijn verantwoordelijkheid werkzame personen ? ook na het beëindigen van de werkzaamheden ?, getuigen alsmede de verzoeker verstrekken de ombudsman de benodigde inlichtingen en verschijnen op een daartoe strekkende uitnodiging voor hem. Gelijke verplichtingen rusten op ieder college, met dien verstande dat het college bepaalt wie van zijn leden aan de verplichtingen zal voldoen, tenzij de ombudsman één of meer bepaalde leden aanwijst. De ombudsman kan betrokkenen die zijn opgeroepen gelasten om in persoon te verschijnen.')
                      , ('Article 9:31 par 2 Awb', 'Inlichtingen die betrekking hebben op het beleid, gevoerd onder de verantwoordelijkheid van een minister of een ander bestuursorgaan, kan de ombudsman bij de daarbij betrokken personen en colleges slechts inwinnen door tussenkomst van de minister onderscheidenlijk dat bestuursorgaan. Het orgaan door tussenkomst waarvan de inlichtingen worden ingewonnen, kan zich bij het horen van de ambtenaren doen vertegenwoordigen.')
                      , ('Article 9:31 par 3 Awb', 'Binnen een door de ombudsman te bepalen termijn worden ten behoeve van een onderzoek de onder het bestuursorgaan, degene op wiens gedraging het verzoek betrekking heeft, en bij anderen berustende stukken aan hem overgelegd nadat hij hierom schriftelijk heeft verzocht.')
                      , ('Article 9:31 par 4 Awb', 'De ingevolge het eerste par opgeroepen personen onderscheidenlijk degenen die ingevolge het derde par verplicht zijn stukken over te leggen kunnen, indien daarvoor gewichtige redenen zijn, het geven van inlichtingen onderscheidenlijk het overleggen van stukken weigeren of de ombudsman mededelen dat uitsluitend hij kennis zal mogen nemen van de inlichtingen onderscheidenlijk de stukken.')
                      , ('Article 9:31 par 5 Awb', 'De ombudsman beslist of de in het vierde par bedoelde weigering onderscheidenlijk de beperking van de kennisneming gerechtvaardigd is.')
                      , ('Article 9:31 par 6 Awb', 'Indien de ombudsman heeft beslist dat de weigering gerechtvaardigd is, vervalt de verplichting.')
                      , ('Article 9:32 par 1 Awb', 'De ombudsman kan ten dienste van het onderzoek deskundigen werkzaamheden opdragen. Hij kan voorts in het belang van het onderzoek deskundigen en tolken oproepen.')
                      , ('Article 9:32 par 2 Awb', 'Door de ombudsman opgeroepen deskundigen of tolken verschijnen voor hem, en verlenen onpartijdig en naar beste weten hun diensten als zodanig. Op deskundigen, tevens ambtenaren, is [229]artikel 9:31, tweede tot en met zesde lid, van overeenkomstige toepassing.')
                      , ('Article 9:32 par 3 Awb', 'De ombudsman kan bepalen dat getuigen niet zullen worden gehoord en tolken niet tot de uitoefening van hun taak zullen worden toegelaten dan na het afleggen van de eed of de belofte. Getuigen leggen in dat geval de eed of de belofte af dat zij de gehele waarheid en niets dan de waarheid zullen zeggen en tolken dat zij hun plichten als tolk met nauwgezetheid zullen vervullen.')
                      , ('Article 9:33 par 1 Awb', 'Aan de door de ombudsman opgeroepen verzoekers, getuigen, deskundigen en tolken wordt een vergoeding toegekend. Deze vergoeding vindt plaats ten laste van de rechtspersoon waartoe het bestuursorgaan behoort op wiens gedraging het verzoek betrekking heeft, indien het een gemeente, provincie, waterschap of gemeenschappelijke regeling betreft. In overige gevallen vindt de vergoeding plaats ten laste van het Rijk. Het bij en krachtens de Wet tarieven in strafzaken bepaalde is van overeenkomstige toepassing.')
                      , ('Article 9:33 par 2 Awb', 'De in het eerste par bedoelde personen die in openbare dienst zijn, ontvangen geen vergoeding indien zij zijn opgeroepen in verband met hun taak als zodanig.')
                      , ('Article 9:34 par 1 Awb', 'De ombudsman kan een onderzoek ter plaatse instellen. Hij heeft daarbij toegang tot elke plaats, met uitzondering van een woning zonder toestemming van de bewoner, voor zover dat redelijkerwijs voor de vervulling van zijn taak nodig is.')
                      , ('Article 9:34 par 2 Awb', 'Bestuursorganen verlenen de medewerking die in het belang van het onderzoek, bedoeld in het eerste lid, is vereist.')
                      , ('Article 9:34 par 3 Awb', 'Van het onderzoek wordt een proces-verbaal gemaakt.')
                      , ('Article 9:35 par 1 Awb', 'De ombudsman deelt, alvorens het onderzoek te beëindigen, zijn bevindingen schriftelijk mee aan: a. het betrokken bestuursorgaan; b. degene op wiens gedraging het verzoek betrekking heeft; c. de verzoeker.')
                      , ('Article 9:35 par 2 Awb', 'De ombudsman geeft hun de gelegenheid zich binnen een door hem te stellen termijn omtrent de bevindingen te uiten.')
                      , ('Article 9:36 par 1 Awb', 'Wanneer een onderzoek is afgesloten, stelt de ombudsman een rapport op, waarin hij zijn bevindingen en zijn oordeel weergeeft. Hij neemt daarbij artikel 10 van de Wet openbaarheid van bestuur in acht.')
                      , ('Article 9:36 par 2 Awb', 'Indien naar het oordeel van de ombudsman de gedraging niet behoorlijk is, vermeldt hij in het rapport welk vereiste van behoorlijkheid geschonden is.')
                      , ('Article 9:36 par 3 Awb', 'De ombudsman zendt zijn rapport aan het betrokken bestuursorgaan, alsmede aan de verzoeker en aan degene op wiens gedraging het verzoek betrekking heeft.')
                      , ('Article 9:36 par 4 Awb', 'Indien de ombudsman aan het bestuursorgaan een aanbeveling doet als bedoeld in [230]artikel 9:27, derde lid, deelt het bestuursorgaan binnen een redelijke termijn aan de ombudsman mee op welke wijze aan de aanbeveling gevolg zal worden gegeven. Indien het bestuursorgaan overweegt de aanbeveling niet op te volgen, deelt het dat met redenen omkleed aan de ombudsman mee.')
                      , ('Article 9:36 par 5 Awb', 'De ombudsman geeft aan een ieder die daarom verzoekt, afschrift of uittreksel van een rapport als bedoeld in het eerste lid. Met betrekking tot de daarvoor in rekening te brengen vergoedingen en met betrekking tot kosteloze verstrekking is het bepaalde bij en krachtens de Wet tarieven in burgerlijke zaken van overeenkomstige toepassing. Tevens legt hij een zodanig rapport ter inzage op een door hem aan te wijzen plaats.')
                      , ('Article 10:1 Awb', 'Onder mandaat wordt verstaan: de bevoegdheid om in naam van een bestuursorgaan besluiten te nemen.')
                      , ('Article 10:2 Awb', 'Een door de gemandateerde binnen de grenzen van zijn bevoegdheid genomen besluit geldt als een besluit van de mandaatgever.')
                      , ('Article 10:3 par 1 Awb', 'Een bestuursorgaan kan mandaat verlenen, tenzij bij wettelijk voorschrift anders is bepaald of de aard van de bevoegdheid zich tegen de mandaatverlening verzet.')
                      , ('Article 10:3 par 2 sub a Awb', 'Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: a. tot het vaststellen van algemeen verbindende voorschriften, tenzij bij de verlening van die bevoegdheid in mandaatverlening is voorzien.')
                      , ('Article 10:3 par 2 sub b Awb', 'Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: b. tot het nemen van een besluit ten aanzien waarvan is bepaald dat het met versterkte meerderheid moet worden genomen of waarvan de aard van de voorgeschreven besluitvormingsprocedure zich anderszins tegen de mandaatverlening verzet.')
                      , ('Article 10:3 par 2 sub c Awb', 'Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: c. tot het beslissen op een beroepschrift.')
                      , ('Article 10:3 par 2 sub d Awb', 'Mandaat wordt in ieder geval niet verleend indien het betreft een bevoegdheid: d. tot het vernietigen van of tot het onthouden van goedkeuring aan een besluit van een ander bestuursorgaan.')
                      , ('Article 10:3 par 3 Awb', 'Mandaat tot het beslissen op een bezwaarschrift of op een verzoek als bedoeld in [231]artikel 7:1a, eerste lid, wordt niet verleend aan degene die het besluit waartegen het bezwaar zich richt, krachtens mandaat heeft genomen.')
                      , ('Article 10:4 par 1 Awb', 'Indien de gemandateerde niet werkzaam is onder verantwoordelijkheid van de mandaatgever, behoeft de mandaatverlening de instemming van de gemandateerde en in het voorkomende geval van degene onder wiens verantwoordelijkheid hij werkt.')
                      , ('Article 10:4 par 2 Awb', 'Het eerste par is niet van toepassing indien bij wettelijk voorschrift in de bevoegdheid tot de mandaatverlening is voorzien.')
                      , ('Article 10:5 par 1 Awb', 'Een bestuursorgaan kan hetzij een algemeen mandaat hetzij een mandaat voor een bepaald geval verlenen.')
                      , ('Article 10:5 par 2 Awb', 'Een algemeen mandaat wordt schriftelijk verleend. Een mandaat voor een bepaald geval wordt in ieder geval schriftelijk verleend indien de gemandateerde niet werkzaam is onder verantwoordelijkheid van de mandaatgever.')
                      , ('Article 10:6 par 1 Awb', 'De mandaatgever kan de gemandateerde per geval of in het algemeen instructies geven ter zake van de uitoefening van de gemandateerde bevoegdheid.')
                      , ('Article 10:6 par 2 Awb', 'De gemandateerde verschaft de mandaatgever op diens verzoek inlichtingen over de uitoefening van de bevoegdheid.')
                      , ('Article 10:7 Awb', 'De mandaatgever blijft bevoegd de gemandateerde bevoegdheid uit te oefenen.')
                      , ('Article 10:8 par 1 Awb', 'De mandaatgever kan het mandaat te allen tijde intrekken.')
                      , ('Article 10:8 par 2 Awb', 'Een algemeen mandaat wordt schriftelijk ingetrokken.')
                      , ('Article 10:9 par 1 Awb', 'De mandaatgever kan toestaan dat ondermandaat wordt verleend.')
                      , ('Article 10:9 par 2 Awb', 'Op ondermandaat zijn de overige artikelen van deze afdeling van overeenkomstige toepassing.')
                      , ('Article 10:10 Awb', 'Een krachtens mandaat genomen besluit vermeldt namens welk bestuursorgaan het besluit is genomen.')
                      , ('Article 10:11 par 1 Awb', 'Een bestuursorgaan kan bepalen dat door hem genomen besluiten namens hem kunnen worden ondertekend, tenzij bij wettelijk voorschrift anders is bepaald of de aard van de bevoegdheid zich hiertegen verzet.')
                      , ('Article 10:11 par 2 Awb', 'In dat geval moet uit het besluit blijken, dat het door het bestuursorgaan zelf is genomen.')
                      , ('Article 10:12 Awb', 'Deze afdeling is van overeenkomstige toepassing indien een bestuursorgaan aan een ander, werkzaam onder zijn verantwoordelijkheid, volmacht verleent tot het verrichten van privaatrechtelijke rechtshandelingen, of machtiging verleent tot het verrichten van handelingen die noch een besluit, noch een privaatrechtelijke rechtshandeling zijn.')
                      , ('Article 10:13 Awb', 'Onder delegatie wordt verstaan: het overdragen door een bestuursorgaan van zijn bevoegdheid tot het nemen van besluiten aan een ander die deze onder eigen verantwoordelijkheid uitoefent.')
                      , ('Article 10:14 Awb', 'Delegatie geschiedt niet aan ondergeschikten.')
                      , ('Article 10:15 Awb', 'Delegatie geschiedt slechts indien in de bevoegdheid daartoe bij wettelijk voorschrift is voorzien.')
                      , ('Article 10:16 par 1 Awb', 'Het bestuursorgaan kan ter zake van de uitoefening van de gedelegeerde bevoegdheid uitsluitend beleidsregels geven.')
                      , ('Article 10:16 par 2 Awb', 'Degene aan wie de bevoegdheid is gedelegeerd, verschaft het bestuursorgaan op diens verzoek inlichtingen over de uitoefening van de bevoegdheid.')
                      , ('Article 10:17 Awb', 'Het bestuursorgaan kan de gedelegeerde bevoegdheid niet meer zelf uitoefenen.')
                      , ('Article 10:18 Awb', 'Het bestuursorgaan kan het delegatiebesluit te allen tijde intrekken.')
                      , ('Article 10:19 Awb', 'Een besluit dat op grond van een gedelegeerde bevoegdheid wordt genomen, vermeldt het delegatiebesluit en de vindplaats daarvan.')
                      , ('Article 10:20 par 1 Awb', 'Op de overdracht door een bestuursorgaan van een bevoegdheid van een ander bestuursorgaan tot het nemen van besluiten aan een derde is deze afdeling, met uitzondering van artikel 10:16, van overeenkomstige toepassing.')
                      , ('Article 10:20 par 2 Awb', 'Bij wettelijk voorschrift of bij het besluit tot overdracht kan worden bepaald dat het bestuursorgaan wiens bevoegdheid is overgedragen beleidsregels over de uitoefening van die bevoegdheid kan geven.')
                      , ('Article 10:20 par 3 Awb', 'Degene aan wie de bevoegdheid is overgedragen, verschaft het overdragende en het oorspronkelijk bevoegde bestuursorgaan op hun verzoek inlichtingen over de uitoefening van de bevoegdheid.')
                      , ('Article 10:25 Awb', 'In deze wet wordt verstaan onder goedkeuring: de voor de inwerkingtreding van een besluit van een bestuursorgaan vereiste toestemming van een ander bestuursorgaan.')
                      , ('Article 10:26 Awb', 'Besluiten kunnen slechts aan goedkeuring worden onderworpen in bij of krachtens de wet bepaalde gevallen.')
                      , ('Article 10:27 Awb', 'De goedkeuring kan slechts worden onthouden wegens strijd met het recht of op een grond, neergelegd in de wet waarin of krachtens welke de goedkeuring is voorgeschreven.')
                      , ('Article 10:28 Awb', 'Aan een besluit waarover een rechter uitspraak heeft gedaan of waarbij een in kracht van gewijsde gegane uitspraak van de rechter wordt uitgevoerd, kan geen goedkeuring worden onthouden op rechtsgronden welke in strijd zijn met die waarop de uitspraak steunt of mede steunt.')
                      , ('Article 10:29 par 1 Awb', 'Een besluit kan alleen dan gedeeltelijk worden goedgekeurd, indien gedeeltelijke inwerkingtreding strookt met aard en inhoud van het besluit.')
                      , ('Article 10:29 par 2 Awb', 'De goedkeuring kan noch voor bepaalde tijd of onder voorwaarden worden verleend, noch worden ingetrokken.')
                      , ('Article 10:30 par 1 Awb', 'Gedeeltelijke goedkeuring of onthouding van goedkeuring vindt niet plaats dan nadat aan het bestuursorgaan dat het besluit heeft genomen, gelegenheid tot overleg is geboden.')
                      , ('Article 10:30 par 2 Awb', 'De motivering van het goedkeuringsbesluit verwijst naar hetgeen in het overleg aan de orde is gekomen.')
                      , ('Article 10:31 par 1 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald, wordt het besluit omtrent goedkeuring binnen dertien weken na de verzending ter goedkeuring bekend gemaakt aan het bestuursorgaan dat het aan goedkeuring onderworpen besluit heeft genomen.')
                      , ('Article 10:31 par 2 Awb', 'Het nemen van het besluit omtrent goedkeuring kan eenmaal voor ten hoogste dertien weken worden verdaagd.')
                      , ('Article 10:31 par 3 Awb', 'In afwijking van het tweede par kan het nemen van het besluit omtrent goedkeuring eenmaal voor ten hoogste zes maanden worden verdaagd indien inzake dat besluit advies van een adviseur als bedoeld in [232]artikel 3:5 is vereist.')
                      , ('Article 10:31 par 4 Awb', 'Tenzij bij wettelijk voorschrift anders is bepaald wordt een besluit tot goedkeuring geacht te zijn genomen, indien binnen de in het eerste par genoemde termijn geen besluit omtrent goedkeuring of geen besluit tot verdaging, dan wel binnen de termijn waarvoor het besluit is verdaagd, geen besluit omtrent goedkeuring is bekendgemaakt aan het bestuursorgaan dat het aan goedkeuring onderworpen besluit heeft genomen.')
                      , ('Article 10:32 par 1 Awb', 'Deze afdeling is van overeenkomstige toepassing indien voor het nemen van een besluit door een bestuursorgaan de toestemming van een ander bestuursorgaan is vereist.')
                      , ('Article 10:32 par 2 Awb', 'Bij de toestemming kan een termijn worden gesteld waarbinnen het besluit dient te worden genomen.')
                      , ('Article 10:33 Awb', 'Deze afdeling is van toepassing indien een bestuursorgaan bevoegd is buiten administratief beroep een besluit van een ander bestuursorgaan te vernietigen.')
                      , ('Article 10:34 Awb', 'De vernietigingsbevoegdheid kan slechts worden verleend bij de wet.')
                      , ('Article 10:35 Awb', 'Vernietiging kan alleen geschieden wegens strijd met het recht of het algemeen belang.')
                      , ('Article 10:36 Awb', 'Een besluit kan alleen dan gedeeltelijk worden vernietigd, indien gedeeltelijke instandhouding strookt met aard en inhoud van het besluit.')
                      , ('Article 10:37 Awb', 'Een besluit waarover de rechter uitspraak heeft gedaan of waarbij een in kracht van gewijsde gegane uitspraak van de rechter wordt uitgevoerd, kan niet worden vernietigd op rechtsgronden welke in strijd zijn met die waarop de uitspraak steunt of mede steunt.')
                      , ('Article 10:38 par 1 Awb', 'Een besluit dat nog goedkeuring behoeft, kan niet worden vernietigd.')
                      , ('Article 10:38 par 2 Awb', 'Een besluit waartegen bezwaar of beroep openstaat of aanhangig is, kan niet worden vernietigd.')
                      , ('Article 10:39 par 1 Awb', 'Een besluit tot het verrichten van een privaatrechtelijke rechtshandeling kan niet worden vernietigd, indien dertien weken zijn verstreken nadat het is bekendgemaakt.')
                      , ('Article 10:39 par 2 Awb', 'Indien binnen de termijn genoemd in het eerste par overeenkomstig [233]artikel 10:43 schorsing heeft plaatsgevonden, blijft vernietiging binnen de duur van de schorsing mogelijk.')
                      , ('Article 10:39 par 3 Awb', 'Indien een besluit als bedoeld in het eerste par aan goedkeuring is onderworpen, vangt de in het eerste par genoemde termijn aan nadat het goedkeuringsbesluit is bekendgemaakt. Op het goedkeuringsbesluit zijn het eerste en tweede par van overeenkomstige toepassing.')
                      , ('Article 10:40 Awb', 'Een besluit dat overeenkomstig [234]artikel 10:43 is geschorst, kan, nadat de schorsing is geëindigd, niet meer worden vernietigd.')
                      , ('Article 10:41 par 1 Awb', 'Vernietiging vindt niet plaats dan nadat aan het bestuursorgaan dat het besluit heeft genomen, gelegenheid tot overleg is geboden.')
                      , ('Article 10:41 par 2 Awb', 'De motivering van het vernietigingsbesluit verwijst naar hetgeen in het overleg aan de orde is gekomen.')
                      , ('Article 10:42 par 1 Awb', 'Vernietiging van een besluit strekt zich uit tot alle rechtsgevolgen waarop het was gericht.')
                      , ('Article 10:42 par 2 Awb', 'In het vernietigingsbesluit kan worden bepaald dat de rechtsgevolgen van het vernietigde besluit geheel of ten dele in stand blijven.')
                      , ('Article 10:42 par 3 Awb', 'Indien een besluit tot het aangaan van een overeenkomst wordt vernietigd, wordt de overeenkomst, zo zij reeds is aangegaan en voor zover bij het vernietigingsbesluit niet anders is bepaald, niet of niet verder uitgevoerd, onverminderd het recht van de wederpartij op schadevergoeding.')
                      , ('Article 10:43 Awb', 'Hangende het onderzoek of er reden is tot vernietiging over te gaan, kan een besluit door het tot vernietiging bevoegde bestuursorgaan worden geschorst.')
                      , ('Article 10:44 par 1 Awb', 'Het besluit tot schorsing bepaalt de duur hiervan.')
                      , ('Article 10:44 par 2 Awb', 'De schorsing van een besluit kan eenmaal worden verlengd.')
                      , ('Article 10:44 par 3 Awb', 'De schorsing kan ook na verlenging niet langer duren dan een jaar.')
                      , ('Article 10:44 par 4 Awb', 'Indien bezwaar is gemaakt of beroep is ingesteld tegen het geschorste besluit, duurt de schorsing evenwel voort tot dertien weken nadat op het bezwaar of beroep onherroepelijk is beslist.')
                      , ('Article 10:44 par 5 Awb', 'De schorsing kan worden opgeheven.')
                      , ('Article 10:45 Awb', 'Op het besluit inzake schorsing zijn de [235]artikelen 10:36, [236]10:37, [237]10:38, eerste lid, [238]10:39, eerste en derde lid, en [239]10:42, derde lid, van overeenkomstige toepassing.')
                      , ('Article 11:1 par 1 Awb', 'Onze Ministers van Justitie en van Binnenlandse Zaken zenden binnen drie jaren na de inwerkingtreding van deze wet en vervolgens om de vijf jaren aan de Staten-Generaal een verslag over de wijze waarop zij is toegepast.')
                      , ('Article 11:1 par 2 Awb', 'Het eerste par is niet van toepassing ten aanzien van de voorschriften betreffende beroep bij een administratieve rechter.')
                      , ('Article 11:2 Awb', 'Deze wet treedt in werking op een bij koninklijk besluit te bepalen tijdstip.')
                      , ('Article 11:3 Awb', 'Voor de bekendmaking van deze wet stelt Onze Minister van Justitie de nummering van de artikelen, afdelingen, titels en hoofdstukken van deze wet opnieuw vast en brengt hij de in deze wet voorkomende aanhalingen van artikelen, afdelingen, titels en hoofdstukken daarmee in overeenstemming.')
                      , ('Article 11:4 Awb', 'Deze wet wordt aangehaald als: Algemene wet bestuursrecht.')
                      , ('Article 48 par 1 RO', 'bezetting van enkelvoudige kamer bepalen')
                      , ('Article 6 par 1 RO', 'bezetting van meervoudige kamer bepalen')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug actarticle *
    *                 *
    * fields:         *
    * I/\act;act~  [] *
    * act  []         *
    \*****************/
    mysql_query("CREATE TABLE `actarticle`
                     ( `article` VARCHAR(255) NOT NULL
                     , `act` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `actarticle` (`article` ,`act` )
                VALUES ('Article 10:2 Awb', 'beslissen op aanvraag')
                      , ('Article 1:3 par 3 Awb', 'aanvraag in behandeling nemen')
                      , ('Article 4:1 Awb', 'beslissen op aanvraag')
                      , ('Article 1:5 par 1 Awb', 'maken van bezwaar')
                      , ('Article 1:5 par 2 Awb', 'instellen van administratief beroep')
                      , ('Article 1:5 par 3 Awb', 'instellen van beroep')
                      , ('Article 6:6 Awb', 'bezwaar in behandeling nemen')
                      , ('Article 6:6 Awb; 8:70 par b Awb', 'beroep in behandeling nemen')
                      , ('Article 6:6 Awb', 'bezwaar niet-ontvankelijk verklaren')
                      , ('Article 6:6 Awb', 'beroep niet-ontvankelijk verklaren')
                      , ('Article 7:1a par 6 Awb', 'griffierecht heffen')
                      , ('Article 8:41 par 1 Awb', 'griffierecht heffen')
                      , ('Article 8:70 sub b Awb', 'beroep niet-ontvankelijk verklaren')
                      , ('Article 8:55 par 5 sub a Awb', 'verzet niet-ontvankelijk verklaren')
                      , ('Article 8:70 sub a Awb', 'rechtbank onbevoegd verklaren')
                      , ('Article 8:70 sub c Awb', 'beroep ongegrond verklaren')
                      , ('Article 8:70 sub d Awb', 'beroep gegrond verklaren')
                      , ('Article 8:82 par 3 Awb', 'Terugboeken griffierecht')
                      , ('Article 8:84 par 2 sub a Awb', 'voorzieningenrechter onbevoegd verklaren')
                      , ('Article 8:84 par 2 sub b Awb', 'verzoek niet-ontvankelijk verklaren')
                      , ('Article 8:84 par 2 sub c Awb', 'verzoek afwijzen')
                      , ('Article 8:84 par 2 sub d Awb', 'verzoek geheel of gedeeltelijk toewijzen')
                      , ('Article 8:87 par 3 Awb', 'Terugboeken griffierecht')
                      , ('Article 48 par 1 RO', 'bezetting van enkelvoudige kamer bepalen')
                      , ('Article 6 par 1 RO', 'bezetting van meervoudige kamer bepalen')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*********************\
    * Plug organarticle   *
    *                     *
    * fields:             *
    * I/\organ;organ~  [] *
    * organ  []           *
    \*********************/
    mysql_query("CREATE TABLE `organarticle`
                     ( `article` VARCHAR(255) NOT NULL
                     , `organ` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `organarticle` (`article` ,`organ` )
                VALUES ('Article 1:3 par. 3 Awb', 'authorities')
                      , ('Article 4:1 Awb', 'authorities')
                      , ('Article 1:5 par. 1 Awb', 'citizen')
                      , ('Article 1:5 par. 2 Awb', 'citizen')
                      , ('Article 1:5 par. 3 Awb', 'citizen')
                      , ('Article 6:6 Awb', 'authorities')
                      , ('Article 6:6 Awb; 8:70 par. b Awb', 'judge')
                      , ('Article 6:6 Awb', 'authorities')
                      , ('Article 6:6 Awb; 8:70 par. b Awb', 'judge')
                      , ('Article 8:55 par. 5 sub a Awb', 'judge')
                      , ('Article 8:70 sub a Awb', '')
                      , ('Article 8:70 sub c Awb', '')
                      , ('Article 8:70 sub d Awb', '')
                      , ('Article 8:82 par. 3 Awb', 'clerk')
                      , ('Article 8:84 par. 2 sub a Awb', '')
                      , ('Article 8:84 par. 2 sub b Awb', '')
                      , ('Article 8:84 par. 2 sub c Awb', '')
                      , ('Article 8:84 par. 2 sub d Awb', '')
                      , ('Article 8:87 par. 3 Awb', 'clerk')
                      , ('Article 48 par. 1 RO', 'district authorities')
                      , ('Article 6 par. 1 RO', 'district authorities')
                      , ('Article 7:1a par. 6 Awb', 'clerk')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug objectact        *
    *                       *
    * fields:               *
    * I/\object;object~  [] *
    * object  []            *
    \***********************/
    mysql_query("CREATE TABLE `objectact`
                     ( `act` VARCHAR(255) NOT NULL
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
    /*******************\
    * Plug verbarticle  *
    *                   *
    * fields:           *
    * I/\verb;verb~  [] *
    * verb  []          *
    \*******************/
    mysql_query("CREATE TABLE `verbarticle`
                     ( `article` VARCHAR(255) NOT NULL
                     , `verb` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `verbarticle` (`article` ,`verb` )
                VALUES ('Article 1:3 par 3 Awb', 'Registreren')
                      , ('Article 4:1 Awb', 'Beslissen')
                      , ('Article 1:5 par 1 Awb', 'Bezwaar maken')
                      , ('Article 1:5 par 1 Awb', 'Aanmaken')
                      , ('Article 1:5 par 1 Awb', 'Aanmaken')
                      , ('Article 6:6 Awb', 'Registreren')
                      , ('Article 6:6 Awb; 8:70 par b Awb', 'Registreren')
                      , ('Article 6:6 Awb', 'Niet-ontvankelijk verklaren')
                      , ('Article 6:6 Awb; 8:70 par b Awb', 'Niet-ontvankelijk verklaren')
                      , ('Article 7:1a par 6 Awb', 'Heffen')
                      , ('Article 8:41 par 1 Awb', 'Heffen')
                      , ('Article 8:55 par 5 sub a Awb', 'Niet-ontvankelijk verklaren')
                      , ('Article 8:70 sub a Awb', 'Onbevoegd verklaren')
                      , ('Article 8:70 sub c Awb', 'Ongegrond verklaren')
                      , ('Article 8:70 sub d Awb', 'Gegrond verklaren')
                      , ('Article 8:82 par 3 Awb', 'Terugboeken')
                      , ('Article 8:84 par 2 sub a Awb', 'Onbevoegd verklaren')
                      , ('Article 8:84 par 2 sub b Awb', 'Niet-ontvankelijk verklaren')
                      , ('Article 8:84 par 2 sub c Awb', 'Afwijzen')
                      , ('Article 8:84 par 2 sub d Awb', 'Toewijzen')
                      , ('Article 8:87 par 3 Awb', 'Terugboeken')
                      , ('Article 48 par 1 RO', 'Toekennen')
                      , ('Article 6 par 1 RO', 'Toekennen')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug objecttypearticle        *
    *                               *
    * fields:                       *
    * I/\objectType;objectType~  [] *
    * objectType  []                *
    \*******************************/
    mysql_query("CREATE TABLE `objecttypearticle`
                     ( `article` VARCHAR(255) NOT NULL
                     , `objecttype` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `objecttypearticle` (`article` ,`objecttype` )
                VALUES ('Article 1:3 par 3 Awb', 'Aanvraag')
                      , ('Article 4:1 Awb', 'Aanvraag')
                      , ('Article 1:5 par 1 Awb', 'Bezwaar')
                      , ('Article 1:5 par 1 Awb', 'Administratief beroep')
                      , ('Article 1:5 par 1 Awb', 'Beroep')
                      , ('Article 6:6 Awb', 'Bezwaar')
                      , ('Article 8:70 sub b Awb', 'Bezwaar')
                      , ('Article 6:6 Awb', 'Beroep')
                      , ('Article 7:1a par 6 Awb', 'Griffierecht')
                      , ('Article 8:41 par 1 Awb', 'Griffierecht')
                      , ('Article 8:87 par 3 Awb', 'Griffierecht')
                      , ('Article 8:70 sub b Awb', 'Beroep')
                      , ('Article 8:55 par 5 sub a Awb', 'Verzet')
                      , ('Article 8:70 sub a Awb', 'Rechtbank')
                      , ('Article 8:70 sub c Awb', 'Beroep')
                      , ('Article 8:70 sub d Awb', 'Beroep')
                      , ('Article 8:82 par 3 Awb', 'Griffierecht')
                      , ('Article 8:84 par 2 sub a Awb', 'Rechter')
                      , ('Article 8:84 par 2 sub b Awb', 'Verzoek')
                      , ('Article 8:84 par 2 sub c Awb', 'Verzoek')
                      , ('Article 8:84 par 2 sub d Awb', 'Verzoek')
                      , ('Article 8:87 par 3 Awb', 'Griffierecht')
                      , ('Article 48 par 1 RO', 'Bezetting van enkelvoudige kamer')
                      , ('Article 6 par 1 RO', 'Bezetting van meervoudige kamer')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug verbusecase  *
    *                   *
    * fields:           *
    * I/\verb;verb~  [] *
    * verb  []          *
    \*******************/
    mysql_query("CREATE TABLE `verbusecase`
                     ( `usecase` VARCHAR(255) NOT NULL
                     , `verb` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug verbact      *
    *                   *
    * fields:           *
    * I/\verb;verb~  [] *
    * verb  []          *
    \*******************/
    mysql_query("CREATE TABLE `verbact`
                     ( `act` VARCHAR(255) NOT NULL
                     , `verb` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug objectaction     *
    *                       *
    * fields:               *
    * I/\object;object~  [] *
    * object  []            *
    \***********************/
    mysql_query("CREATE TABLE `objectaction`
                     ( `action` VARCHAR(255) NOT NULL
                     , `object` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************\
    * Plug as       *
    *               *
    * fields:       *
    * I/\as;as~  [] *
    * as  []        *
    \***************/
    mysql_query("CREATE TABLE `as`
                     ( `action` VARCHAR(255) NOT NULL
                     , `organ` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug objecttypeobject         *
    *                               *
    * fields:                       *
    * I/\objectType;objectType~  [] *
    * objectType  []                *
    \*******************************/
    mysql_query("CREATE TABLE `objecttypeobject`
                     ( `object` VARCHAR(255) NOT NULL
                     , `objecttype` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug actsas           *
    *                       *
    * fields:               *
    * I/\actsas;actsas~  [] *
    * actsas  []            *
    \***********************/
    mysql_query("CREATE TABLE `actsas`
                     ( `party` VARCHAR(255) NOT NULL
                     , `role` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `actsas` (`party` ,`role` )
                VALUES ('de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst', 'Plaintiff')
                      , ('de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen', 'Defendant')
                      , ('het dagelijks bestuur van het stadsdeel Zeeburg van de gemeente Amsterdam', 'Defendant')
                      , ('de besloten vennootschap Fountainhead Enterprise B.V., gevestigd te Amsterdam', 'Joined')
                      , ('Jan met de Vilten Hoed', 'Nobody')
                      , ('mr. M.R.A. Dekker', 'Representative')
                      , ('drs. D. de Rooij', 'Representative')
                      , ('mr. S.M. Klein', 'Representative')
                      , ('mr. G.L.M. Teeuwen', 'Representative')
                      , ('mr. J.H.A. van der Grinten', 'Representative')
                      , ('mr. M.L.M. Lohman', 'Representative')
                      , ('Mevr. El Amrani', 'Plaintiff')
                      , ('Dhr. Klaas Vreugdenhil', 'Defendant')
                      , ('Mw. Annemarie Stegeman', 'Local official')
                      , ('mr. F. H. Goossens', 'Lawyer')
                      , ('Emilio Garcia', 'InterestedParty')
                      , ('Frits Ticherus', 'Secretary')
                      , ('mr. K.L.M. Lenaerts', 'Judge')
                      , ('mw.mr. Chr.Ph. Tetrode', 'Clerk')
                      , ('mr. P. van der Vossen', 'Judge')
                      , ('mr. M.M. Mijwaard', 'Clerk')
                      , ('mr. V.M. Behrens', 'Clerk')
                      , ('mr. J.J. Schuurman', 'Clerk')
                      , ('mr. K.F. van Dam', 'Clerk')
                      , ('mr. Ch. Dequaistenit', 'Clerk')
                      , ('mr. N.M. van Waterschoot', 'Judge')
                      , ('mr. J.H.B. van der Meer', 'Judge')
                      , ('mr. Ph.Q. van Otterloo-Pannerden', 'Judge')
                ");
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
                     , `act` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug may        *
    *                 *
    * fields:         *
    * I/\may;may~  [] *
    * may  []         *
    \*****************/
    mysql_query("CREATE TABLE `may`
                     ( `act` VARCHAR(255) NOT NULL
                     , `role` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug to                              *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * to  [TOT]                            *
    \**************************************/
    mysql_query("CREATE TABLE `to`
                     ( `document` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `to` (`document` ,`party` )
                VALUES ('doc987384', 'de Stichting Katholiek Onderwijs Staphorsteradeel, gevestigd te Staphorst')
                      , ('doc987384', 'de Staatssecretaris van Onderwijs, Cultuur en Wetenschappen')
                      , ('doc987384', 'mr. M.R.A. Dekker')
                      , ('doc987384', 'drs. D. de Rooij')
                      , ('doc987384', 'mr. S.M. Klein')
                      , ('letter 2000/864821a', 'Council of State')
                      , ('letter 2000/860338e', 'Council of State')
                      , ('doc763820', '???')
                      , ('letter 2009/87743', 'Utrecht district court')
                      , ('letter 2009/87743a', 'Mevr. El Amrani')
                      , ('schedule 2009/87743.1', 'Dhr. Klaas Vreugdenhil')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************************\
    * Plug yourproperty                 *
    *                                   *
    * fields:                           *
    * I/\yourProperty;yourProperty~  [] *
    * yourProperty  []                  *
    \***********************************/
    mysql_query("CREATE TABLE `yourproperty`
                     ( `document` VARCHAR(255) NOT NULL
                     , `text` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
