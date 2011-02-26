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
  if($DB_slct = @mysql_select_db('ELMTest')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `ELMTest` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('ELMTest');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'ELMTest'");
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
    //// Number of plugs: 5
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `Obligation`")){
        mysql_query("DROP TABLE `Obligation`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Asset`")){
        mysql_query("DROP TABLE `Asset`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `LMH`")){
        mysql_query("DROP TABLE `LMH`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Person`")){
        mysql_query("DROP TABLE `Person`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `lth`")){
        mysql_query("DROP TABLE `lth`");
      }
    }
    /*******************************************\
    * Plug Obligation                           *
    *                                           *
    * fields:                                   *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX]      *
    * obligationOf[Obligation*Asset]  [UNI,TOT] *
    * oblRisk[Obligation*LMH]  [UNI]            *
    * statOblRA[Obligation]  [SYM,ASY,UNI,INJ]  *
    * dOblRA[Obligation]  [SYM,ASY,UNI,INJ]     *
    \*******************************************/
    mysql_query("CREATE TABLE `Obligation`
                     ( `Obligation` VARCHAR(255) NOT NULL
                     , `obligationOf` VARCHAR(255) NOT NULL
                     , `oblRisk` VARCHAR(255)
                     , `statOblRA` VARCHAR(255)
                     , `dOblRA` VARCHAR(255)
                     , UNIQUE KEY (`Obligation`)
                     , UNIQUE INDEX (`statOblRA`)
                     , UNIQUE INDEX (`dOblRA`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Obligation` (`Obligation` ,`obligationOf` ,`oblRisk` ,`statOblRA` ,`dOblRA` )
                VALUES ('O2b', 'Asset 2', NULL, 'O2b', 'O2b')
                      , ('O3a', 'Asset 3', 'L', 'O3a', NULL)
                      , ('O1a', 'Asset 1', 'H', NULL, NULL)
                      , ('O2a', 'Asset 2', 'M', NULL, NULL)
                      , ('O1b', 'Asset 1', NULL, NULL, NULL)
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************************\
    * Plug Asset                            *
    *                                       *
    * fields:                               *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX]  *
    * assetManager[Asset*Person]  [UNI,TOT] *
    * statAssetRA[Asset]  [SYM,ASY,UNI,INJ] *
    * dAssetRA[Asset]  [SYM,ASY,UNI,INJ]    *
    \***************************************/
    mysql_query("CREATE TABLE `Asset`
                     ( `Asset` VARCHAR(255) NOT NULL
                     , `assetManager` VARCHAR(255) NOT NULL
                     , `statAssetRA` VARCHAR(255)
                     , `dAssetRA` VARCHAR(255)
                     , UNIQUE KEY (`Asset`)
                     , UNIQUE INDEX (`statAssetRA`)
                     , UNIQUE INDEX (`dAssetRA`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Asset` (`Asset` ,`assetManager` ,`statAssetRA` ,`dAssetRA` )
                VALUES ('Asset 1', 'Pietje Puk', NULL, NULL)
                      , ('Asset 2', 'Jan Jansen', 'Asset 2', 'Asset 2')
                      , ('Asset 3', 'Pietje Puk', 'Asset 3', NULL)
                      , ('Asset 4', 'Jan Klaasen', NULL, NULL)
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug LMH                             *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `LMH`
                     ( `LMH` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`LMH`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `LMH` (`LMH` )
                VALUES ('L')
                      , ('M')
                      , ('H')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Person                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Person`
                     ( `Person` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`Person`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Person` (`Person` )
                VALUES ('Pietje Puk')
                      , ('Jan Jansen')
                      , ('Jan Klaasen')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***************************\
    * Plug lth                  *
    *                           *
    * fields:                   *
    * I/\lth[LMH];lth[LMH]~  [] *
    * lth[LMH]  [TRN,ASY]       *
    \***************************/
    mysql_query("CREATE TABLE `lth`
                     ( `sLMH` VARCHAR(255) NOT NULL
                     , `tLMH` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `lth` (`sLMH` ,`tLMH` )
                VALUES ('L', 'M')
                      , ('L', 'H')
                      , ('M', 'H')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
