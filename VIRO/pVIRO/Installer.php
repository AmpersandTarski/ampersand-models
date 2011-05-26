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
  if($DB_slct = @mysql_select_db('VIROENG')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `VIROENG` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('VIROENG');
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
    //// Number of plugs: 36
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `session`")){
        mysql_query("DROP TABLE `session`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `document`")){
        mysql_query("DROP TABLE `document`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `legalcase`")){
        mysql_query("DROP TABLE `legalcase`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `city`")){
        mysql_query("DROP TABLE `city`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `process`")){
        mysql_query("DROP TABLE `process`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `court`")){
        mysql_query("DROP TABLE `court`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `party`")){
        mysql_query("DROP TABLE `party`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `panel`")){
        mysql_query("DROP TABLE `panel`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `courtofappeal`")){
        mysql_query("DROP TABLE `courtofappeal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `areaoflaw`")){
        mysql_query("DROP TABLE `areaoflaw`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `documenttype`")){
        mysql_query("DROP TABLE `documenttype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `casetype`")){
        mysql_query("DROP TABLE `casetype`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `role`")){
        mysql_query("DROP TABLE `role`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `date`")){
        mysql_query("DROP TABLE `date`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `timestamp`")){
        mysql_query("DROP TABLE `timestamp`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `text`")){
        mysql_query("DROP TABLE `text`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `plaintiff`")){
        mysql_query("DROP TABLE `plaintiff`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `defendant`")){
        mysql_query("DROP TABLE `defendant`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `domicile`")){
        mysql_query("DROP TABLE `domicile`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `writtenauthof`")){
        mysql_query("DROP TABLE `writtenauthof`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authfor`")){
        mysql_query("DROP TABLE `authfor`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authby`")){
        mysql_query("DROP TABLE `authby`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `casefile`")){
        mysql_query("DROP TABLE `casefile`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `appeal`")){
        mysql_query("DROP TABLE `appeal`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `appealtoadmincourt`")){
        mysql_query("DROP TABLE `appealtoadmincourt`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `objection`")){
        mysql_query("DROP TABLE `objection`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `person`")){
        mysql_query("DROP TABLE `person`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `organization`")){
        mysql_query("DROP TABLE `organization`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `administrativeauthority`")){
        mysql_query("DROP TABLE `administrativeauthority`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `memberofgovernment`")){
        mysql_query("DROP TABLE `memberofgovernment`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `members`")){
        mysql_query("DROP TABLE `members`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `judge`")){
        mysql_query("DROP TABLE `judge`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `clerk`")){
        mysql_query("DROP TABLE `clerk`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `broughtbefore`")){
        mysql_query("DROP TABLE `broughtbefore`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `administrativeauthorityawb87`")){
        mysql_query("DROP TABLE `administrativeauthorityawb87`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `remark`")){
        mysql_query("DROP TABLE `remark`");
      }
    }
    /**************************************\
    * Plug session                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * panel  [UNI,TOT]                     *
    * clerk  [UNI,TOT]                     *
    * scheduled  [UNI,TOT]                 *
    * occured  [UNI]                       *
    * location  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `session`
                     ( `i` VARCHAR(255) NOT NULL
                     , `panel` VARCHAR(255) NOT NULL
                     , `clerk` VARCHAR(255) NOT NULL
                     , `scheduled` VARCHAR(255) NOT NULL
                     , `occured` VARCHAR(255)
                     , `location` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `session` (`i` ,`panel` ,`clerk` ,`scheduled` ,`occured` ,`location` )
                VALUES ('Session RbAms 1094', 'Amsterdam district court single-judge panel for cases of administrative law', 'mr. V.M. Behrens', '23-4-2009', NULL, 'Amsterdam district court')
                      , ('Session RvS 83', 'Panel 2 department administrative administration of justice of the Council of State', 'mr. J.J. Schuurman', '15-9-2000', '15-9-2000', 'Council of State')
                      , ('Session RvS 84', 'Panel 2 department administrative administration of justice of the Council of State', 'mr. J.J. Schuurman', '16-11-2000', '16-11-2000', 'Council of State')
                      , ('SBR 2009/05/02', 'Utrecht district court single-judge panel for cases of administrative law', 'mr. Ch. Dequaistenit', '2-5-2009', NULL, 'Utrecht district court')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug document                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * documentType  [UNI,TOT]              *
    * sent  [UNI]                          *
    * received  [UNI]                      *
    \**************************************/
    mysql_query("CREATE TABLE `document`
                     ( `i` VARCHAR(255) NOT NULL
                     , `documenttype` VARCHAR(255) NOT NULL
                     , `sent` VARCHAR(255)
                     , `received` VARCHAR(255)
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `document` (`i` ,`documenttype` ,`sent` ,`received` )
                VALUES ('letter 2000/864821a', 'Authorization', '2-3-2000', '3-3-2000')
                      , ('letter 2000/860338e', 'Authorization', '5-3-2000', '8-3-2000')
                      , ('letter 2007/33-9887', 'Authorization', '12-9-2007', '14-9-2007')
                      , ('letter 2007/33-9910', 'Authorization', '28-10-2007', '29-10-2007')
                      , ('doc987384', 'Verdict', '10-10-2000', '12-10-2000')
                      , ('doc763820', 'Evidence', '10-4-2009', '11-4-2009')
                      , ('letter 2009/87743', 'Correspondence', '10-4-2009', '12-4-2009')
                      , ('letter 2009/87743a', 'Appeal', '16-4-2009', '17-4-2009')
                      , ('schedule 2009/87743.1', 'Evidence', '27-2-2009', '27-2-2009')
                      , ('letter 2009/33-9854', 'Correspondence', '20-4-2009', '22-4-2009')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug legalcase                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * areaOfLaw  [UNI,TOT]                 *
    * caseType  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `legalcase`
                     ( `i` VARCHAR(255) NOT NULL
                     , `areaoflaw` VARCHAR(255) NOT NULL
                     , `casetype` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `legalcase` (`i` ,`areaoflaw` ,`casetype` )
                VALUES ('199902238', 'Administrative law', 'Appeal to administrative court')
                      , ('AWB 07/2481 WRO', 'Administrative law', 'Appeal')
                      , ('SBR 02/74331', 'Administrative law', 'Appeal')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug city                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * localOffices  [UNI]                  *
    * jurisdiction  [UNI,TOT]              *
    \**************************************/
    mysql_query("CREATE TABLE `city`
                     ( `i` VARCHAR(255) NOT NULL
                     , `localoffices` VARCHAR(255)
                     , `jurisdiction` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `city` (`i` ,`localoffices` ,`jurisdiction` )
                VALUES ('Den Helder', 'Alkmaar district court', 'Alkmaar district court')
                      , ('Hoorn', 'Alkmaar district court', 'Alkmaar district court')
                      , ('Hilversum', 'Amsterdam district court', 'Amsterdam district court')
                      , ('Zaanstad', 'Haarlem district court', 'Haarlem district court')
                      , ('Amersfoort', 'Utrecht district court', 'Utrecht district court')
                      , ('Enschede', 'Almelo district court', 'Almelo district court')
                      , ('Nijmegen', 'Arnhem district court', 'Arnhem district court')
                      , ('Tiel', 'Arnhem district court', 'Arnhem district court')
                      , ('Wageningen', 'Arnhem district court', 'Arnhem district court')
                      , ('Apeldoorn', 'Zutphen district court', 'Zutphen district court')
                      , ('Groenlo', 'Zutphen district court', 'Zutphen district court')
                      , ('Harderwijk', 'Zutphen district court', 'Zutphen district court')
                      , ('Terborg', 'Zutphen district court', 'Zutphen district court')
                      , ('Deventer', 'Zwolle-Lelystad district court', 'Zwolle-Lelystad district court')
                      , ('Lelystad', 'Zwolle-Lelystad district court', 'Zwolle-Lelystad district court')
                      , ('Gorinchem', 'Dordrecht district court', 'Dordrecht district court')
                      , ('Oud-Beijerland', 'Dordrecht district court', 'Dordrecht district court')
                      , ('Alphen to de Rijn', '\'s-Gravenhage district court', '\'s-Gravenhage district court')
                      , ('Delft', '\'s-Gravenhage district court', '\'s-Gravenhage district court')
                      , ('Gouda', '\'s-Gravenhage district court', '\'s-Gravenhage district court')
                      , ('Leiden', '\'s-Gravenhage district court', '\'s-Gravenhage district court')
                      , ('Schouwen-Duiveland', 'Middelburg district court', 'Middelburg district court')
                      , ('Terneuzen', 'Middelburg district court', 'Middelburg district court')
                      , ('Brielle', 'Rotterdam district court', 'Rotterdam district court')
                      , ('Middelharnis', 'Rotterdam district court', 'Rotterdam district court')
                      , ('Schiedam', 'Rotterdam district court', 'Rotterdam district court')
                      , ('Bergen op Zoom', 'Breda district court', 'Breda district court')
                      , ('Tilburg', 'Breda district court', 'Breda district court')
                      , ('Boxmeer', '\'s-Hertogenbosch district court', '\'s-Hertogenbosch district court')
                      , ('Eindhoven', '\'s-Hertogenbosch district court', '\'s-Hertogenbosch district court')
                      , ('Helmond', '\'s-Hertogenbosch district court', '\'s-Hertogenbosch district court')
                      , ('Heerlen', 'Maastricht district court', 'Maastricht district court')
                      , ('Sittard-Geleen', 'Maastricht district court', 'Maastricht district court')
                      , ('Venlo', 'Roermond district court', 'Roermond district court')
                      , ('Emmen', 'Assen district court', 'Assen district court')
                      , ('Meppel', 'Assen district court', 'Assen district court')
                      , ('Winschoten', 'Groningen district court', 'Groningen district court')
                      , ('Heerenveen', 'Leeuwarden district court', 'Leeuwarden district court')
                      , ('Sneek', 'Leeuwarden district court', 'Leeuwarden district court')
                      , ('Utrecht', NULL, 'Utrecht district court')
                      , ('Staphorst', NULL, 'Zwolle-Lelystad district court')
                      , ('Amsterdam', NULL, 'Amsterdam district court')
                      , ('Den Haag', NULL, '\'s-Gravenhage district court')
                      , ('Alkmaar', NULL, 'Alkmaar district court')
                      , ('Haarlem', NULL, 'Haarlem district court')
                      , ('Almelo', NULL, 'Almelo district court')
                      , ('Arnhem', NULL, 'Arnhem district court')
                      , ('Zutphen', NULL, 'Zutphen district court')
                      , ('Zwolle', NULL, 'Zwolle-Lelystad district court')
                      , ('Dordrecht', NULL, 'Dordrecht district court')
                      , ('Middelburg', NULL, 'Middelburg district court')
                      , ('Rotterdam', NULL, 'Rotterdam district court')
                      , ('Breda', NULL, 'Breda district court')
                      , ('Den Bosch', NULL, '\'s-Hertogenbosch district court')
                      , ('Maastricht', NULL, 'Maastricht district court')
                      , ('Roermond', NULL, 'Roermond district court')
                      , ('Assen', NULL, 'Assen district court')
                      , ('Groningen', NULL, 'Groningen district court')
                      , ('Leeuwarden', NULL, 'Leeuwarden district court')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug process                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * session  [UNI,TOT]                   *
    * legalCase  [UNI,TOT]                 *
    \**************************************/
    mysql_query("CREATE TABLE `process`
                     ( `i` VARCHAR(255) NOT NULL
                     , `session` VARCHAR(255) NOT NULL
                     , `legalcase` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `process` (`i` ,`session` ,`legalcase` )
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
    * seatedIn  [UNI,TOT]                  *
    * district  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `court`
                     ( `i` VARCHAR(255) NOT NULL
                     , `seatedin` VARCHAR(255) NOT NULL
                     , `district` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `court` (`i` ,`seatedin` ,`district` )
                VALUES ('Amsterdam district court', 'Amsterdam', 'Amsterdam court of appeal')
                      , ('Council of State', 'Den Haag', 'Council of State')
                      , ('Utrecht district court', 'Utrecht', 'Amsterdam court of appeal')
                      , ('Alkmaar district court', 'Alkmaar', 'Amsterdam court of appeal')
                      , ('Haarlem district court', 'Haarlem', 'Amsterdam court of appeal')
                      , ('Almelo district court', 'Almelo', 'Arnhem court of appeal')
                      , ('Arnhem district court', 'Arnhem', 'Arnhem court of appeal')
                      , ('Zutphen district court', 'Zutphen', 'Arnhem court of appeal')
                      , ('Zwolle-Lelystad district court', 'Zwolle', 'Arnhem court of appeal')
                      , ('Dordrecht district court', 'Dordrecht', '\'s-Gravenhage court of appeal')
                      , ('\'s-Gravenhage district court', 'Den Haag', '\'s-Gravenhage court of appeal')
                      , ('Middelburg district court', 'Middelburg', '\'s-Gravenhage court of appeal')
                      , ('Rotterdam district court', 'Rotterdam', '\'s-Gravenhage court of appeal')
                      , ('Breda district court', 'Breda', '\'s-Hertogenbosch court of appeal')
                      , ('\'s-Hertogenbosch district court', 'Den Bosch', '\'s-Hertogenbosch court of appeal')
                      , ('Maastricht district court', 'Maastricht', '\'s-Hertogenbosch court of appeal')
                      , ('Roermond district court', 'Roermond', '\'s-Hertogenbosch court of appeal')
                      , ('Assen district court', 'Assen', 'Leeuwarden court of appeal')
                      , ('Groningen district court', 'Groningen', 'Leeuwarden court of appeal')
                      , ('Leeuwarden district court', 'Leeuwarden', 'Leeuwarden court of appeal')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug party                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * actsas  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `party`
                     ( `i` VARCHAR(255) NOT NULL
                     , `actsas` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `party` (`i` ,`actsas` )
                VALUES ('the Stichting Katholiek Onderwijs Staphorsteradeel, Staphorst', 'plaintiff')
                      , ('the Secretary of State for Education, Culture and Science', 'defendant')
                      , ('the council of borough Zeeburg of the municipality of Amsterdam', 'defendant')
                      , ('Fountainhead Enterprise B.V., Amsterdam', 'joined')
                      , ('the council of the municipality of Utrecht', 'defendant')
                      , ('dhr. J. de Vries', 'plaintiff')
                      , ('mr. M.R.A. Dekker', 'representative')
                      , ('drs. D. de Rooij', 'representative')
                      , ('mr. S.M. Klein', 'representative')
                      , ('mr. G.L.M. Teeuwen', 'representative')
                      , ('mr. J.H.A. van der Grinten', 'representative')
                      , ('mr. M.L.M. Lohman', 'representative')
                      , ('mw. El Amrani', 'plaintiff')
                      , ('dhr. Klaas Vreugdenhil', 'defendant')
                      , ('mr. F. H. Goossens', 'representative')
                      , ('mw. E. Garcia', 'InterestedParty')
                      , ('mr. K.L.M. Lenaerts', 'judge')
                      , ('mw.mr. Chr.Ph. Tetrode', 'clerk')
                      , ('mr. P. van der Vossen', 'judge')
                      , ('mr. M.M. Mijwaard', 'clerk')
                      , ('mr. V.M. Behrens', 'clerk')
                      , ('mr. J.J. Schuurman', 'clerk')
                      , ('mr. K.F. van Dam', 'clerk')
                      , ('mr. Ch. Dequaistenit', 'clerk')
                      , ('mr. N.M. van Waterschoot', 'judge')
                      , ('mr. J.H.B. van der Meer', 'judge')
                      , ('mr. Ph.Q. van Otterloo-Pannerden', 'judge')
                      , ('mr. T.M.A. van Loben Sels', 'judge')
                      , ('mr. G.M.P. Brouns', 'judge')
                      , ('mr. H.P. Kijlstra', 'judge')
                      , ('mr. M. Vtodrager', 'judge')
                      , ('mr. J. Sap', 'judge')
                      , ('mr. M. ter Brugge', 'judge')
                      , ('mr. L.E. Verschoor-Bergsma', 'judge')
                      , ('mr. J. Ebbens', 'judge')
                      , ('mr. B.J. van Ettekoven', 'judge')
                      , ('mr. G.J. van Binsbergen', 'judge')
                      , ('mr. J. Struiksma', 'judge')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug panel                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * court  [UNI,TOT]                     *
    \**************************************/
    mysql_query("CREATE TABLE `panel`
                     ( `i` VARCHAR(255) NOT NULL
                     , `court` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `panel` (`i` ,`court` )
                VALUES ('Amsterdam district court fourth single-judge panel', 'Amsterdam district court')
                      , ('Roermond district court single-judge panel', 'Roermond district court')
                      , ('Amsterdam district court single-judge panel for cases of administrative law', 'Amsterdam district court')
                      , ('Panel 2 department administrative administration of justice of the Council of State', 'Council of State')
                      , ('Three-judge panel to process judicial disqualifications of Utrecht district court', 'Utrecht district court')
                      , ('Utrecht district court three-judge panel for cases of administrative law', 'Utrecht district court')
                      , ('Utrecht district court single-judge panel for cases of administrative law', 'Utrecht district court')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug courtofappeal                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * seatedIn  [UNI,TOT]                  *
    \**************************************/
    mysql_query("CREATE TABLE `courtofappeal`
                     ( `i` VARCHAR(255) NOT NULL
                     , `seatedin` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`i`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `courtofappeal` (`i` ,`seatedin` )
                VALUES ('Council of State', 'Den Haag')
                      , ('Amsterdam court of appeal', 'Amsterdam')
                      , ('Arnhem court of appeal', 'Arnhem')
                      , ('\'s-Gravenhage court of appeal', 'Den Haag')
                      , ('\'s-Hertogenbosch court of appeal', 'Den Bosch')
                      , ('Leeuwarden court of appeal', 'Leeuwarden')
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
                VALUES ('Appeal to administrative court')
                      , ('Appeal')
                ");
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
                VALUES ('plaintiff')
                      , ('defendant')
                      , ('joined')
                      , ('representative')
                      , ('InterestedParty')
                      , ('judge')
                      , ('clerk')
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
                VALUES ('23-4-2009')
                      , ('15-9-2000')
                      , ('16-11-2000')
                      , ('2-5-2009')
                ");
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
                      , ('10-4-2009')
                      , ('16-4-2009')
                      , ('27-2-2009')
                      , ('12-9-2007')
                      , ('20-4-2009')
                      , ('28-10-2007')
                      , ('12-10-2000')
                      , ('3-3-2000')
                      , ('8-3-2000')
                      , ('11-4-2009')
                      , ('12-4-2009')
                      , ('17-4-2009')
                      , ('14-9-2007')
                      , ('22-4-2009')
                      , ('29-10-2007')
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
                      , ('Decision of the city council of Utrecht, Utrechtsblad 2009 No. 8')
                      , ('2007/33-9887')
                      , ('2009/33-9854')
                      , ('2007/33-9910')
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
                     ( `legalcase` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `plaintiff` (`legalcase` ,`party` )
                VALUES ('199902238', 'the Stichting Katholiek Onderwijs Staphorsteradeel, Staphorst')
                      , ('AWB 07/2481 WRO', 'dhr. J. de Vries')
                      , ('SBR 02/74331', 'mw. El Amrani')
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
                     , `legalcase` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `defendant` (`party` ,`legalcase` )
                VALUES ('the Secretary of State for Education, Culture and Science', '199902238')
                      , ('the council of borough Zeeburg of the municipality of Amsterdam', 'AWB 07/2481 WRO')
                      , ('the council of the municipality of Utrecht', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug domicile             *
    *                           *
    * fields:                   *
    * I/\domicile;domicile~  [] *
    * domicile  []              *
    \***************************/
    mysql_query("CREATE TABLE `domicile`
                     ( `party` VARCHAR(255) NOT NULL
                     , `city` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `domicile` (`party` ,`city` )
                VALUES ('the Stichting Katholiek Onderwijs Staphorsteradeel, Staphorst', 'Staphorst')
                      , ('the council of borough Zeeburg of the municipality of Amsterdam', 'Amsterdam')
                      , ('Fountainhead Enterprise B.V., Amsterdam', 'Amsterdam')
                      , ('the council of the municipality of Utrecht', 'Utrecht')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************************\
    * Plug writtenauthof                  *
    *                                     *
    * fields:                             *
    * I/\writtenAuthOf;writtenAuthOf~  [] *
    * writtenAuthOf  []                   *
    \*************************************/
    mysql_query("CREATE TABLE `writtenauthof`
                     ( `document` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `writtenauthof` (`document` ,`party` )
                VALUES ('letter 2000/864821a', 'mr. M.R.A. Dekker')
                      , ('letter 2000/864821a', 'drs. D. de Rooij')
                      , ('letter 2000/860338e', 'mr. S.M. Klein')
                      , ('letter 2007/33-9887', 'mr. G.L.M. Teeuwen')
                      , ('letter 2007/33-9910', 'mr. M.L.M. Lohman')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug authfor            *
    *                         *
    * fields:                 *
    * I/\authFor;authFor~  [] *
    * authFor  []             *
    \*************************/
    mysql_query("CREATE TABLE `authfor`
                     ( `document` VARCHAR(255) NOT NULL
                     , `legalcase` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `authfor` (`document` ,`legalcase` )
                VALUES ('letter 2000/864821a', '199902238')
                      , ('letter 2000/860338e', '199902238')
                      , ('letter 2007/33-9887', 'AWB 07/2481 WRO')
                      , ('letter 2007/33-9910', 'AWB 07/2481 WRO')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug authby           *
    *                       *
    * fields:               *
    * I/\authBy;authBy~  [] *
    * authBy  []            *
    \***********************/
    mysql_query("CREATE TABLE `authby`
                     ( `document` VARCHAR(255) NOT NULL
                     , `party` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `authby` (`document` ,`party` )
                VALUES ('letter 2000/864821a', 'the Stichting Katholiek Onderwijs Staphorsteradeel, Staphorst')
                      , ('letter 2000/860338e', 'the Secretary of State for Education, Culture and Science')
                      , ('letter 2007/33-9887', 'dhr. J. de Vries')
                      , ('letter 2007/33-9910', 'the council of borough Zeeburg of the municipality of Amsterdam')
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
                     , `legalcase` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `casefile` (`document` ,`legalcase` )
                VALUES ('doc987384', '199902238')
                      , ('doc763820', 'AWB 07/2481 WRO')
                      , ('letter 2009/87743', 'SBR 02/74331')
                      , ('letter 2009/87743a', 'SBR 02/74331')
                      , ('schedule 2009/87743.1', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug appeal           *
    *                       *
    * fields:               *
    * I/\appeal;appeal~  [] *
    * appeal  [SYM,ASY]     *
    \***********************/
    mysql_query("CREATE TABLE `appeal`
                     ( `legalcase` VARCHAR(255) NOT NULL
                     , `legalcase1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `appeal` (`legalcase` ,`legalcase1` )
                VALUES ('AWB 07/2481 WRO', 'AWB 07/2481 WRO')
                      , ('SBR 02/74331', 'SBR 02/74331')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************************************\
    * Plug appealtoadmincourt                       *
    *                                               *
    * fields:                                       *
    * I/\appealToAdminCourt;appealToAdminCourt~  [] *
    * appealToAdminCourt  [SYM,ASY]                 *
    \***********************************************/
    mysql_query("CREATE TABLE `appealtoadmincourt`
                     ( `legalcase` VARCHAR(255) NOT NULL
                     , `legalcase1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `appealtoadmincourt` (`legalcase` ,`legalcase1` )
                VALUES ('199902238', '199902238')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug objection              *
    *                             *
    * fields:                     *
    * I/\objection;objection~  [] *
    * objection  [SYM,ASY]        *
    \*****************************/
    mysql_query("CREATE TABLE `objection`
                     ( `legalcase` VARCHAR(255) NOT NULL
                     , `legalcase1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug person           *
    *                       *
    * fields:               *
    * I/\person;person~  [] *
    * person  [SYM,ASY]     *
    \***********************/
    mysql_query("CREATE TABLE `person`
                     ( `party` VARCHAR(255) NOT NULL
                     , `party1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `person` (`party` ,`party1` )
                VALUES ('dhr. J. de Vries', 'dhr. J. de Vries')
                      , ('mr. M.R.A. Dekker', 'mr. M.R.A. Dekker')
                      , ('drs. D. de Rooij', 'drs. D. de Rooij')
                      , ('mr. S.M. Klein', 'mr. S.M. Klein')
                      , ('mr. G.L.M. Teeuwen', 'mr. G.L.M. Teeuwen')
                      , ('mr. J.H.A. van der Grinten', 'mr. J.H.A. van der Grinten')
                      , ('mr. M.L.M. Lohman', 'mr. M.L.M. Lohman')
                      , ('mw. El Amrani', 'mw. El Amrani')
                      , ('dhr. Klaas Vreugdenhil', 'dhr. Klaas Vreugdenhil')
                      , ('mr. F. H. Goossens', 'mr. F. H. Goossens')
                      , ('mw. E. Garcia', 'mw. E. Garcia')
                      , ('mr. K.L.M. Lenaerts', 'mr. K.L.M. Lenaerts')
                      , ('mw.mr. Chr.Ph. Tetrode', 'mw.mr. Chr.Ph. Tetrode')
                      , ('mr. P. van der Vossen', 'mr. P. van der Vossen')
                      , ('mr. M.M. Mijwaard', 'mr. M.M. Mijwaard')
                      , ('mr. V.M. Behrens', 'mr. V.M. Behrens')
                      , ('mr. J.J. Schuurman', 'mr. J.J. Schuurman')
                      , ('mr. K.F. van Dam', 'mr. K.F. van Dam')
                      , ('mr. Ch. Dequaistenit', 'mr. Ch. Dequaistenit')
                      , ('mr. N.M. van Waterschoot', 'mr. N.M. van Waterschoot')
                      , ('mr. J.H.B. van der Meer', 'mr. J.H.B. van der Meer')
                      , ('mr. Ph.Q. van Otterloo-Pannerden', 'mr. Ph.Q. van Otterloo-Pannerden')
                      , ('mr. T.M.A. van Loben Sels', 'mr. T.M.A. van Loben Sels')
                      , ('mr. G.M.P. Brouns', 'mr. G.M.P. Brouns')
                      , ('mr. H.P. Kijlstra', 'mr. H.P. Kijlstra')
                      , ('mr. M. Vtodrager', 'mr. M. Vtodrager')
                      , ('mr. J. Sap', 'mr. J. Sap')
                      , ('mr. M. ter Brugge', 'mr. M. ter Brugge')
                      , ('mr. L.E. Verschoor-Bergsma', 'mr. L.E. Verschoor-Bergsma')
                      , ('mr. J. Ebbens', 'mr. J. Ebbens')
                      , ('mr. B.J. van Ettekoven', 'mr. B.J. van Ettekoven')
                      , ('mr. G.J. van Binsbergen', 'mr. G.J. van Binsbergen')
                      , ('mr. J. Struiksma', 'mr. J. Struiksma')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************************\
    * Plug organization                 *
    *                                   *
    * fields:                           *
    * I/\organization;organization~  [] *
    * organization  [SYM,ASY]           *
    \***********************************/
    mysql_query("CREATE TABLE `organization`
                     ( `party` VARCHAR(255) NOT NULL
                     , `party1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `organization` (`party` ,`party1` )
                VALUES ('Fountainhead Enterprise B.V., Amsterdam', 'Fountainhead Enterprise B.V., Amsterdam')
                      , ('the Stichting Katholiek Onderwijs Staphorsteradeel, Staphorst', 'the Stichting Katholiek Onderwijs Staphorsteradeel, Staphorst')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*********************************************************\
    * Plug administrativeauthority                            *
    *                                                         *
    * fields:                                                 *
    * I/\administrativeAuthority;administrativeAuthority~  [] *
    * administrativeAuthority  [SYM,ASY]                      *
    \*********************************************************/
    mysql_query("CREATE TABLE `administrativeauthority`
                     ( `party` VARCHAR(255) NOT NULL
                     , `party1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `administrativeauthority` (`party` ,`party1` )
                VALUES ('the council of borough Zeeburg of the municipality of Amsterdam', 'the council of borough Zeeburg of the municipality of Amsterdam')
                      , ('the council of the municipality of Utrecht', 'the council of the municipality of Utrecht')
                      , ('the Secretary of State for Education, Culture and Science', 'the Secretary of State for Education, Culture and Science')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************************************\
    * Plug memberofgovernment                       *
    *                                               *
    * fields:                                       *
    * I/\memberOfGovernment;memberOfGovernment~  [] *
    * memberOfGovernment  [SYM,ASY]                 *
    \***********************************************/
    mysql_query("CREATE TABLE `memberofgovernment`
                     ( `party` VARCHAR(255) NOT NULL
                     , `party1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `memberofgovernment` (`party` ,`party1` )
                VALUES ('the Secretary of State for Education, Culture and Science', 'the Secretary of State for Education, Culture and Science')
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
                VALUES ('mr. T.M.A. van Loben Sels', 'Amsterdam district court fourth single-judge panel')
                      , ('mr. G.M.P. Brouns', 'Roermond district court single-judge panel')
                      , ('mr. N.M. van Waterschoot', 'Amsterdam district court single-judge panel for cases of administrative law')
                      , ('mr. J.H.B. van der Meer', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('mr. Ph.Q. van Otterloo-Pannerden', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('mr. H.P. Kijlstra', 'Amsterdam district court single-judge panel for cases of administrative law')
                      , ('mr. M. Vtodrager', 'Panel 2 department administrative administration of justice of the Council of State')
                      , ('mr. J. Sap', 'Three-judge panel to process judicial disqualifications of Utrecht district court')
                      , ('mr. M. ter Brugge', 'Three-judge panel to process judicial disqualifications of Utrecht district court')
                      , ('mr. L.E. Verschoor-Bergsma', 'Three-judge panel to process judicial disqualifications of Utrecht district court')
                      , ('mr. J. Ebbens', 'Utrecht district court single-judge panel for cases of administrative law')
                      , ('mr. B.J. van Ettekoven', 'Utrecht district court three-judge panel for cases of administrative law')
                      , ('mr. G.J. van Binsbergen', 'Utrecht district court three-judge panel for cases of administrative law')
                      , ('mr. J. Struiksma', 'Utrecht district court three-judge panel for cases of administrative law')
                ");
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
    /*************************************\
    * Plug broughtbefore                  *
    *                                     *
    * fields:                             *
    * I/\broughtBefore;broughtBefore~  [] *
    * broughtBefore  []                   *
    \*************************************/
    mysql_query("CREATE TABLE `broughtbefore`
                     ( `legalcase` VARCHAR(255) NOT NULL
                     , `court` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `broughtbefore` (`legalcase` ,`court` )
                VALUES ('199902238', 'Council of State')
                      , ('AWB 07/2481 WRO', 'Amsterdam district court')
                      , ('SBR 02/74331', 'Utrecht district court')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************************************************\
    * Plug administrativeauthorityawb87                                 *
    *                                                                   *
    * fields:                                                           *
    * I/\administrativeAuthorityAwb87;administrativeAuthorityAwb87~  [] *
    * administrativeAuthorityAwb87  [SYM,ASY]                           *
    \*******************************************************************/
    mysql_query("CREATE TABLE `administrativeauthorityawb87`
                     ( `party` VARCHAR(255) NOT NULL
                     , `party1` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `administrativeauthorityawb87` (`party` ,`party1` )
                VALUES ('the council of borough Zeeburg of the municipality of Amsterdam', 'the council of borough Zeeburg of the municipality of Amsterdam')
                      , ('the council of the municipality of Utrecht', 'the council of the municipality of Utrecht')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************\
    * Plug remark           *
    *                       *
    * fields:               *
    * I/\remark;remark~  [] *
    * remark  []            *
    \***********************/
    mysql_query("CREATE TABLE `remark`
                     ( `document` VARCHAR(255) NOT NULL
                     , `text` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `remark` (`document` ,`text` )
                VALUES ('doc987384', 'doc987384')
                      , ('letter 2000/864821a', '2000/864821a')
                      , ('letter 2000/860338e', '2000/860338e')
                      , ('doc763820', 'doc763820')
                      , ('letter 2009/87743', 'Vreugdenhil')
                      , ('letter 2009/87743a', '2009/87743a')
                      , ('schedule 2009/87743.1', 'Decision of the city council of Utrecht, Utrechtsblad 2009 No. 8')
                      , ('letter 2007/33-9887', '2007/33-9887')
                      , ('letter 2009/33-9854', '2009/33-9854')
                      , ('letter 2007/33-9910', '2007/33-9910')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
