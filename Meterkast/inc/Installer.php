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
  if($DB_slct = @mysql_select_db('ADL')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `ADL` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('ADL');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'ADL'");
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
    //// Number of plugs: 8
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `OperationTbl`")){
        mysql_query("DROP TABLE `OperationTbl`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `ActieTbl`")){
        mysql_query("DROP TABLE `ActieTbl`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `BestandTbl`")){
        mysql_query("DROP TABLE `BestandTbl`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `SessieTbl`")){
        mysql_query("DROP TABLE `SessieTbl`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Flag`")){
        mysql_query("DROP TABLE `Flag`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Gebruiker`")){
        mysql_query("DROP TABLE `Gebruiker`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Text`")){
        mysql_query("DROP TABLE `Text`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Compilation`")){
        mysql_query("DROP TABLE `Compilation`");
      }
    }
    /**************************************\
    * Plug OperationTbl                    *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * name  [INJ,UNI,TOT]                  *
    * call  [UNI,TOT]                      *
    * output  [UNI,TOT]                    *
    \**************************************/
    mysql_query("CREATE TABLE `OperationTbl`
                     ( `Id` INT AUTO_INCREMENT NOT NULL
                     , `name` VARCHAR(255) NOT NULL
                     , `call` VARCHAR(255) NOT NULL
                     , `output` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`Id`)
                     , UNIQUE KEY (`name`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `OperationTbl` (`Id` ,`name` ,`call` ,`output` )
                VALUES ('1', 'Test', 'adl --help', 'NULL')
                      , ('2', 'Atlas(verbose)', 'adl --verbose -aD:/workspace/svnadl/trunk/apps/meterkast/atlas/ --user=%4$s.local %2$s', 'atlas/Rules.php?User=%4$s&Script=%2$s')
                      , ('3', 'Prototype(verbose)', 'adl -p%1$s --verbose %2$s', '%1$s')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug ActieTbl                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * object  [UNI,TOT]                    *
    * type  [UNI,TOT]                      *
    * done  [UNI,TOT]                      *
    * error  [UNI]                         *
    \**************************************/
    mysql_query("CREATE TABLE `ActieTbl`
                     ( `Id` INT AUTO_INCREMENT NOT NULL
                     , `object` INT NOT NULL
                     , `type` INT NOT NULL
                     , `done` BOOLEAN NOT NULL
                     , `error` BLOB
                     , UNIQUE KEY (`Id`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug BestandTbl                      *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * path  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `BestandTbl`
                     ( `Id` INT AUTO_INCREMENT NOT NULL
                     , `path` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`Id`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug SessieTbl                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * ip  [UNI,TOT]                        *
    * session~  [UNI,INJ,SUR]              *
    * user  [UNI,TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `SessieTbl`
                     ( `Id` VARCHAR(255) NOT NULL
                     , `ip` VARCHAR(255) NOT NULL
                     , `bestand` INT
                     , `gebruiker` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`Id`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Flag                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Flag`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Gebruiker                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Gebruiker`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Text                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Text`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Text` (`I` )
                VALUES ('adl --help')
                      , ('adl --verbose -aD:/workspace/svnadl/trunk/apps/meterkast/atlas/ --user=%4$s.local %2$s')
                      , ('adl -p%1$s --verbose %2$s')
                      , ('Test')
                      , ('Atlas(verbose)')
                      , ('Prototype(verbose)')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Compilation                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Compilation`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Compilation` (`I` )
                VALUES ('NULL')
                      , ('atlas/Rules.php?User=%4$s&Script=%2$s')
                      , ('%1$s')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
