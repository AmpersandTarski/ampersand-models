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
  if($DB_slct = @mysql_select_db('SessionAccounts')){
    $existing=true;
  }else{
    $existing = false; // db does not exist, so try to create it
    @mysql_query("CREATE DATABASE `SessionAccounts` DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    $DB_slct = @mysql_select_db('SessionAccounts');
  }
  if(!$DB_slct){
    echo die("Install failed: cannot connect to MySQL or error selecting database 'SessionAccounts'");
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
    //// Number of plugs: 15
    if($existing==true){
      if($columns = mysql_query("SHOW COLUMNS FROM `Session`")){
        mysql_query("DROP TABLE `Session`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `UserAccount`")){
        mysql_query("DROP TABLE `UserAccount`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Phonenumber`")){
        mysql_query("DROP TABLE `Phonenumber`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Emailaddr`")){
        mysql_query("DROP TABLE `Emailaddr`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Text1`")){
        mysql_query("DROP TABLE `Text1`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `text2`")){
        mysql_query("DROP TABLE `text2`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Password`")){
        mysql_query("DROP TABLE `Password`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Person`")){
        mysql_query("DROP TABLE `Person`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `Role`")){
        mysql_query("DROP TABLE `Role`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `emailOf`")){
        mysql_query("DROP TABLE `emailOf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `phoneOf`")){
        mysql_query("DROP TABLE `phoneOf`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `iscalled`")){
        mysql_query("DROP TABLE `iscalled`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `anonymous`")){
        mysql_query("DROP TABLE `anonymous`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `personAssignedRole`")){
        mysql_query("DROP TABLE `personAssignedRole`");
      }
      if($columns = mysql_query("SHOW COLUMNS FROM `userAssignedRole`")){
        mysql_query("DROP TABLE `userAssignedRole`");
      }
    }
    /**************************************\
    * Plug Session                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * loginSession~  [UNI,INJ,SUR]         *
    * sUser  [UNI]                         *
    * sUsers  [UNI]                        *
    * sAccount  [UNI]                      *
    * loginUsername  [UNI]                 *
    * loginPassword  [UNI]                 *
    \**************************************/
    mysql_query("CREATE TABLE `Session`
                     ( `I` VARCHAR(255) NOT NULL
                     , `loginSession` VARCHAR(255)
                     , `sUser` VARCHAR(255) NOT NULL
                     , `sUsers` VARCHAR(255) NOT NULL
                     , `sAccount` VARCHAR(255) NOT NULL
                     , `loginUsername` VARCHAR(255)
                     , `loginPassword` VARCHAR(255)
                     , UNIQUE KEY (`I`)
                     , UNIQUE INDEX (`loginSession`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug UserAccount                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * userPerson  [UNI]                    *
    * userPassword  [UNI]                  *
    \**************************************/
    mysql_query("CREATE TABLE `UserAccount`
                     ( `I` VARCHAR(255) NOT NULL
                     , `userPerson` VARCHAR(255) NOT NULL
                     , `userPassword` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `UserAccount` (`I` ,`userPerson` ,`userPassword` )
                VALUES ('joostenhjm', 'Rieks', '*****')
                      , ('joostensmm', 'Stef', '****')
                      , ('michelsg', 'Gerard', '******')
                      , ('joostenjmm', 'Han', '***')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Phonenumber                     *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Phonenumber`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Emailaddr                       *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Emailaddr`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Emailaddr` (`I` )
                VALUES ('Gerard.Michels@ou.nl')
                      , ('han.joosten@atosorigin.com')
                      , ('rieks.joosten@tno.nl')
                      , ('sjcjoosten@gmail.com')
                      , ('stef.joosten@ordina.nl')
                      , ('stef.joosten@ou.nl')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Text1                           *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Text1`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Text1` (`I` )
                VALUES ('U bent ingelogd')
                      , ('Gerard Michels')
                      , ('Han Joosten')
                      , ('Rieks Joosten')
                      , ('Bas Joosten')
                      , ('Stef Joosten')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************\
    * Plug text2        *
    *                   *
    * fields:           *
    * I/\text;text~  [] *
    * text  []          *
    \*******************/
    mysql_query("CREATE TABLE `text2`
                     ( `s_Text` VARCHAR(255) NOT NULL
                     , `t_Text` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `text2` (`s_Text` ,`t_Text` )
                VALUES ('U bent ingelogd', 'U bent ingelogd')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Password                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Password`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Password` (`I` )
                VALUES ('*****')
                      , ('***')
                      , ('****')
                      , ('******')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Person                          *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Person`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Person` (`I` )
                VALUES ('Rieks')
                      , ('Gerard')
                      , ('Han')
                      , ('Bas')
                      , ('Stef')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug Role                            *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    \**************************************/
    mysql_query("CREATE TABLE `Role`
                     ( `I` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`I`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `Role` (`I` )
                VALUES ('BeheerAccount')
                      , ('Beheerder')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug emailOf                         *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * emailOf~  [TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `emailOf`
                     ( `Person` VARCHAR(255) NOT NULL
                     , `Emailaddr` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `emailOf` (`Person` ,`Emailaddr` )
                VALUES ('Gerard', 'Gerard.Michels@ou.nl')
                      , ('Han', 'han.joosten@atosorigin.com')
                      , ('Rieks', 'rieks.joosten@tno.nl')
                      , ('Bas', 'sjcjoosten@gmail.com')
                      , ('Stef', 'stef.joosten@ordina.nl')
                      , ('Stef', 'stef.joosten@ou.nl')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*************************\
    * Plug phoneOf            *
    *                         *
    * fields:                 *
    * I/\phoneOf;phoneOf~  [] *
    * phoneOf  []             *
    \*************************/
    mysql_query("CREATE TABLE `phoneOf`
                     ( `Phonenumber` VARCHAR(255) NOT NULL
                     , `Person` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /**************************************\
    * Plug iscalled                        *
    *                                      *
    * fields:                              *
    * I  [INJ,SUR,UNI,TOT,SYM,ASY,TRN,RFX] *
    * iscalled  [TOT]                      *
    \**************************************/
    mysql_query("CREATE TABLE `iscalled`
                     ( `Person` VARCHAR(255) NOT NULL
                     , `Text` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `iscalled` (`Person` ,`Text` )
                VALUES ('Gerard', 'Gerard Michels')
                      , ('Han', 'Han Joosten')
                      , ('Rieks', 'Rieks Joosten')
                      , ('Bas', 'Bas Joosten')
                      , ('Stef', 'Stef Joosten')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*****************************\
    * Plug anonymous              *
    *                             *
    * fields:                     *
    * I/\anonymous;anonymous~  [] *
    * anonymous  [SYM,ASY]        *
    \*****************************/
    mysql_query("CREATE TABLE `anonymous`
                     ( `s_Person` VARCHAR(255) NOT NULL
                     , `t_Person` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /***********************************************\
    * Plug personAssignedRole                       *
    *                                               *
    * fields:                                       *
    * I/\personAssignedRole;personAssignedRole~  [] *
    * personAssignedRole  []                        *
    \***********************************************/
    mysql_query("CREATE TABLE `personAssignedRole`
                     ( `Person` VARCHAR(255) NOT NULL
                     , `Role` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `personAssignedRole` (`Person` ,`Role` )
                VALUES ('Rieks', 'Beheerder')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /*******************************************\
    * Plug userAssignedRole                     *
    *                                           *
    * fields:                                   *
    * I/\userAssignedRole;userAssignedRole~  [] *
    * userAssignedRole  []                      *
    \*******************************************/
    mysql_query("CREATE TABLE `userAssignedRole`
                     ( `UserAccount` VARCHAR(255) NOT NULL
                     , `Role` VARCHAR(255) NOT NULL
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    else
    mysql_query("INSERT IGNORE INTO `userAssignedRole` (`UserAccount` ,`Role` )
                VALUES ('joostenhjm', 'BeheerAccount')
                      , ('joostensmm', 'BeheerAccount')
                      , ('michelsg', 'BeheerAccount')
                ");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
