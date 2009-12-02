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
    //// Number of plugs: 5
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
      if($columns = mysql_query("SHOW COLUMNS FROM `text`")){
        mysql_query("DROP TABLE `text`");
      }
    }
    /* Plug OperationTbl, fields: [I,name,call] */
    mysql_query("CREATE TABLE `OperationTbl`
                     ( `Id` INT AUTO_INCREMENT NOT NULL
                     , `name` VARCHAR(255) NOT NULL
                     , `call` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`Id`)
                     , UNIQUE KEY (`name`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /* Plug ActieTbl, fields: [I,object,type] */
    mysql_query("CREATE TABLE `ActieTbl`
                     ( `Id` INT AUTO_INCREMENT NOT NULL
                     , `object` INT NOT NULL
                     , `type` INT NOT NULL
                     , UNIQUE KEY (`Id`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /* Plug BestandTbl, fields: [I,path] */
    mysql_query("CREATE TABLE `BestandTbl`
                     ( `Id` INT AUTO_INCREMENT NOT NULL
                     , `path` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`Id`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /* Plug SessieTbl, fields: [I,ip,session~] */
    mysql_query("CREATE TABLE `SessieTbl`
                     ( `Id` VARCHAR(255) NOT NULL
                     , `ip` VARCHAR(255) NOT NULL
                     , `bestand` INT
                     , UNIQUE KEY (`Id`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    /* Plug text, fields: [I] */
    mysql_query("CREATE TABLE `text`
                     ( `text` VARCHAR(255) NOT NULL
                     , UNIQUE KEY (`text`)
                      ) TYPE=InnoDB DEFAULT CHARACTER SET latin1 COLLATE latin1_bin");
    if($err=mysql_error()) { $error=true; echo $err.'<br />'; }
    mysql_query('SET TRANSACTION ISOLATION LEVEL SERIALIZABLE');
  }
?>
