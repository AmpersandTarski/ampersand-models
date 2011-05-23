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
                VALUES ('Article 1:3 par. 3 Awb')
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
