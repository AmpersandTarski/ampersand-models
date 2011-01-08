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
  if($DB_slct = @mysql_select_db('Historie')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `Historie` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('Historie');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'Historie'");
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
    //// Number of plugs: 22
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `Feit`")){
        mysql_query("DROP TABLE `Feit`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Inhoud`")){
        mysql_query("DROP TABLE `Inhoud`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Gebeurtenis`")){
        mysql_query("DROP TABLE `Gebeurtenis`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Object`")){
        mysql_query("DROP TABLE `Object`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Gegeven`")){
        mysql_query("DROP TABLE `Gegeven`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Authenticatie`")){
        mysql_query("DROP TABLE `Authenticatie`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Document`")){
        mysql_query("DROP TABLE `Document`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Bewerking`")){
        mysql_query("DROP TABLE `Bewerking`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Feitnaam`")){
        mysql_query("DROP TABLE `Feitnaam`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Persoon`")){
        mysql_query("DROP TABLE `Persoon`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Tijdstip`")){
        mysql_query("DROP TABLE `Tijdstip`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Versie`")){
        mysql_query("DROP TABLE `Versie`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Actor`")){
        mysql_query("DROP TABLE `Actor`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `lt`")){
        mysql_query("DROP TABLE `lt`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `volgtOp`")){
        mysql_query("DROP TABLE `volgtOp`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `pre`")){
        mysql_query("DROP TABLE `pre`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `post`")){
        mysql_query("DROP TABLE `post`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `changed`")){
        mysql_query("DROP TABLE `changed`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `onderbouwt`")){
        mysql_query("DROP TABLE `onderbouwt`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `betreft`")){
        mysql_query("DROP TABLE `betreft`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `authentiek`")){
        mysql_query("DROP TABLE `authentiek`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `persoonsdossier`")){
        mysql_query("DROP TABLE `persoonsdossier`");
      }
    }
    /**************************************\
    * Plug Feit                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * naam  [UNI,TOT]                      *
    * vastgesteldDoor  [UNI,TOT]           *
    * vastgesteldOp  [UNI,TOT]             *
    \**************************************/
    mysql_query("CREATE TABLE `Feit`
                     ( `I` VARCHAR(255) NOT NULL
                     , `naam` VARCHAR(255) NOT NULL
                     , `vastgesteldDoor` VARCHAR(255) NOT NULL
                     , `vastgesteldOp` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Feit` (`I` ,`naam` ,`vastgesteldDoor` ,`vastgesteldOp` )
                VALUES ('110402', 'huwelijk', 'van der Knaap', '12 okt 1998')
                      , ('987237', 'paspoort gezien', 'van der Knaap', '12 okt 1998')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Inhoud                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * object  [UNI,TOT]                    *
    * versie  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `Inhoud`
                     ( `I` VARCHAR(255) NOT NULL
                     , `object` VARCHAR(255) NOT NULL
                     , `versie` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Inhoud` (`I` ,`object` ,`versie` )
                VALUES ('leeg', 'doc1', '1')
                      , ('beetje', 'doc1', '2')
                      , ('meer', 'doc1', '4')
                      , ('vol', 'doc1', '5')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Gebeurtenis                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * op  [UNI,TOT]                        *
    \**************************************/
    mysql_query("CREATE TABLE `Gebeurtenis`
                     ( `I` VARCHAR(255) NOT NULL
                     , `op` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Object                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * inhoud  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `Object`
                     ( `I` VARCHAR(255) NOT NULL
                     , `inhoud` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Object` (`I` ,`inhoud` )
                VALUES ('doc1', 'vol')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Gegeven                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * bron  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `Gegeven`
                     ( `I` VARCHAR(255) NOT NULL
                     , `bron` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Gegeven` (`I` ,`bron` )
                VALUES ('110402', 'Tanghasami')
                      , ('987237', 'Tanghasami')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Authenticatie                   *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Authenticatie`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Document                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Document`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Bewerking                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Bewerking`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Feitnaam                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Feitnaam`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Feitnaam` (`I` )
                VALUES ('huwelijk')
                      , ('paspoort gezien')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Persoon                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Persoon`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Persoon` (`I` )
                VALUES ('van der Knaap')
                      , ('Tanghasami')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Tijdstip                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Tijdstip`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Tijdstip` (`I` )
                VALUES ('12 okt 1998')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Versie                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Versie`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Versie` (`I` )
                VALUES ('1')
                      , ('2')
                      , ('3')
                      , ('4')
                      , ('5')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Actor                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Actor`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Actor` (`I` )
                VALUES ('Tanghasami')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************\
    * Plug lt       *
    *               *
    * fields:       *
    * I/\lt;lt~  [] *
    * lt  []        *
    \***************/
    mysql_query("CREATE TABLE `lt`
                     ( `s_Versie` VARCHAR(255) NOT NULL
                     , `t_Versie` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `lt` (`s_Versie` ,`t_Versie` )
                VALUES ('1', '2')
                      , ('2', '3')
                      , ('3', '4')
                      , ('4', '5')
                      , ('1', '3')
                      , ('2', '4')
                      , ('3', '5')
                      , ('1', '4')
                      , ('2', '5')
                      , ('1', '5')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug volgtOp            *
    *                         *
    * fields:                 *
    * I/\volgtOp;volgtOp~  [] *
    * volgtOp  [ASY]          *
    \*************************/
    mysql_query("CREATE TABLE `volgtOp`
                     ( `s_Versie` VARCHAR(255) NOT NULL
                     , `t_Versie` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `volgtOp` (`s_Versie` ,`t_Versie` )
                VALUES ('5', '4')
                      , ('4', '3')
                      , ('3', '2')
                      , ('2', '1')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************\
    * Plug pre        *
    *                 *
    * fields:         *
    * I/\pre;pre~  [] *
    * pre  []         *
    \*****************/
    mysql_query("CREATE TABLE `pre`
                     ( `Gebeurtenis` VARCHAR(255) NOT NULL
                     , `Inhoud` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug post         *
    *                   *
    * fields:           *
    * I/\post;post~  [] *
    * post  []          *
    \*******************/
    mysql_query("CREATE TABLE `post`
                     ( `Gebeurtenis` VARCHAR(255) NOT NULL
                     , `Inhoud` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug changed            *
    *                         *
    * fields:                 *
    * I/\changed;changed~  [] *
    * changed  []             *
    \*************************/
    mysql_query("CREATE TABLE `changed`
                     ( `Gebeurtenis` VARCHAR(255) NOT NULL
                     , `Object` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug onderbouwt               *
    *                               *
    * fields:                       *
    * I/\onderbouwt;onderbouwt~  [] *
    * onderbouwt  []                *
    \*******************************/
    mysql_query("CREATE TABLE `onderbouwt`
                     ( `Document` VARCHAR(255) NOT NULL
                     , `Feit` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug betreft            *
    *                         *
    * fields:                 *
    * I/\betreft;betreft~  [] *
    * betreft  []             *
    \*************************/
    mysql_query("CREATE TABLE `betreft`
                     ( `Feit` VARCHAR(255) NOT NULL
                     , `Persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `betreft` (`Feit` ,`Persoon` )
                VALUES ('110402', 'Tanghasami')
                      , ('987237', 'Tanghasami')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************\
    * Plug authentiek               *
    *                               *
    * fields:                       *
    * I/\authentiek;authentiek~  [] *
    * authentiek  []                *
    \*******************************/
    mysql_query("CREATE TABLE `authentiek`
                     ( `Document` VARCHAR(255) NOT NULL
                     , `Authenticatie` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************************\
    * Plug persoonsdossier                    *
    *                                         *
    * fields:                                 *
    * I/\persoonsdossier;persoonsdossier~  [] *
    * persoonsdossier  []                     *
    \*****************************************/
    mysql_query("CREATE TABLE `persoonsdossier`
                     ( `Document` VARCHAR(255) NOT NULL
                     , `Persoon` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
